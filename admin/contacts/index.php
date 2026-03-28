<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Gestion des Demandes de Contact
 * Page admin pour voir et gérer les demandes
 */

require_once __DIR__ . '/../../includes/ContactService.php';

// Vérifier authentification (tu dois ajouter cette vérif)
// if (!isset($_SESSION['admin'])) { header('Location: /admin/login'); exit; }

// Récupérer les contacts via ContactService
$contactService = new ContactService();
$result = $contactService->getContacts([], 1, 100);
$contacts = $result['contacts'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Contact - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-900: #111827;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .header {
            margin-bottom: 2rem;
        }
        
        .header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-card .label {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-top: 0.5rem;
        }
        
        .table-wrapper {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: var(--gray-100);
            border-bottom: 2px solid var(--gray-200);
        }
        
        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-900);
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }
        
        tbody tr:hover {
            background: var(--gray-50);
        }
        
        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-replied {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-other {
            background: var(--gray-100);
            color: var(--gray-600);
        }
        
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-small {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-view {
            background: var(--primary);
            color: white;
        }
        
        .btn-view:hover {
            opacity: 0.9;
        }
        
        .empty {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Demandes de Contact</h1>
            <p style="color: var(--gray-600);">Gérez toutes les demandes reçues du formulaire public</p>
        </div>
        
        <!-- STATS -->
        <div class="stats">
            <div class="stat-card">
                <div class="number"><?= count($contacts) ?></div>
                <div class="label">Demandes totales</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= count(array_filter($contacts, fn($c) => $c['status'] === 'pending')) ?></div>
                <div class="label">En attente</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= count(array_filter($contacts, fn($c) => $c['is_replied'])) ?></div>
                <div class="label">Répondues</div>
            </div>
        </div>
        
        <!-- TABLEAU -->
        <div class="table-wrapper">
            <?php if (empty($contacts)): ?>
                <div class="empty">
                    Aucune demande de contact pour le moment.
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Ville</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><strong><?= h($contact['nom']) ?></strong></td>
                            <td><?= h($contact['email']) ?></td>
                            <td><?= h($contact['telephone'] ?? '-') ?></td>
                            <td><?= h($contact['ville'] ?? '-') ?></td>
                            <td><?= h($contact['type_demande']) ?></td>
                            <td>
                                <?php if ($contact['is_replied']): ?>
                                    <span class="badge badge-replied">✓ Répondue</span>
                                <?php else: ?>
                                    <span class="badge badge-pending">⚠ En attente</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="?id=<?= $contact['id'] ?>" class="btn-small btn-view">Voir</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>