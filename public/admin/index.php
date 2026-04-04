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
  <title>Admin CRM — ECOSYSTEMEIMMO</title>
  <style>
    body{font-family:Inter,system-ui,sans-serif;background:#0f172a;color:#e2e8f0;margin:0;padding:0}
    .wrap{max-width:1100px;margin:0 auto;padding:24px}
    .card{background:#111827;border:1px solid #334155;border-radius:14px;padding:20px}
    table{width:100%;border-collapse:collapse;font-size:.9rem}
    th,td{padding:10px;border-bottom:1px solid #334155;text-align:left;vertical-align:top}
    select,textarea,input,button{font:inherit;border-radius:8px;border:1px solid #475569;padding:8px;background:#0b1220;color:#e2e8f0}
    .btn{cursor:pointer;background:#0ea5e9;border-color:#0284c7;color:#fff}
    .row{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .small{font-size:.8rem;color:#94a3b8}
    .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px;margin:10px 0 18px}
    .stats .card{padding:12px}
    .ok{color:#22c55e}.err{color:#ef4444}
    .top{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:16px}
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
      <h1 style="margin:0">CRM Leads — ECOSYSTEMEIMMO</h1>
      <p class="small">Capture, qualification et séquence email automatisée.</p>
    </div>
    <div class="row">
      <button class="btn" id="send-sequence">Envoyer emails dus</button>
      <a href="/admin/?logout=1" class="btn" style="text-decoration:none;background:#475569;border-color:#334155">Déconnexion</a>
    </div>
  </div>
  <div class="stats" id="stats"></div>
  <div class="card">
    <p id="feedback" class="small"></p>
    <table>
      <thead>
        <tr>
          <th>Lead</th><th>Contact</th><th>Statut</th><th>Score</th><th>Séquence email</th><th>Notes</th><th>Action</th>
        </tr>
      </thead>
      <tbody id="lead-body"></tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
<?php if ($loggedIn): ?>
<script>
const body = document.getElementById('lead-body');
const feedback = document.getElementById('feedback');
const statsNode = document.getElementById('stats');
const statuses = ['nouveau','qualifie','rdv_planifie','close','perdu'];

function esc(v=''){return String(v).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"}[c]));}

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
          ${statuses.map(s => `<option ${lead.status===s?'selected':''}>${s}</option>`).join('')}
        </select>
      </td>
      <td>${esc(lead.score)}/100</td>
      <td><ul class="small" style="margin:0;padding-left:18px">${sequence}</ul></td>
      <td><textarea data-id="${esc(lead.id)}" data-field="notes" rows="2" style="min-width:180px">${esc(lead.notes || '')}</textarea></td>
      <td><button class="btn save" data-id="${esc(lead.id)}">Sauver</button></td>
    </tr>`;
  }).join('');
}

body.addEventListener('click', async (e) => {
  if (!e.target.classList.contains('save')) return;
  const id = e.target.dataset.id;
  const status = document.querySelector(`[data-id="${id}"][data-field="status"]`).value;
  const notes = document.querySelector(`[data-id="${id}"][data-field="notes"]`).value;

  const res = await fetch('/api/crm.php?action=update', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({lead_id: id, status, notes})
  });

  feedback.textContent = res.ok ? 'Lead mis à jour.' : 'Erreur de sauvegarde.';
  feedback.className = res.ok ? 'ok' : 'err';
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

loadLeads();
</script>
<?php endif; ?>
</body>
</html>
