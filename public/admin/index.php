<?php

declare(strict_types=1);

const ADMIN_PASSWORD = 'ecosystemeimmo2026';

session_start();

if (isset($_POST['password'])) {
    if (hash_equals(ADMIN_PASSWORD, (string) $_POST['password'])) {
        $_SESSION['crm_admin'] = true;
        header('Location: /admin/');
        exit;
    }

    $error = 'Mot de passe incorrect.';
}

if (isset($_GET['logout'])) {
    unset($_SESSION['crm_admin']);
    header('Location: /admin/');
    exit;
}

$loggedIn = !empty($_SESSION['crm_admin']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM ECOSYSTEMEIMMO</title>
  <style>
    :root{
      --bg:#f3f5f9;
      --panel:#ffffff;
      --line:#e6e9f0;
      --ink:#111827;
      --ink-soft:#5b6474;
      --primary:#2563eb;
      --primary-dark:#1d4ed8;
      --ok:#16a34a;
      --warn:#f59e0b;
      --lost:#ef4444;
      --radius:14px;
      --shadow:0 8px 24px rgba(15,23,42,.06);
      --sidebar-w:260px;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;font-family:Inter,system-ui,-apple-system,sans-serif;background:var(--bg);color:var(--ink)}
    .small{font-size:.82rem;color:var(--ink-soft)}
    .ok{color:var(--ok)}
    .err{color:var(--lost)}
    .btn{cursor:pointer;border:1px solid transparent;background:var(--primary);color:#fff;padding:10px 14px;border-radius:10px;font-weight:600;transition:.2s ease}
    .btn:hover{background:var(--primary-dark)}
    .btn-ghost{background:#eef2ff;color:#1e3a8a;border-color:#dbe3ff}
    .btn-ghost:hover{background:#e2e8ff}
    .layout{display:flex;min-height:100vh}
    .sidebar{position:fixed;left:0;top:0;bottom:0;width:var(--sidebar-w);background:#0f172a;color:#dbe4ff;padding:24px 18px;border-right:1px solid #1f2937;z-index:20}
    .brand{font-weight:700;letter-spacing:.2px;margin-bottom:18px}
    .brand span{color:#93c5fd}
    .menu{display:flex;flex-direction:column;gap:8px;margin-top:14px}
    .menu a{padding:10px 12px;border-radius:10px;color:#c4d0e8;font-size:.92rem}
    .menu a.active,.menu a:hover{background:#1e293b;color:#fff}
    .sidebar-foot{position:absolute;left:18px;right:18px;bottom:24px}
    .main{margin-left:var(--sidebar-w);padding:24px;width:calc(100% - var(--sidebar-w))}
    .topbar{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px}
    .title{margin:0;font-size:1.35rem}
    .actions{display:flex;gap:10px;flex-wrap:wrap}
    .grid-kpi{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:16px}
    .kpi{background:var(--panel);border:1px solid var(--line);border-radius:var(--radius);padding:14px;box-shadow:var(--shadow)}
    .kpi .value{font-size:1.4rem;font-weight:700;margin-top:6px}
    .surface{background:var(--panel);border:1px solid var(--line);border-radius:var(--radius);box-shadow:var(--shadow)}
    .surface-pad{padding:16px}
    .split{display:grid;grid-template-columns:1.2fr 1fr;gap:14px;margin-bottom:14px}

    .pipeline{display:grid;grid-template-columns:repeat(5,minmax(150px,1fr));gap:10px}
    .stage{border:1px solid var(--line);border-radius:12px;padding:10px;background:#fafbff;min-height:110px}
    .stage h3{margin:0 0 8px;font-size:.85rem;text-transform:uppercase;letter-spacing:.4px;color:#334155}
    .chip{display:inline-block;background:#e8edff;color:#1d4ed8;font-size:.78rem;padding:4px 8px;border-radius:999px;margin:0 6px 6px 0}

    .table-wrap{overflow:auto}
    table{width:100%;border-collapse:collapse;font-size:.9rem;min-width:900px}
    th,td{padding:10px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top}
    th{background:#f8fafc;color:#334155;position:sticky;top:0}
    select,textarea,input{width:100%;font:inherit;border-radius:10px;border:1px solid #cdd5e3;padding:8px;background:#fff;color:#0f172a}
    textarea{min-width:180px}
    .feedback{min-height:18px;margin-bottom:8px}

    .login-card{max-width:430px;margin:10vh auto;background:#fff;border:1px solid var(--line);border-radius:16px;padding:22px;box-shadow:var(--shadow)}
    .login-form{display:flex;gap:10px;align-items:center}

    @media (max-width: 1080px){
      .grid-kpi{grid-template-columns:repeat(2,minmax(0,1fr))}
      .split{grid-template-columns:1fr}
      .pipeline{grid-template-columns:repeat(3,minmax(0,1fr))}
    }
    @media (max-width: 840px){
      .sidebar{position:sticky;width:100%;height:auto;bottom:auto;padding:14px 16px}
      .menu{flex-direction:row;overflow:auto;padding-bottom:4px}
      .sidebar-foot{position:static;margin-top:10px}
      .layout{display:block}
      .main{margin-left:0;width:100%;padding:16px}
      .pipeline{grid-template-columns:repeat(2,minmax(0,1fr))}
      .login-form{flex-direction:column;align-items:stretch}
    }
    @media (max-width: 560px){
      .grid-kpi,.pipeline{grid-template-columns:1fr}
      .actions{width:100%}
      .actions a,.actions button{flex:1}
    }
  </style>
</head>
<body>
  <?php if (!$loggedIn): ?>
  <div class="login-card">
    <h1 style="margin-top:0">Connexion CRM</h1>
    <p class="small" style="margin:0 0 14px">Mot de passe par défaut: <strong>ecosystemeimmo2026</strong> (à changer dans <code>public/admin/index.php</code>).</p>
    <?php if (!empty($error)): ?><p class="err"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
    <form method="post" class="login-form">
      <input type="password" name="password" placeholder="Mot de passe" required>
      <button class="btn" type="submit">Se connecter</button>
    </form>
  </div>
  <?php else: ?>
  <div class="layout">
    <aside class="sidebar">
      <div class="brand">ECOSYSTEME<span>CRM</span></div>
      <p class="small">Vue simple pour piloter les leads sans complexité.</p>
      <nav class="menu">
        <a class="active" href="#dashboard">Dashboard</a>
        <a href="#pipeline">Pipeline</a>
        <a href="#leads">Leads</a>
      </nav>
      <div class="sidebar-foot">
        <a href="/admin/?logout=1" class="btn btn-ghost" style="display:block;text-align:center;text-decoration:none;">Déconnexion</a>
      </div>
    </aside>

    <main class="main">
      <header class="topbar" id="dashboard">
        <div>
          <h1 class="title">CRM Leads — Dashboard</h1>
          <p class="small">Suivi, qualification et relances email.</p>
        </div>
        <div class="actions">
          <button class="btn" id="send-sequence">Envoyer emails dus</button>
        </div>
      </header>

      <section class="grid-kpi" aria-label="KPI CRM">
        <article class="kpi"><div class="small">Total leads</div><div class="value" id="kpi-total">0</div></article>
        <article class="kpi"><div class="small">Nouveaux</div><div class="value" id="kpi-new">0</div></article>
        <article class="kpi"><div class="small">RDV planifiés</div><div class="value" id="kpi-rdv">0</div></article>
        <article class="kpi"><div class="small">Emails en attente</div><div class="value" id="kpi-pending">0</div></article>
      </section>

      <section class="split">
        <div class="surface surface-pad" id="pipeline">
          <h2 style="margin:0 0 10px;font-size:1rem">Pipeline visuel</h2>
          <div id="pipeline-board" class="pipeline"></div>
        </div>
        <div class="surface surface-pad">
          <h2 style="margin:0 0 8px;font-size:1rem">Feedback système</h2>
          <p id="feedback" class="small feedback"></p>
          <p class="small">Astuce UX: mettez à jour uniquement les champs utiles, puis cliquez <strong>Sauver</strong>.</p>
        </div>
      </section>

      <section class="surface" id="leads">
        <div class="surface-pad table-wrap">
          <table>
            <thead>
              <tr>
                <th>Lead</th><th>Contact</th><th>Statut</th><th>Score</th><th>Séquence email</th><th>Notes</th><th>Action</th>
              </tr>
            </thead>
            <tbody id="lead-body"></tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
  <?php endif; ?>

<?php if ($loggedIn): ?>
<script>
const feedback = document.getElementById('feedback');
const statsNode = document.getElementById('stats');
const statuses = ['nouveau','qualifie','rdv_planifie','close','perdu'];
const labels = {
  nouveau: 'Nouveau',
  qualifie: 'Qualifié',
  rdv_planifie: 'RDV planifié',
  close: 'Clos',
  perdu: 'Perdu'
};

function esc(v=''){return String(v).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"}[c]));}
function badge(txt){return `<span class="badge">${esc(txt)}</span>`;}

function renderStats(stats={}){
  const cards = [
    ['Leads', stats.leads || 0],
    ['Emails envoyés', stats.emails_sent || 0],
    ['File d\'attente', stats.queue_pending || 0],
    ['Ouvertures', `${stats.opens || 0} (${stats.open_rate || 0}%)`],
    ['Clics', `${stats.clicks || 0} (${stats.click_rate || 0}%)`],
    ['RDV', stats.rdv || 0],
  ];

  statsBox.innerHTML = cards.map(([label,val]) => `<div class="stat"><span class="small">${esc(label)}</span><strong>${esc(val)}</strong></div>`).join('');
}

function renderSequence(lead){
  return (lead.email_sequence || []).map((step, index) => {
    const key = step.key || `email_${index+1}`;
    return `${badge(`#${index+1} ${key}`)} ${esc(step.status || 'pending')}<br><span class="small">${esc(step.sent_at || step.due_at || '')}</span>`;
  }).join('<hr style="border-color:#1f2937">');
}

function renderEmailStats(lead){
  const opens = (lead.email_sequence || []).reduce((a,s)=>a + (Number(s.open_count)||0),0);
  const clicks = (lead.email_sequence || []).reduce((a,s)=>a + (Number(s.click_count)||0),0);
  const auto = lead.automation || {};
  return `<span class="small">Ouvertures: ${opens}<br>Clics: ${clicks}<br>Vidéo vue: ${auto.video_viewed ? 'oui' : 'non'}<br>Offre vue: ${auto.offer_viewed ? 'oui' : 'non'}<br>RDV: ${auto.meeting_booked ? 'pris' : 'non pris'}</span>`;
}

function setKpi(id, value){
  const el = document.getElementById(id);
  if (el) el.textContent = value;
}

function renderPipeline(leads){
  const board = document.getElementById('pipeline-board');
  if (!board) return;

  const grouped = statuses.reduce((acc, s) => {
    acc[s] = leads.filter(lead => lead.status === s);
    return acc;
  }, {});

  board.innerHTML = statuses.map(stage => `
    <article class="stage">
      <h3>${labels[stage]} (${grouped[stage].length})</h3>
      <div>
        ${grouped[stage].slice(0, 6).map(lead => `<span class="chip">${esc(lead.nom || 'Lead')}</span>`).join('') || '<span class="small">Aucun lead</span>'}
      </div>
    </article>
  `).join('');
}

function renderKpi(leads){
  const total = leads.length;
  const newCount = leads.filter(l => l.status === 'nouveau').length;
  const rdvCount = leads.filter(l => l.status === 'rdv_planifie').length;
  const pending = leads.reduce((sum, lead) => sum + (lead.email_sequence || []).filter(s => s.status === 'pending').length, 0);

  setKpi('kpi-total', total);
  setKpi('kpi-new', newCount);
  setKpi('kpi-rdv', rdvCount);
  setKpi('kpi-pending', pending);
}

async function loadLeads(){
  const res = await fetch('/api/crm.php?action=list');
  const data = await res.json();
  const leads = data.leads || [];
  const globalStats = data.stats || {};

  statsNode.innerHTML = [
    ['Leads', globalStats.total_leads || 0],
    ['Emails envoyés', globalStats.emails_sent || 0],
    ['Ouvertures', globalStats.emails_opened || 0],
    ['Clics', globalStats.emails_clicked || 0],
    ['RDV pris', globalStats.rdv_taken || 0],
  ].map(([label, value]) => `<div class="card"><div class="small">${esc(label)}</div><strong>${esc(value)}</strong></div>`).join('');

  renderKpi(leads);
  renderPipeline(leads);

  body.innerHTML = leads.map(lead => {
    const sequence = (lead.email_sequence || []).map(step => {
      const opened = step.opened_at ? 'oui' : 'non';
      const clicked = step.clicked_at ? 'oui' : 'non';
      return `<li>${esc(step.name || step.id)} — ${esc(step.status || 'pending')} (open: ${opened}, click: ${clicked})</li>`;
    }).join('');

    return `<tr>
      <td><strong>${esc(lead.nom)}</strong><div class="small">${esc(lead.city)}<br>${esc(lead.created_at)}</div></td>
      <td>${esc(lead.email)}<br>${esc(lead.phone || '—')}</td>
      <td>
        <select data-id="${esc(lead.id)}" data-field="status">
          ${statuses.map(s => `<option value="${s}" ${lead.status===s?'selected':''}>${labels[s]}</option>`).join('')}
        </select>
        <div class="small">${esc(autoStatus)}</div>
      </td>
      <td>${esc(lead.score)}/100</td>
      <td><span class="small">Envoyés: ${sent}<br>En attente: ${pending}</span></td>
      <td><textarea data-id="${esc(lead.id)}" data-field="notes" rows="2">${esc(lead.notes || '')}</textarea></td>
      <td><button class="btn save" data-id="${esc(lead.id)}">Sauver</button></td>
    </tr>`).join('');
}

function money(value) {
  return new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(Number(value || 0));
}

async function updateLead(id, payload) {
  const res = await fetch('/api/crm.php?action=update', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({lead_id: id, ...payload}),
  });

  feedback.textContent = res.ok ? 'Lead mis à jour.' : 'Erreur de sauvegarde.';
  feedback.className = res.ok ? 'feedback ok' : 'feedback err';

  if (res.ok) {
    await loadLeads();
  }
});

document.getElementById('send-sequence').addEventListener('click', async () => {
  const res = await fetch('/api/crm.php?action=send-sequence', {method: 'POST'});
  const data = await res.json();
  const sent = data.result?.sent || 0;
  const queued = data.result?.queued || 0;
  const skipped = data.result?.skipped || 0;
  const errors = (data.result?.errors || []).length;
  feedback.textContent = `Envoi terminé: ${sent} email(s) envoyé(s), ${errors} erreur(s).`;
  feedback.className = errors ? 'feedback err' : 'feedback ok';
  await loadLeads();
});

let timer;
function debounceReload(){
  clearTimeout(timer);
  timer = setTimeout(loadLeads, 250);
}

searchInput.addEventListener('input', debounceReload);
cityFilter.addEventListener('change', loadLeads);
statusFilter.addEventListener('change', loadLeads);
sortFilter.addEventListener('change', loadLeads);

loadLeads();
</script>
<?php endif; ?>
</body>
</html>
