<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

$loggedIn = Auth::check();

if (!$loggedIn) {
    header('Location: /admin/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CRM - Ecosystème Immo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
</head>
<body>
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
        <a href="/admin/logout.php" class="btn btn-ghost" style="display:block;text-align:center;text-decoration:none;">Déconnexion</a>
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
</body>
</html>
