<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Générateur d'Offres IA
 * Interface chat pour construire une offre immobilière guidée par l'IA
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// Stats pour la sidebar
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads WHERE status = 'client' OR status = 'Clients'");
$clients = $stmt->fetch()['total'];

// Compter les offres
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM offres");
    $totalOffres = $stmt->fetch()['total'];
} catch (PDOException $e) {
    $totalOffres = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Générateur d'Offres IA - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
        }

        .container { display: flex; min-height: 100vh; }

        /* Sidebar - same as index.php */
        .sidebar {
            width: 220px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header { padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 2rem; }
        .sidebar-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; opacity: 0.8; letter-spacing: 0.5px; }
        .sidebar-section { margin-bottom: 2rem; padding: 0 1rem; }
        .sidebar-section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.75rem; padding: 0 0.5rem; letter-spacing: 0.5px; }
        .sidebar-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; text-decoration: none; color: rgba(255,255,255,0.8); font-size: 0.9rem; }
        .sidebar-item:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-item.active { background: rgba(255,255,255,0.2); color: white; font-weight: 600; }
        .sidebar-icon { font-size: 1.2rem; width: 1.5rem; }
        .sidebar-badge { margin-left: auto; background: rgba(255,255,255,0.3); padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-card { display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 1rem; }
        .user-avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; }
        .user-info { flex: 1; font-size: 0.85rem; }
        .user-name { font-weight: 600; display: block; }
        .user-email { opacity: 0.7; font-size: 0.75rem; }
        .logout-btn { width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; text-decoration: none; display: block; text-align: center; }
        .logout-btn:hover { background: rgba(255,255,255,0.3); }

        /* Main content */
        .main {
            flex: 1;
            margin-left: 220px;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: white;
            border-bottom: 1px solid var(--gray-200);
        }

        .header-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--secondary); }
        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { opacity: 0.9; }
        .btn-outline { background: white; color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-outline:hover { background: var(--gray-50); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }

        /* Chat area */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .message {
            max-width: 85%;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            font-size: 0.95rem;
            line-height: 1.6;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-assistant {
            align-self: flex-start;
            background: white;
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-bottom-left-radius: 0.25rem;
        }

        .message-user {
            align-self: flex-end;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-bottom-right-radius: 0.25rem;
        }

        .message-label {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            opacity: 0.7;
        }

        .message-content {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .message-content strong, .message-content b {
            font-weight: 600;
        }

        .typing-indicator {
            align-self: flex-start;
            padding: 1rem 1.5rem;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 1rem;
            border-bottom-left-radius: 0.25rem;
            display: none;
        }

        .typing-indicator.visible { display: block; }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gray-400);
            animation: typing 1.4s infinite;
        }

        .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typing {
            0%, 60%, 100% { opacity: 0.3; transform: translateY(0); }
            30% { opacity: 1; transform: translateY(-4px); }
        }

        /* Input area */
        .chat-input-area {
            padding: 1rem 2rem 1.5rem;
            background: white;
            border-top: 1px solid var(--gray-200);
        }

        .chat-input-wrapper {
            display: flex;
            gap: 0.75rem;
            align-items: flex-end;
        }

        .chat-input {
            flex: 1;
            padding: 0.85rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 0.75rem;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            resize: none;
            outline: none;
            transition: border-color 0.2s;
            max-height: 120px;
            min-height: 48px;
        }

        .chat-input:focus {
            border-color: var(--primary);
        }

        .send-btn {
            padding: 0.85rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .send-btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .send-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        /* Offre validée - banner */
        .offre-banner {
            display: none;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .offre-banner.visible { display: flex; }

        .offre-banner-text {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .offre-banner-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-white {
            background: white;
            color: #059669;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-white:hover { opacity: 0.9; }

        /* Progress bar */
        .progress-bar {
            height: 4px;
            background: var(--gray-200);
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--success));
            transition: width 0.5s ease;
            border-radius: 2px;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 2rem;
            background: white;
            border-bottom: 1px solid var(--gray-100);
        }

        .progress-step {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s;
        }

        .progress-step.active { color: var(--primary); }
        .progress-step.done { color: var(--success); }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.visible { display: flex; }

        .modal {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal h3 {
            font-family: 'Poppins', sans-serif;
            margin-bottom: 1rem;
        }

        .modal p {
            color: var(--gray-500);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: relative; padding: 1rem 0; }
            .main { margin-left: 0; height: auto; min-height: 100vh; }
            .sidebar-footer { position: relative; }
            .message { max-width: 95%; }
            .progress-steps { overflow-x: auto; gap: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'offers'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <div>
                    <h1 class="header-title">🤖 Generateur d'Offres IA</h1>
                </div>
                <div class="header-actions">
                    <button class="btn btn-outline" onclick="resetChat()">Nouvelle conversation</button>
                    <a href="/admin/crm/offres" class="btn btn-outline">Mes Offres</a>
                </div>
            </div>

            <!-- Progress -->
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width: 0%"></div>
            </div>
            <div class="progress-steps">
                <span class="progress-step active" data-step="1">Positionnement</span>
                <span class="progress-step" data-step="2">Persona</span>
                <span class="progress-step" data-step="3">Promesse</span>
                <span class="progress-step" data-step="4">Offre</span>
                <span class="progress-step" data-step="5">Valeur</span>
                <span class="progress-step" data-step="6">Confiance</span>
                <span class="progress-step" data-step="7">Validation</span>
            </div>

            <!-- Offre validée banner -->
            <div class="offre-banner" id="offreBanner">
                <span class="offre-banner-text">Ton offre est prete ! Sauvegarde-la dans ton back-office.</span>
                <div class="offre-banner-actions">
                    <button class="btn-white" onclick="saveOffre()">Sauvegarder l'offre</button>
                </div>
            </div>

            <!-- Chat -->
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    <!-- Messages will be inserted here -->
                </div>

                <div class="typing-indicator" id="typingIndicator">
                    <div class="typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>

                <div class="chat-input-area">
                    <div class="chat-input-wrapper">
                        <textarea
                            class="chat-input"
                            id="chatInput"
                            placeholder="Ecris ta reponse ici..."
                            rows="1"
                            onkeydown="handleKeyDown(event)"
                        ></textarea>
                        <button class="send-btn" id="sendBtn" onclick="sendMessage()">Envoyer</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de confirmation de sauvegarde -->
    <div class="modal-overlay" id="saveModal">
        <div class="modal">
            <h3>Sauvegarder l'offre</h3>
            <p>Ton offre va etre sauvegardee dans ton back-office. Tu pourras la modifier, la valider et l'utiliser ensuite.</p>
            <div class="modal-actions">
                <button class="btn btn-outline" onclick="closeSaveModal()">Annuler</button>
                <button class="btn btn-success" id="confirmSaveBtn" onclick="confirmSave()">Confirmer la sauvegarde</button>
            </div>
        </div>
    </div>

    <script>
    // =====================================================
    // STATE
    // =====================================================
    let conversationHistory = []; // Messages for API (role/content)
    let currentStep = 1;
    let offreData = null;
    let isLoading = false;

    // =====================================================
    // INIT
    // =====================================================
    document.addEventListener('DOMContentLoaded', () => {
        startConversation();
        autoResizeInput();
    });

    function autoResizeInput() {
        const input = document.getElementById('chatInput');
        input.addEventListener('input', () => {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 120) + 'px';
        });
    }

    // =====================================================
    // CHAT FUNCTIONS
    // =====================================================

    async function startConversation() {
        setLoading(true);

        try {
            const response = await fetch('/api/api-ai-offre.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ action: 'start' })
            });

            const data = await response.json();

            if (data.success) {
                // Add the initial user message (hidden) and assistant response to history
                conversationHistory = [
                    { role: 'user', content: 'Bonjour, je veux créer mon offre immobilière.' },
                    { role: 'assistant', content: data.response }
                ];
                appendMessage('assistant', data.response);
            } else {
                appendMessage('assistant', 'Erreur: ' + (data.error || 'Impossible de demarrer la conversation.'));
            }
        } catch (error) {
            appendMessage('assistant', 'Erreur de connexion. Verifie ta connexion internet et reessaie.');
        }

        setLoading(false);
    }

    async function sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();

        if (!message || isLoading) return;

        // Add user message
        appendMessage('user', message);
        conversationHistory.push({ role: 'user', content: message });

        input.value = '';
        input.style.height = 'auto';

        setLoading(true);

        try {
            const response = await fetch('/api/api-ai-offre.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({
                    action: 'chat',
                    messages: conversationHistory
                })
            });

            const data = await response.json();

            if (data.success) {
                conversationHistory.push({ role: 'assistant', content: data.response });

                // Clean the response from JSON markers for display
                let displayResponse = data.response;
                displayResponse = displayResponse.replace(/---OFFRE_COMPLETE---[\s\S]*?---FIN_OFFRE---/, '').trim();

                appendMessage('assistant', displayResponse);

                // Check if offer data was extracted
                if (data.offre_data) {
                    offreData = data.offre_data;
                    showOffreBanner();
                    updateProgress(7);
                } else {
                    detectStep(data.response);
                }
            } else {
                appendMessage('assistant', 'Erreur: ' + (data.error || 'Reponse invalide.'));
            }
        } catch (error) {
            appendMessage('assistant', 'Erreur de connexion. Reessaie.');
        }

        setLoading(false);
    }

    // =====================================================
    // UI FUNCTIONS
    // =====================================================

    function appendMessage(role, content) {
        const container = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = 'message message-' + role;

        const label = document.createElement('div');
        label.className = 'message-label';
        label.textContent = role === 'assistant' ? '🤖 Coach IA' : '👤 Vous';

        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.textContent = content;

        div.appendChild(label);
        div.appendChild(contentDiv);
        container.appendChild(div);

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    }

    function setLoading(loading) {
        isLoading = loading;
        const sendBtn = document.getElementById('sendBtn');
        const input = document.getElementById('chatInput');
        const indicator = document.getElementById('typingIndicator');

        sendBtn.disabled = loading;
        input.disabled = loading;

        if (loading) {
            indicator.classList.add('visible');
            sendBtn.textContent = '...';
        } else {
            indicator.classList.remove('visible');
            sendBtn.textContent = 'Envoyer';
            input.focus();
        }
    }

    function handleKeyDown(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    }

    function detectStep(response) {
        const lower = response.toLowerCase();
        if (lower.includes('étape 6') || lower.includes('confiance') || lower.includes('garantie') || lower.includes('preuves')) {
            updateProgress(6);
        } else if (lower.includes('étape 5') || lower.includes('prix') || lower.includes('combien')) {
            updateProgress(5);
        } else if (lower.includes('étape 4') || lower.includes('proposes concrètement') || lower.includes('services')) {
            updateProgress(4);
        } else if (lower.includes('étape 3') || lower.includes('promesse') || lower.includes('résultat')) {
            updateProgress(3);
        } else if (lower.includes('étape 2') || lower.includes('persona') || lower.includes('attirer en priorité')) {
            updateProgress(2);
        }
    }

    function updateProgress(step) {
        currentStep = step;
        const fill = document.getElementById('progressFill');
        const percentage = Math.round((step / 7) * 100);
        fill.style.width = percentage + '%';

        document.querySelectorAll('.progress-step').forEach(el => {
            const s = parseInt(el.dataset.step);
            el.classList.remove('active', 'done');
            if (s < step) el.classList.add('done');
            if (s === step) el.classList.add('active');
        });
    }

    function showOffreBanner() {
        document.getElementById('offreBanner').classList.add('visible');
    }

    // =====================================================
    // SAVE OFFRE
    // =====================================================

    function saveOffre() {
        if (!offreData) {
            alert('Aucune offre a sauvegarder. Continue la conversation pour generer ton offre.');
            return;
        }
        document.getElementById('saveModal').classList.add('visible');
    }

    function closeSaveModal() {
        document.getElementById('saveModal').classList.remove('visible');
    }

    async function confirmSave() {
        const btn = document.getElementById('confirmSaveBtn');
        btn.disabled = true;
        btn.textContent = 'Sauvegarde en cours...';

        try {
            const response = await fetch('/api/api-ai-offre.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({
                    action: 'save_offre',
                    offre_data: offreData,
                    conversation: conversationHistory
                })
            });

            const data = await response.json();

            if (data.success) {
                closeSaveModal();
                alert('Offre sauvegardee avec succes !');
                window.location.href = '/admin/crm/offre-detail?id=' + data.offre_id;
            } else {
                alert('Erreur: ' + (data.error || 'Impossible de sauvegarder.'));
            }
        } catch (error) {
            alert('Erreur de connexion.');
        }

        btn.disabled = false;
        btn.textContent = 'Confirmer la sauvegarde';
    }

    // =====================================================
    // RESET
    // =====================================================

    function resetChat() {
        if (!confirm('Recommencer une nouvelle conversation ? L\'historique actuel sera perdu.')) return;

        conversationHistory = [];
        offreData = null;
        currentStep = 1;

        document.getElementById('chatMessages').innerHTML = '';
        document.getElementById('offreBanner').classList.remove('visible');
        updateProgress(1);

        startConversation();
    }
    </script>
</body>
</html>
