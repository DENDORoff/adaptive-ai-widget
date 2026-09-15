'use strict';

const fs = require('fs');
const path = require('path');

const DEFAULT_FROM = 'support@deworld.su';
const DATA_DIR = process.env.AW_DATA_DIR || path.join(__dirname, '..', 'data');
const EMAIL_LOG = path.join(DATA_DIR, 'email.log.ndjson');

let handler = null;

function configure(cfg) {
  handler = (cfg && cfg.smtp && cfg.smtp.host) ? 'smtp' : 'file';
  module.exports.from = (cfg && cfg.smtp && cfg.smtp.from) || (cfg && cfg.from) || DEFAULT_FROM;
}

function ensure() {
  const dir = path.dirname(EMAIL_LOG);
  if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
}

/**
 * Отправка email. При не настроенном SMTP пишем письмо в outbox-лог,
 * чтобы логика работала в демо, а при наличии SMTP-конфига вызывается adapter().
 */
async function sendEmail({ to, subject, text }) {
  const rec = {
    id: 'mail_' + Date.now().toString(36) + '_' + Math.random().toString(36).slice(2, 8),
    from: module.exports.from,
    to: String(to || '').trim(),
    subject: String(subject || ''),
    text: String(text || ''),
    at: new Date().toISOString()
  };
  if (!rec.to) return rec;

  ensure();
  fs.appendFileSync(EMAIL_LOG, JSON.stringify(rec) + '\n');

  if (handler === 'smtp' && module.exports.adapter) {
    try {
      await module.exports.adapter(rec);
    } catch (e) {
      console.error('[mail] SMTP-ошибка:', e.message);
    }
  }
  console.log('[mail] ' + rec.from + ' -> ' + rec.to + ' :: ' + rec.subject);
  return rec;
}

// Адаптер для реальной отправки подключается при старте сервера (см. server.js).
module.exports = { sendEmail, configure, from: DEFAULT_FROM };