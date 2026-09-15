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
      res.writeHead(200, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify({
        choices: [{ message: { role: 'assistant', content: 'Наушники Aurora X стоят 7990 ₽ (по данным сайта).' } }]
      }));
    });
    return;
  }

  if (u.pathname === '/api/tags') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ models: [{ name: 'qwen2.5:3b' }] }));
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

  check('нет ошибок в консоли', pageErrors.length === 0, pageErrors.join('; '));

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