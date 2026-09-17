'use strict';

const http = require('http');
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const ROOT = path.join(__dirname, '..');
const PORT = 11434;
const HOST = '127.0.0.1';

const indexHtml = fs.readFileSync(path.join(ROOT, 'demo', 'index.html'), 'utf8');
const darkHtml = fs.readFileSync(path.join(ROOT, 'demo', 'dark-store.html'), 'utf8');
const widgetJs = fs.readFileSync(path.join(ROOT, 'widget', 'adaptive-widget.js'), 'utf8');

let lastAiRequest = null;
let lastAiHeaders = null;
let lastInit = null;
let lastMessage = null;
let lastHandoff = null;
let lastInstr = null;
let lastRating = null;
const chatMode = {};
const sseClients = Object.create(null);
let ollamaDown = false;

function pushEvent(chatId, event, data) {
  const payload = 'event: ' + event + '\ndata: ' + JSON.stringify(data) + '\n\n';
  if (sseClients[chatId]) sseClients[chatId].forEach((res) => { try { res.write(payload); } catch (e) {} });
}

function jsonRes(res, code, data) {
  res.writeHead(code, { 'Content-Type': 'application/json' });
  res.end(JSON.stringify(data));
}

const server = http.createServer((req, res) => {
  const u = new URL(req.url, 'http://' + HOST + ':' + PORT);

  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

  if (req.method === 'OPTIONS') { res.writeHead(204); res.end(); return; }

  if (req.method === 'POST' && u.pathname === '/v1/chat/completions') {
    let body = '';
    req.on('data', (c) => (body += c));
    req.on('end', () => {
      try { lastAiRequest = JSON.parse(body); } catch (e) { lastAiRequest = null; }
      lastAiHeaders = req.headers;
      res.writeHead(200, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify({
        choices: [{ message: { role: 'assistant', content: 'Наушники Aurora X стоят 7990 ₽ (по данным сайта).' } }]
      }));
    });
    return;
  }

  if (u.pathname === '/api/tags') {
    if (ollamaDown) { res.writeHead(500); res.end('olm down'); return; }
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ models: [{ name: 'qwen2.5:3b' }] }));
    return;
  }

  if (u.pathname === '/disableollama') {
    ollamaDown = true;
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('ollama disabled');
    return;
  }

  if (u.pathname === '/widget/adaptive-widget.js') {
    res.writeHead(200, { 'Content-Type': 'application/javascript; charset=utf-8' });
    res.end(widgetJs);
    return;
  }

  if (u.pathname === '/noai') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(indexHtml.replace('aiEnabled: true', 'aiEnabled: false'));
    return;
  }

  if (u.pathname === '/dark') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(darkHtml);
    return;
  }

  if (u.pathname === '/openai') {
    const html = indexHtml.replace("model: 'qwen2.5:3b'", "provider: 'openai',\n  apiKey: 'sk-test-123',\n  model: 'gpt-4o-mini'");
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(html);
    return;
  }

  if (u.pathname === '/custom') {
    const html = indexHtml.replace("model: 'qwen2.5:3b'", "provider: 'custom',\n  endpoint: 'http://localhost:11434/v1/chat/completions',\n  apiKey: 'sk-test-123',\n  model: 'gpt-test'");
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(html);
    return;
  }

  if (u.pathname === '/backend') {
    const html = indexHtml.replace("model: 'qwen2.5:3b'", "backend: 'http://localhost:11434',\n  askEmail: true,\n  siteName: 'GadgetHub'");
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(html);
    return;
  }

  if (u.pathname === '/api/health') {
    jsonRes(res, 200, { ok: true, from: 'support@deworld.su' });
    return;
  }

  if (u.pathname === '/api/init' && req.method === 'POST') {
    let body = '';
    req.on('data', (c) => (body += c));
    req.on('end', () => {
      lastInit = JSON.parse(body);
      if (!chatMode[lastInit.chatId]) chatMode[lastInit.chatId] = 'ai';
      jsonRes(res, 200, { ok: true, chatId: lastInit.chatId });
    });
    return;
  }

  if (u.pathname === '/api/faq' && req.method === 'GET') {
    jsonRes(res, 200, { items: [{ q: 'Сколько стоят наушники Aurora X?', source: 'qa' }] });
    return;
  }

  const cm = u.pathname.match(/^\/api\/chat\/([^/]+)\/(\w+)$/);
  if (cm) {
    const chatId = decodeURIComponent(cm[1]);
    const action = cm[2];

    if (action === 'events' && req.method === 'GET') {
      res.writeHead(200, {
        'Content-Type': 'text/event-stream',
        'Cache-Control': 'no-cache',
        'Connection': 'keep-alive',
        'Access-Control-Allow-Origin': '*'
      });
      res.write('event: ready\ndata: {"ok":true}\n\n');
      if (!sseClients[chatId]) sseClients[chatId] = new Set();
      sseClients[chatId].add(res);
      req.on('close', () => { sseClients[chatId].delete(res); });
      return;
    }

    if (action === 'message' && req.method === 'POST') {
      let body = '';
      req.on('data', (c) => (body += c));
      req.on('end', () => {
        lastMessage = JSON.parse(body);
        const mode = chatMode[chatId] || 'ai';
        if (mode === 'human') return jsonRes(res, 200, { mode, messages: [] });
        jsonRes(res, 200, { mode, messages: [{ id: 'm_ai', from: 'bot', text: 'Стоимость по данным сайта: 7990 ₽ (ответ сервера).' }] });
      });
      return;
    }

    if (action === 'handoff' && req.method === 'POST') {
      lastHandoff = chatId;
      chatMode[chatId] = 'human';
      jsonRes(res, 200, { ok: true, mode: 'human' });
      return;
    }

    if (action === 'instructions' && req.method === 'POST') {
      let body = '';
      req.on('data', (c) => (body += c));
      req.on('end', () => { lastInstr = JSON.parse(body); jsonRes(res, 200, { ok: true }); });
      return;
    }

    if (action === 'rating' && req.method === 'POST') {
      let body = '';
      req.on('data', (c) => (body += c));
      req.on('end', () => { lastRating = JSON.parse(body); jsonRes(res, 200, { ok: true, score: lastRating.score }); });
      return;
    }
  }

  if (u.pathname === '/' || u.pathname === '/index.html') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(indexHtml);
    return;
  }

  res.writeHead(404);
  res.end();
});

const pageErrors = [];

function base() { return 'http://localhost:' + PORT; }

async function main() {
  await new Promise((resolve) => server.listen(PORT, resolve));
  console.log('[server] mock на ' + base());

  const browser = await puppeteer.launch({
    executablePath: 'C:/Program Files/Google/Chrome/Application/chrome.exe',
    headless: true,
    args: ['--no-sandbox', '--disable-gpu']
  });

  const page = await browser.newPage();
  page.on('pageerror', (e) => pageErrors.push(String(e)));
  page.setDefaultTimeout(15000);

  function shExpr() {
    return "document.querySelector('[data-adaptive-widget]').shadowRoot";
  }

  let passed = 0;
  let failed = 0;
  function check(name, cond, extra) {
    if (cond) { passed++; console.log('  [ok] ' + name); }
    else { failed++; console.log('  [FAIL] ' + name + (extra ? ' :: ' + extra : '')); }
  }

  // ---------- Тест 1: светлый магазин, стиль + знания ----------
  console.log('\n== Тест 1: GadgetHub (светлая тема) ==');
  await page.goto(base() + '/', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => window.__ADAPTIVE_DEBUG__, { timeout: 10000 });

  const palette = await page.evaluate(() => window.__ADAPTIVE_DEBUG__.palette);
  const knowledge = await page.evaluate(() => window.__ADAPTIVE_DEBUG__.knowledge);
  const knowText = knowledge.map((k) => k.split(' :: ')[0]).join(' | ');

  check('primary = #0284c7 (из --brand)', palette.primary === '#0284c7', palette.primary);
  check('acc = #7c3aed (из --accent)', String(palette.accent).toLowerCase() === '#7c3aed', palette.accent);
  check('тема светлая (dark=false)', palette.dark === false);
  check('фон = #f8fafc', palette.bg.toLowerCase() === '#f8fafc', palette.bg);

  check('знания: товар Наушники Aurora X', knowText.indexOf('Наушники Aurora X') !== -1);
  check('знания: FAQ возврат', knowText.indexOf('Как оформить возврат?') !== -1);
  check('знания: контакты', knowText.indexOf('Контакты') !== -1);
  const price = knowledge.find((k) => k.indexOf('Наушники Aurora X') !== -1);
  check('JSON-LD цена 7990 в знаниях', !!price && price.indexOf('7990') !== -1, price && price.slice(0, 80));

  // ---------- Тест 2: статус AI через mock Ollama ----------
  console.log('\n== Тест 2: health-check Ollama ==');
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host.shadowRoot.querySelector('.s').textContent.indexOf('AI:') !== -1;
  }, { timeout: 10000 });
  const status = await page.evaluate(() => document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.s').textContent);
  check('статус: AI: qwen2.5:3b', status.indexOf('qwen2.5:3b') !== -1, status);

  // ---------- Тест 3: диалог через AI (mock) ----------
  console.log('\n== Тест 3: диалог через AI (mock) ==');
  await page.evaluate(() => {
    document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.fab').click();
  });
  await page.waitForFunction(() => document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.panel').classList.contains('open'));
  check('панель открывается', true);

  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    const input = s.querySelector('.input input');
    input.value = 'Сколько стоят наушники Aurora X?';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });

  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('по данным сайта') !== -1;
  }, { timeout: 12000 });

  const lastBot = await page.evaluate(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    return msgs[msgs.length - 1].textContent;
  });
  check('ответ бота пришёл от AI', lastBot.indexOf('7990') !== -1 && lastBot.indexOf('по данным сайта') !== -1, lastBot);

  await new Promise((r) => setTimeout(r, 200));
  check('в RAG-контекст попали данные сайта', !!lastAiRequest && lastAiRequest.messages[0].content.indexOf('GadgetHub') !== -1, lastAiRequest && lastAiRequest.messages[0].content.slice(0, 60));
  check('модель в запросе qwen2.5:3b', !!lastAiRequest && lastAiRequest.model === 'qwen2.5:3b', lastAiRequest && lastAiRequest.model);

  // ---------- Тест 4: fallback без AI ----------
  console.log('\n== Тест 4: локальный поиск (AI выключен) ==');
  await page.goto(base() + '/noai', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => window.__ADAPTIVE_DEBUG__, { timeout: 10000 });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && !!host.shadowRoot.querySelector('.fab');
  });
  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    s.querySelector('.fab').click();
    const input = s.querySelector('.input input');
    input.value = 'Как оформить возврат?';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });
  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('14 дней') !== -1;
  }, { timeout: 10000 });
  const localBot = await page.evaluate(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    return msgs[msgs.length - 1].textContent;
  });
  check('fallback ответил из FAQ (14 дней)', localBot.indexOf('14 дней') !== -1, localBot.slice(0, 80));

  // ---------- Тест 5: тёмная тема ----------
  console.log('\n== Тест 5: Nebula (тёмная тема) ==');
  await page.goto(base() + '/dark', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => window.__ADAPTIVE_DEBUG__, { timeout: 10000 });
  const darkPalette = await page.evaluate(() => window.__ADAPTIVE_DEBUG__.palette);
  check('primary = #f43f5e (из --brand)', darkPalette.primary.toLowerCase() === '#f43f5e', darkPalette.primary);
  check('тема тёмная (dark=true)', darkPalette.dark === true, 'dark=' + darkPalette.dark);
  check('bg тёмный', parseInt(darkPalette.bg.replace('#', ''), 16) < 0x808080, darkPalette.bg);
  const darkKnow = await page.evaluate(() => window.__ADAPTIVE_DEBUG__.knowledge.join(' | '));
  check('знания: ключ приходит мгновенно', darkKnow.indexOf('Как быстро приходит ключ') !== -1, darkKnow.slice(0, 100));

  // ---------- Тест 6: облачный провайдер OpenAI по API-ключу ----------
  console.log('\n== Тест 6: облачный провайдер OpenAI по API-ключу ==');
  await page.goto(base() + '/openai', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && host.shadowRoot.querySelector('.s').textContent.indexOf('OpenAI') !== -1;
  }, { timeout: 10000 });
  const openaiStatus = await page.evaluate(() => document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.s').textContent);
  check('статус: AI: gpt-4o-mini · OpenAI', openaiStatus.indexOf('gpt-4o-mini') !== -1 && openaiStatus.indexOf('OpenAI') !== -1, openaiStatus);
  const backend = await page.evaluate(() => window.__ADAPTIVE_DEBUG__.backend);
  check('авто-резолв провайдера → openai', backend.provider === 'openai', backend.provider);
  check('эндпоинт = api.openai.com/v1', backend.endpoint === 'https://api.openai.com/v1/chat/completions', backend.endpoint);
  check('модель по умолчанию gpt-4o-mini', backend.model === 'gpt-4o-mini', backend.model);

  // ---------- Тест 7: свой API-эндпоинт (OpenAI-совместимый) + apiKey ----------
  console.log('\n== Тест 7: свой API-эндпоинт + apiKey ==');
  await page.goto(base() + '/custom', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => window.__ADAPTIVE_DEBUG__, { timeout: 10000 });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && !!host.shadowRoot.querySelector('.fab');
  });
  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    s.querySelector('.fab').click();
    const input = s.querySelector('.input input');
    input.value = 'Сколько стоят наушники Aurora X?';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });
  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('по данным сайта') !== -1;
  }, { timeout: 12000 });
  await new Promise((r) => setTimeout(r, 200));
  check('модель в запросе gpt-test', !!lastAiRequest && lastAiRequest.model === 'gpt-test', lastAiRequest && lastAiRequest.model);
  check('отправлен Bearer-ключ', !!(lastAiHeaders && lastAiHeaders.authorization === 'Bearer sk-test-123'), lastAiHeaders && lastAiHeaders.authorization);
  check('RAG-контекст в системном промпте', !!lastAiRequest && lastAiRequest.messages[0].content.indexOf('Наушники Aurora X') !== -1);

  // ---------- Тест 8: backend-режим — email, чат, оператор ----------
  console.log('\n== Тест 8: backend-режим (email + оператор) ==');
  await page.goto(base() + '/backend', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && !!host.shadowRoot.querySelector('.fab');
  });
  await page.evaluate(() => { document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.fab').click(); });
  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('email') !== -1;
  }, { timeout: 10000 });
  check('запрос email перед чатом', true);

  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    const input = s.querySelector('.input input');
    input.value = 'user@example.com';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });
  await new Promise((r) => setTimeout(r, 600));
  check('email отправлен на сервер (init)', !!lastInit && lastInit.email === 'user@example.com', lastInit && lastInit.email);
  check('в init переданы знания сайта', !!lastInit && lastInit.knowledge.length > 3, lastInit && lastInit.knowledge.length);
  check('в init передан промпт (RAG)', !!lastInit && lastInit.prompt.indexOf('Данные сайта') !== -1);

  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    const input = s.querySelector('.input input');
    input.value = 'Сколько стоят наушники?';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });
  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('ответ сервера') !== -1;
  }, { timeout: 10000 });
  check('запрос уходит на сервер', !!lastMessage && lastMessage.text === 'Сколько стоят наушники?', lastMessage && lastMessage.text);

  await page.waitForFunction(() => {
    const chips = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.chip');
    return chips.length && Array.from(chips).some((c) => c.textContent.indexOf('Aurora') !== -1);
  }, { timeout: 8000 });
  check('чипы: частые вопросы подгружены с сервера (/api/faq)', true);
  await page.evaluate(() => {
    const chips = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.chip');
    const chip = Array.from(chips).find((c) => c.textContent.indexOf('Aurora') !== -1);
    chip.click();
  });
  await new Promise((r) => setTimeout(r, 500));
  check('клик по чипу отправляет частый вопрос', !!lastMessage && lastMessage.text === 'Сколько стоят наушники Aurora X?', lastMessage && lastMessage.text);

  await page.evaluate(() => { document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('[data-op]').click(); });
  await new Promise((r) => setTimeout(r, 600));
  check('кнопка оператора → handoff', lastHandoff !== null);
  const chatId = lastInit && lastInit.chatId;
  pushEvent(chatId, 'reply', { id: 'm_op1', from: 'agent', text: 'Добрый день! Я оператор, чем помочь?' });

  await page.waitForFunction(() => {
    const names = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .name');
    return Array.from(names).some((n) => n.textContent.indexOf('Оператор') !== -1);
  }, { timeout: 10000 });
  check('ответ оператора приходит через SSE', true);
  check('нет ошибок в консоли', pageErrors.length === 0, pageErrors.join('; '));

  // ---------- Тест 9: настроек агента в виджете больше нет ----------
  console.log('\n== Тест 9: настройки агента не в виджете (в админке) ==');
  await page.goto(base() + '/', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && !!host.shadowRoot.querySelector('.fab');
  });
  const hasGear = await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    return !!(s.querySelector('[data-gear]') || s.querySelector('[data-cfg]') || s.querySelector('[data-save]'));
  });
  check('шестерёнки и панели настроек в виджете нет', !hasGear);

  // ---------- Тест 10: оценка агента при закрытии чата ----------
  console.log('\n== Тест 10: оценка агента при закрытии ==');
  await page.evaluate(() => { try { localStorage.clear(); } catch (e) {} });
  await page.goto(base() + '/backend', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && !!host.shadowRoot.querySelector('.fab');
  });
  await page.evaluate(() => { document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.fab').click(); });
  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('email') !== -1;
  }, { timeout: 10000 });
  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    const input = s.querySelector('.input input');
    input.value = 'user@example.com';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });
  await new Promise((r) => setTimeout(r, 600));

  await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot;
    const input = s.querySelector('.input input');
    input.value = 'Сколько стоят наушники?';
    input.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
  });
  await page.waitForFunction(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    const last = msgs[msgs.length - 1];
    return last && last.textContent.indexOf('ответ сервера') !== -1;
  }, { timeout: 10000 });

  await page.evaluate(() => { document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.close').click(); });
  await page.waitForFunction(() => !!document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.stars [data-star]'), { timeout: 6000 });
  check('при закрытии предлагается оценка', true);

  await page.evaluate(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    host.shadowRoot.querySelector('.stars [data-star="4"]').click();
  });
  await new Promise((r) => setTimeout(r, 500));
  const closedAfterRating = await page.evaluate(() => !document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.panel').classList.contains('open'));
  check('панель закрылась после оценки', closedAfterRating);
  check('оценка отправлена на сервер', !!lastRating && lastRating.score === 4, lastRating && lastRating.score);
  const ratingMsg = await page.evaluate(() => {
    const msgs = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelectorAll('.b .m');
    return msgs[msgs.length - 1].textContent;
  });
  check('показано подтверждение оценки', ratingMsg.indexOf('Спасибо') !== -1, ratingMsg);

  // ---------- Тест 11: нейтральный статус, когда Ollama недоступна ----------
  console.log('\n== Тест 11: статус при недоступной Ollama ==');
  await page.goto(base() + '/disableollama', { waitUntil: 'domcontentloaded' });
  await page.goto(base() + '/', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => {
    const host = document.querySelector('[data-adaptive-widget]');
    return host && host.shadowRoot && host.shadowRoot.querySelector('.s').textContent.indexOf('ИИ отключён') !== -1;
  }, { timeout: 10000 });
  const offStatus = await page.evaluate(() => {
    const s = document.querySelector('[data-adaptive-widget]').shadowRoot.querySelector('.s');
    return { text: s.textContent, color: s.style.color };
  });
  check('нет красной ошибки "Ollama не запущен"', offStatus.text.indexOf('Ollama не запущен') === -1 && offStatus.text.indexOf('ИИ отключён') !== -1, offStatus.text);
  check('статус жёлтый (не ошибка)', offStatus.color === 'rgb(251, 191, 36)', offStatus.color);

  // ---------- Тест 12: динамическая смена темы и палитры без перезагрузки ----------
  console.log('\n== Тест 12: динамическая смена темы и палитры ==');
  const apiType = await page.evaluate(() => typeof window.AdaptiveWidget.refresh);
  check('публичный API AdaptiveWidget.refresh доступен', apiType === 'function', apiType);

  await page.evaluate(() => {
    document.documentElement.style.setProperty('--brand', '#ea580c');
    document.documentElement.style.setProperty('--accent', '#f59e0b');
    window.AdaptiveWidget.refresh();
  });
  await new Promise((r) => setTimeout(r, 300));
  const dyn = await page.evaluate(() => {
    const p = window.__ADAPTIVE_DEBUG__.palette;
    return { primary: p.primary, accent: p.accent, hosts: document.querySelectorAll('[data-adaptive-widget]').length };
  });
  check('палитра обновилась без перезагрузки', String(dyn.primary).toLowerCase() === '#ea580c' && String(dyn.accent).toLowerCase() === '#f59e0b', dyn.primary + '/' + dyn.accent);
  check('виджет не дублируется при refresh', dyn.hosts === 1, 'hosts=' + dyn.hosts);

  await page.evaluate(() => {
    document.body.style.background = '#0b1220';
    window.AdaptiveWidget.refresh();
  });
  await new Promise((r) => setTimeout(r, 300));
  const darkDyn = await page.evaluate(() => window.__ADAPTIVE_DEBUG__.palette.dark);
  check('тёмная тема подхватывается динамически', darkDyn === true, 'dark=' + darkDyn);

  check('итог: нет ошибок в консоли на всей сессии', pageErrors.length === 0, pageErrors.join('; '));

  await browser.close();
  server.close();

  console.log('\n==================================');
  console.log('  ИТОГО: ' + passed + ' passed, ' + failed + ' failed');
  console.log('==================================');
  process.exit(failed ? 1 : 0);
}

main().catch((e) => {
  console.error('Тест упал:', e);
  server.close();
  process.exit(2);
});