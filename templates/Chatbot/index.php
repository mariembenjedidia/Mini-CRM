<?php
/** @var \App\View\AppView $view */
$this->assign('title', 'Assistant CRM');
?>

<div class="crm-chat-container">

  <div class="crm-chat-card">

    <div class="crm-chat-header">
      <div class="crm-bot-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.8">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <path d="M9 11V7a3 3 0 0 1 6 0v4"/>
          <circle cx="9" cy="16" r="1" fill="currentColor"/>
          <circle cx="15" cy="16" r="1" fill="currentColor"/>
        </svg>
      </div>
      <div>
        <p class="crm-bot-name">Assistant CRM</p>
        <p class="crm-bot-status">
          <span class="crm-status-dot"></span> En ligne
        </p>
      </div>
    </div>

    <div class="crm-chat-body" id="chatBody">
      <div class="crm-msg crm-msg--bot">
        <div class="crm-bubble">
          Bonjour 👋 Je suis votre assistant CRM. Posez-moi une question sur vos données.
        </div>
        <div class="crm-chips">
          <button class="crm-chip" type="button"
                  onclick="sendMessage('Combien de prospects ?')">Prospects</button>
          <button class="crm-chip" type="button"
                  onclick="sendMessage('Nombre de clients')">Clients</button>
          <button class="crm-chip" type="button"
                  onclick="sendMessage('Total des appels')">Appels</button>
        </div>
        <span class="crm-time"><?= date('H:i') ?></span>
      </div>
    </div>

    <div class="crm-chat-footer">
      <input
        id="chatInput"
        type="text"
        class="crm-input"
        placeholder="Posez votre question..."
        autocomplete="off"
        onkeydown="if(event.key==='Enter') sendMessage()"
      />
      <button class="crm-send-btn" type="button" onclick="sendMessage()" aria-label="Envoyer">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
      </button>
    </div>

  </div>

</div>

<style>
.crm-chat-container { display: flex; justify-content: center; padding: 2rem 1rem; }

.crm-chat-card {
  display: flex; flex-direction: column;
  width: 100%; max-width: 640px; height: 580px;
  background: #fff; border: 1px solid #e8e8e8;
  border-radius: 16px; overflow: hidden;
  box-shadow: 0 4px 24px rgba(0,0,0,.07);
}

.crm-chat-header {
  display: flex; align-items: center; gap: 12px;
  padding: 14px 18px; border-bottom: 1px solid #f0f0f0;
  background: #fafafa;
}
.crm-bot-icon {
  width: 40px; height: 40px; border-radius: 50%;
  background: #dbeafe; color: #1d4ed8;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.crm-bot-name { font-size: 14px; font-weight: 600; color: #111; margin: 0; }
.crm-bot-status { font-size: 12px; color: #6b7280; margin: 2px 0 0; display: flex; align-items: center; gap: 5px; }
.crm-status-dot { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; display: inline-block; }

.crm-chat-body {
  flex: 1; overflow-y: auto; padding: 20px 18px;
  display: flex; flex-direction: column; gap: 16px;
}

.crm-msg { display: flex; flex-direction: column; max-width: 78%; }
.crm-msg--bot { align-self: flex-start; }
.crm-msg--user { align-self: flex-end; align-items: flex-end; }

.crm-bubble {
  padding: 10px 15px; border-radius: 18px;
  font-size: 14px; line-height: 1.55;
}
.crm-msg--bot .crm-bubble {
  background: #f3f4f6; color: #111;
  border-bottom-left-radius: 4px;
}
.crm-msg--user .crm-bubble {
  background: #1d9e75; color: #fff;
  border-bottom-right-radius: 4px;
}

.crm-time { font-size: 11px; color: #9ca3af; margin-top: 4px; padding: 0 4px; }

.crm-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
.crm-chip {
  padding: 4px 12px; border-radius: 20px; font-size: 12px;
  border: 1px solid #d1d5db; color: #374151; background: #fff;
  cursor: pointer; transition: background .15s;
}
.crm-chip:hover { background: #f3f4f6; }

.crm-stat-card {
  display: inline-flex; align-items: center; gap: 10px;
  background: #fff; border: 1px solid #e5e7eb;
  border-radius: 10px; padding: 10px 16px; margin-top: 8px;
}
.crm-stat-num { font-size: 22px; font-weight: 700; color: #1d9e75; }
.crm-stat-lbl { font-size: 12px; color: #6b7280; }

.crm-typing { display: flex; gap: 4px; padding: 8px 4px; }
.crm-dot {
  width: 7px; height: 7px; border-radius: 50%; background: #9ca3af;
  animation: crmBounce 1s infinite;
}
.crm-dot:nth-child(2) { animation-delay: .15s; }
.crm-dot:nth-child(3) { animation-delay: .3s; }
@keyframes crmBounce { 0%,80%,100%{transform:translateY(0)} 40%{transform:translateY(-5px)} }

.crm-chat-footer {
  display: flex; gap: 8px; padding: 12px 14px;
  border-top: 1px solid #f0f0f0; background: #fafafa;
}
.crm-input {
  flex: 1; padding: 9px 16px; font-size: 14px;
  border-radius: 22px; border: 1px solid #d1d5db;
  background: #fff; outline: none; color: #111;
  transition: border-color .2s;
}
.crm-input:focus { border-color: #1d9e75; }
.crm-send-btn {
  width: 40px; height: 40px; border-radius: 50%;
  background: #1d9e75; border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; color: #fff; transition: background .15s;
}
.crm-send-btn:hover { background: #178a64; }

/* ── Dark Mode ── */
body.dark-mode .crm-chat-card {
    background: #1a1a1a;
    border-color: #2d2d2d;
    box-shadow: 0 4px 24px rgba(0,0,0,.4);
}

body.dark-mode .crm-chat-header {
    background: #111111;
    border-color: #2d2d2d;
}

body.dark-mode .crm-bot-name {
    color: #ffffff;
}

body.dark-mode .crm-bot-status {
    color: #9ca3af;
}

body.dark-mode .crm-chat-body {
    background: #1a1a1a;
}

body.dark-mode .crm-msg--bot .crm-bubble {
    background: #252525;
    color: #ffffff;
}

body.dark-mode .crm-chip {
    background: #252525;
    border-color: #444444;
    color: #e5e7eb;
}

body.dark-mode .crm-chip:hover {
    background: #333333;
}

body.dark-mode .crm-stat-card {
    background: #252525;
    border-color: #444444;
}

body.dark-mode .crm-stat-lbl {
    color: #9ca3af;
}

body.dark-mode .crm-chat-footer {
    background: #111111;
    border-color: #2d2d2d;
}

body.dark-mode .crm-input {
    background: #1a1a1a;
    border-color: #444444;
    color: #ffffff;
}

body.dark-mode .crm-input::placeholder {
    color: #6b7280;
}

body.dark-mode .crm-input:focus {
    border-color: #1d9e75;
    box-shadow: 0 0 0 .2rem rgba(29,158,117,.2);
}

body.dark-mode .crm-time {
    color: #6b7280;
}

body.dark-mode .crm-dot {
    background: #6b7280;
}
</style>

<script>
const REPLY_URL = '<?= $this->Url->build(['action' => 'reply']) ?>';
const CSRF_TOKEN = '<?= $this->request->getAttribute('csrfToken') ?>';

function now() {
    return new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
}

function appendMessage(html) {
    const body = document.getElementById('chatBody');
    body.insertAdjacentHTML('beforeend', html);
    body.scrollTop = body.scrollHeight;
}

function showTyping() {
    appendMessage(`
        <div class="crm-msg crm-msg--bot" id="crmTyping">
            <div class="crm-bubble">
                <div class="crm-typing">
                    <div class="crm-dot"></div>
                    <div class="crm-dot"></div>
                    <div class="crm-dot"></div>
                </div>
            </div>
        </div>
    `);
}

function removeTyping() {
    document.getElementById('crmTyping')?.remove();
}

function formatResponse(text) {
    const match = text.match(/^(\d[\d\s]*)\s+(.+)$/);
    if (match) {
        return `
            <div class="crm-stat-card">
                <div>
                    <div class="crm-stat-num">${match[1]}</div>
                    <div class="crm-stat-lbl">${match[2]}</div>
                </div>
            </div>
        `;
    }
    return `<div class="crm-bubble">${text}</div>`;
}

async function sendMessage(preset = null) {
    const input = document.getElementById('chatInput');
    const text  = (preset ?? input.value).trim();
    if (!text) return;

    input.value = '';

    appendMessage(`
        <div class="crm-msg crm-msg--user">
            <div class="crm-bubble">${text}</div>
            <span class="crm-time">${now()}</span>
        </div>
    `);

    showTyping();

    try {
        const res  = await fetch(REPLY_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ message: text }),
        });

        const data = await res.json();
        removeTyping();

        appendMessage(`
            <div class="crm-msg crm-msg--bot">
                ${formatResponse(data.response)}
                <span class="crm-time">${now()}</span>
            </div>
        `);

    } catch (err) {
        removeTyping();
        appendMessage(`
            <div class="crm-msg crm-msg--bot">
                <div class="crm-bubble" style="color:#dc2626">
                    Erreur de connexion. Réessayez.
                </div>
            </div>
        `);
    }
}
</script>