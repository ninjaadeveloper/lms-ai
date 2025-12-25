@extends('../admin.layout')

@section('content')
<style>
.chat-content {
    height: 280px;
    overflow-y: auto;
    background: #f8f9fa;
}
.chat-item {
    margin-bottom: 15px;
}
.chat-item.user {
    text-align: right;
}
.chat-item.user .chat-details {
    background: #6777ef;
    color: #fff;
    display: inline-block;
    padding: 10px 14px;
    border-radius: 15px 15px 0 15px;
    max-width: 75%;
}
.chat-item.bot .chat-details {
    background: #fff;
    border: 1px solid #e4e6fc;
    display: inline-block;
    padding: 10px 14px;
    border-radius: 15px 15px 15px 0;
    max-width: 75%;
}
.chat-time {
    font-size: 11px;
    opacity: 0.6;
    margin-top: 4px;
}
.prompt-btn {
    margin: 4px 4px 0 0;
}
</style>

<div class="main-content">
<section class="section">
<div class="section-body">

<div class="row justify-content-center">
<div class="col-12 col-lg-12">

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="fas fa-robot text-primary"></i> AI Learning Assistant
        </h4>
        <button class="btn btn-sm btn-light" id="clearChat">
            <i class="fas fa-trash"></i> Clear
        </button>
    </div>

    <!-- CHAT BODY -->
    <div class="card-body chat-content" id="chatBox"></div>

    <!-- DUMMY PROMPTS -->
    <div class="px-4 pb-2">
        <strong class="d-block mb-1">Try sample prompts:</strong>
        <button class="btn btn-sm btn-outline-primary prompt-btn">Explain MVC in Laravel</button>
        <button class="btn btn-sm btn-outline-primary prompt-btn">What is REST API?</button>
        <button class="btn btn-sm btn-outline-primary prompt-btn">Difference between GET & POST</button>
        <button class="btn btn-sm btn-outline-primary prompt-btn">How authentication works?</button>
    </div>

    <!-- INPUT -->
    <div class="card-footer">
        <form id="chatForm">
            @csrf
            <div class="input-group">
                <input type="text" id="message" class="form-control" placeholder="Ask something about programming or courses..." autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-primary">
                        <i class="far fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

</div>
</div>

</div>
</section>
</div>

<script>
const chatBox = document.getElementById('chatBox');
const form = document.getElementById('chatForm');
const input = document.getElementById('message');
const clearBtn = document.getElementById('clearChat');

function timeNow() {
  return new Date().toLocaleTimeString();
}

// XSS safe (user text)
function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, (m) => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
  }[m]));
}

// Bot formatting (bold + line breaks + bullets etc.)
function formatAIResponse(text) {
  // first escape everything
  let safe = escapeHtml(text);

  // then allow very limited formatting
  safe = safe
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // **bold**
    .replace(/\n\n/g, '<br><br>')
    .replace(/\n/g, '<br>')
    .replace(/•/g, '&bull;')
    .replace(/GET:/g, '<strong>GET:</strong>')
    .replace(/POST:/g, '<strong>POST:</strong>');

  return safe;
}

// type: user|bot, htmlAllowed: true only for bot
function addMessage(type, text, htmlAllowed = false) {
  const div = document.createElement('div');
  div.className = 'chat-item ' + type;

  const content = htmlAllowed ? text : escapeHtml(text);

  div.innerHTML = `
    <div class="chat-details">
      ${content}
      <div class="chat-time">${timeNow()}</div>
    </div>
  `;

  chatBox.appendChild(div);
  chatBox.scrollTop = chatBox.scrollHeight;
}

async function sendMessage(msg) {
  addMessage('user', msg, false);

  const loading = document.createElement('div');
  loading.className = 'chat-item bot';
  loading.innerHTML = `<div class="chat-details">Typing...</div>`;
  chatBox.appendChild(loading);
  chatBox.scrollTop = chatBox.scrollHeight;

  try {
    const res = await fetch("{{ route(auth()->user()->role . '.ai.send') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({ message: msg })
    });

    const data = await res.json();
    loading.remove();

    const reply = data.reply || 'No response';
    addMessage('bot', formatAIResponse(reply), true);

  } catch (e) {
    loading.remove();
    addMessage('bot', formatAIResponse("Error: " + e.message), true);
  }
}

form.addEventListener('submit', e => {
  e.preventDefault();
  const msg = input.value.trim();
  if (!msg) return;
  input.value = '';
  sendMessage(msg);
});

document.querySelectorAll('.prompt-btn').forEach(btn => {
  btn.addEventListener('click', () => sendMessage(btn.innerText));
});

clearBtn.addEventListener('click', () => {
  chatBox.innerHTML = '';
});
</script>

@endsection
