<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Publications GBP
 * Création, programmation et gestion des posts
 */
$pageTitle = 'Publications GBP';
require_once __DIR__ . '/includes/header.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$filters = [
    'listing_id' => $_GET['listing_id'] ?? '',
    'status' => $_GET['status'] ?? '',
    'type' => $_GET['type'] ?? '',
];
$data = $gmb->getPosts($filters, $page);
$posts = $data['posts'];
$allListings = $gmb->getListings([], 1, 1000)['listings'];

$tab = $_GET['tab'] ?? 'all';

// Post type suggestions for real estate
$postSuggestions = [
    'mandat' => ['icon' => '🏠', 'title' => 'Nouveau mandat', 'desc' => 'Annoncez un nouveau bien en vente ou en location'],
    'vendu' => ['icon' => '✅', 'title' => 'Bien vendu / loué', 'desc' => 'Célébrez une vente ou location réussie'],
    'estimation' => ['icon' => '📊', 'title' => 'Estimation gratuite', 'desc' => 'Proposez une estimation gratuite dans le secteur'],
    'conseil_vendeur' => ['icon' => '💡', 'title' => 'Conseil vendeur', 'desc' => 'Partagez un conseil pour vendre rapidement'],
    'conseil_acheteur' => ['icon' => '🔑', 'title' => 'Conseil acheteur', 'desc' => 'Aidez les acheteurs avec un conseil pratique'],
    'marche' => ['icon' => '📈', 'title' => 'Tendance du marché', 'desc' => 'Partagez les chiffres du marché local'],
    'equipe' => ['icon' => '👥', 'title' => 'Vie de l\'agence', 'desc' => 'Montrez votre équipe et vos valeurs'],
    'evenement' => ['icon' => '🎉', 'title' => 'Événement / JPO', 'desc' => 'Annoncez une journée portes ouvertes'],
];
?>

<?php include __DIR__ . '/includes/sidebar.php'; ?>

<main class="main-content">
    <div class="content-header">
        <div>
            <h1 class="page-title">📝 Publications GBP</h1>
            <p class="page-subtitle"><?= $data['total'] ?> publication(s)</p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('postModal').classList.add('active')">+ Créer une publication</button>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <a href="?tab=all&<?= http_build_query(array_filter($filters)) ?>" class="tab <?= $tab === 'all' ? 'active' : '' ?>">Toutes</a>
        <a href="?tab=calendar&<?= http_build_query(array_filter($filters)) ?>" class="tab <?= $tab === 'calendar' ? 'active' : '' ?>">Calendrier</a>
        <a href="?tab=ideas&<?= http_build_query(array_filter($filters)) ?>" class="tab <?= $tab === 'ideas' ? 'active' : '' ?>">Idées de posts</a>
    </div>

    <?php if ($tab === 'ideas'): ?>
    <!-- Post Ideas -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:15px;">
        <?php foreach ($postSuggestions as $key => $sug): ?>
        <div class="card" style="cursor:pointer;" onclick="prefillPost('<?= $key ?>')">
            <div class="flex gap-10 mb-10">
                <span style="font-size:2rem;"><?= $sug['icon'] ?></span>
                <div>
                    <div class="fw-600"><?= $sug['title'] ?></div>
                    <div class="text-sm text-muted"><?= $sug['desc'] ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php elseif ($tab === 'calendar'): ?>
    <!-- Calendar View -->
    <div class="card">
        <div class="card-title">📅 Calendrier des publications</div>
        <?php
        $calendarPosts = [];
        foreach ($posts as $p) {
            $date = date('Y-m-d', strtotime($p['scheduled_at'] ?? $p['published_at'] ?? $p['created_at']));
            $calendarPosts[$date][] = $p;
        }
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        ?>
        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:1px;background:var(--gray-200);border-radius:var(--radius);overflow:hidden;">
            <?php
            $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            foreach ($days as $d): ?>
                <div style="background:var(--gray-50);padding:8px;text-align:center;font-size:0.8rem;font-weight:600;color:var(--gray-500);"><?= $d ?></div>
            <?php endforeach; ?>

            <?php for ($i = 0; $i < 28; $i++):
                $date = date('Y-m-d', strtotime($startOfWeek . " +{$i} days"));
                $isToday = $date === date('Y-m-d');
                $dayPosts = $calendarPosts[$date] ?? [];
            ?>
                <div style="background:white;padding:8px;min-height:80px;<?= $isToday ? 'border:2px solid var(--primary);' : '' ?>">
                    <div style="font-size:0.8rem;font-weight:<?= $isToday ? '700' : '500' ?>;color:<?= $isToday ? 'var(--primary)' : 'var(--gray-600)' ?>;margin-bottom:5px;">
                        <?= date('d', strtotime($date)) ?>
                    </div>
                    <?php foreach (array_slice($dayPosts, 0, 2) as $dp): ?>
                        <div style="font-size:0.7rem;padding:2px 5px;border-radius:3px;margin-bottom:2px;" class="post-type-<?= $dp['type'] ?>">
                            <?= mb_substr(htmlspecialchars($dp['title'] ?? $dp['content']), 0, 20) ?>...
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($dayPosts) > 2): ?>
                        <div class="text-sm text-muted">+<?= count($dayPosts) - 2 ?> autres</div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <?php else: ?>
    <!-- Filters -->
    <div class="filters-bar">
        <form class="filters-form" method="GET">
            <input type="hidden" name="tab" value="all">
            <div class="filter-group" style="min-width:160px;">
                <select name="listing_id" class="filter-select">
                    <option value="">Toutes les fiches</option>
                    <?php foreach ($allListings as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= $filters['listing_id'] == $l['id'] ? 'selected' : '' ?>><?= htmlspecialchars($l['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="type" class="filter-select">
                    <option value="">Type</option>
                    <option value="update" <?= $filters['type'] === 'update' ? 'selected' : '' ?>>Mise à jour</option>
                    <option value="offer" <?= $filters['type'] === 'offer' ? 'selected' : '' ?>>Offre</option>
                    <option value="event" <?= $filters['type'] === 'event' ? 'selected' : '' ?>>Événement</option>
                    <option value="product" <?= $filters['type'] === 'product' ? 'selected' : '' ?>>Produit</option>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="status" class="filter-select">
                    <option value="">Statut</option>
                    <option value="draft" <?= $filters['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                    <option value="scheduled" <?= $filters['status'] === 'scheduled' ? 'selected' : '' ?>>Programmé</option>
                    <option value="published" <?= $filters['status'] === 'published' ? 'selected' : '' ?>>Publié</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
        </form>
    </div>

    <!-- Posts List -->
    <?php if (empty($posts)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>Aucune publication</h3>
                <p>Créez votre première publication GBP pour engager votre audience.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="flex-between mb-10">
                <div class="flex gap-10 flex-center">
                    <span class="post-type-badge post-type-<?= $post['type'] ?>">
                        <?= ['update'=>'Mise à jour','offer'=>'Offre','event'=>'Événement','product'=>'Produit'][$post['type']] ?? $post['type'] ?>
                    </span>
                    <span class="post-status-badge status-<?= $post['status'] ?>">
                        <?= ['draft'=>'Brouillon','scheduled'=>'Programmé','published'=>'Publié','expired'=>'Expiré','failed'=>'Échoué'][$post['status']] ?? $post['status'] ?>
                    </span>
                    <span class="text-sm text-muted"><?= htmlspecialchars($post['listing_name'] ?? '') ?> — <?= htmlspecialchars($post['listing_city'] ?? '') ?></span>
                </div>
                <div class="action-buttons">
                    <button class="action-btn" onclick="editPost(<?= $post['id'] ?>)" title="Modifier">✏️</button>
                    <button class="action-btn action-delete" onclick="deletePost(<?= $post['id'] ?>)" title="Supprimer">🗑️</button>
                </div>
            </div>

            <?php if (!empty($post['title'])): ?>
                <h3 style="font-size:1.05rem;font-weight:600;margin-bottom:5px;"><?= htmlspecialchars($post['title']) ?></h3>
            <?php endif; ?>

            <p class="text-sm" style="color:var(--gray-600);line-height:1.6;"><?= nl2br(htmlspecialchars(mb_substr($post['content'], 0, 300))) ?><?= mb_strlen($post['content']) > 300 ? '...' : '' ?></p>

            <?php if ($post['cta_type'] !== 'none' && !empty($post['cta_url'])): ?>
                <div class="mt-20">
                    <span class="btn btn-outline btn-sm"><?= ['book'=>'Réserver','order'=>'Commander','shop'=>'Acheter','learn_more'=>'En savoir plus','sign_up'=>'S\'inscrire','call'=>'Appeler'][$post['cta_type']] ?? $post['cta_type'] ?></span>
                </div>
            <?php endif; ?>

            <div class="flex-between mt-20" style="padding-top:10px;border-top:1px solid var(--gray-100);">
                <div class="text-sm text-muted">
                    <?php if ($post['scheduled_at']): ?>
                        📅 Programmé : <?= date('d/m/Y H:i', strtotime($post['scheduled_at'])) ?>
                    <?php elseif ($post['published_at']): ?>
                        ✅ Publié : <?= date('d/m/Y H:i', strtotime($post['published_at'])) ?>
                    <?php else: ?>
                        Créé : <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
                    <?php endif; ?>
                </div>
                <?php if ($post['views'] > 0 || $post['clicks'] > 0): ?>
                <div class="text-sm">
                    👁️ <?= $post['views'] ?> vues · 👆 <?= $post['clicks'] ?> clics
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if ($data['totalPages'] > 1): ?>
        <div style="display:flex;justify-content:center;gap:5px;padding:20px 0;">
            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                <a href="?tab=all&page=<?= $i ?>&<?= http_build_query(array_filter($filters)) ?>" class="btn <?= $i === $page ? 'btn-primary' : 'btn-outline' ?> btn-sm"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
</main>

<!-- Create Post Modal -->
<div class="modal-overlay" id="postModal">
    <div class="modal-content" style="max-width:700px;">
        <button class="modal-close" onclick="this.closest('.modal-overlay').classList.remove('active')">×</button>
        <h2 style="margin-bottom:20px;">📝 Nouvelle publication</h2>
        <form id="postForm">
            <div class="form-row">
                <div class="form-group">
                    <label>Fiche GBP *</label>
                    <select name="listing_id" class="form-control" required>
                        <option value="">Sélectionner...</option>
                        <?php foreach ($allListings as $l): ?>
                            <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['name']) ?> — <?= htmlspecialchars($l['city']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="update">Mise à jour</option>
                        <option value="offer">Offre</option>
                        <option value="event">Événement</option>
                        <option value="product">Produit</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Titre</label>
                <input type="text" name="title" class="form-control" id="postTitle" placeholder="Titre de la publication">
            </div>
            <div class="form-group">
                <label>Contenu *</label>
                <textarea name="content" class="form-control" rows="5" required id="postContent" placeholder="Rédigez votre publication..."></textarea>
                <div class="text-sm text-muted mt-20">Conseil: 150-300 mots, incluez des mots-clés locaux</div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Appel à l'action</label>
                    <select name="cta_type" class="form-control">
                        <option value="none">Aucun</option>
                        <option value="learn_more">En savoir plus</option>
                        <option value="book">Réserver</option>
                        <option value="call">Appeler</option>
                        <option value="sign_up">S'inscrire</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>URL du CTA</label>
                    <input type="url" name="cta_url" class="form-control" placeholder="https://...">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Statut</label>
                    <select name="status" class="form-control">
                        <option value="draft">Brouillon</option>
                        <option value="scheduled">Programmer</option>
                        <option value="published">Publier maintenant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date de programmation</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>URL de l'image</label>
                <input type="url" name="media_url" class="form-control" placeholder="https://...">
            </div>
            <div class="flex gap-10" style="justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('postModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer la publication</button>
            </div>
        </form>
    </div>
</div>

<script>
const postTemplates = {
    mandat: { title: 'Nouveau bien en vente', content: '🏠 Nouveau mandat exclusif !\n\nDécouvrez ce magnifique bien situé à [VILLE]. [DESCRIPTION DU BIEN]\n\n📍 Secteur : [QUARTIER]\n💰 Prix : [PRIX]€\n\nContactez-nous pour une visite privée !' },
    vendu: { title: 'Bien vendu !', content: '✅ Encore une vente réussie !\n\nFélicitations aux nouveaux propriétaires de ce [TYPE DE BIEN] à [VILLE] !\n\nMerci pour votre confiance. Vous aussi, confiez-nous votre projet immobilier.' },
    estimation: { title: 'Estimation gratuite de votre bien', content: '📊 Vous souhaitez connaître la valeur de votre bien ?\n\nNous vous offrons une estimation gratuite et sans engagement.\n\n✅ Connaissance du marché local\n✅ Analyse comparative récente\n✅ Résultat sous 48h\n\nContactez-nous dès maintenant !' },
    conseil_vendeur: { title: 'Conseil vendeur du mois', content: '💡 Conseil pour bien vendre :\n\n[VOTRE CONSEIL]\n\nBesoin d\'un accompagnement personnalisé ? Nous sommes là pour vous guider à chaque étape.' },
    conseil_acheteur: { title: 'Conseil acheteur', content: '🔑 Conseil pour les acheteurs :\n\n[VOTRE CONSEIL]\n\nVous cherchez le bien idéal ? Contactez-nous pour bénéficier de notre expertise locale.' },
    marche: { title: 'Tendances du marché immobilier', content: '📈 Le marché immobilier à [VILLE] en [MOIS] [ANNÉE]\n\n• Prix moyen au m² : [PRIX]€\n• Évolution : [+/-X]% sur 12 mois\n• Délai moyen de vente : [X] jours\n\nVous souhaitez en savoir plus sur votre quartier ? Contactez-nous !' },
    equipe: { title: 'Notre équipe', content: '👥 Découvrez notre équipe !\n\n[PRÉSENTATION]\n\nChaque jour, nous mettons notre expertise au service de vos projets immobiliers. 🏠' },
    evenement: { title: 'Journée portes ouvertes', content: '🎉 Journée portes ouvertes !\n\n📅 [DATE]\n📍 [ADRESSE]\n⏰ [HORAIRES]\n\nVenez découvrir ce [TYPE DE BIEN] exceptionnel. Entrée libre, sans rendez-vous !' },
};

function prefillPost(type) {
    const tpl = postTemplates[type];
    if (tpl) {
        document.getElementById('postTitle').value = tpl.title;
        document.getElementById('postContent').value = tpl.content;
        document.getElementById('postModal').classList.add('active');
    }
}

document.getElementById('postForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {};
    formData.forEach((v, k) => { if(v) data[k] = v; });
    if (data.status === 'published') data.published_at = new Date().toISOString().slice(0, 19).replace('T', ' ');

    fetch('/api/gmb/api.php?action=create_post', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) location.reload();
        else alert(result.data?.error || 'Erreur');
    })
    .catch(() => alert('Erreur réseau'));
});

function deletePost(id) {
    if (!confirm('Supprimer cette publication ?')) return;
    fetch('/api/gmb/api.php?action=delete_post', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ post_id: id })
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) location.reload();
        else alert('Erreur');
    });
}

function editPost(id) {
    alert('Fonctionnalité de modification en cours de développement.');
}
</script>
</div>
</body>
</html>
