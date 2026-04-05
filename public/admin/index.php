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
  <title>Admin CRM — ECOSYSTEMEIMMO</title>
  <style>
    :root{
      --bg:#f1f5f9;
      --surface:#ffffff;
      --border:#dbe3ef;
      --text:#0f172a;
      --muted:#64748b;
      --accent:#2563eb;
      --accent-soft:#dbeafe;
      --ok:#16a34a;
      --err:#dc2626;
    }
    *{box-sizing:border-box}
    body{font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--text);margin:0;padding:0}
    .wrap{max-width:1200px;margin:0 auto;padding:18px}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:18px;box-shadow:0 8px 24px rgba(15,23,42,.06)}
    table{width:100%;border-collapse:collapse;font-size:.9rem}
    th,td{padding:10px;border-bottom:1px solid var(--border);text-align:left;vertical-align:top}
    select,textarea,input,button{font:inherit;border-radius:10px;border:1px solid #c5d1e1;padding:8px;background:#fff;color:var(--text)}
    .btn{cursor:pointer;background:var(--accent);border-color:#1d4ed8;color:#fff}
    .row{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .small{font-size:.82rem;color:var(--muted)}
    .ok{color:var(--ok)}.err{color:var(--err)}
    .top{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:16px}
    .dashboard{display:grid;gap:12px}
    .kpis{display:grid;grid-template-columns:repeat(6,minmax(130px,1fr));gap:10px}
    .kpi{padding:12px;border-radius:12px;border:1px solid var(--border);background:#f8fafc}
    .kpi .label{font-size:.78rem;color:var(--muted);display:block}
    .kpi .value{font-size:1.2rem;font-weight:700}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .chart-list{display:grid;gap:8px;margin-top:6px}
    .bar-row{display:grid;grid-template-columns:90px 1fr 48px;gap:8px;align-items:center}
    .bar{height:10px;border-radius:999px;background:var(--accent-soft);overflow:hidden}
    .bar span{display:block;height:100%;background:var(--accent)}
    .quick-list{display:grid;gap:6px;padding:0;margin:0;list-style:none}
    .pill{display:inline-block;padding:2px 8px;border-radius:999px;background:#eef2ff;color:#3730a3;font-size:.75rem}
    .table-wrap{overflow:auto}
    @media (max-width:980px){
      .kpis{grid-template-columns:repeat(2,minmax(140px,1fr))}
      .grid-2{grid-template-columns:1fr}
      .top{flex-direction:column;align-items:flex-start}
    }
  </style>
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
  <?php else: ?>
  <div class="top">
    <div>
      <h1 style="margin:0">CRM Leads — ECOSYSTEMEIMMO</h1>
      <p class="small">Capture, qualification et séquence email automatisée.</p>
    </div>
    <div class="row">
      <button class="btn" id="send-sequence">Envoyer emails dus</button>
      <a href="/admin/?logout=1" class="btn" style="text-decoration:none;background:#475569;border-color:#334155">Déconnexion</a>
    </div>
  </div>
  <div class="dashboard" style="margin-bottom:12px">
    <div class="card">
      <div class="row" style="justify-content:space-between">
        <div>
          <h2 style="margin:0 0 4px 0">Dashboard CRM</h2>
          <p class="small" style="margin:0">Vue rapide avec filtres par période, indicateurs clés et graphiques.</p>
        </div>
        <div class="row">
          <label class="small" for="period-filter">Période</label>
          <select id="period-filter">
            <option value="7">7 derniers jours</option>
            <option value="30" selected>30 derniers jours</option>
            <option value="90">90 derniers jours</option>
            <option value="all">Toutes les données</option>
          </select>
        </div>
      </div>
      <div class="kpis" id="kpi-grid" style="margin-top:12px"></div>
    </div>
    <div class="grid-2">
      <div class="card">
        <h3 style="margin-top:0">Graphique — Leads par ville</h3>
        <div id="city-chart" class="chart-list"></div>
      </div>
      <div class="card">
        <h3 style="margin-top:0">Graphique — Leads par statut</h3>
        <div id="status-chart" class="chart-list"></div>
      </div>
    </div>
    <div class="card">
      <h3 style="margin-top:0">Vue rapide</h3>
      <ul id="quick-view" class="quick-list"></ul>
    </div>
  </div>
  <div class="card">
    <p id="feedback" class="small"></p>
    <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Lead</th><th>Contact</th><th>Statut</th><th>Score</th><th>Séquence email</th><th>Notes</th><th>Action</th>
        </tr>
      </thead>
      <tbody id="lead-body"></tbody>
    </table>
    </div>
  </div>
  <?php endif; ?>
</div>
<?php if ($loggedIn): ?>
<script>
const feedback = document.getElementById('feedback');
const periodFilter = document.getElementById('period-filter');
const cityChart = document.getElementById('city-chart');
const statusChart = document.getElementById('status-chart');
const kpiGrid = document.getElementById('kpi-grid');
const quickView = document.getElementById('quick-view');
const statuses = ['nouveau','qualifie','rdv_planifie','close','perdu'];
let allLeads = [];

function esc(v=''){return String(v).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"}[c]));}
function fmt(n){return new Intl.NumberFormat('fr-FR').format(Number(n || 0));}
function money(n){return new Intl.NumberFormat('fr-FR',{style:'currency',currency:'EUR',maximumFractionDigits:0}).format(Number(n||0));}

function getFilteredLeads(){
  const p = periodFilter.value;
  if (p === 'all') return allLeads;
  const days = Number(p);
  const cutoff = Date.now() - (days * 24 * 60 * 60 * 1000);
  return allLeads.filter(lead => {
    const created = Date.parse(lead.created_at || '');
    return !Number.isNaN(created) && created >= cutoff;
  });
}

function countBy(leads, key){
  return leads.reduce((acc, lead) => {
    const raw = (lead[key] || 'Non renseigné').toString().trim();
    const value = raw || 'Non renseigné';
    acc[value] = (acc[value] || 0) + 1;
    return acc;
  }, {});
}

function renderBars(el, source){
  const entries = Object.entries(source).sort((a,b) => b[1]-a[1]).slice(0,8);
  const max = entries.length ? entries[0][1] : 1;
  el.innerHTML = entries.length ? entries.map(([label, value]) => `
    <div class="bar-row">
      <span class="small">${esc(label)}</span>
      <div class="bar"><span style="width:${Math.max(8,(value/max)*100)}%"></span></div>
      <strong>${value}</strong>
    </div>
  `).join('') : '<p class="small">Aucune donnée pour cette période.</p>';
}

function computePotentialRevenue(leads){
  const weights = {nouveau: 1200, qualifie: 3500, rdv_planifie: 7000, close: 12000, perdu: 0};
  return leads.reduce((sum, lead) => sum + (weights[lead.status] || 0), 0);
}

function renderDashboard(leads){
  const byStatus = countBy(leads, 'status');
  const byCity = countBy(leads, 'city');
  const rdvCount = (byStatus.rdv_planifie || 0) + (byStatus.close || 0);
  const conversion = leads.length ? (((byStatus.close || 0) / leads.length) * 100) : 0;
  const potentialRevenue = computePotentialRevenue(leads);

  kpiGrid.innerHTML = [
    ['Leads totaux', fmt(leads.length)],
    ['Leads qualifiés', fmt(byStatus.qualifie || 0)],
    ['Nombre de RDV pris', fmt(rdvCount)],
    ['Taux de conversion', `${conversion.toFixed(1)}%`],
    ['CA potentiel', money(potentialRevenue)],
    ['Villes actives', fmt(Object.keys(byCity).length)],
  ].map(([label, value]) => `<div class="kpi"><span class="label">${label}</span><span class="value">${value}</span></div>`).join('');

  renderBars(cityChart, byCity);
  renderBars(statusChart, byStatus);

  const topCity = Object.entries(byCity).sort((a,b) => b[1]-a[1])[0];
  const lastLead = [...leads].sort((a,b)=>String(b.created_at||'').localeCompare(String(a.created_at||'')))[0];
  quickView.innerHTML = `
    <li><strong>Ville dominante :</strong> ${topCity ? `${esc(topCity[0])} <span class="pill">${topCity[1]} lead(s)</span>` : '—'}</li>
    <li><strong>Statut dominant :</strong> ${Object.entries(byStatus).sort((a,b) => b[1]-a[1])[0]?.[0] || '—'}</li>
    <li><strong>Dernier lead :</strong> ${lastLead ? `${esc(lastLead.nom || 'Sans nom')} (${esc(lastLead.city || 'Ville inconnue')})` : '—'}</li>
    <li><strong>Période active :</strong> ${periodFilter.options[periodFilter.selectedIndex].text}</li>
  `;
}

async function loadLeads(){
  const res = await fetch('/api/crm.php?action=list');
  const data = await res.json();
  allLeads = data.leads || [];
  const leads = getFilteredLeads();

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
    </tr>`;
  }).join('');

  renderDashboard(leads);
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

periodFilter.addEventListener('change', loadLeads);

loadLeads();
</script>
</body>
</html>
