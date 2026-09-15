'use strict';

const fs = require('fs');
const os = require('os');
const path = require('path');

const TMP = fs.mkdtempSync(path.join(os.tmpdir(), 'aw-auth-'));
const CFG = path.join(TMP, 'config.json');
fs.writeFileSync(CFG, JSON.stringify({
  provider: 'openai',
  endpoint: 'http://localhost:12999/v1/chat/completions',
  model: 'auth-model',
  apiKey: 'sk-super-secret-key',
  from: 'noreply@example.com',
  adminToken: 'SECRET',
  smtp: null
}, null, 2));

process.env.AW_CONFIG = CFG;
process.env.AW_DATA_DIR = TMP;
process.env.AW_ADMIN_TOKEN = 'SECRET';

const srv = require('../server/server');
const PORT = 13002;

let passed = 0, failed = 0;
function check(name, cond, extra) {
  if (cond) { passed++; console.log('  [ok] ' + name); }
  else { failed++; console.log('  [FAIL] ' + name + (extra ? ' :: ' + extra : '')); }
}

function api(p, opt) {
  return fetch('http://localhost:' + PORT + p, opt || {}).then(async (r) => ({ status: r.status, body: await r.json().catch(() => ({})) }));
}

async function main() {
  const server = srv.start(PORT);
  await new Promise((resolve) => server.once('listening', resolve));

  console.log('\n== Auth: доступ к админ-эндпоинтам ==');
  check('без токена /api/chats → 401', (await api('/api/chats')).status === 401);
  check('без токена /api/stats → 401', (await api('/api/stats')).status === 401);
  check('без токена /api/config → 401', (await api('/api/config')).status === 401);
  check('без токена PUT /api/config → 401', (await api('/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ model: 'x' }) })).status === 401);
  check('неверный токен → 401', (await api('/api/chats', { headers: { 'x-admin-token': 'BAD' } })).status === 401);
  check('верный токен → 200', (await api('/api/chats', { headers: { 'x-admin-token': 'SECRET' } })).status === 200);
  check('public /api/health без токена → 200', (await api('/api/health')).status === 200);

  console.log('\n== Auth: from без SMTP (bugfix mailer) ==');
  const h = await api('/api/health');
  check('health.from = cfg.from (noreply@example.com)', h.body.from === 'noreply@example.com', h.body.from);

  console.log('\n== Auth: сохранение конфига ==');
  const put = await api('/api/config', { method: 'PUT', headers: { 'Content-Type': 'application/json', 'x-admin-token': 'SECRET' }, body: JSON.stringify({ model: 'new-auth-model', instructions: 'Всегда здоровайтесь' }) });
  check('PUT конфига применился', put.body.model === 'new-auth-model' && put.body.instructions === 'Всегда здоровайтесь', JSON.stringify(put.body));
  check('конфиг персистнулся в файл', JSON.parse(fs.readFileSync(CFG, 'utf8')).model === 'new-auth-model');
  check('apiKey в ответе замаскирован', put.body.apiKey !== 'sk-super-secret-key' && String(put.body.apiKey).indexOf('…') !== -1, put.body.apiKey);

  console.log('\n== Auth: SSE клиент не требует токена ==');
  const sse = await new Promise((resolve) => {
    const req = require('http').get('http://localhost:' + PORT + '/api/chat/nonexist/events', (res) => resolve(res.statusCode));
    req.on('error', () => resolve(500));
  });
  check('events для несуществующего чата → 404', sse === 404, sse);

  console.log('\n==================================');
  console.log('  AUTH: ' + passed + ' passed, ' + failed + ' failed');
  console.log('==================================');
  process.exitCode = failed ? 1 : 0;
  server.close();
}

main().catch((e) => { console.error('auth-тест упал:', e); process.exit(2); });