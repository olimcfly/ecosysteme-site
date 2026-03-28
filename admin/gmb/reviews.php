<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Gestion des avis GBP
 */
$pageTitle = 'Avis GBP';
require_once __DIR__ . '/includes/header.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$filters = [
    'listing_id' => $_GET['listing_id'] ?? '',
    'rating' => $_GET['rating'] ?? '',
    'has_reply' => $_GET['has_reply'] ?? '',
    'postal_code' => $_GET['postal_code'] ?? '',
    'agent_name' => $_GET['agent_name'] ?? '',
];
$data = $gmb->getReviews($filters, $page);
$reviews = $data['reviews'];
$reviewStats = $gmb->getReviewStats((int)($filters['listing_id'] ?? 0));
$templates = $gmb->getReplyTemplates();

$allListings = $gmb->getListings([], 1, 1000)['listings'];
$allPostalCodes = $gmb->getAllPostalCodes();
$allAgents = $gmb->getAllAgents();
?>

<?php include __DIR__ . '/includes/sidebar.php'; ?>

<main class="main-content">
    <div class="content-header">
        <div>
            <h1 class="page-title">⭐ Gestion des avis</h1>
            <p class="page-subtitle"><?= $data['total'] ?> avis au total</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="dashboard-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:20px;">
        <div class="stat-card" style="padding:15px;">
            <div class="stat-content" style="width:100%;text-align:center;">
                <div class="stat-value" style="font-size:1.5rem;"><?= number_format((float)($reviewStats['avg_rating'] ?? 0), 1) ?> ★</div>
                <div class="stat-label">Note moyenne</div>
            </div>
        </div>
        <?php for ($s = 5; $s >= 2; $s--): ?>
        <div class="stat-card" style="padding:15px;">
            <div class="stat-content" style="width:100%;text-align:center;">
                <div class="stat-value" style="font-size:1.5rem;"><?= (int)($reviewStats["stars_{$s}"] ?? 0) ?></div>
                <div class="stat-label"><?= $s ?> étoile<?= $s > 1 ? 's' : '' ?></div>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <!-- Filters -->
    <div class="filters-bar">
        <form class="filters-form" method="GET">
            <div class="filter-group" style="min-width:160px;">
                <select name="listing_id" class="filter-select">
                    <option value="">Toutes les fiches</option>
                    <?php foreach ($allListings as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= $filters['listing_id'] == $l['id'] ? 'selected' : '' ?>><?= htmlspecialchars($l['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="rating" class="filter-select">
                    <option value="">Toutes notes</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= $filters['rating'] == $i ? 'selected' : '' ?>><?= $i ?> étoile<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="has_reply" class="filter-select">
                    <option value="">Réponse</option>
                    <option value="no" <?= $filters['has_reply'] === 'no' ? 'selected' : '' ?>>Sans réponse</option>
                    <option value="yes" <?= $filters['has_reply'] === 'yes' ? 'selected' : '' ?>>Avec réponse</option>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="postal_code" class="filter-select">
                    <option value="">Code postal</option>
                    <?php foreach ($allPostalCodes as $cp): ?>
                        <option value="<?= htmlspecialchars($cp) ?>" <?= $filters['postal_code'] === $cp ? 'selected' : '' ?>><?= htmlspecialchars($cp) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="agent_name" class="filter-select">
                    <option value="">Conseiller</option>
                    <?php foreach ($allAgents as $agent): ?>
                        <option value="<?= htmlspecialchars($agent) ?>" <?= $filters['agent_name'] === $agent ? 'selected' : '' ?>><?= htmlspecialchars($agent) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="/admin/gmb/reviews" class="btn btn-ghost btn-sm">Reset</a>
        </form>
    </div>

    <!-- Reviews List -->
    <?php if (empty($reviews)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-icon">⭐</div>
                <h3>Aucun avis</h3>
                <p>Les avis de vos fiches GBP apparaîtront ici.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($reviews as $review): ?>
        <div class="review-card rating-<?= $review['rating'] ?>" id="review-<?= $review['id'] ?>">
            <div class="review-header">
                <div class="review-avatar"><?= strtoupper(mb_substr($review['reviewer_name'], 0, 1)) ?></div>
                <div class="review-meta">
                    <div class="review-name"><?= htmlspecialchars($review['reviewer_name']) ?></div>
                    <div class="review-date">
                        <span class="stars"><?= str_repeat('★', $review['rating']) ?></span><span class="stars-gray"><?= str_repeat('★', 5 - $review['rating']) ?></span>
                        &nbsp;·&nbsp;<?= date('d/m/Y', strtotime($review['review_date'])) ?>
                        &nbsp;·&nbsp;<span class="text-muted"><?= htmlspecialchars($review['listing_name'] ?? '') ?> (<?= htmlspecialchars($review['listing_city'] ?? '') ?>)</span>
                    </div>
                </div>
                <?php if (!empty($review['agent_name'])): ?>
                    <span class="lead-type-badge type-ressource"><?= htmlspecialchars($review['agent_name']) ?></span>
                <?php endif; ?>
            </div>

            <?php if (!empty($review['comment'])): ?>
                <div class="review-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></div>
            <?php endif; ?>

            <?php if (!empty($review['reply'])): ?>
                <div class="review-reply">
                    <div class="review-reply-label">Réponse du propriétaire — <?= $review['reply_date'] ? date('d/m/Y', strtotime($review['reply_date'])) : '' ?></div>
                    <p class="text-sm"><?= nl2br(htmlspecialchars($review['reply'])) ?></p>
                </div>
            <?php else: ?>
                <div class="mt-20" id="reply-form-<?= $review['id'] ?>">
                    <div class="flex gap-10 mb-10" style="flex-wrap:wrap;">
                        <?php
                        $matchingTemplates = array_filter($templates, function($t) use ($review) {
                            return $t['rating_target'] === null || (int)$t['rating_target'] === (int)$review['rating'];
                        });
                        foreach (array_slice($matchingTemplates, 0, 3) as $tpl):
                        ?>
                            <button class="btn btn-outline btn-sm" onclick="useTemplate(<?= $review['id'] ?>, '<?= addslashes(str_replace(["\r","\n"], ' ', $tpl['template_text'])) ?>', '<?= htmlspecialchars($review['reviewer_name']) ?>')">
                                <?= htmlspecialchars($tpl['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <textarea id="reply-text-<?= $review['id'] ?>" class="form-control" rows="3" placeholder="Écrire votre réponse..."></textarea>
                    <div class="flex gap-10 mt-20" style="justify-content:flex-end;">
                        <button class="btn btn-outline btn-sm" onclick="generateAIReply(<?= $review['id'] ?>, <?= $review['rating'] ?>, '<?= addslashes($review['reviewer_name']) ?>', '<?= addslashes(mb_substr($review['comment'] ?? '', 0, 200)) ?>')">
                            🤖 Suggestion IA
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="submitReply(<?= $review['id'] ?>)">Répondre</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <?php if ($data['totalPages'] > 1): ?>
        <div style="display:flex;justify-content:center;gap:5px;padding:20px 0;">
            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                <a href="?page=<?= $i ?>&<?= http_build_query(array_filter($filters)) ?>" class="btn <?= $i === $page ? 'btn-primary' : 'btn-outline' ?> btn-sm"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</main>

<script>
function useTemplate(reviewId, template, reviewerName) {
    const text = template.replace(/{reviewer_name}/g, reviewerName).replace(/{phone}/g, '');
    document.getElementById('reply-text-' + reviewId).value = text;
}

function generateAIReply(reviewId, rating, name, comment) {
    const textarea = document.getElementById('reply-text-' + reviewId);
    textarea.value = 'Génération en cours...';
    textarea.disabled = true;

    // Simple AI-like response based on rating
    setTimeout(() => {
        let reply = '';
        if (rating >= 4) {
            reply = `Merci beaucoup ${name} pour votre avis ! Nous sommes ravis que notre service vous ait satisfait. Votre confiance est notre meilleure récompense. Au plaisir de collaborer à nouveau !`;
        } else if (rating === 3) {
            reply = `Merci ${name} pour votre retour. Nous prenons note de vos remarques et nous nous efforçons d'améliorer constamment nos services. N'hésitez pas à nous contacter pour en discuter.`;
        } else {
            reply = `${name}, nous regrettons sincèrement que votre expérience n'ait pas été à la hauteur. Nous aimerions comprendre ce qui s'est passé et trouver une solution. Pourriez-vous nous contacter directement ?`;
        }
        textarea.value = reply;
        textarea.disabled = false;
    }, 500);
}

function submitReply(reviewId) {
    const text = document.getElementById('reply-text-' + reviewId).value.trim();
    if (!text) { alert('Veuillez écrire une réponse.'); return; }

    fetch('/api/gmb/api.php?action=reply_review', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ review_id: reviewId, reply: text })
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) location.reload();
        else alert(result.data?.error || 'Erreur');
    })
    .catch(() => alert('Erreur réseau'));
}
</script>
</div>
</body>
</html>
