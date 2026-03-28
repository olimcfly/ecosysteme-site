<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Formulaire de Contact
 */
$pageTitle = 'Contactez-nous — ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Diagnostic gratuit. Pas de pression commerciale. Juste une analyse honnête de votre situation immobilière.';
$currentPage = 'contact';

include '../includes/header.php';
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - ÉCOSYSTÈME IMMO LOCAL+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: white;
            color: var(--gray-900);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
        }
        
        .section {
            padding: 80px 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea15, #764ba215);
            color: var(--primary);
            padding: 0.5rem 1.2rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
            max-width: 1100px;
            margin: 0 auto;
        }
        
        .form-column h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }
        
        .form-label .required {
            color: #ef4444;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.75rem;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s;
            background: white;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 140px;
        }
        
        .form-group.two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        .form-group.two-cols .form-group {
            margin-bottom: 0;
        }
        
        .form-hint {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.35rem;
        }
        
        .btn {
            display: inline-block;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            font-family: inherit;
            width: 100%;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102,126,234,0.3);
        }
        
        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .form-footer {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-top: 1rem;
            text-align: center;
        }
        
        .info-column {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .info-card {
            background: var(--gray-50);
            padding: 2rem;
            border-radius: 1rem;
            border-left: 4px solid var(--primary);
        }
        
        .info-card h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.75rem;
        }
        
        .info-card p {
            color: var(--gray-600);
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }
        
        .debug-panel {
            position: fixed;
            bottom: 0;
            right: 0;
            background: black;
            color: #0f0;
            padding: 1rem;
            width: 400px;
            height: 300px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 0.75rem;
            border: 1px solid #0f0;
            z-index: 9999;
            display: none;
        }
        
        .debug-panel.active {
            display: block;
        }
        
        .debug-panel h3 {
            color: #0f0;
            margin-bottom: 0.5rem;
        }
        
        .debug-line {
            margin: 0.25rem 0;
            padding: 0.25rem;
            border-bottom: 1px solid #0f030;
        }
        
        .debug-error {
            color: #f00;
        }
        
        .debug-success {
            color: #0f0;
        }
        
        .debug-info {
            color: #0ff;
        }
        
        .debug-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #667eea;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            z-index: 10000;
            font-weight: 600;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .debug-panel {
                width: 100%;
                height: 200px;
            }
        }
        #char-counter {
    font-weight: 600;
    transition: color 0.3s;
}

#char-counter.valid {
    color: var(--success);
}

#char-counter.invalid {
    color: #ef4444;
}
    </style>
</head>
<body>
    <div class="debug-panel" id="debugPanel">
        <h3>🐛 DEBUG LOG</h3>
        <div id="debugLog"></div>
    </div>
    <button class="debug-toggle" id="debugToggle">🐛 DEBUG</button>
    
    <section class="hero">
        <div class="container">
            <h1>Parlons de votre vente</h1>
            <p>Diagnostic gratuit. Pas de pression commerciale. Juste une analyse honnête de votre situation.</p>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">💬 Votre demande</span>
                <h2 class="section-title">Par où commencer ?</h2>
            </div>
            
            <div class="form-grid">
                <div class="form-column">
                    <h3>Remplissez vos infos</h3>
                    
                    <form id="contact-form" method="POST">
                        <?= csrfField() ?>
                        <input type="hidden" name="action" value="submit_contact">
                        
                        <div id="form-message"></div>
                        
                        <div class="form-group two-cols">
                            <div class="form-group">
                                <label class="form-label">Prénom <span class="required">*</span></label>
                                <input type="text" name="firstname" class="form-input" placeholder="Votre prénom" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nom <span class="required">*</span></label>
                                <input type="text" name="lastname" class="form-input" placeholder="Votre nom" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-input" placeholder="votre@email.com" required>
                            <div class="form-hint">Où on vous enverra la confirmation</div>
                        </div>
                        
                        <div class="form-group two-cols">
                            <div class="form-group">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="phone" class="form-input" placeholder="06 XX XX XX XX">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Ville du bien</label>
                                <input type="text" name="city" class="form-input" placeholder="Paris, Lyon...">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Que cherchez-vous ? <span class="required">*</span></label>
                            <select name="intent" class="form-select" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="diagnostic">🔍 Diagnostic de ma situation</option>
                                <option value="demo">🎬 Démo de la plateforme</option>
                                <option value="ressource">📚 Ressources et contenus</option>
                                <option value="outil">🧰 Tester les outils</option>
                                <option value="cold">💬 Simplement vous parler</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
    <label class="form-label">Votre message <span class="required">*</span></label>
    <textarea name="message" class="form-textarea" id="message-input" placeholder="Décrivez votre situation..." required minlength="30"></textarea>
    <div class="form-hint">
        <span id="char-counter">0</span>/30 caractères minimum
    </div>
</div>
                        
                        <button type="submit" class="btn btn-primary">✉️ Envoyer ma demande</button>
                        
                        <div class="form-footer">
                            Pas de spam, pas de relance agressive.
                        </div>
                    </form>
                </div>
                
                <div class="info-column">
                    <div class="info-card">
                        <div class="icon-circle">🎯</div>
                        <h4>Diagnostic gratuit</h4>
                        <p>Pas d'engagement, pas de surprise. Juste une vraie analyse de votre situation immobilière.</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="icon-circle">👂</div>
                        <h4>On vous écoute d'abord</h4>
                        <p>Avant toute action, nous comprenons vos blocages réels et vos objectifs véritables.</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="icon-circle">🗺️</div>
                        <h4>Options claires</h4>
                        <p>Vous connaissez vos scénarios possibles et choisissez en connaissance de cause.</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="icon-circle">📞</div>
                        <h4>Réponse rapide</h4>
                        <p>Notre équipe examine votre demande et vous recontacte dans les 24 heures.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const debugLog = document.getElementById('debugLog');
        const debugPanel = document.getElementById('debugPanel');
        const debugToggle = document.getElementById('debugToggle');
        
        function addDebug(type, message, data) {
            const timestamp = new Date().toLocaleTimeString();
            const className = type === 'error' ? 'debug-error' : type === 'success' ? 'debug-success' : 'debug-info';
            
            const line = document.createElement('div');
            line.className = `debug-line ${className}`;
            line.textContent = `[${timestamp}] ${type.toUpperCase()}: ${message}`;
            if (data) {
                line.textContent += ' ' + JSON.stringify(data);
            }
            
            debugLog.appendChild(line);
            debugLog.scrollTop = debugLog.scrollHeight;
            console[type === 'error' ? 'error' : 'log'](`[${type}] ${message}`, data || '');
        }
        
        debugToggle.addEventListener('click', () => {
            debugPanel.classList.toggle('active');
        });
        
        addDebug('info', 'Page chargée');
        
        document.getElementById('contact-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            addDebug('info', 'Formulaire soumis');
            
            const form = e.target;
            const messageDiv = document.getElementById('form-message');
            const submitBtn = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);
            
            addDebug('info', 'Données formulaire:', {
                firstname: formData.get('firstname'),
                lastname: formData.get('lastname'),
                email: formData.get('email'),
                action: formData.get('action'),
                intent: formData.get('intent')
            });
            
            try {
                submitBtn.disabled = true;
                submitBtn.textContent = '⏳ Envoi en cours...';
                
                addDebug('info', 'Envoi POST vers /contacts/api.php');
                
                const response = await fetch('/contacts/api.php', {
                    method: 'POST',
                    body: formData
                });
                
                addDebug('info', 'Réponse reçue:', {
                    status: response.status,
                    ok: response.ok
                });
                
                const responseText = await response.text();
                addDebug('info', 'Texte brut:', responseText.substring(0, 200));
                
                let data;
                try {
                    data = JSON.parse(responseText);
                    addDebug('success', 'JSON parsé correctement');
                } catch (e) {
                    addDebug('error', 'Réponse non-JSON:', responseText);
                    messageDiv.innerHTML = `<div class="alert alert-error"><strong>Erreur serveur:</strong> ${responseText}</div>`;
                    submitBtn.disabled = false;
                    submitBtn.textContent = '✉️ Envoyer ma demande';
                    return;
                }
                
                if (data.success) {
                    addDebug('success', 'Succès API!');
                    addDebug('info', 'Redirection vers:', data.redirect_url);
                    setTimeout(() => {
                        window.location.href = data.redirect_url || '/contacts/merci?email=' + encodeURIComponent(formData.get('email'));
                    }, 500);
                } else {
                    const errorMsg = data.message || 'Erreur inconnue';
                    addDebug('error', 'Erreur API:', errorMsg);
                    messageDiv.innerHTML = `<div class="alert alert-error"><strong>Erreur:</strong> ${errorMsg}</div>`;
                    submitBtn.disabled = false;
                    submitBtn.textContent = '✉️ Envoyer ma demande';
                }
            } catch (error) {
                addDebug('error', 'ERREUR EXCEPTION:', error.message);
                messageDiv.innerHTML = `<div class="alert alert-error"><strong>Erreur réseau:</strong> ${error.message}</div>`;
                submitBtn.disabled = false;
                submitBtn.textContent = '✉️ Envoyer ma demande';
            }
        });
        // Compteur de caractères
const messageInput = document.getElementById('message-input');
const charCounter = document.getElementById('char-counter');
const minChars = 30;

messageInput.addEventListener('input', () => {
    const count = messageInput.value.length;
    charCounter.textContent = count;
    
    if (count >= minChars) {
        charCounter.classList.add('valid');
        charCounter.classList.remove('invalid');
    } else {
        charCounter.classList.add('invalid');
        charCounter.classList.remove('valid');
    }
});
    </script>
    <?php include '../includes/footer.php'; ?>

</body>
</html>