(() => {
  const body = document.body;
  const feedback = document.getElementById('feedback');
  const leadBody = document.getElementById('lead-body');
  const emailBody = document.getElementById('email-body');
  const emailStats = document.getElementById('email-stats');
  const calendarList = document.getElementById('calendar-list');
  const searchInput = document.getElementById('lead-search');
  const nav = document.getElementById('admin-nav');
  const panels = document.querySelectorAll('.tab-panel');

  const statusLabels = {
    nouveau: 'Nouveau',
    qualifie: 'Qualifié',
    rdv_planifie: 'RDV planifié',
    close: 'Clos',
    perdu: 'Perdu',
  };

  let leads = parseJSON(body.dataset.initialLeads) || [];
  let stats = parseJSON(body.dataset.initialStats) || {};

  function parseJSON(value) {
    try {
      return JSON.parse(value || 'null');
    } catch (e) {
      return null;
    }
  }

  function esc(value = '') {
    return String(value)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  function setFeedback(message, ok = true) {
    if (!feedback) return;
    feedback.textContent = message;
    feedback.className = ok ? 'feedback ok' : 'feedback error';
  }

  function updateKpi() {
    const pending = leads.reduce((sum, lead) => {
      const sequence = Array.isArray(lead.email_sequence) ? lead.email_sequence : [];
      return sum + sequence.filter((step) => step.status === 'pending').length;
    }, 0);

    setText('kpi-total', leads.length);
    setText('kpi-new', leads.filter((lead) => lead.status === 'nouveau').length);
    setText('kpi-rdv', leads.filter((lead) => lead.status === 'rdv_planifie').length);
    setText('kpi-pending', pending);
  }

  function setText(id, value) {
    const node = document.getElementById(id);
    if (node) node.textContent = String(value);
  }

  function renderLeads() {
    if (!leadBody) return;

    const query = (searchInput?.value || '').trim().toLowerCase();
    const filtered = leads.filter((lead) => {
      const haystack = `${lead.nom || ''} ${lead.email || ''} ${lead.city || ''}`.toLowerCase();
      return haystack.includes(query);
    });

    leadBody.innerHTML = filtered.map((lead) => {
      const id = esc(lead.id || '');
      return `
        <tr>
          <td>${esc(lead.nom || '—')}</td>
          <td>${esc(lead.email || '—')}<br><span class="small">${esc(lead.phone || '—')}</span></td>
          <td>${esc(lead.city || '—')}</td>
          <td>
            <select data-id="${id}" data-field="status">
              ${Object.keys(statusLabels).map((status) => `<option value="${status}" ${lead.status === status ? 'selected' : ''}>${statusLabels[status]}</option>`).join('')}
            </select>
          </td>
          <td>${Number(lead.score || 0)}/100</td>
          <td><textarea rows="2" data-id="${id}" data-field="notes">${esc(lead.notes || '')}</textarea></td>
          <td><button class="btn btn-primary save-lead" data-id="${id}">Sauver</button></td>
        </tr>`;
    }).join('');
  }

  function renderEmails() {
    if (!emailBody || !emailStats) return;

    let sentTotal = 0;
    let pendingTotal = 0;
    let openedTotal = 0;
    let clickedTotal = 0;

    emailBody.innerHTML = leads.map((lead) => {
      const sequence = Array.isArray(lead.email_sequence) ? lead.email_sequence : [];
      const sent = sequence.filter((step) => step.status === 'sent').length;
      const pending = sequence.filter((step) => step.status === 'pending').length;
      const opened = sequence.filter((step) => step.opened_at).length;
      const clicked = sequence.filter((step) => step.clicked_at).length;

      sentTotal += sent;
      pendingTotal += pending;
      openedTotal += opened;
      clickedTotal += clicked;

      return `
        <tr>
          <td>${esc(lead.nom || '—')}</td>
          <td>${sent}</td>
          <td>${pending}</td>
          <td>${opened}</td>
          <td>${clicked}</td>
        </tr>`;
    }).join('');

    emailStats.innerHTML = `
      <article><strong>${sentTotal}</strong><span>Emails envoyés</span></article>
      <article><strong>${pendingTotal}</strong><span>En attente</span></article>
      <article><strong>${openedTotal}</strong><span>Ouvertures</span></article>
      <article><strong>${clickedTotal}</strong><span>Clics</span></article>
    `;
  }

  function renderCalendar() {
    if (!calendarList) return;

    const events = leads.map((lead) => {
      const nextEmail = (lead.email_sequence || []).find((step) => step.status === 'pending');
      return {
        date: lead.created_at || new Date().toISOString(),
        title: lead.nom || 'Lead',
        detail: nextEmail ? `Prochain email : ${nextEmail.name || nextEmail.id}` : 'Aucune relance en attente',
      };
    }).sort((a, b) => new Date(b.date) - new Date(a.date));

    calendarList.innerHTML = events.slice(0, 25).map((event) => `
      <li>
        <time>${new Date(event.date).toLocaleString('fr-FR')}</time>
        <div>
          <p>${esc(event.title)}</p>
          <span>${esc(event.detail)}</span>
        </div>
      </li>`).join('');
  }

  async function loadData() {
    try {
      const response = await fetch('/api/crm.php?action=list', { headers: { Accept: 'application/json' } });
      const data = await response.json();
      leads = Array.isArray(data.leads) ? data.leads : [];
      stats = data.stats || {};
      render();
    } catch (error) {
      setFeedback('Impossible de rafraîchir les données CRM.', false);
    }
  }

  async function saveLead(id) {
    const statusNode = document.querySelector(`select[data-id="${CSS.escape(id)}"][data-field="status"]`);
    const notesNode = document.querySelector(`textarea[data-id="${CSS.escape(id)}"][data-field="notes"]`);

    const payload = {
      lead_id: id,
      status: statusNode?.value || null,
      notes: notesNode?.value || null,
    };

    try {
      const response = await fetch('/api/crm.php?action=update', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });

      if (!response.ok) {
        setFeedback('Erreur lors de la sauvegarde du lead.', false);
        return;
      }

      setFeedback('Lead mis à jour.');
      await loadData();
    } catch (error) {
      setFeedback('Erreur réseau pendant la sauvegarde.', false);
    }
  }

  async function sendSequence() {
    try {
      const response = await fetch('/api/crm.php?action=send-sequence', { method: 'POST' });
      const data = await response.json();
      const sent = data?.result?.sent || 0;
      const errors = (data?.result?.errors || []).length;
      setFeedback(`Envoi terminé : ${sent} email(s), ${errors} erreur(s).`, errors === 0);
      await loadData();
    } catch (error) {
      setFeedback('Impossible de déclencher la séquence email.', false);
    }
  }

  function activateTab(tabName) {
    document.querySelectorAll('.nav-item').forEach((item) => {
      item.classList.toggle('active', item.dataset.tab === tabName);
    });

    panels.forEach((panel) => {
      panel.classList.toggle('active', panel.dataset.panel === tabName);
    });

    nav?.classList.remove('open');
  }

  function bindEvents() {
    document.addEventListener('click', (event) => {
      const tabButton = event.target.closest('.nav-item');
      if (tabButton) {
        activateTab(tabButton.dataset.tab);
      }

      const saveButton = event.target.closest('.save-lead');
      if (saveButton) {
        saveLead(saveButton.dataset.id || '');
      }
    });

    searchInput?.addEventListener('input', renderLeads);

    document.getElementById('refresh-dashboard')?.addEventListener('click', loadData);
    document.getElementById('send-sequence')?.addEventListener('click', sendSequence);
    document.getElementById('mobile-menu-toggle')?.addEventListener('click', () => nav?.classList.toggle('open'));

    document.getElementById('settings-form')?.addEventListener('submit', (event) => {
      event.preventDefault();
      const form = event.currentTarget;
      localStorage.setItem('crm_settings', JSON.stringify({
        refreshInterval: form.refreshInterval.value,
        compactMode: form.compactMode.checked,
      }));
      setFeedback('Paramètres sauvegardés localement.');
      body.classList.toggle('compact-mode', form.compactMode.checked);
    });
  }

  function hydrateSettings() {
    const raw = localStorage.getItem('crm_settings');
    if (!raw) return;

    const settings = parseJSON(raw);
    if (!settings) return;

    const form = document.getElementById('settings-form');
    if (!form) return;

    form.refreshInterval.value = settings.refreshInterval || '60';
    form.compactMode.checked = Boolean(settings.compactMode);
    body.classList.toggle('compact-mode', form.compactMode.checked);
  }

  function render() {
    updateKpi();
    renderLeads();
    renderEmails();
    renderCalendar();

    if (stats && typeof stats === 'object') {
      const sent = Number(stats.emails_sent || 0);
      if (sent > 0) setFeedback(`Statistiques chargées (${sent} emails envoyés).`);
    }
  }

  hydrateSettings();
  bindEvents();
  render();
})();
