<?php
/**
 * ÉCOSYSTÈME IMMO+ - Éditeur Email avec IA
 * Composant réutilisable avec Quill.js + Claude AI
 */

// Ce fichier peut être inclus dans admin-emails.php
// ou utilisé comme page standalone

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditeur Email IA - ÉCOSYSTÈME IMMO+</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Quill CSS -->
    <link href="/css/quill.core.css" rel="stylesheet">
    <link href="/css/admin-crm.css" rel="stylesheet">
    <style>
    :root {
        --primary: #667eea;
        --primary-dark: #5a67d8;
        --secondary: #764ba2;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #1f2937;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
    }
    
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--gray-100);
        color: var(--gray-800);
        line-height: 1.6;
    }
    
    .email-editor-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .editor-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .editor-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
    }
    
    .editor-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    /* Section Objet */
    .subject-section {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .subject-row {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .subject-label {
        font-weight: 600;
        color: var(--gray-600);
        min-width: 60px;
    }
    
    .subject-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid var(--gray-300);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .subject-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }
    
    /* Toolbar IA */
    .ai-toolbar {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1));
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .ai-toolbar-label {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .ai-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.5rem;
        cursor: pointer;
        border: 1px solid var(--gray-300);
        background: white;
        color: var(--gray-700);
        transition: all 0.2s;
    }
    
    .ai-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(102,126,234,0.05);
    }
    
    .ai-btn.primary {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .ai-btn.primary:hover {
        background: var(--primary-dark);
    }
    
    .ai-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .ai-btn .spinner {
        width: 14px;
        height: 14px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: none;
    }
    
    .ai-btn.loading .spinner {
        display: inline-block;
    }
    
    .ai-btn.loading .btn-icon {
        display: none;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Variables dropdown */
    .variables-dropdown {
        position: relative;
    }
    
    .variables-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        min-width: 200px;
        z-index: 100;
        display: none;
    }
    
    .variables-menu.active {
        display: block;
    }
    
    .variable-item {
        padding: 0.6rem 1rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        transition: background 0.15s;
    }
    
    .variable-item:hover {
        background: var(--gray-50);
    }
    
    .variable-item code {
        color: var(--primary);
        font-family: monospace;
        font-size: 0.8rem;
    }
    
    /* Quill Editor */
    .quill-wrapper {
        border-bottom: 1px solid var(--gray-200);
    }
    
    #email-editor {
        min-height: 350px;
        font-size: 1rem;
    }
    
    #email-editor .ql-editor {
        min-height: 350px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.7;
    }
    
    #email-editor .ql-editor p {
        margin-bottom: 1rem;
    }
    
    .ql-toolbar.ql-snow {
        border: none;
        border-bottom: 1px solid var(--gray-200);
        padding: 0.75rem 1rem;
    }
    
    .ql-container.ql-snow {
        border: none;
    }
    
    /* Actions footer */
    .editor-footer {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--gray-50);
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 0.5rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
    }
    
    .btn-outline {
        background: white;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
    }
    
    .btn-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-success {
        background: var(--success);
        color: white;
    }
    
    .btn-success:hover {
        background: #059669;
    }
    
    /* Modal Génération */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        z-index: 1000;
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .modal-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .modal-close {
        width: 32px;
        height: 32px;
        border: none;
        background: var(--gray-100);
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        color: var(--gray-500);
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--gray-700);
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--gray-300);
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    /* Toast notifications */
    .toast {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        padding: 1rem 1.5rem;
        background: var(--dark);
        color: white;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        opacity: 0;
        transform: translateY(1rem);
        transition: all 0.3s;
        z-index: 2000;
    }
    
    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    .toast.success { background: var(--success); }
    .toast.error { background: var(--danger); }
    
    /* Responsive */
    @media (max-width: 768px) {
        .ai-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .editor-footer {
            flex-direction: column;
            gap: 1rem;
        }
    }
    </style>
</head>
<body>
    <div class="email-editor-container">
        <header class="editor-header">
            <h1>✉️ Éditeur d'Email</h1>
            <a href="admin-emails.php" class="btn btn-outline">← Retour</a>
        </header>
        
        <div class="editor-card">
            <!-- Objet -->
            <div class="subject-section">
                <div class="subject-row">
                    <span class="subject-label">Objet</span>
                    <input type="text" id="email-subject" class="subject-input" placeholder="Ligne d'objet de votre email...">
                    <button class="ai-btn" onclick="generateSubjects()" title="Générer des idées d'objet">
                        <span class="btn-icon">✨</span>
                        <span class="spinner"></span>
                        Idées
                    </button>
                </div>
            </div>
            
            <!-- Toolbar IA -->
            <div class="ai-toolbar">
                <span class="ai-toolbar-label">🤖 Assistant IA</span>
                
                <button class="ai-btn primary" onclick="openGenerateModal()">
                    <span class="btn-icon">✨</span>
                    Générer email
                </button>
                
                <button class="ai-btn" id="btn-improve" onclick="improveText()">
                    <span class="btn-icon">🔄</span>
                    <span class="spinner"></span>
                    Améliorer
                </button>
                
                <button class="ai-btn" id="btn-shorten" onclick="shortenText()">
                    <span class="btn-icon">✂️</span>
                    <span class="spinner"></span>
                    Raccourcir
                </button>
                
                <button class="ai-btn" id="btn-persuade" onclick="makePersuasive()">
                    <span class="btn-icon">🎯</span>
                    <span class="spinner"></span>
                    + Persuasif
                </button>
                
                <div class="variables-dropdown">
                    <button class="ai-btn" onclick="toggleVariables()">
                        <span class="btn-icon">{ }</span>
                        Variables
                    </button>
                    <div class="variables-menu" id="variables-menu">
                        <div class="variable-item" onclick="insertVariable('{{firstname}}')">
                            <span>Prénom</span>
                            <code>{{firstname}}</code>
                        </div>
                        <div class="variable-item" onclick="insertVariable('{{email}}')">
                            <span>Email</span>
                            <code>{{email}}</code>
                        </div>
                        <div class="variable-item" onclick="insertVariable('{{resource}}')">
                            <span>Ressource</span>
                            <code>{{resource}}</code>
                        </div>
                        <div class="variable-item" onclick="insertVariable('{{city}}')">
                            <span>Ville</span>
                            <code>{{city}}</code>
                        </div>
                        <div class="variable-item" onclick="insertVariable('{{unsubscribe_link}}')">
                            <span>Désinscription</span>
                            <code>{{unsubscribe_link}}</code>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Éditeur Quill -->
            <div class="quill-wrapper">
                <div id="email-editor"></div>
            </div>
            
            <!-- Footer -->
            <div class="editor-footer">
                <div class="footer-left">
                    <button class="btn btn-outline" onclick="previewEmail()">👁️ Aperçu</button>
                    <button class="btn btn-outline" onclick="saveAsDraft()">💾 Brouillon</button>
                </div>
                <div class="footer-right">
                    <button class="btn btn-success" onclick="saveEmail()">✅ Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Génération -->
    <div class="modal-overlay" id="generate-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>✨ Générer un email avec l'IA</h2>
                <button class="modal-close" onclick="closeGenerateModal()">&times;</button>
            </div>
            
            <div class="form-group">
                <label>Type d'email</label>
                <select id="gen-type">
                    <option value="bienvenue">Email de bienvenue</option>
                    <option value="suivi">Suivi après téléchargement</option>
                    <option value="relance">Relance / Rappel</option>
                    <option value="valeur">Apport de valeur</option>
                    <option value="demo">Proposition de démo</option>
                    <option value="temoignage">Témoignage client</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Contexte / Instructions</label>
                <textarea id="gen-context" placeholder="Ex: Le prospect a téléchargé le guide des mandats exclusifs. Objectif : l'inciter à prendre un RDV démo."></textarea>
            </div>
            
            <div class="form-group">
                <label>Ton</label>
                <select id="gen-tone">
                    <option value="professionnel">Professionnel</option>
                    <option value="amical">Amical et accessible</option>
                    <option value="expert">Expert et autoritaire</option>
                    <option value="urgent">Urgent mais respectueux</option>
                </select>
            </div>
            
            <button class="btn btn-primary" style="width: 100%;" id="btn-generate" onclick="generateEmail()">
                <span class="btn-icon">✨</span>
                <span class="spinner"></span>
                Générer l'email
            </button>
        </div>
    </div>
    
    <!-- Toast -->
    <div class="toast" id="toast"></div>
    
    <!-- Quill JS -->
    <script src="/js/quill.core.js"></script>
    <script>
    // Initialisation Quill
    var quill = new Quill('#email-editor', {
        theme: 'snow',
        placeholder: 'Rédigez votre email ici...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });
    
    // API endpoint
    var API_URL = '/api/ai-email.php';
    
    // Toast notification
    function showToast(message, type) {
        var toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = 'toast ' + (type || '');
        toast.classList.add('show');
        setTimeout(function() {
            toast.classList.remove('show');
        }, 3000);
    }
    
    // Toggle variables menu
    function toggleVariables() {
        document.getElementById('variables-menu').classList.toggle('active');
    }
    
    // Fermer menu si clic ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.variables-dropdown')) {
            document.getElementById('variables-menu').classList.remove('active');
        }
    });
    
    // Insérer une variable
    function insertVariable(variable) {
        var range = quill.getSelection(true);
        quill.insertText(range.index, variable);
        quill.setSelection(range.index + variable.length);
        document.getElementById('variables-menu').classList.remove('active');
    }
    
    // Modal génération
    function openGenerateModal() {
        document.getElementById('generate-modal').classList.add('active');
    }
    
    function closeGenerateModal() {
        document.getElementById('generate-modal').classList.remove('active');
    }
    
    // Appel API générique
    async function callAI(action, data, buttonId) {
        var btn = buttonId ? document.getElementById(buttonId) : null;
        if (btn) btn.classList.add('loading');
        
        try {
            var response = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.assign({ action: action }, data))
            });
            
            var result = await response.json();
            
            if (btn) btn.classList.remove('loading');
            
            if (!result.success) {
                showToast(result.error || 'Erreur IA', 'error');
                return null;
            }
            
            return result.content;
        } catch (error) {
            if (btn) btn.classList.remove('loading');
            showToast('Erreur de connexion', 'error');
            return null;
        }
    }
    
    // Générer email complet
    async function generateEmail() {
        var type = document.getElementById('gen-type').value;
        var context = document.getElementById('gen-context').value;
        var tone = document.getElementById('gen-tone').value;
        
        var content = await callAI('generate', {
            type: type,
            context: context,
            tone: tone
        }, 'btn-generate');
        
        if (content) {
            // Parser le résultat
            var lines = content.split('\n');
            var subject = '';
            var body = '';
            var inBody = false;
            
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i];
                if (line.startsWith('OBJET:')) {
                    subject = line.replace('OBJET:', '').trim();
                } else if (line.trim() !== '' || inBody) {
                    inBody = true;
                    body += line + '\n';
                }
            }
            
            if (subject) {
                document.getElementById('email-subject').value = subject;
            }
            
            quill.root.innerHTML = body.trim();
            closeGenerateModal();
            showToast('Email généré !', 'success');
        }
    }
    
    // Améliorer le texte
    async function improveText() {
        var html = quill.root.innerHTML;
        if (!html || html === '<p><br></p>') {
            showToast('Écrivez d\'abord du texte', 'error');
            return;
        }
        
        var content = await callAI('improve', {
            text: html,
            instruction: 'Améliore ce texte pour le rendre plus engageant et professionnel'
        }, 'btn-improve');
        
        if (content) {
            quill.root.innerHTML = content;
            showToast('Texte amélioré !', 'success');
        }
    }
    
    // Raccourcir le texte
    async function shortenText() {
        var html = quill.root.innerHTML;
        if (!html || html === '<p><br></p>') {
            showToast('Écrivez d\'abord du texte', 'error');
            return;
        }
        
        var content = await callAI('shorten', { text: html }, 'btn-shorten');
        
        if (content) {
            quill.root.innerHTML = content;
            showToast('Texte raccourci !', 'success');
        }
    }
    
    // Rendre plus persuasif
    async function makePersuasive() {
        var html = quill.root.innerHTML;
        if (!html || html === '<p><br></p>') {
            showToast('Écrivez d\'abord du texte', 'error');
            return;
        }
        
        var content = await callAI('persuade', { text: html }, 'btn-persuade');
        
        if (content) {
            quill.root.innerHTML = content;
            showToast('Texte rendu plus persuasif !', 'success');
        }
    }
    
    // Générer des lignes d'objet
    async function generateSubjects() {
        var html = quill.root.innerHTML;
        var content = await callAI('subject', {
            body: html,
            context: document.getElementById('gen-context')?.value || ''
        });
        
        if (content) {
            // Prendre la première suggestion
            var lines = content.split('\n').filter(function(l) { return l.trim(); });
            if (lines.length > 0) {
                var firstSuggestion = lines[0].replace(/^\d+[\.\)]\s*/, '');
                document.getElementById('email-subject').value = firstSuggestion;
                showToast('Objet généré ! ' + lines.length + ' suggestions disponibles', 'success');
            }
        }
    }
    
    // Aperçu email
    function previewEmail() {
        var subject = document.getElementById('email-subject').value;
        var body = quill.root.innerHTML;
        
        var preview = window.open('', '_blank', 'width=600,height=700');
        preview.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Aperçu: ${subject}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 2rem; max-width: 600px; margin: 0 auto; }
                    .subject { font-size: 1.2rem; font-weight: bold; color: #333; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd; }
                    .body { line-height: 1.6; color: #444; }
                    .variable { background: #e0e7ff; color: #4338ca; padding: 0.1rem 0.3rem; border-radius: 0.25rem; }
                </style>
            </head>
            <body>
                <div class="subject">📧 ${subject || '(Pas d\'objet)'}</div>
                <div class="body">${body.replace(/\{\{(\w+)\}\}/g, '<span class="variable">{{$1}}</span>')}</div>
            </body>
            </html>
        `);
    }
    
    // Sauvegarder brouillon
    function saveAsDraft() {
        var data = {
            subject: document.getElementById('email-subject').value,
            body: quill.root.innerHTML,
            savedAt: new Date().toISOString()
        };
        localStorage.setItem('email_draft', JSON.stringify(data));
        showToast('Brouillon sauvegardé !', 'success');
    }
    
    // Charger brouillon au démarrage
    function loadDraft() {
        var draft = localStorage.getItem('email_draft');
        if (draft) {
            try {
                var data = JSON.parse(draft);
                if (confirm('Un brouillon existe. Voulez-vous le charger ?')) {
                    document.getElementById('email-subject').value = data.subject || '';
                    quill.root.innerHTML = data.body || '';
                }
            } catch (e) {}
        }
    }
    
    // Sauvegarder email (à connecter à ton backend)
    function saveEmail() {
        var subject = document.getElementById('email-subject').value;
        var body = quill.root.innerHTML;
        
        if (!subject) {
            showToast('Ajoutez une ligne d\'objet', 'error');
            return;
        }
        
        if (!body || body === '<p><br></p>') {
            showToast('Ajoutez du contenu', 'error');
            return;
        }
        
        // TODO: Appel API pour sauvegarder
        console.log('Email à sauvegarder:', { subject, body });
        showToast('Email enregistré !', 'success');
        
        // Effacer le brouillon
        localStorage.removeItem('email_draft');
    }
    
    // Fermer modal avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGenerateModal();
        }
    });
    
    // Charger brouillon au démarrage
    document.addEventListener('DOMContentLoaded', loadDraft);
    </script>
</body>
</html>