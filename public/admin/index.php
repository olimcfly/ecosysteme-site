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
    :root{color-scheme:dark}
    body{font-family:Inter,system-ui,sans-serif;background:#0f172a;color:#e2e8f0;margin:0;padding:0}
    .wrap{max-width:1500px;margin:0 auto;padding:24px}
    .card{background:#111827;border:1px solid #334155;border-radius:14px;padding:20px}
    select,textarea,input,button{font:inherit;border-radius:8px;border:1px solid #475569;padding:8px;background:#0b1220;color:#e2e8f0}
    .btn{cursor:pointer;background:#0ea5e9;border-color:#0284c7;color:#fff}
    .row{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .small{font-size:.8rem;color:#94a3b8}
    .ok{color:#22c55e}.err{color:#ef4444}
    .top{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:16px}
    .layout{display:grid;grid-template-columns:1fr;gap:12px}
    .pipeline{display:grid;grid-auto-flow:column;grid-auto-columns:minmax(250px,1fr);gap:12px;overflow-x:auto;padding-bottom:8px}
    .col{background:#0b1220;border:1px solid #334155;border-radius:12px;min-height:420px;padding:10px;display:flex;flex-direction:column;gap:10px}
    .col.drop-target{border-color:#38bdf8;box-shadow:0 0 0 2px rgba(56,189,248,.2) inset}
    .col-head{display:flex;justify-content:space-between;align-items:flex-start;gap:8px}
    .count{background:#1e293b;border:1px solid #334155;border-radius:999px;padding:3px 9px;font-size:.75rem}
    .total{font-size:.78rem;color:#86efac}
    .cards{display:flex;flex-direction:column;gap:10px;min-height:280px}
    .lead{background:#111827;border:1px solid #334155;border-radius:10px;padding:10px;cursor:grab}
    .lead.dragging{opacity:.6}
    .lead h4{margin:0 0 6px 0;font-size:.95rem}
    .lead p{margin:0 0 8px 0;font-size:.8rem;color:#cbd5e1}
    .lead footer{display:flex;justify-content:space-between;align-items:center;gap:8px}
    .lead input{width:100%;max-width:120px;padding:6px}
    .meta{font-size:.75rem;color:#94a3b8}
    .summary{display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;margin-bottom:8px}
  </style>
</head>
<body>
<div class="wrap">
  <?php if (!$loggedIn): ?>
  <div class="card" style="max-width:420px;margin:10vh auto 0;">
    <h1>Connexion CRM</h1>
    <p class="small">Mot de passe par défaut: <strong>ecosystemeimmo2026</strong> (à changer dans <code>public/admin/index.php</code>).</p>
    <?php if (!empty($error)): ?><p class="err"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
    <form method="post">
      <input type="password" name="password" placeholder="Mot de passe" required>
      <button class="btn" type="submit">Se connecter</button>
    </form>
  </div>
  <?php else: ?>
  <div class="top">
    <div>
      <h1 style="margin:0">Pipeline CRM — ECOSYSTEMEIMMO</h1>
      <p class="small">Suivi type Trello : progression des leads et estimation du chiffre d'affaires.</p>
    </div>
    <div class="row">
      <button class="btn" id="send-sequence">Envoyer emails dus</button>
      <a href="/admin/?logout=1" class="btn" style="text-decoration:none;background:#475569;border-color:#334155">Déconnexion</a>
    </div>
  </div>
  <div class="card layout">
    <div class="summary">
      <p id="feedback" class="small"></p>
      <p id="global-total" class="small"></p>
    </div>
    <div id="pipeline" class="pipeline"></div>
  </div>
  <?php endif; ?>
</div>

<script>
const feedback = document.getElementById('feedback');
const pipeline = document.getElementById('pipeline');
const globalTotal = document.getElementById('global-total');

const columns = [
  {key: 'nouveau', label: 'Nouveau lead'},
  {key: 'video_non_vue', label: 'Vidéo non vue'},
  {key: 'video_vue', label: 'Vidéo vue'},
  {key: 'offre_vue', label: 'Offre vue'},
  {key: 'rdv_pris', label: 'RDV pris'},
  {key: 'rdv_realise', label: 'RDV réalisé'},
  {key: 'qualifie', label: 'Qualifié'},
  {key: 'paiement_envoye', label: 'Paiement envoyé'},
  {key: 'client', label: 'Client'},
];

let leadsState = [];

function esc(v = '') {
  return String(v).replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"}[c]));
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

  if (!res.ok) {
    throw new Error('Erreur API');
  }
}

function render() {
  const totalRevenue = leadsState.reduce((sum, lead) => sum + Number(lead.estimated_amount || 0), 0);
  globalTotal.textContent = `CA estimé total : ${money(totalRevenue)}`;

  pipeline.innerHTML = columns.map(col => {
    const leads = leadsState.filter(lead => (lead.status || 'nouveau') === col.key);
    const colRevenue = leads.reduce((sum, lead) => sum + Number(lead.estimated_amount || 0), 0);

    return `<section class="col" data-status="${col.key}">
      <header class="col-head">
        <div>
          <strong>${col.label}</strong><br>
          <span class="total">${money(colRevenue)}</span>
        </div>
        <span class="count">${leads.length}</span>
      </header>
      <div class="cards">
        ${leads.map(lead => `<article class="lead" draggable="true" data-id="${esc(lead.id)}">
          <h4>${esc(lead.nom || 'Lead sans nom')}</h4>
          <p>${esc(lead.email || '')}<br>${esc(lead.phone || '—')}</p>
          <footer>
            <label class="meta" for="amount-${esc(lead.id)}">Montant</label>
            <input id="amount-${esc(lead.id)}" type="number" min="0" step="100" value="${Number(lead.estimated_amount || 0)}" data-field="amount" data-id="${esc(lead.id)}">
          </footer>
          <div class="meta">${esc(lead.city || '')} · ${esc(lead.created_at || '')}</div>
        </article>`).join('')}
      </div>
    </section>`;
  }).join('');
}

async function loadLeads() {
  const res = await fetch('/api/crm.php?action=list');
  const data = await res.json();
  leadsState = data.leads || [];
  render();
}

pipeline.addEventListener('dragstart', (e) => {
  const card = e.target.closest('.lead');
  if (!card) return;
  card.classList.add('dragging');
  e.dataTransfer.setData('text/plain', card.dataset.id);
});

pipeline.addEventListener('dragend', (e) => {
  e.target.classList.remove('dragging');
  pipeline.querySelectorAll('.col').forEach(col => col.classList.remove('drop-target'));
});

pipeline.addEventListener('dragover', (e) => {
  const col = e.target.closest('.col');
  if (!col) return;
  e.preventDefault();
  col.classList.add('drop-target');
});

pipeline.addEventListener('dragleave', (e) => {
  const col = e.target.closest('.col');
  if (!col) return;
  col.classList.remove('drop-target');
});

pipeline.addEventListener('drop', async (e) => {
  const col = e.target.closest('.col');
  if (!col) return;
  e.preventDefault();

  const leadId = e.dataTransfer.getData('text/plain');
  const newStatus = col.dataset.status;
  const lead = leadsState.find(item => item.id === leadId);

  if (!lead || lead.status === newStatus) return;

  lead.status = newStatus;
  render();

  try {
    await updateLead(leadId, {status: newStatus});
    feedback.textContent = `Statut mis à jour automatiquement : ${lead.nom} → ${columns.find(c => c.key === newStatus)?.label || newStatus}`;
    feedback.className = 'ok';
  } catch (err) {
    feedback.textContent = 'Erreur lors du changement de statut.';
    feedback.className = 'err';
    await loadLeads();
  }
});

pipeline.addEventListener('change', async (e) => {
  const input = e.target.closest('input[data-field="amount"]');
  if (!input) return;

  const lead = leadsState.find(item => item.id === input.dataset.id);
  if (!lead) return;

  const amount = Number(input.value || 0);
  lead.estimated_amount = amount;
  render();

  try {
    await updateLead(lead.id, {estimated_amount: amount});
    feedback.textContent = `Montant enregistré pour ${lead.nom}.`;
    feedback.className = 'ok';
  } catch (err) {
    feedback.textContent = 'Erreur lors de la sauvegarde du montant.';
    feedback.className = 'err';
    await loadLeads();
  }
});

document.getElementById('send-sequence').addEventListener('click', async () => {
  const res = await fetch('/api/crm.php?action=send-sequence', {method: 'POST'});
  const data = await res.json();
  const sent = data.result?.sent || 0;
  const errors = (data.result?.errors || []).length;
  feedback.textContent = `Envoi terminé: ${sent} email(s) envoyé(s), ${errors} erreur(s).`;
  feedback.className = errors ? 'err' : 'ok';
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
