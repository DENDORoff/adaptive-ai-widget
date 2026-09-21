'use strict';

const fs = require('fs');
const os = require('os');
const path = require('path');
const http = require('http');

const TMP = fs.mkdtempSync(path.join(os.tmpdir(), 'aw-test-'));
process.env.AW_DATA_DIR = TMP;
process.env.AW_ENDPOINT = 'http://localhost:11999/v1/chat/completions';
process.env.AW_MODEL = 'test-model';
process.env.AW_CONFIG = path.join(TMP, 'config.json');
process.env.AW_FLY_BASE = 'http://localhost:11997';
fs.writeFileSync(process.env.AW_CONFIG, JSON.stringify({ from: 'support@deworld.su' }, null, 2));

const srv = require('../server/server');
const { store, mailer } = srv;
const PORT = 13001;
const HOOK_PORT = 11998;

const KNOWLEDGE = [
  { title: 'Как оформить возврат?', content: 'Возврат оформляется в течение 14 дней с момента получения, деньги возвращаем за 5 рабочих дней.' },
  { title: 'Наушники Aurora X', content: 'Беспроводные наушники с шумоподавлением. Цена: 7990RUB.' }
];

let aiMock;
let aiCalls = 0;
let hookMock;
let flyMock;
const webhookHits = [];
let flyDown = false;
let passed = 0;
let failed = 0;
function check(name, cond, extra) {
  if (cond) { passed++; console.log('  [ok] ' + name); }
  else { failed++; console.log('  [FAIL] ' + name + (extra ? ' :: ' + extra : '')); }
}

function startAiMock() {
  aiMock = http.createServer((req, res) => {
    if (req.method === 'POST' && req.url === '/v1/chat/completions') {
      aiCalls++;
      let b = '';
      req.on('data', (c) => (b += c));
      req.on('end', () => {
        const body = JSON.parse(b);
        const q = (body.messages[1] || {}).content || '';
        if (q.indexOf('HARDFAIL') !== -1) { res.writeHead(500); res.end('boom'); return; }
        if (body.tools) {
          const hasToolResult = (body.messages || []).some((m) => m && m.role === 'tool');
          res.writeHead(200, { 'Content-Type': 'application/json' });
          if (hasToolResult) {
            res.end(JSON.stringify({ choices: [{ message: { role: 'assistant', content: 'TOOLS-ответ: ' + q } }] }));
          } else {
            res.end(JSON.stringify({ choices: [{ message: { role: 'assistant', content: null, tool_calls: [{ id: 'tool-1', type: 'function', function: { name: 'search_knowledge', arguments: JSON.stringify({ query: q }) } }] } }] }));
          }
          return;
        }
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ choices: [{ message: { role: 'assistant', content: 'LLM-ответ: ' + q } }] }));
      });
      return;
    }
    res.writeHead(404); res.end();
  });
  return new Promise((r) => aiMock.listen(11999, r));
}

function startHookMock() {
  hookMock = http.createServer((req, res) => {
    let b = '';
    req.on('data', (c) => (b += c));
    req.on('end', () => {
      try { webhookHits.push(JSON.parse(b)); } catch (e) { webhookHits.push({ raw: b }); }
      res.writeHead(204); res.end();
    });
  });
  return new Promise((r) => hookMock.listen(HOOK_PORT, r));
}

function startFlyMock() {
  flyMock = http.createServer((req, res) => {
    if (flyDown) { res.writeHead(500, { 'Content-Type': 'application/json' }); res.end('down'); return; }
    res.writeHead(200, { 'Content-Type': 'application/json' });
    if (req.method === 'GET' && req.url.indexOf('/api/datasets') !== -1) { res.end(JSON.stringify([{ name: 'hemibrain:v1.2.1' }])); return; }
    if (req.method === 'POST' && req.url.indexOf('/api/cypher') !== -1) { res.end(JSON.stringify({ data: [[21000]] })); return; }
    if (req.url.split('?')[0].indexOf('/api/trace/') === 0) {
      res.end(JSON.stringify({ trace: { bodyId: 101, type: 'MBON(online)', nodes: [
        { pos: { x: 1, y: 2, z: 3 } },
        { pos: { x: 4, y: 5, z: 6 }, parent: 0 },
        { pos: { x: 7, y: 8, z: 9 }, parent: 1 },
        { pos: { x: 10, y: 11, z: 12 }, parent: 2 }
      ] } }));
      return;
    }
    res.end(JSON.stringify([]));
  });
  return new Promise((r) => flyMock.listen(11997, r));
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
  await startHookMock();
  await startFlyMock();
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

  console.log('\n== Server: клиентский режим и статусы ==');
  const chatsHuman = await fetch(base + '/api/chats').then((r) => r.json());
  const cW = chatsHuman.find((c) => c.id === 'chat1');
  check('статус human помечен как «ждёт оператора»', cW && cW.status === 'human' && cW.waiting === true, cW && JSON.stringify({ status: cW.status, waiting: cW.waiting }));

  const rs = await post(base + '/api/chat/chat1/resume', {});
  check('публичный resume возвращает ИИ-режим', rs.ok === true && rs.mode === 'ai', JSON.stringify(rs));
  const chatsResumed = await fetch(base + '/api/chats').then((r) => r.json());
  const cW2 = chatsResumed.find((c) => c.id === 'chat1');
  check('после resume awaiting сброшен', cW2 && cW2.waiting === false, cW2 && String(cW2.waiting));

  await post(base + '/api/init', { chatId: 'chatR', email: 'r@example.com', siteName: 'R', knowledge: KNOWLEDGE });
  await post(base + '/api/chat/chatR/handoff', {});
  await post(base + '/api/chat/chatR/reply', { text: 'Опер отвечает' });
  const chatsAfterReply = await fetch(base + '/api/chats').then((r) => r.json());
  const cR = chatsAfterReply.find((c) => c.id === 'chatR');
  check('после ответа оператора статус «оператор отвечает»', cR && cR.status === 'human' && cR.waiting === false, cR && JSON.stringify({ status: cR.status, waiting: cR.waiting }));
  const rv = await post(base + '/api/chat/chatR/resolve', {});
  check('публичный resolve закрывает тикет', rv.ok === true && rv.mode === 'closed', JSON.stringify(rv));
  const fullR = await fetch(base + '/api/chat/chatR/full').then((r) => r.json());
  check('resolve помечен в тикете и истории', fullR.status === 'closed' && fullR.resolved === true && fullR.messages.some((m) => m.role === 'system' && m.text.indexOf('решён') !== -1), JSON.stringify({ status: fullR.status, resolved: fullR.resolved }));

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

  console.log('\n== Server: конфиг агента ==');
  const cfg0 = await fetch(base + '/api/config').then((r) => r.json());
  check('GET /api/config отдаёт провайдера', cfg0.provider === 'ollama', cfg0.provider);
  const upd = await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      model: 'test-model-2',
      instructions: 'Всегда вежливо здороваться',
      provider: 'ollama',
      qaThreshold: 0.4,
      qa: [
        { q: 'Сколько стоят наушники Aurora X?', a: 'QA-ответ: 7990 ₽', keys: ['цена', 'наушники', 'aurora', 'стоимость'] }
      ]
    })
  }).then((r) => r.json());
  check('PUT /api/config обновил модель', upd.model === 'test-model-2', upd.model);
  check('PUT /api/config обновил инструкции', upd.instructions === 'Всегда вежливо здороваться');
  check('PUT /api/config принял базу Q&A', upd.qa && upd.qa.length === 1 && upd.qa[0].q === 'Сколько стоят наушники Aurora X?', JSON.stringify(upd.qa));

  console.log('\n== Server: Q&A без ИИ (перефразировка) ==');
  const qaMsg = await post(base + '/api/chat/chat1/message', { text: 'Какая цена наушников Ауроры?' });
  check('перефразированный вопрос отвечает из базы Q&A', qaMsg.messages[0] && qaMsg.messages[0].text.indexOf('QA-ответ') !== -1, qaMsg.messages[0] && qaMsg.messages[0].text);
  const fullQa = await fetch(base + '/api/chat/chat1/full').then((r) => r.json());
  check('попадание помечено источником qa', (fullQa.hits || []).some((h) => h.q === 'Какая цена наушников Ауроры?' && h.source === 'qa' && h.resolved === true));

  console.log('\n== Server: нерешённый запрос ==');
  const ru = await post(base + '/api/chat/chat1/message', { text: 'Гиппопотам в океане HARDFAIL' });
  check('при отсутствии ответа приходит fallback-сообщение', ru.messages[0] && ru.messages[0].from === 'bot' && ru.messages[0].text.indexOf('Не нашёл точного ответа') !== -1, ru.messages[0] && ru.messages[0].text.slice(0, 60));
  const fullU = await fetch(base + '/api/chat/chat1/full').then((r) => r.json());
  check('попадание записано как нерешённое', (fullU.hits || []).some((h) => h.resolved === false && h.q === 'Гиппопотам в океане HARDFAIL'));

  console.log('\n== Server: оценка ==');
  const rt = await post(base + '/api/chat/chat1/rating', { score: 5 });
  check('rating сохранён', rt.ok === true && rt.score === 5, rt.score);

  console.log('\n== Server: второй чат ==');
  await post(base + '/api/init', { chatId: 'chat2', email: 'two@example.com', siteName: 'Two', knowledge: KNOWLEDGE });
  const r5 = await post(base + '/api/chat/chat2/message', { text: 'Наушники Aurora X' });
  check('второй чат отвечает', !!r5.messages[0] && !!r5.messages[0].text, r5.messages[0] && r5.messages[0].text);
  await post(base + '/api/chat/chat2/rating', { score: 3 });

  console.log('\n== Server: кэш ответов ==');
  const qCache = 'Расскажи про гарантию на технику CACHETEST';
  const c1 = await post(base + '/api/chat/chat2/message', { text: qCache });
  const llmCallsAfter1 = aiCalls;
  const c2 = await post(base + '/api/chat/chat2/message', { text: qCache });
  check('первый ответ сгенерирован (LLM)', c1.messages[0] && c1.messages[0].text.indexOf('LLM-ответ') === 0, c1.messages[0] && c1.messages[0].text);
  check('повторный ответ взят из кэша', c2.messages[0] && c2.messages[0].text === c1.messages[0].text);
  check('LLM не вызывалась повторно', aiCalls === llmCallsAfter1, 'calls=' + aiCalls);
  const fullC2 = await fetch(base + '/api/chat/chat2/full').then((r) => r.json());
  check('попадание из кэша имеет source=cache', (fullC2.hits || []).filter((h) => h.q === qCache).some((h) => h.source === 'cache'));

  console.log('\n== Server: агент с инструментами (agentMode=tools) ==');
  const updTools = await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ agentMode: 'tools' })
  }).then((r) => r.json());
  check('PUT /api/config принял agentMode=tools', updTools.agentMode === 'tools', updTools.agentMode);
  const toolsBefore = aiCalls;
  const tMsg = await post(base + '/api/chat/chat2/message', { text: 'Сколько стоит гарантия TECHTOOLS' });
  check('tools-агент отвечает после tool-calling цикла', tMsg.messages[0] && tMsg.messages[0].text.indexOf('TOOLS-ответ') === 0, tMsg.messages[0] && tMsg.messages[0].text);
  check('tools-агент сделал два запроса к модели (вызов инструмента + ответ)', aiCalls === toolsBefore + 2, 'aiCalls=' + aiCalls);
  const fullTools = await fetch(base + '/api/chat/chat2/full').then((r) => r.json());
  check('попадание tools-агента source=tools', (fullTools.hits || []).filter((h) => h.q === 'Сколько стоит гарантия TECHTOOLS').some((h) => h.source === 'tools'));
  await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ agentMode: 'rag' })
  }).then((r) => r.json());
  const rBack = await post(base + '/api/chat/chat2/message', { text: 'Ракета на Луне BACKRAG' });
  check('переключение обратно на rag — снова обычный LLM', rBack.messages[0] && rBack.messages[0].text.indexOf('LLM-ответ') === 0, rBack.messages[0] && rBack.messages[0].text);

  console.log('\n== Server: FAQ для чипов ==');
  const faq = await fetch(base + '/api/faq').then((r) => r.json());
  check('faq отдаёт вопросы', Array.isArray(faq.items) && faq.items.length >= 1, JSON.stringify(faq.items));
  check('faq содержит вопрос из Q&A', faq.items.some((i) => String(i.q).toLowerCase() === 'сколько стоят наушники aurora x?'), JSON.stringify(faq.items));

  console.log('\n== Server: статистика ==');
  const stats = await fetch(base + '/api/stats').then((r) => r.json());
  check('stats.sites', stats.totalSites >= 2, stats.totalSites);
  check('stats.answers', stats.answers >= 4, stats.answers);
  check('stats.unresolved >= 1', stats.unresolved >= 1, stats.unresolved);
  check('stats.ratings.avg = 4', stats.ratings.avg === 4, stats.ratings.avg);
  check('stats.popular содержит запрос', stats.popular.some((p) => String(p.q).toLowerCase() === 'сколько стоят наушники aurora x?'), JSON.stringify(stats.popular));
  check('stats.unresolvedQueries', stats.unresolvedQueries.length >= 1 && stats.unresolvedQueries[0].q === 'Гиппопотам в океане HARDFAIL', JSON.stringify(stats.unresolvedQueries[0]));
  check('stats.ai.instructionsSet после PUT', stats.ai.instructionsSet === true && stats.ai.model === 'test-model-2', stats.ai.model);
  check('stats.ai.qaCount после PUT', stats.ai.qaCount === 1, stats.ai.qaCount);
  check('stats.cache.size >= 1', stats.cache.size >= 1, stats.cache.size);
  check('stats.cache.hits >= 1', stats.cache.hits >= 1, stats.cache.hits);

  const logFile = path.join(TMP, 'chatlog.ndjson');
  const logLines = fs.readFileSync(logFile, 'utf8').split('\n').filter(Boolean);
  check('все чаты логируются (NDJSON)', logLines.length >= 6, 'lines=' + logLines.length);

  console.log('\n== Server: нерешённые запросы содержат chatId ==');
  const statsU = await fetch(base + '/api/stats').then((r) => r.json());
  check('unresolvedQueries содержит chatId', statsU.unresolvedQueries.some((u) => u.chatId === 'chat1' && u.q === 'Гиппопотам в океане HARDFAIL'), JSON.stringify(statsU.unresolvedQueries[0]));

  console.log('\n== Server: TTL-очистка тикетов ==');
  await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ticketTtlDays: 0 }) }).then((r) => r.json());
  await post(base + '/api/init', { chatId: 'chat3', email: 'three@example.com', siteName: 'Old', knowledge: KNOWLEDGE });
  store.mutate((s) => {
    const c = s.chats.chat3;
    c.updatedAt = new Date(Date.now() - 100 * 86400000).toISOString();
    return s;
  });
  const cfgTtl = await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ticketTtlDays: 2 }) }).then((r) => r.json());
  check('PUT /api/config принял ticketTtlDays', cfgTtl.ticketTtlDays === 2, cfgTtl.ticketTtlDays);
  const removed = srv.pruneTickets();
  check('старый тикет удалён TTL-очисткой', removed === 1 && store.getChat('chat3') === null, 'removed=' + removed);
  check('свежие тикеты не тронуты', store.getChat('chat1') !== null && store.getChat('chat2') !== null);
  await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ticketTtlDays: 14 }) }).then((r) => r.json());

  console.log('\n== Server: хранилище инструкций (KB) ==');
  const kbList = await fetch(base + '/api/instructions').then((r) => r.json());
  check('инструкция из чата попала в KB', Array.isArray(kbList.items) && kbList.items.some((i) => i.title === 'chat:chat1' && i.text.indexOf('10%') !== -1), JSON.stringify(kbList.items).slice(0, 160));
  const kbAdd = await fetch(base + '/api/instructions', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ title: 'Правило вежливости', text: 'Отвечать кратко и по делу' }) }).then((r) => r.json());
  check('POST /api/instructions добавил инструкцию', kbAdd.ok === true && !!kbAdd.item.id, JSON.stringify(kbAdd));
  const kbList2 = await fetch(base + '/api/instructions').then((r) => r.json());
  check('инструкция появилась в списке', kbList2.items.some((i) => i.title === 'Правило вежливости'));
  const kbDel = await fetch(base + '/api/instructions?id=' + encodeURIComponent(kbAdd.item.id), { method: 'DELETE' }).then((r) => r.json());
  check('DELETE /api/instructions удалил', kbDel.ok === true);
  const kbList3 = await fetch(base + '/api/instructions').then((r) => r.json());
  check('удалённая инструкция отсутствует', !kbList3.items.some((i) => i.id === kbAdd.item.id));

  console.log('\n== Server: SMTP-конфиг из админки ==');
  const smtpUpd = await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ smtp: { host: 'smtp.yandex.ru', port: 465, secure: true, user: 'bot@yandex.ru', pass: 'superpass', from: 'bot@yandex.ru' } }) }).then((r) => r.json());
  check('SMTP включён в ответе конфига', smtpUpd.smtp && smtpUpd.smtp.on === true && smtpUpd.smtp.host === 'smtp.yandex.ru', JSON.stringify(smtpUpd.smtp));
  check('smtpConfig применён в mailer', mailer.smtpConfig && mailer.smtpConfig.host === 'smtp.yandex.ru', JSON.stringify(mailer.smtpConfig));
  const smtpGet = await fetch(base + '/api/config').then((r) => r.json());
  check('пароль SMTP не отдаётся', !('pass' in (smtpGet.smtp || {})) && smtpGet.smtp.user === 'bot@yandex.ru', JSON.stringify(smtpGet.smtp));
  await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ smtp: null }) }).then((r) => r.json());
  const smtpOff = await fetch(base + '/api/config').then((r) => r.json());
  check('SMTP выключается (outbox-режим)', smtpOff.smtp && smtpOff.smtp.on === false, JSON.stringify(smtpOff.smtp));

  console.log('\n== Server: Discord-вебхук ==');
  const hookUrl = 'http://localhost:' + HOOK_PORT + '/api/webhooks/123/test-token';
  const dOff = await fetch(base + '/api/config').then((r) => r.json());
  check('по умолчанию Discord выключен', dOff.discord && dOff.discord.on === false, JSON.stringify(dOff.discord));
  const dUpd = await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ discordWebhook: hookUrl }) }).then((r) => r.json());
  check('PUT /api/config включил Discord', dUpd.discord && dUpd.discord.on === true, JSON.stringify(dUpd.discord));
  check('webhook в ответе маскируется', dUpd.discord.webhook && dUpd.discord.webhook.indexOf('test-token') === -1, dUpd.discord.webhook);

  await post(base + '/api/init', { chatId: 'chatH', email: 'hook@example.com', siteName: 'HookShop', knowledge: KNOWLEDGE });
  await post(base + '/api/chat/chatH/rating', { score: 5 });
  await post(base + '/api/chat/chatH/message', { text: 'Гиппопотам HOOKFAIL HARDFAIL' });
  await post(base + '/api/chat/chatH/handoff', {});
  await new Promise((r) => setTimeout(r, 2500));

  const titles = webhookHits.map((h) => ((h.embeds && h.embeds[0] && h.embeds[0].title) || '')).join(' | ');
  check('события ушли в Discord-вебхук', webhookHits.length >= 3, 'hits=' + webhookHits.length + ' :: ' + titles);
  check('уведомление о новом чате', titles.indexOf('Новый чат') !== -1, titles);
  check('уведомление о нерешённом вопросе', titles.indexOf('Нерешённый вопрос') !== -1, titles);
  check('уведомление о запросе оператора', titles.indexOf('Запрос оператора') !== -1, titles);
  check('в embed есть сайт и email', webhookHits.some((h) => JSON.stringify(h).indexOf('HookShop') !== -1 && JSON.stringify(h).indexOf('hook@example.com') !== -1));

  const dClear = await fetch(base + '/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ discordWebhook: '' }) }).then((r) => r.json());
  check('Discord выключается пустым webhook', dClear.discord && dClear.discord.on === false, JSON.stringify(dClear.discord));

  console.log('\n== Server: отключение операторов ==');
  const off1 = await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ operatorsEnabled: false })
  }).then((r) => r.json());
  check('PUT /api/config отключил операторов', off1.operatorsEnabled === false, off1.operatorsEnabled);
  const cfgOff = await fetch(base + '/api/config').then((r) => r.json());
  check('GET /api/config держит operatorsEnabled=false', cfgOff.operatorsEnabled === false, cfgOff.operatorsEnabled);
  const iniOff = await post(base + '/api/init', { chatId: 'chatNO', email: 'noop@example.com', siteName: 'NoOp', knowledge: KNOWLEDGE });
  check('/api/init отдаёт operatorsEnabled=false', iniOff.operatorsEnabled === false, iniOff.operatorsEnabled);
  const handoffOff = await fetch(base + '/api/chat/chatNO/handoff', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({}) });
  check('handoff при выключенных операторах → 400', handoffOff.status === 400, handoffOff.status);
  const hb = await handoffOff.json();
  check('handoff путь возвращает operators_disabled', hb.error === 'operators_disabled', hb.error);
  const replyOff = await fetch(base + '/api/chat/chatNO/reply', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ text: 'ответ' }) });
  check('reply при выключенных операторах → 400', replyOff.status === 400, replyOff.status);
  const on2 = await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ operatorsEnabled: true })
  }).then((r) => r.json());
  check('PUT /api/config включил операторов обратно', on2.operatorsEnabled === true, on2.operatorsEnabled);
  const handoffOn = await post(base + '/api/chat/chatNO/handoff', {});
  check('handoff после включения операторов работает', handoffOn.ok === true, JSON.stringify(handoffOn));

  console.log('\n== Server: Муха (connectome, альфа) ==');
  const fsta = await fetch(base + '/api/fly/status').then((r) => r.json());
  check('fly: включён по умолчанию', fsta.enabled === true, fsta.enabled);
  check('fly: NeuPrint подключён (mock)', fsta.ok === true && fsta.dataset === 'hemibrain:v1.2.1', JSON.stringify(fsta));
  const flyChatOut = await post(base + '/api/fly/chat', { text: 'Сколько нейронов в мозге мухи?' });
  check('fly: чат отвечает', flyChatOut.ok === true && !!flyChatOut.text && flyChatOut.text.length > 5, JSON.stringify(flyChatOut));
  const flyNeurons = await fetch(base + '/api/fly/neurons').then((r) => r.json());
  check('fly: список нейронов', flyNeurons.items && flyNeurons.items.length === 5, JSON.stringify(flyNeurons).slice(0, 80));
  const fnOnline = await fetch(base + '/api/fly/neuron/101').then((r) => r.json());
  check('fly: реальный нейрон из NeuPrint', fnOnline.demo === false && fnOnline.type === 'MBON(online)' && fnOnline.nodeCount > 0, JSON.stringify(fnOnline).slice(0, 80));
  const fnDemo = await fetch(base + '/api/fly/neuron/demokc1').then((r) => r.json());
  check('fly: демо-нейрон офлайн', fnDemo.demo === true && fnDemo.nodeCount > 0 && fnDemo.points.x.length > 0, JSON.stringify(fnDemo).slice(0, 80));
  flyDown = true;
  const fnFall = await fetch(base + '/api/fly/neuron/999').then((r) => r.json());
  check('fly: фолбэк на демо при недоступности NeuPrint', fnFall.demo === true && fnFall.nodeCount > 0, fnFall.demo);
  flyDown = false;
  await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ flyEnabled: false })
  }).then((r) => r.json());
  const iniFlyOff = await post(base + '/api/init', { chatId: 'chatFLY', email: 'f@example.com', siteName: 'Fly', knowledge: KNOWLEDGE });
  check('fly: /api/init отдаёт flyEnabled=false', iniFlyOff.flyEnabled === false, iniFlyOff.flyEnabled);
  const flyChatDis = await fetch(base + '/api/fly/chat', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ text: 'hi' }) });
  check('fly: чат при выключении → 400 fly_disabled', flyChatDis.status === 400, flyChatDis.status);
  await fetch(base + '/api/config', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ flyEnabled: true })
  }).then((r) => r.json());
  const flyCatOn = await post(base + '/api/fly/chat', { text: 'про инструменты navis' });
  check('fly: чат заработал после включения', flyCatOn.ok === true && !!flyCatOn.text, JSON.stringify(flyCatOn));

  server.close();
  aiMock.close();
  if (hookMock) hookMock.close();
  if (flyMock) flyMock.close();

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