'use strict';

const http = require('http');
const fs = require('fs');
const path = require('path');

const store = require('./lib/store');
const mailer = require('./lib/mailer');
const ai = require('./lib/ai');

const ADMIN_DIR = path.join(__dirname, '..', 'admin');

function loadConfig() {
  const def = {
    provider: 'ollama',
    endpoint: process.env.AW_ENDPOINT || 'http://localhost:11434/v1/chat/completions',
    model: process.env.AW_MODEL || 'qwen2.5:3b',
    apiKey: process.env.AW_API_KEY || '',
    from: 'support@deworld.su',
    adminToken: process.env.AW_ADMIN_TOKEN || '',
    smtp: null
  };
  try {
    const f = path.join(__dirname, 'config.json');
    if (fs.existsSync(f)) Object.assign(def, JSON.parse(fs.readFileSync(f, 'utf8')));
  } catch (e) {
    console.error('[server] config.json не прочитан:', e.message);
  }
  return def;
}

const CFG = loadConfig();
mailer.configure(CFG);

const SSE_CLIENTS = Object.create(null);

function sseClients(chatId) {
  if (!SSE_CLIENTS[chatId]) SSE_CLIENTS[chatId] = new Set();
  return SSE_CLIENTS[chatId];
}
function sseCount(chatId) { return SSE_CLIENTS[chatId] ? SSE_CLIENTS[chatId].size : 0; }
function sseSend(chatId, event, data) {
  const payload = 'event: ' + event + '\ndata: ' + JSON.stringify(data) + '\n\n';
  sseClients(chatId).forEach((res) => { try { res.write(payload); } catch (e) {} });
}

function readBody(req) {
  return new Promise((resolve) => {
    let b = '';
    req.on('data', (c) => (b += c));
    req.on('end', () => { try { resolve(b ? JSON.parse(b) : {}); } catch (e) { resolve({}); } });
  });
}

function json(res, code, data) {
  res.writeHead(code, {
    'Content-Type': 'application/json; charset=utf-8',
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'GET, POST, OPTIONS',
    'Access-Control-Allow-Headers': 'Content-Type, Authorization, x-admin-token'
  });
  res.end(JSON.stringify(data));
}

function now() { return new Date().toISOString(); }
function logChat(action, chatId, extra) {
  store.appendLog(Object.assign({ at: now(), action, chatId }, extra || {}));
}

function chip(chat) {
  const ms = chat.messages || [];
  return {
    id: chat.id,
    email: chat.email || '',
    siteName: chat.siteName || '',
    status: chat.status,
    createdAt: chat.createdAt,
    updatedAt: chat.updatedAt,
    messageCount: ms.length,
    lastText: ms.length ? String(ms[ms.length - 1].text).slice(0, 80) : ''
  };
}

function serveAdmin(res, p) {
  let file = p;
  if (file === '/' || file === '/admin' || file === '/admin/') file = '/admin/index.html';
  const fp = path.join(ADMIN_DIR, path.normalize(file.replace(/^\/admin/, '')));
  if (!fp.startsWith(ADMIN_DIR) || !fs.existsSync(fp)) { res.writeHead(404); res.end('not found'); return; }
  const ext = path.extname(fp);
  const types = { '.html': 'text/html; charset=utf-8', '.js': 'application/javascript; charset=utf-8', '.css': 'text/css; charset=utf-8' };
  res.writeHead(200, { 'Content-Type': types[ext] || 'text/plain' });
  fs.createReadStream(fp).pipe(res);
}

function adminGuard(req, res) {
  if (CFG.adminToken && req.headers['x-admin-token'] !== CFG.adminToken) { json(res, 401, { error: 'forbidden' }); return false; }
  return true;
}

async function handle(req, res) {
  const u = new URL(req.url, 'http://localhost');

  if (req.method === 'OPTIONS') {
    res.writeHead(204, { 'Access-Control-Allow-Origin': '*', 'Access-Control-Allow-Headers': 'Content-Type, Authorization, x-admin-token' });
    res.end();
    return;
  }

  if (u.pathname === '/' || u.pathname === '/admin' || u.pathname === '/admin/' || u.pathname.indexOf('/admin/') === 0) {
    return serveAdmin(res, u.pathname);
  }

  if (u.pathname === '/api/health') {
    return json(res, 200, { ok: true, from: mailer.from });
  }

  if (u.pathname === '/api/init' && req.method === 'POST') {
    const body = await readBody(req);
    const chatId = String(body.chatId || '').slice(0, 120) || store.genId('c');
    const snap = {
      email: String(body.email || '').slice(0, 200),
      siteName: String(body.siteName || '').slice(0, 200),
      page: String(body.page || '').slice(0, 500),
      instructions: String(body.instructions || '').slice(0, 4000),
      promptSnap: String(body.prompt || '').slice(0, 8000)
    };
    const chat = store.getChat(chatId);
    if (chat) {
      Object.keys(snap).forEach((k) => { if (snap[k]) chat[k] = snap[k]; });
      if (Array.isArray(body.knowledge)) chat.knowledge = body.knowledge.slice(0, 80);
      chat.updatedAt = now();
      logChat('chat_refresh', chatId, { email: snap.email });
    } else {
      store.mutate((s) => {
        s.chats[chatId] = Object.assign({
          id: chatId,
          createdAt: now(),
          updatedAt: now(),
          status: 'ai',
          knowledge: Array.isArray(body.knowledge) ? body.knowledge.slice(0, 80) : [],
          messages: []
        }, snap);
        return s;
      });
      logChat('chat_created', chatId, { email: snap.email, site: snap.siteName });
    }
    return json(res, 200, { ok: true, chatId });
  }

  if (u.pathname === '/api/chats' && req.method === 'GET') {
    if (!adminGuard(req, res)) return;
    const list = Object.keys(store.getChats()).map((id) => chip(store.getChat(id)));
    list.sort((a, b) => (a.updatedAt < b.updatedAt ? 1 : -1));
    return json(res, 200, list);
  }

  const m = u.pathname.match(/^\/api\/chat\/([^/]+)\/([a-z]+)$/);
  if (m) {
    const chatId = decodeURIComponent(m[1]);
    const action = m[2];
    const chat = store.getChat(chatId);

    if (action === 'events' && req.method === 'GET') {
      if (!chat) return json(res, 404, { error: 'chat not found' });
      res.writeHead(200, {
        'Content-Type': 'text/event-stream; charset=utf-8',
        'Cache-Control': 'no-cache',
        'Connection': 'keep-alive',
        'Access-Control-Allow-Origin': '*'
      });
      res.write('event: ready\ndata: {"ok":true}\n\n');
      sseClients(chatId).add(res);
      req.on('close', () => { sseClients(chatId).delete(res); });
      return;
    }

    if (!chat) return json(res, 404, { error: 'chat not found' });

    if (action === 'message' && req.method === 'POST') {
      const body = await readBody(req);
      const text = String(body.text || '').trim().slice(0, 2000);
      if (!text) return json(res, 400, { error: 'empty message' });
      chat.messages.push({ id: store.genId('m'), role: 'user', text, ts: now() });
      chat.updatedAt = now();
      logChat('user_message', chatId, { text: text.slice(0, 120) });

      let out = [];
      if (chat.status === 'ai') {
        const a = await ai.answer(CFG, chat, text);
        chat.lastAnswerSource = a.source || null;
        logChat('ai_answer', chatId, { source: a.source || null, fallback: a.source === 'search' });
        if (a.text) {
          const botMsg = { id: store.genId('m'), role: 'bot', text: a.text, ts: now() };
          chat.messages.push(botMsg);
          out.push({ id: botMsg.id, from: 'bot', text: botMsg.text });
        }
      }
      chat.updatedAt = now();
      return json(res, 200, { mode: chat.status, messages: out });
    }

    if (action === 'handoff' && req.method === 'POST') {
      chat.status = 'human';
      chat.messages.push({ id: store.genId('m'), role: 'system', text: 'Чат передан оператору', ts: now() });
      chat.updatedAt = now();
      logChat('handoff', chatId, { email: chat.email });
      sseSend(chatId, 'mode', { mode: 'human' });
      return json(res, 200, { ok: true, mode: 'human' });
    }

    if (action === 'reply' && req.method === 'POST') {
      if (!adminGuard(req, res)) return;
      const body = await readBody(req);
      const text = String(body.text || '').trim().slice(0, 2000);
      if (!text) return json(res, 400, { error: 'empty reply' });
      const msg = { id: store.genId('m'), role: 'agent', text, ts: now() };
      chat.messages.push(msg);
      chat.status = chat.status === 'closed' ? 'closed' : 'human';
      chat.updatedAt = now();
      logChat('agent_reply', chatId, { text: text.slice(0, 120) });

      if (sseCount(chatId) === 0 && chat.email) {
        const tail = chat.messages.slice(-6).map((x) => (x.role === 'user' ? 'Пользователь: ' : 'Оператор: ') + x.text).join('\n');
        mailer.sendEmail({
          to: chat.email,
          subject: 'Ответ оператора — ' + (chat.siteName || 'ваш чат'),
          text: 'Новый ответ в вашем чате:\n\n' + text + '\n\n--- История ---\n' + tail
        }).then((rec) => logChat('email_sent', chatId, { id: rec.id, to: rec.to }));
      }

      sseSend(chatId, 'reply', { id: msg.id, from: 'agent', text });
      return json(res, 200, { ok: true });
    }

    if (action === 'instructions' && req.method === 'POST') {
      if (!adminGuard(req, res)) return;
      const body = await readBody(req);
      chat.instructions = String(body.instructions || '').slice(0, 4000);
      chat.updatedAt = now();
      logChat('instructions', chatId);
      return json(res, 200, { ok: true });
    }

    if (action === 'mode' && req.method === 'POST') {
      if (!adminGuard(req, res)) return;
      const body = await readBody(req);
      chat.status = body.mode === 'ai' ? 'ai' : 'human';
      chat.messages.push({ id: store.genId('m'), role: 'system', text: 'Режим: ' + (chat.status === 'ai' ? 'ИИ-агент' : 'оператор'), ts: now() });
      chat.updatedAt = now();
      logChat('mode_change', chatId, { mode: chat.status });
      sseSend(chatId, 'mode', { mode: chat.status });
      return json(res, 200, { ok: true });
    }

    if (action === 'close' && req.method === 'POST') {
      if (!adminGuard(req, res)) return;
      chat.status = 'closed';
      chat.updatedAt = now();
      logChat('closed', chatId);
      sseSend(chatId, 'mode', { mode: 'closed' });
      return json(res, 200, { ok: true });
    }

    if (action === 'full' && req.method === 'GET') {
      if (!adminGuard(req, res)) return;
      return json(res, 200, chat);
    }

    return json(res, 404, { error: 'unknown action' });
  }

  return json(res, 404, { error: 'not found' });
}

function start(port) {
  const server = http.createServer(handle);
  server.listen(port, () => {
    console.log('[server] Адаптивный виджет: http://localhost:' + port);
    console.log('[server] Админ-панель:   http://localhost:' + port + '/admin');
    console.log('[server] AI endpoint: ' + CFG.endpoint + ' (' + CFG.model + ')');
  });
  return server;
}

if (require.main === module) {
  start(Number(process.env.PORT || 3000));
}

module.exports = { start, store, ai, mailer, loadConfig };