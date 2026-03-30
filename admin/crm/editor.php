<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Éditeur d'Emails
 * Éditeur WYSIWYG pour les templates d'emails avec Quill.js
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// ============================================
// TRAITER LES ACTIONS
// ============================================
$message = '';
$messageType = '';
$currentTemplate = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        die('Token de sécurité invalide.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'save_template') {
        $name = $_POST['template_name'] ?? '';
        $subject = $_POST['template_subject'] ?? '';
        $content = $_POST['template_content'] ?? '';
        $template_id = intval($_POST['template_id'] ?? 0);
        
        if (!$name || !$subject || !$content) {
            $message = '❌ Nom, sujet et contenu requis';
            $messageType = 'error';
        } else {
            try {
                if ($template_id) {
                    // Mise à jour
                    $stmt = $pdo->prepare("
                        UPDATE email_templates 
                        SET name = ?, subject = ?, content = ?, updated_at = NOW()
                        WHERE id = ?
                    ");
                    if ($stmt->execute([$name, $subject, $content, $template_id])) {
                        $message = '✅ Template mise à jour';
                        $messageType = 'success';
                    }
                } else {
                    // Création
                    $stmt = $pdo->prepare("
                        INSERT INTO email_templates (name, subject, content, created_at)
                        VALUES (?, ?, ?, NOW())
                    ");
                    if ($stmt->execute([$name, $subject, $content])) {
                        $message = '✅ Template créé';
                        $messageType = 'success';
                        $template_id = $pdo->lastInsertId();
                    }
                }
            } catch (Exception $e) {
                $message = '❌ Erreur : ' . $e->getMessage();
                $messageType = 'error';
            }
        }
    }
    
    if ($action === 'delete_template') {
        $template_id = intval($_POST['template_id'] ?? 0);
        
        try {
            $stmt = $pdo->prepare("DELETE FROM email_templates WHERE id = ?");
            if ($stmt->execute([$template_id])) {
                $message = '✅ Template supprimé';
                $messageType = 'success';
                $template_id = null;
            }
        } catch (Exception $e) {
            // Ignore
        }
    }
}

// Récupérer le template à éditer
if (isset($_GET['template_id'])) {
    $template_id = intval($_GET['template_id']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE id = ?");
        $stmt->execute([$template_id]);
        $currentTemplate = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Table n'existe pas
    }
}

// Récupérer les templates
$templates = [];
try {
    $stmt = $pdo->query("SELECT id, name, created_at FROM email_templates ORDER BY created_at DESC");
    $templates = $stmt->fetchAll();
} catch (Exception $e) {
    // Table n'existe pas
}

// Templates prédéfinis
$builtinTemplates = [
    [
        'id' => 'welcome',
        'name' => '👋 Bienvenue',
        'subject' => 'Bienvenue chez ÉCOSYSTÈME IMMO LOCAL+',
        'content' => '<h2>Bonjour [PRENOM],</h2><p>Merci de votre intérêt pour notre plateforme.</p><p>Nous vous aiderons à transformer votre activité immobilière.</p>'
    ],
    [
        'id' => 'followup',
        'name' => '📞 Suivi',
        'subject' => 'Suivi de votre demande',
        'content' => '<h2>Bonjour [PRENOM],</h2><p>J\'aimerais connaître vos prochaines étapes.</p><p>Seriez-vous disponible pour un appel cette semaine ?</p>'
    ],
    [
        'id' => 'demo',
        'name' => '🎥 Accès Demo',
        'subject' => 'Voici votre accès à la démonstration',
        'content' => '<h2>Bonjour [PRENOM],</h2><p>Voici votre lien d\'accès à la démonstration personnalisée :</p><p><a href="[LIEN]">Cliquez ici pour accéder</a></p>'
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Éditeur d'Emails - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
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
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        .template-item {
            padding: 0.75rem;
            background: rgba(255,255,255,0.1);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .template-item:hover {
            background: rgba(255,255,255,0.2);
        }

        .template-item.active {
            background: rgba(255,255,255,0.3);
            font-weight: 600;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .header-left h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .header-breadcrumb {
            font-size: 0.85rem;
            color: var(--gray-500);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .editor-section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.75rem;
            display: block;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        
        .ql-container {
            border: 1px solid var(--gray-200);
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            font-family: inherit;
            font-size: 0.95rem;
            min-height: 300px;
        }
        
        .ql-editor {
            padding: 1.5rem;
            min-height: 300px;
        }
        
        .ql-toolbar {
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem 0.5rem 0 0;
            background: var(--gray-50);
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
        }
        
        .btn-danger:hover {
            background: #dc2626;
        }
        
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .template-preview {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .variables {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .variable-btn {
            padding: 0.4rem 0.8rem;
            background: var(--gray-200);
            border: 1px solid var(--gray-300);
            border-radius: 0.35rem;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
        }
        
        .variable-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .info-box {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #92400e;
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'editor'; include __DIR__ . '/../shared/sidebar.php'; ?>
        
        <main class="main app-content">
            <div class="header">
                <div class="header-left">
                    <h1>✏️ Éditeur d'Emails</h1>
                    <div class="header-breadcrumb">Dashboard > Éditeur</div>
                </div>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="editor-section">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="save_template">
                <?php if ($currentTemplate): ?>
                <input type="hidden" name="template_id" value="<?= $currentTemplate['id'] ?>">
                <?php endif; ?>
                
                <div class="info-box">
                    💡 Utilisez [PRENOM], [NOM], [EMAIL] et [LIEN] pour personnaliser vos templates
                </div>
                
                <!-- Nom Template -->
                <div class="form-group">
                    <label class="form-label">Nom du Template</label>
                    <input type="text" name="template_name" class="form-input" 
                           value="<?= h($currentTemplate['name'] ?? '') ?>"
                           placeholder="Ex: Bienvenue, Suivi, Demo..." required>
                </div>
                
                <!-- Sujet Email -->
                <div class="form-group">
                    <label class="form-label">Sujet de l'Email</label>
                    <input type="text" name="template_subject" class="form-input"
                           value="<?= h($currentTemplate['subject'] ?? '') ?>"
                           placeholder="Ex: Bienvenue chez ÉCOSYSTÈME IMMO LOCAL+" required>
                </div>
                
                <!-- Variables rapides -->
                <div class="form-group">
                    <label class="form-label">Variables</label>
                    <div class="variables">
                        <button type="button" class="variable-btn" onclick="insertVariable('[PRENOM]')">
                            [PRENOM]
                        </button>
                        <button type="button" class="variable-btn" onclick="insertVariable('[NOM]')">
                            [NOM]
                        </button>
                        <button type="button" class="variable-btn" onclick="insertVariable('[EMAIL]')">
                            [EMAIL]
                        </button>
                        <button type="button" class="variable-btn" onclick="insertVariable('[LIEN]')">
                            [LIEN]
                        </button>
                    </div>
                </div>
                
                <!-- Quill Editor -->
                <div class="form-group">
                    <label class="form-label">Contenu de l'Email</label>
                    <div id="email-editor"></div>
                    <textarea name="template_content" id="content-hidden" style="display: none;"></textarea>
                </div>
                
                <!-- Buttons -->
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                    <?php if ($currentTemplate): ?>
                        <button type="submit" name="action" value="delete_template" class="btn btn-danger" 
                                onclick="return confirm('Êtes-vous sûr ?')">
                            🗑️ Supprimer
                        </button>
                    <?php endif; ?>
                </div>
            </form>
            
            <!-- Prévisualisation -->
            <div class="template-preview">
                <h3>📧 Aperçu</h3>
                <div id="preview-content" style="margin-top: 1rem; padding: 1rem; background: white; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
                    Votre aperçu apparaîtra ici
                </div>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Initialiser Quill
        const quill = new Quill('#email-editor', {
            theme: 'snow',
            placeholder: 'Écrivez votre email ici...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
        
        // Charger le contenu existant
        <?php if ($currentTemplate): ?>
            quill.root.innerHTML = <?= json_encode($currentTemplate['content']) ?>;
        <?php endif; ?>
        
        // Mettre à jour l'aperçu en temps réel
        quill.on('text-change', function() {
            const html = quill.root.innerHTML;
            document.getElementById('preview-content').innerHTML = html;
            document.getElementById('content-hidden').value = html;
        });
        
        // Au chargement initial
        document.getElementById('preview-content').innerHTML = quill.root.innerHTML;
        document.getElementById('content-hidden').value = quill.root.innerHTML;
        
        // Insérer une variable
        function insertVariable(variable) {
            const range = quill.getSelection();
            if (range) {
                quill.insertText(range.index, variable);
            }
        }
        
        // Charger un template prédéfini
        const builtins = {
            'welcome': {
                name: '👋 Bienvenue',
                subject: 'Bienvenue chez ÉCOSYSTÈME IMMO LOCAL+',
                content: '<h2>Bonjour [PRENOM],</h2><p>Merci de votre intérêt pour notre plateforme.</p><p>Nous vous aiderons à transformer votre activité immobilière.</p>'
            },
            'followup': {
                name: '📞 Suivi',
                subject: 'Suivi de votre demande',
                content: '<h2>Bonjour [PRENOM],</h2><p>J\'aimerais connaître vos prochaines étapes.</p><p>Seriez-vous disponible pour un appel cette semaine ?</p>'
            },
            'demo': {
                name: '🎥 Accès Demo',
                subject: 'Voici votre accès à la démonstration',
                content: '<h2>Bonjour [PRENOM],</h2><p>Voici votre lien d\'accès à la démonstration personnalisée :</p><p><a href="[LIEN]">Cliquez ici pour accéder</a></p>'
            }
        };
        
        function loadBuiltinTemplate(id) {
            if (builtins[id]) {
                const tmpl = builtins[id];
                document.querySelector('input[name="template_name"]').value = tmpl.name;
                document.querySelector('input[name="template_subject"]').value = tmpl.subject;
                quill.root.innerHTML = tmpl.content;
                document.getElementById('preview-content').innerHTML = tmpl.content;
                document.getElementById('content-hidden').value = tmpl.content;
            }
            return false;
        }
        
        // Soumettre le form
        document.querySelector('form').addEventListener('submit', function(e) {
            document.getElementById('content-hidden').value = quill.root.innerHTML;
        });
    </script>
</body>
</html>