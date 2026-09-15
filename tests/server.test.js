'use strict';

const fs = require('fs');
const os = require('os');
const path = require('path');
const http = require('http');

const TMP = fs.mkdtempSync(path.join(os.tmpdir(), 'aw-test-'));
process.env.AW_DATA_DIR = TMP;
process.env.AW_ENDPOINT = 'http://localhost:11999/v1/chat/completions';
process.env.AW_MODEL = 'test-model';

const srv = require('../server/server');
const { store, mailer } = srv;
const PORT = 13001;

const KNOWLEDGE = [
  { title: 'Как оформить возврат?', content: 'Возврат оформляется в течение 14 дней с момента получения, деньги возвращаем за 5 рабочих дней.' },
  { title: 'Наушники Aurora X', content: 'Беспроводные наушники с шумоподавлением. Цена: 7990RUB.' }
];

let aiMock;
let passed = 0;
let failed = 0;
function check(name, cond, extra) {
  if (cond) { passed++; console.log('  [ok] ' + name); }
  else { failed++; console.log('  [FAIL] ' + name + (extra ? ' :: ' + extra : '')); }
}

function startAiMock() {
  aiMock = http.createServer((req, res) => {
    if (req.method === 'POST' && req.url === '/v1/chat/completions') {
      let b = '';
      req.on('data', (c) => (b += c));
      req.on('end', () => {
        const body = JSON.parse(b);
        const q = (body.messages[1] || {}).content || '';
        if (q.indexOf('HARDFAIL') !== -1) { res.writeHead(500); res.end('boom'); return; }
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ choices: [{ message: { role: 'assistant', content: 'LLM-ответ: ' + q } }] }));
      });
      return;
    }
    res.writeHead(404); res.end();
  });
  return new Promise((r) => aiMock.listen(11999, r));
}

function post(url, body) {
  return fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body)
  }).then((r) => r.json());
}

async function readSseUntilReply(chatId, expectedText) {
  return new Promise((resolve, reject) => {
    const req = http.get('http://localhost:' + PORT + '/api/chat/' + chatId + '/events', (res) => {
      let acc = '';
      const to = setTimeout(() => { req.destroy(); reject(new Error('SSE timeout')); }, 6000);
      res.on('data', (chunk) => {
        acc += chunk.toString();
        if (acc.indexOf(expectedText) !== -1) { clearTimeout(to); req.destroy(); resolve(true); }
      });
    });
    req.on('error', reject);
  });
}

async function main() {
  await startAiMock();
  const server = srv.start(PORT);

  const base = 'http://localhost:' + PORT;

  console.log('\n== Server: health ==');
  const health = await fetch(base + '/api/health').then((r) => r.json());
  check('health.ok', health.ok === true);
  check('from = support@deworld.su', health.from === 'support@deworld.su', health.from);

  console.log('\n== Server: init и AI-ответ ==');
  await post(base + '/api/init', {
    chatId: 'chat1',
    email: 'user@example.com',
    siteName: 'TestShop',
    page: 'http://localhost/test',
    knowledge: KNOWLEDGE,
    prompt: 'Промпт теста',
    instructions: ''
  });
  check('чат создан', store.getChat('chat1') !== null);

  const r1 = await post(base + '/api/chat/chat1/message', { text: 'Сколько стоят наушники Aurora X?' });
  check('AI отвечает из LLM', r1.messages[0] && r1.messages[0].text.indexOf('LLM-ответ') === 0, r1.messages[0] && r1.messages[0].text);
  check('режим ai', r1.mode === 'ai', r1.mode);

  const r2 = await post(base + '/api/chat/chat1/message', { text: 'Как оформить возврат? HARDFAIL' });
  check('fallback поиска при сбое LLM', r2.messages[0] && r2.messages[0].text.indexOf('14 дней') !== -1, r2.messages[0] && r2.messages[0].text);
  const full = await fetch(base + '/api/chat/chat1/full').then((r) => r.json());
  check('fallback помечен в логе ответа', full.lastAnswerSource === 'search', full.lastAnswerSource);

  console.log('\n== Server: руководство ==');
  const chats = await fetch(base + '/api/chats').then((r) => r.json());
  check('чаты в списке', Array.isArray(chats) && chats.some((c) => c.id === 'chat1'));
  check('summary содержит email', chats[0].email === 'user@example.com');

  await post(base + '/api/chat/chat1/handoff', {});
  const r3 = await post(base + '/api/chat/chat1/message', { text: 'Сообщение для оператора' });
  check('после handoff AI молчит', r3.mode === 'human' && r3.messages.length === 0, r3.mode);

  await post(base + '/api/chat/chat1/instructions', { instructions: 'Всегда предлагать скидку 10%' });
  const full2 = await fetch(base + '/api/chat/chat1/full').then((r) => r.json());
  check('инструкции сохранены', full2.instructions === 'Всегда предлагать скидку 10%');

  console.log('\n== Server: ответ оператора + email ==');
  await post(base + '/api/chat/chat1/reply', { text: 'Здравствуйте! Готов помочь.' });
  const full3 = await fetch(base + '/api/chat/chat1/full').then((r) => r.json());
  check('ответ оператора в истории', full3.messages.some((m) => m.role === 'agent' && m.text === 'Здравствуйте! Готов помочь.'));
  await new Promise((r) => setTimeout(r, 200));
  const mailLog = fs.readFileSync(path.join(TMP, 'email.log.ndjson'), 'utf8');
  check('email ушёл в outbox (клиент офлайн)', mailLog.indexOf('user@example.com') !== -1 && mailLog.indexOf('Здравствуйте! Готов помочь.') !== -1, mailLog.slice(0, 120));
  check('from = support@deworld.su', mailLog.indexOf('support@deworld.su') !== -1);

  console.log('\n== Server: SSE ==');
  const sseP = readSseUntilReply('chat1', 'Спасибо за ожидание');
  await new Promise((r) => setTimeout(r, 300));
  await post(base + '/api/chat/chat1/reply', { text: 'Спасибо за ожидание!' });
  check('оператор виден клиенту по SSE', await sseP);

  console.log('\n== Server: возврат режима ИИ ==');
  await post(base + '/api/chat/chat1/mode', { mode: 'ai' });
  const r4 = await post(base + '/api/chat/chat1/message', { text: 'Вернули ИИ?' });
  check('ИИ работает после mode ai', r4.messages[0] && r4.messages[0].text.indexOf('LLM-ответ') === 0, r4.messages[0] && r4.messages[0].text);

  const logFile = path.join(TMP, 'chatlog.ndjson');
  const logLines = fs.readFileSync(logFile, 'utf8').split('\n').filter(Boolean);
  check('все чаты логируются (NDJSON)', logLines.length >= 6, 'lines=' + logLines.length);

  console.log('\n== Server: второй чат (fallback без AI) ==');
  await post(base + '/api/init', { chatId: 'chat2', email: 'two@example.com', siteName: 'Two', knowledge: KNOWLEDGE });
  const r5 = await post(base + '/api/chat/chat2/message', { text: 'Наушники Aurora X' });
  check('второй чат отвечает', !!r5.messages[0] && !!r5.messages[0].text, r5.messages[0] && r5.messages[0].text);

  server.close();
  aiMock.close();

  console.log('\n==================================');
  console.log('  SERVER: ' + passed + ' passed, ' + failed + ' failed');
  console.log('==================================');
  process.exit(failed ? 1 : 0);
}

main().catch((e) => {
  console.error('Server-тест упал:', e);
  if (aiMock) aiMock.close();
  process.exit(2);
});