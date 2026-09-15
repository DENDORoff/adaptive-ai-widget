(function () {
  'use strict';

  var DEFAULTS = {
    siteName: '',
    logo: '',
    position: 'right',
    apiKey: '',
    endpoint: 'http://localhost:11434/v1/chat/completions',
    model: 'qwen2.5:3b',
    aiEnabled: true,
    autoOpen: true,
    teaser: ''
  };

  var CUSTOM = window.ADAPTIVE_WIDGET || {};
  var CONFIG = {};
  var k;
  for (k in DEFAULTS) {
    if (DEFAULTS.hasOwnProperty(k)) {
      CONFIG[k] = CUSTOM[k] !== undefined ? CUSTOM[k] : DEFAULTS[k];
    }
  }
  if (!CONFIG.siteName) {
    CONFIG.siteName = (document.title || '').split(/[|—–]/)[0].trim() || 'Сайт';
  }

  var LANG = (document.documentElement.lang || 'ru').slice(0, 2).toLowerCase();
  if (CONFIG.lang && CONFIG.lang.length === 2) LANG = CONFIG.lang;
  var I18N_EN = LANG === 'en';
  var T = I18N_EN ? {
    title: 'Site assistant',
    status: 'answers with real site data',
    input: 'Ask about products, delivery, returns...',
    send: 'Send',
    fallback: 'I could not find an exact answer on this page. Please clarify your question or contact us directly.',
    chips: 'Popular questions',
    source: 'Source',
    close: 'Close',
    preview: 'Hi! I am an AI agent for this site. Try asking about products, delivery or returns.'
  } : {
    title: 'Ассистент сайта',
    status: 'отвечаю по реальным данным',
    input: 'Спросите о товарах, доставке, возврате…',
    send: 'Отправить',
    fallback: 'Не нашёл точного ответа на этой странице. Уточните вопрос или свяжитесь с нами напрямую.',
    chips: 'Частые вопросы',
    source: 'Источник',
    close: 'Закрыть',
    preview: 'Привет! Я ИИ-агент этого сайта. Спросите меня о товарах, доставке или возврате.'
  };

  var PALETTE = { primary: '#2563eb', accent: '#312e81', bg: '#ffffff', fg: '#111827', font: 'system-ui', radius: 14, dark: false, logo: '' };

  function cssVar(el, name) {
    var v = getComputedStyle(el).getPropertyValue(name);
    return v ? v.trim() : '';
  }

  function rgbToHex(color) {
    var m = color.match(/rgba?\(([^)]+)\)/);
    if (!m) return '';
    var p = m[1].split(',').map(function (x) { return Math.round(parseFloat(x.trim())); });
    function h(n) { var s = n.toString(16); return s.length === 1 ? '0' + s : s; }
    return '#' + h(p[0]) + h(p[1]) + h(p[2]);
  }

  function luminance(hex) {
    var m = hex.replace('#', '');
    if (m.length === 3) m = m.split('').map(function (c) { return c + c; }).join('');
    if (m.length < 6) return 1;
    var r = parseInt(m.substr(0, 2), 16);
    var g = parseInt(m.substr(2, 2), 16);
    var b = parseInt(m.substr(4, 2), 16);
    return (0.299 * r + 0.587 * g + 0.114 * b) / 255;
  }

  function shade(hex, pct) {
    var m = hex.replace('#', '');
    if (m.length === 3) m = m.split('').map(function (c) { return c + c; }).join('');
    var n = [parseInt(m.substr(0, 2), 16), parseInt(m.substr(2, 2), 16), parseInt(m.substr(4, 2), 16)];
    var out = n.map(function (v) {
      var x = pct >= 0 ? Math.round(v * (1 - pct)) : Math.round(v + (255 - v) * Math.abs(pct));
      return Math.max(0, Math.min(255, x));
    });
    function hh(v) { var s = v.toString(16); return s.length === 1 ? '0' + s : s; }
    return '#' + hh(out[0]) + hh(out[1]) + hh(out[2]);
  }

  function plausible(c) { return /^#[0-9a-f]{3,8}$/i.test(c); }

  function extractStyle() {
    var rootEl = document.documentElement;
    var VARS = ['--brand', '--primary', '--accent', '--color-primary', '--color-accent', '--main-color', '--site-color'];
    var i, v;
    for (i = 0; i < VARS.length; i++) {
      v = cssVar(rootEl, VARS[i]);
      if (plausible(v)) { PALETTE.primary = v; break; }
    }
    if (!plausible(PALETTE.primary)) {
      var lnk = document.querySelector('a');
      if (lnk) { var c = rgbToHex(getComputedStyle(lnk).color); if (plausible(c)) PALETTE.primary = c; }
    }
    var acc = cssVar(rootEl, '--accent');
    PALETTE.accent = plausible(acc) ? acc : shade(PALETTE.primary, 0.55);
    if (!plausible(PALETTE.primary)) PALETTE.primary = '#2563eb';

    var bodyColor = rgbToHex(getComputedStyle(document.body).backgroundColor);
    if (plausible(bodyColor) && bodyColor !== '#ffffff') PALETTE.bg = bodyColor;
    PALETTE.dark = luminance(PALETTE.bg) < 0.45;
    PALETTE.fg = PALETTE.dark ? '#f3f4f6' : '#111827';
    PALETTE.font = (getComputedStyle(document.body).fontFamily || 'system-ui').split('"').join('').split(',')[0];
    var btn = document.querySelector('button, .btn, a[class*="btn"]');
    if (btn) {
      var r = parseInt(getComputedStyle(btn).borderRadius, 10);
      if (!isNaN(r) && r > 0) PALETTE.radius = Math.min(26, r);
    }
    var img = document.querySelector('header img, .logo img, nav img');
    if (img && img.src && img.src.indexOf('data:') !== 0) PALETTE.logo = img.src;
  }

  function nodeText(el) {
    if (!el) return '';
    return (el.innerText || el.textContent || '').replace(/\s+/g, ' ').trim();
  }

  var KNOW = [];

  function addItem(title, content, urls) {
    if (!content) return;
    content = String(content).replace(/\s+/g, ' ').trim().slice(0, 600);
    if (!content) return;
    KNOW.push({ title: String(title || 'Информация'), content: content, urls: urls || [] });
  }

  function extractJsonLd() {
    var scripts = document.querySelectorAll('script[type="application/ld+json"]');
    var s, list, o;
    for (s = 0; s < scripts.length; s++) {
      var obj;
      try { obj = JSON.parse(scripts[s].textContent); } catch (e) { continue; }
      if (!obj || typeof obj !== 'object') continue;
      list = obj['@graph'] || [obj];
      for (var y = 0; y < list.length; y++) {
        o = list[y];
        if (!o || typeof o !== 'object') continue;
        var type = o['@type'] || '';
        if (type === 'Product' && o.name) {
          var price = o.offers && o.offers.price ? ' Цена: ' + o.offers.price + (o.offers.priceCurrency || '').toUpperCase() + '.' : '';
          addItem(o.name, (o.description || 'Описание не указано.') + price);
        } else if (type === 'FAQPage' && o.mainEntity) {
          for (var q = 0; q < o.mainEntity.length; q++) {
            if (o.mainEntity[q] && o.mainEntity[q].name) addItem(o.mainEntity[q].name, o.mainEntity[q].acceptedAnswer ? o.mainEntity[q].acceptedAnswer.text : '');
          }
        } else if (type === 'Organization') {
          addItem(o.name + ' — контакты', [o.address, o.telephone, o.email].filter(Boolean).join(', '));
        } else if (o.name || o.headline) {
          addItem(o.name || o.headline, o.description || o.text || '');
        }
      }
    }
  }

  function extractHeadings() {
    var hs = document.querySelectorAll('h1, h2, h3');
    var i, guard, next, parts;
    for (i = 0; i < hs.length; i++) {
      var title = nodeText(hs[i]);
      if (!title || title.length < 4) continue;
      var dup = false;
      for (guard = 0; guard < KNOW.length; guard++) { if (KNOW[guard].title === title) { dup = true; break; } }
      if (dup) continue;
      next = hs[i].nextElementSibling;
      parts = [];
      guard = 0;
      while (next && !/^H[1-3]$/.test(next.tagName) && guard < 6) {
        parts.push(nodeText(next));
        next = next.nextElementSibling;
        guard++;
      }
      addItem(title, parts.join(' '));
    }
  }

  function extractFaq() {
    var els = document.querySelectorAll('[class*="faq"], [data-faq]');
    var i, j;
    for (i = 0; i < els.length; i++) {
      var children = els[i].querySelectorAll('dt, h3, h4, [class*="question"], [data-question]');
      for (j = 0; j < children.length; j++) {
        var q = nodeText(children[j]);
        if (!q) continue;
        var ans = '';
        var aEl = children[j].nextElementSibling;
        var g = 0;
        while (aEl && !/^H[1-4]$/.test(aEl.tagName) && g < 4) {
          ans += nodeText(aEl) + ' ';
          aEl = aEl.nextElementSibling;
          g++;
        }
        addItem(q, ans);
      }
    }
  }

  function extractProducts() {
    var els = document.querySelectorAll('[class*="product"], [class*="card"], [data-product]');
    var i;
    for (i = 0; i < els.length; i++) {
      var el = els[i];
      var name = el.getAttribute('data-name') || nodeText(el.querySelector('[class*="name"], h3, h4')) || el.getAttribute('alt') || '';
      if (!name) { var img = el.querySelector('img'); if (img && img.alt) name = img.alt; }
      if (!name) continue;
      var price = el.getAttribute('data-price') || nodeText(el.querySelector('[class*="price"], [class*="cost"]'));
      addItem(name, (price ? 'Цена: ' + price.trim() + '.' : '') + (el.getAttribute('data-desc') ? ' ' + el.getAttribute('data-desc') : ''));
    }
  }

  function extractLinks() {
    var links = document.querySelectorAll('a');
    var seen = {};
    var items = [];
    var href, txt, i;
    for (i = 0; i < links.length; i++) {
      txt = (nodeText(links[i]) || links[i].getAttribute('aria-label') || '').trim();
      href = links[i].getAttribute('href') || '';
      if (txt && txt.length < 60 && !seen[txt] && href && href.indexOf('javascript') !== 0) {
        seen[txt] = 1;
        items.push(txt + ' — ' + href);
      }
    }
    if (items.length) addItem('Разделы сайта', items.slice(0, 30).join(' · '));
    var mails = [];
    var tels = [];
    var a;
    for (i = 0; i < links.length; i++) {
      a = links[i];
      if (a.getAttribute('href') && a.getAttribute('href').indexOf('mailto:') === 0) mails.push(a.getAttribute('href').replace('mailto:', ''));
      if (a.getAttribute('href') && a.getAttribute('href').indexOf('tel:') === 0) tels.push(a.getAttribute('href').replace('tel:', ''));
    }
    if (mails.length || tels.length) addItem('Контакты', mails.concat(tels).join(', '));
  }

  function buildKnowledge() {
    addItem('О сайте', document.querySelector('meta[name="description"]') ? document.querySelector('meta[name="description"]').getAttribute('content') : '');
    extractJsonLd();
    extractHeadings();
    extractFaq();
    extractProducts();
    extractLinks();
    while (KNOW.length > 60) KNOW.pop();
  }

  var STOP = new Set('и,в,на,с,у,о,об,по,за,из,от,до,к,для,что,как,где,когда,почему,зачем,это,то,все,если,но,или,при,можно,не,уж,ли,есть,уже,было,будет,будут,а,так,ведь,вот,да,нет,его,её,их,мой,меня,вас,ваш,этот,эта,это,сколько'.split(','));
  var IDX = {};

  function tokenize(t) {
    return String(t || '').toLowerCase().replace(/[^a-zа-яё0-9\.\-@\s]/gi, ' ').split(/\s+/).filter(function (w) { return w.length > 1; });
  }

  function terms(t) {
    return tokenize(t).filter(function (w) { return !STOP.has(w); });
  }

  function uniqueArr(a) {
    var o = {};
    a.forEach(function (x) { o[x] = 1; });
    return Object.keys(o);
  }

  function indexKnowledge() {
    var i, tokens;
    for (i = 0; i < KNOW.length; i++) {
      tokens = uniqueArr(tokenize(KNOW[i].title).concat(tokenize(KNOW[i].content)));
      KNOW[i]._t = new Set(tokenize(KNOW[i].title));
      KNOW[i]._a = new Set(tokens);
    }
    for (i = 0; i < KNOW.length; i++) {
      tokens.forEach(function (w) {
        if (!IDX[w]) IDX[w] = [];
        IDX[w].push(i);
      });
    }
  }

  function findBest(q) {
    q = uniqueArr(terms(q));
    if (!q.length) return null;
    var results = [];
    var total = q.length;
    KNOW.forEach(function (item, idx) {
      var matched = 0;
      q.forEach(function (w) {
        if (item._t.has(w) || item._a.has(w)) matched++;
      });
      if (!matched) return;
      var conf = matched / total;
      results.push({ idx: idx, item: item, conf: conf, matched: matched });
    });
    results.sort(function (a, b) { return (b.conf - a.conf) || (b.matched - a.matched); });
    var best = results[0];
    if (!best) return null;
    if (best.conf < 0.35 && best.matched < 2) {
      var second = results[1];
      if (second && second.matched >= 2) return second;
    }
    return best;
  }

  function context(q) {
    var queryTerms = uniqueArr(terms(q));
    var scored = [];
    var i, j, matched;
    for (i = 0; i < KNOW.length; i++) {
      matched = 0;
      for (j = 0; j < queryTerms.length; j++) {
        if (KNOW[i]._t.has(queryTerms[j]) || KNOW[i]._a.has(queryTerms[j])) matched++;
      }
      if (matched > 0) scored.push({ idx: i, m: matched });
    }
    scored.sort(function (a, b) { return b.m - a.m; });
    if (!scored.length) {
      for (i = 0; i < Math.min(6, KNOW.length); i++) scored.push({ idx: i, m: 0 });
    }
    var ids = scored.slice(0, 6).map(function (s) { return s.idx; });
    return ids.map(function (id) { return '[' + KNOW[id].title + '] ' + KNOW[id].content; }).join('\n\n');
  }

  function aiAnswer(q) {
    if (!CONFIG.aiEnabled) return Promise.resolve(null);
    var sysMsg = 'Ты — ИИ-агент сайта «' + CONFIG.siteName + '». Отвечай кратко, дружелюбно, только на основе данных сайта. Если ответа нет — честно скажи, что не знаешь, и предложи связаться с поддержкой.\n\nДанные сайта:\n' + context(q);
    var headers = { 'Content-Type': 'application/json' };
    if (CONFIG.apiKey) headers['Authorization'] = 'Bearer ' + CONFIG.apiKey;
    return fetch(CONFIG.endpoint, {
      method: 'POST',
      headers: headers,
      body: JSON.stringify({
        model: CONFIG.model,
        messages: [{ role: 'system', content: sysMsg }, { role: 'user', content: q }],
        temperature: 0.3
      })
    }).then(function (r) {
      if (!r.ok) throw new Error('api error');
      return r.json();
    }).then(function (data) {
      return data.choices && data.choices[0] && data.choices[0].message ? data.choices[0].message.content : null;
    }).catch(function () { return null; });
  }

  function answerText(q) {
    var best = findBest(q);
    if (!best) return { text: T.fallback, best: null };
    var out = best.item.content;
    if (best.item.urls.length) {
      out += '\n\n' + T.source + ': ' + best.item.urls.join(', ');
    }
    return { text: out, best: best.item };
  }

  var host, shadow, sendBtn, inputEl, msgEl, panelEl, toggleBtn, teaserEl, chipsEl;

  var SVG_ICON = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="11" rx="2.5"/><path d="M12 8v-1M9 3l1.5 4M15 3l-1.5 4"/><circle cx="9.2" cy="12.6" r="1"/><circle cx="14.8" cy="12.6" r="1"/><path d="M9.5 16.2c.8.6 4 .6 5 0"/></svg>';
  var SVG_SEND = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>';
  var SVG_CLOSE = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>';

  function cssText() {
    var dark = PALETTE.dark;
    var panelBg = dark ? '#1f2430' : '#ffffff';
    var panelText = dark ? '#f3f4f6' : '#111827';
    var sub = dark ? '#9aa3b2' : '#6b7280';
    var chipBg = dark ? '#2b3242' : '#f1f5f9';
    var chipText = dark ? '#dbe2ec' : '#374151';
    var accentDark = shade(PALETTE.accent, 0.15);
    return [
      ':host{all:initial;}',
      '*{box-sizing:border-box;font-family:var(--pw-font),system-ui,sans-serif;}',
      '.fab{position:fixed;' + (CONFIG.position === 'left' ? 'left:20px' : 'right:20px') + ';bottom:20px;width:56px;height:56px;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;z-index:2147483000;',
      'background:linear-gradient(135deg,' + PALETTE.primary + ',' + PALETTE.accent + ');box-shadow:0 8px 24px rgba(0,0,0,.25);transition:transform .2s ease;padding:0;}',
      '.fab:hover{transform:scale(1.06);}',
      '.panel{position:fixed;' + (CONFIG.position === 'left' ? 'left:20px' : 'right:20px') + ';bottom:88px;width:380px;max-width:calc(100vw - 32px);height:560px;max-height:min(560px,calc(100vh - 120px));',
      'background:' + panelBg + ';color:' + panelText + ';border-radius:' + (PALETTE.radius + 6) + 'px;overflow:hidden;display:flex;flex-direction:column;z-index:2147483001;',
      'box-shadow:0 20px 60px rgba(0,0,0,.3);border:1px solid ' + (dark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)') + ';',
      'transform:translateY(16px) scale(.98);opacity:0;pointer-events:none;transition:transform .25s ease,opacity .25s ease;font-size:14px;line-height:1.5;}',
      '.panel.open{transform:none;opacity:1;pointer-events:auto;}',
      '.head{display:flex;align-items:center;gap:10px;padding:14px 16px;color:#fff;',
      'background:linear-gradient(120deg,' + PALETTE.primary + ',' + accentDark + ');}',
      '.head .ava{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex:0 0 36px;}',
      '.head .titles{flex:1;min-width:0;}',
      '.head .t{font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}',
      '.head .s{font-size:11.5px;opacity:.85;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}',
      '.close{background:none;border:none;color:#fff;cursor:pointer;opacity:.8;padding:4px;}',
      '.close:hover{opacity:1;}',
      '.chips{padding:8px 12px;display:flex;gap:6px;flex-wrap:wrap;border-bottom:1px solid ' + (dark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)') + ';}',
      '.chips .lbl{width:100%;font-size:11.5px;color:' + sub + ';margin-bottom:2px;}',
      '.chip{border:1px solid ' + (dark ? 'rgba(255,255,255,.14)' : 'rgba(0,0,0,.12)') + ';background:' + chipBg + ';color:' + chipText + ';border-radius:100px;padding:5px 11px;font-size:12.5px;cursor:pointer;transition:background .15s;}',
      '.chip:hover{background:' + (dark ? '#374151' : '#e2e8f0') + ';border-color:' + PALETTE.primary + ';color:' + PALETTE.primary + ';}',
      '.msgs{flex:1;overflow-y:auto;padding:14px 14px 4px;scroll-behavior:smooth;}',
      '.b{display:flex;margin-bottom:10px;}',
      '.b .av{width:28px;height:28px;border-radius:50%;flex:0 0 28px;margin-right:8px;display:flex;align-items:center;justify-content:center;color:#fff;background:linear-gradient(135deg,' + PALETTE.primary + ',' + PALETTE.accent + ');}',
      '.b.user{justify-content:flex-end;}',
      '.b .m{max-width:78%;padding:9px 13px;border-radius:14px;white-space:pre-wrap;word-break:break-word;}',
      '.b.bot .m{background:' + (dark ? '#2b3242' : '#f1f5f9') + ';border-top-left-radius:4px;}',
      '.b.user .m{background:linear-gradient(135deg,' + PALETTE.primary + ',' + accentDark + ');color:#fff;border-top-right-radius:4px;}',
      '.b .name{font-size:10.5px;color:' + sub + ';margin-bottom:2px;padding-left:2px;}',
      '.dots span{display:inline-block;width:6px;height:6px;margin-right:3px;background:' + sub + ';border-radius:50%;animation:blink 1.2s infinite;}',
      '.dots span:nth-child(2){animation-delay:.2s}.dots span:nth-child(3){animation-delay:.4s}',
      '@keyframes blink{0%,80%,100%{opacity:.25}40%{opacity:1}}',
      '.input{display:flex;gap:8px;padding:12px;border-top:1px solid ' + (dark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)') + ';}',
      '.input input{flex:1;border:1px solid ' + (dark ? 'rgba(255,255,255,.16)' : 'rgba(0,0,0,.14)') + ';background:transparent;color:' + panelText + ';border-radius:12px;padding:10px 12px;outline:none;font-size:14px;}',
      '.input input:focus{border-color:' + PALETTE.primary + ';}',
      '.input button{border:none;background:linear-gradient(135deg,' + PALETTE.primary + ',' + accentDark + ');color:#fff;border-radius:12px;width:44px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex:0 0 44px;padding:0;}',
      '.input button:hover{filter:brightness(1.08);}',
      '.teaser{position:fixed;' + (CONFIG.position === 'left' ? 'left:20px' : 'right:20px') + ';bottom:88px;background:' + panelBg + ';color:' + panelText + ';border-radius:16px;padding:12px 14px;max-width:280px;box-shadow:0 12px 40px rgba(0,0,0,.22);font-size:13.5px;z-index:2147482999;cursor:pointer;border:1px solid ' + (dark ? 'rgba(255,255,255,.1)' : 'rgba(0,0,0,.06)') + ';}',
      '.teaser b{color:' + PALETTE.primary + ';}',
      '.teaser .x{position:absolute;top:-8px;right:-8px;width:22px;height:22px;border-radius:50%;border:none;background:' + sub + ';color:#fff;cursor:pointer;font-size:11px;line-height:1;}'
    ].join('\n');
  }

  function markup() {
    return '<button class="fab" title="' + T.title + '" aria-label="' + T.title + '">' + SVG_ICON + '</button>' +
      '<div class="teaser" style="display:none">' + (CONFIG.teaser || T.preview) + '<button class="x">✕</button></div>' +
      '<div class="panel">' +
      '<div class="head">' +
      '<div class="ava">' + SVG_ICON + '</div>' +
      '<div class="titles"><div class="t">' + T.title + '</div><div class="s">' + T.status + '</div></div>' +
      '<button class="close" aria-label="' + T.close + '">' + SVG_CLOSE + '</button>' +
      '</div>' +
      '<div class="chips"><div class="lbl">' + T.chips + '</div><div data-chips></div></div>' +
      '<div class="msgs"></div>' +
      '<div class="input"><input type="text" placeholder="' + T.input + '"><button aria-label="' + T.send + '">' + SVG_SEND + '</button></div>' +
      '</div>';
  }

  function safeHtml(s) {
    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function addMsg(text, who, name) {
    var div = document.createElement('div');
    div.className = 'b ' + who;
    var html = '';
    if (who === 'bot') {
      html += '<div class="av">' + SVG_ICON + '</div>';
      html += '<div class="col" style="min-width:0"><div class="name">' + safeHtml(name || T.title) + '</div><div class="m">' + safeHtml(text).replace(/\n/g, '<br>') + '</div></div>';
    } else {
      html += '<div class="col" style="min-width:0"><div class="m">' + safeHtml(text).replace(/\n/g, '<br>') + '</div></div>';
    }
    div.innerHTML = html;
    msgEl.appendChild(div);
    msgEl.scrollTop = msgEl.scrollHeight;
  }

  function typing(on) {
    if (!on) { var d = msgEl.querySelector('.dots'); if (d) d.parentElement.parentElement.remove(); return; }
    var div = document.createElement('div');
    div.className = 'b bot';
    div.innerHTML = '<div class="av">' + SVG_ICON + '</div><div class="col"><div class="name">' + safeHtml(T.title) + '</div><div class="m dots"><span></span><span></span><span></span></div></div>';
    msgEl.appendChild(div);
    msgEl.scrollTop = msgEl.scrollHeight;
  }

  function pushChips() {
    var box = chipsEl.querySelector('[data-chips]');
    if (!box) return;
    var items = [];
    KNOW.forEach(function (item) { if (items.length < 3 && item.title && item.title !== 'Разделы сайта') items.push(item.title); });
    if (!items.length) items = [T.chips.replace('Популярные', ''), 'Доставка', 'Возврат'].filter(Boolean);
    box.innerHTML = items.map(function (t) { return '<button class="chip">' + safeHtml(t.length > 42 ? t.slice(0, 42) + '…' : t) + '</button>'; }).join('');
  }

  function ask(q) {
    q = String(q || '').trim();
    if (!q) return;
    addMsg(q, 'user');
    inputEl.value = '';
    typing(true);
    aiAnswer(q).then(function (ai) {
      typing(false);
      setTimeout(function () {
        addMsg((ai || answerText(q).text), 'bot');
      }, 220);
    });
  }

  function wire() {
    toggleBtn = shadow.querySelector('.fab');
    teaserEl = shadow.querySelector('.teaser');
    panelEl = shadow.querySelector('.panel');
    msgEl = shadow.querySelector('.msgs');
    chipsEl = shadow.querySelector('.chips');
    inputEl = shadow.querySelector('.input input');
    sendBtn = shadow.querySelector('.input button');

    toggleBtn.addEventListener('click', toggle);
    shadow.querySelector('.close').addEventListener('click', function () { panelEl.classList.remove('open'); });
    shadow.querySelectorAll('.teaser .x').forEach(function (b) { b.addEventListener('click', function (e) { e.stopPropagation(); teaserEl.style.display = 'none'; }); });
    teaserEl.addEventListener('click', function () { teaserEl.style.display = 'none'; toggle(); });
    sendBtn.addEventListener('click', function () { ask(inputEl.value); });
    inputEl.addEventListener('keydown', function (e) { if (e.key === 'Enter') ask(inputEl.value); });
    chipsEl.addEventListener('click', function (e) {
      var chip = e.target.closest('.chip');
      if (chip) ask(chip.textContent);
    });
    addMsg('Привет! ' + CONFIG.siteName + '. Спросите меня о товарах, доставке или возврате — я отвечаю данными этого сайта.', 'bot');
    if (CONFIG.aiEnabled) checkOllama();
  }

  function checkOllama() {
    var statusEl = shadow.querySelector('.s');
    if (!statusEl) return;
    statusEl.textContent = 'проверяю AI...';
    fetch(CONFIG.endpoint.replace('/chat/completions', '/../api/tags'), { method: 'GET' }).then(function (r) {
      if (!r.ok) throw new Error();
      return r.json();
    }).then(function (data) {
      var models = (data.models || []).map(function (m) { return m.name; });
      var found = models.some(function (n) { return n.indexOf(CONFIG.model.split(':')[0]) === 0; });
      if (found) {
        statusEl.textContent = 'AI: ' + CONFIG.model;
        statusEl.style.color = '#4ade80';
      } else {
        statusEl.textContent = 'AI: нужна модель ' + CONFIG.model;
        statusEl.style.color = '#fbbf24';
      }
    }).catch(function () {
      statusEl.textContent = 'AI: Ollama не запущен';
      statusEl.style.color = '#f87171';
    });
  }

  function toggle() {
    if (panelEl.classList.contains('open')) panelEl.classList.remove('open');
    else { panelEl.classList.add('open'); }
  }

  function boot() {
    extractStyle();
    buildKnowledge();
    indexKnowledge();
    host = document.createElement('div');
    host.setAttribute('data-adaptive-widget', '');
    host.style.cssText = 'position:static;z-index:auto;all:initial;';
    document.body.appendChild(host);
    shadow = host.attachShadow({ mode: 'open' });
    shadow.innerHTML = '<style>' + cssText() + '</style>' + markup();
    host.style.setProperty('--pw-font', JSON.stringify(PALETTE.font));
    wire();
    pushChips();
    if (CONFIG.autoOpen || CONFIG.teaser) {
      setTimeout(function () {
        if (!panelEl.classList.contains('open')) teaserEl.style.display = 'block';
      }, 1600);
    }
    try {
      window.__ADAPTIVE_DEBUG__ = {
        palette: { primary: PALETTE.primary, accent: PALETTE.accent, bg: PALETTE.bg, fg: PALETTE.fg, dark: PALETTE.dark, radius: PALETTE.radius, font: PALETTE.font, logo: PALETTE.logo },
        knowledge: KNOW.slice(0, 40).map(function (i) { return i.title + ' :: ' + i.content.slice(0, 120); }),
        knowCount: KNOW.length
      };
    } catch (e) {}
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();