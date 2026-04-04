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
    :root{--bg:#f8fafc;--surface:#fff;--border:#e2e8f0;--text:#0f172a;--muted:#64748b;--brand:#0ea5e9;--dark:#0b1220}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--text)}
    .layout{display:grid;grid-template-columns:240px 1fr;min-height:100vh}
    .sidebar{background:var(--dark);color:#fff;padding:20px}
    .logo{font-weight:700;margin-bottom:20px}
    .menu{display:grid;gap:8px}
    .menu a{color:#cbd5e1;text-decoration:none;padding:10px 12px;border-radius:8px;display:block}
    .menu a.active,.menu a:hover{background:#1e293b;color:#fff}
    .content{padding:20px}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:16px;margin-bottom:16px}
    .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
    .metric{font-size:1.8rem;font-weight:700}
    .small{font-size:.85rem;color:var(--muted)}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid var(--border);text-align:left;vertical-align:top}
    .toolbar{display:grid;grid-template-columns:1.2fr 1fr 1fr auto;gap:10px;margin-bottom:12px}
    input,select,button{font:inherit;border:1px solid #cbd5e1;border-radius:8px;padding:10px;background:#fff}
    button{background:var(--brand);border-color:#0284c7;color:#fff;cursor:pointer}
    .status{padding:4px 8px;border-radius:999px;background:#e2e8f0;color:#1e293b;font-size:.75rem;display:inline-block}
    .topbar{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px}
    .msg{font-size:.85rem}
    @media (max-width: 900px){
      .layout{grid-template-columns:1fr}
      .sidebar{position:sticky;top:0;z-index:2;padding:14px}
      .menu{grid-template-columns:repeat(3,minmax(0,1fr))}
      .grid{grid-template-columns:1fr}
      .toolbar{grid-template-columns:1fr}
      .table-wrap{overflow:auto}
    }
  </style>
</head>
<body>
<?php if (!$loggedIn): ?>
<div style="max-width:420px;margin:10vh auto;padding:20px" class="card">
  <h1>Connexion CRM</h1>
  <p class="small">Mot de passe par défaut : <strong>ecosystemeimmo2026</strong></p>
  <?php if (!empty($error)): ?><p style="color:#dc2626"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
  <form method="post" style="display:grid;gap:10px">
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
  </form>
</div>
<?php else: ?>
<div class="layout">
  <aside class="sidebar">
    <div class="logo">ECOSYSTEMEIMMO CRM</div>
    <nav class="menu">
      <a href="#" class="active">Dashboard</a>
      <a href="#">Contacts</a>
      <a href="#">Pipeline</a>
      <a href="#">Emails</a>
      <a href="#">Automations</a>
    </nav>
    <p style="margin-top:18px"><a href="/admin/?logout=1" style="color:#93c5fd">Déconnexion</a></p>
  </aside>

  <main class="content">
    <div class="topbar">
      <div>
        <h1 style="margin:0">Dashboard Leads</h1>
        <p class="small" style="margin:4px 0 0">Vue rapide des leads + progression dans le tunnel.</p>
      </div>
      <p id="feedback" class="msg small"></p>
    </div>

    <section class="card grid">
      <div>
        <div class="small">Total leads</div>
        <div class="metric" id="m-total">0</div>
      </div>
      <div>
        <div class="small">Leads aujourd'hui</div>
        <div class="metric" id="m-today">0</div>
      </div>
      <div>
        <div class="small">Convertis</div>
        <div class="metric" id="m-converted">0</div>
      </div>
    </section>

    <section class="card">
      <div class="toolbar">
        <input type="search" id="search" placeholder="Recherche nom, email, téléphone, ville...">
        <select id="filter-city"><option value="">Toutes les villes</option></select>
        <select id="filter-status">
          <option value="">Tous les statuts</option>
          <option value="nouveau">Nouveau</option>
          <option value="contacte">Contacté</option>
          <option value="qualifie">Qualifié</option>
          <option value="proposition">Proposition</option>
          <option value="negociation">Négociation</option>
          <option value="converti">Converti</option>
          <option value="perdu">Perdu</option>
        </select>
        <select id="sort">
          <option value="DESC">Tri ville + récent</option>
          <option value="ASC">Tri ville + ancien</option>
        </select>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Ville</th>
              <th>Source</th>
              <th>Statut tunnel</th>
              <th>Date création</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="lead-body"></tbody>
        </table>
      </div>
    </section>
  </main>
</div>

<script>
const body = document.getElementById('lead-body');
const feedback = document.getElementById('feedback');
const searchInput = document.getElementById('search');
const cityFilter = document.getElementById('filter-city');
const statusFilter = document.getElementById('filter-status');
const sortFilter = document.getElementById('sort');

const statuses = ['nouveau', 'contacte', 'qualifie', 'proposition', 'negociation', 'converti', 'perdu'];

function esc(v=''){return String(v).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"}[c]));}

function formatDate(v){
  if(!v) return '—';
  const d = new Date(v.replace(' ', 'T'));
  if(Number.isNaN(d.getTime())) return v;
  return d.toLocaleString('fr-FR');
}

async function loadLeads(){
  const params = new URLSearchParams({
    action: 'list',
    ville: cityFilter.value,
    statut: statusFilter.value,
    q: searchInput.value.trim(),
    sort: sortFilter.value
  });

  const res = await fetch('/api/crm.php?' + params.toString());
  const data = await res.json();
  const leads = data.leads || [];

  document.getElementById('m-total').textContent = data.stats?.total ?? 0;
  document.getElementById('m-today').textContent = data.stats?.today ?? 0;
  document.getElementById('m-converted').textContent = data.stats?.converted ?? 0;

  if (!cityFilter.value) {
    const cities = (data.stats?.cities || []).map(row => row.ville).filter(Boolean);
    cityFilter.innerHTML = '<option value="">Toutes les villes</option>' +
      [...new Set(cities)].map(city => `<option value="${esc(city)}">${esc(city)}</option>`).join('');
  }

  body.innerHTML = leads.map(lead => `
    <tr>
      <td>${esc(lead.id)}</td>
      <td><strong>${esc(lead.nom)}</strong></td>
      <td>${esc(lead.email)}</td>
      <td>${esc(lead.telephone || '—')}</td>
      <td>${esc(lead.ville)}</td>
      <td>${esc(lead.source || '—')}</td>
      <td>
        <select data-id="${esc(lead.id)}" data-field="statut_tunnel">
          ${statuses.map(s => `<option value="${s}" ${lead.statut_tunnel===s?'selected':''}>${s}</option>`).join('')}
        </select>
      </td>
      <td>${esc(formatDate(lead.date_creation))}</td>
      <td><button data-id="${esc(lead.id)}" class="save">Sauver</button></td>
    </tr>
  `).join('');
}

body.addEventListener('click', async (e) => {
  if (!e.target.classList.contains('save')) return;

  const id = e.target.dataset.id;
  const statut = document.querySelector(`[data-id="${id}"][data-field="statut_tunnel"]`).value;

  const res = await fetch('/api/crm.php?action=update', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({id, statut_tunnel: statut})
  });

  feedback.textContent = res.ok ? 'Lead mis à jour.' : 'Erreur de mise à jour.';
  feedback.style.color = res.ok ? '#16a34a' : '#dc2626';
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
