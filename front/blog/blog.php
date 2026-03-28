<?php
$currentPage = 'blog';
$pageTitle = 'Blog ÉCOSYSTÈME IMMO+ | Stratégies, Guides & Conseils Immobilier';
$pageDescription = 'Articles détaillés sur le SEO local, lead generation, automation marketing et stratégies digitales pour agents immobiliers.';
include '../../includes/header.php';

// Articles du blog
$articles = [
    [
        'slug' => 'seo-local',
        'title' => 'SEO Local : Dominer Google dans votre ville',
        'excerpt' => 'Guide complet du SEO local pour agents immobiliers. Optimisez votre présence Google avec GMB, citations locales et contenu ciblé.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => true
    ],
    [
        'slug' => '50-vendeurs',
        'title' => 'Comment attirer 50 vendeurs par mois sans portail immobilier',
        'excerpt' => 'Construisez votre propre machine à leads avec 4 leviers éprouvés. Lead magnets, email nurturing, SEO et réseaux sociaux.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 9,
        'featured' => true
    ],
    [
        'slug' => 'automation',
        'title' => 'Automation marketing immobilier : Gagner 10h/semaine',
        'excerpt' => 'Automatisez vos tâches répétitives et récupérez 10h/semaine. Email, SMS, réseaux sociaux : tout en pilote automatique.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => false
    ],
    [
        'slug' => 'crm-immobilier',
        'title' => 'CRM immobilier : Pourquoi les outils seuls ne suffisent pas',
        'excerpt' => 'Un CRM sans méthode = chaos. Découvrez comment structurer votre processus vendeurs pour convertir plus et mieux.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => false
    ],
    [
        'slug' => 'facebook-ads',
        'title' => 'Facebook & Instagram Ads pour agents : ROI garanti',
        'excerpt' => 'Les meilleurs agents dépensent 500€/mois en publicité ciblée. Voici exactement comment faire pour un ROI de 300%+.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => false
    ],
    [
        'slug' => '5-erreurs',
        'title' => 'Les 5 erreurs qui tuent votre présence en ligne',
        'excerpt' => 'Design mauvais, pas de mobile, contenu faible, SEO ignoré, analytics invisibles. Ces 5 erreurs coûtent des milliers en leads perdus.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 7,
        'featured' => false
    ],
    [
        'slug' => 'personas',
        'title' => 'Personas immobiliers : Parlez aux bons vendeurs',
        'excerpt' => 'Les séniors, les familles, les investisseurs n\'ont pas les mêmes besoins. Créez des personas pour parler à la bonne personne.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => false
    ],
    [
        'slug' => 'blog-immobilier',
        'title' => 'Blog immobilier : Stratégie complète pour dominer',
        'excerpt' => 'Créer un blog n\'est pas assez. C\'est la distribution, la structure et le calendrier éditorial qui font la différence.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 9,
        'featured' => false
    ],
    [
        'slug' => 'estimer-biens',
        'title' => 'Estimer les biens : La stratégie cachée des meilleurs agents',
        'excerpt' => 'L\'estimation n\'est pas un service. C\'est un lead magnet. Transformez chaque estimation en conversation de vente.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => false
    ],
    [
        'slug' => 'email-marketing',
        'title' => 'Email marketing immobilier : Templates & sequences gagnantes',
        'excerpt' => 'Les meilleurs agents envoient des emails sophistiqués. Découvrez les 5 sequences que vous devriez automatiser dès aujourd\'hui.',
        'date' => '16 Mars 2026',
        'author' => 'Olivier Colas',
        'readTime' => 8,
        'featured' => false
    ]
];
?>

<style>
.blog-hero {
    background: linear-gradient(135deg, #5B5EC7 0%, #8B5CF6 100%);
    padding: 80px 0 100px;
    color: white;
    text-align: center;
}

.blog-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    margin: 0 0 20px 0;
    line-height: 1.1;
}

.blog-hero p {
    font-size: 1.2rem;
    margin: 0;
    opacity: 0.95;
}

.blog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 80px 20px;
}

.blog-featured {
    margin-bottom: 80px;
}

.featured-article {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    background: white;
    padding: 50px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.featured-article:nth-child(odd) {
    direction: rtl;
}

.featured-article > * {
    direction: ltr;
}

.featured-badge {
    display: inline-block;
    padding: 6px 14px;
    background: #FEF3C7;
    color: #92400E;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 16px;
}

.featured-article h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #1a202c;
    margin: 0 0 16px 0;
    line-height: 1.2;
}

.featured-article p {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #718096;
    margin-bottom: 24px;
}

.article-meta {
    font-size: 0.9rem;
    color: #a0aec0;
    margin-bottom: 20px;
}

.read-more {
    display: inline-block;
    padding: 12px 28px;
    background: linear-gradient(135deg, #5B5EC7, #8B5CF6);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: opacity 0.2s;
}

.read-more:hover {
    opacity: 0.9;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}

.article-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.article-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}

.article-card-content {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.article-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 12px 0;
    line-height: 1.3;
}

.article-card p {
    color: #718096;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 20px 0;
    flex: 1;
}

.article-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 30px;
    border-top: 1px solid #e2e8f0;
    font-size: 0.85rem;
    color: #a0aec0;
}

.article-card-link {
    padding: 10px 20px;
    background: linear-gradient(135deg, #5B5EC7, #8B5CF6);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: opacity 0.2s;
}

.article-card-link:hover {
    opacity: 0.9;
}

.section-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1a202c;
    margin: 60px 0 40px 0;
    padding-bottom: 20px;
    border-bottom: 3px solid #5B5EC7;
}

@media (max-width: 768px) {
    .blog-hero h1 {
        font-size: 1.8rem;
    }

    .featured-article {
        grid-template-columns: 1fr;
        padding: 30px;
        gap: 20px;
    }

    .featured-article:nth-child(odd) {
        direction: ltr;
    }

    .featured-article h2 {
        font-size: 1.5rem;
    }

    .blog-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- HERO -->
<section class="blog-hero">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <h1>📚 Blog ÉCOSYSTÈME IMMO+</h1>
        <p>Stratégies, guides et conseils pour dominer votre marché immobilier local</p>
    </div>
</section>

<!-- ARTICLES EN VEDETTE -->
<section style="background: #f7fafc;">
    <div class="blog-container">
        <div class="blog-featured">
            <?php 
            $featured = array_filter($articles, fn($a) => $a['featured'] ?? false);
            foreach ($featured as $article): 
            ?>
                <article class="featured-article">
                    <div>
                        <span class="featured-badge">⭐ En vedette</span>
                        <h2><?php echo h($article['title']); ?></h2>
                        <div class="article-meta">
                            📅 <?php echo h($article['date']); ?> • ⏱️ <?php echo h($article['readTime']); ?> min
                        </div>
                        <p><?php echo h($article['excerpt']); ?></p>
                        <a href="/blog/<?php echo h($article['slug']); ?>" class="read-more">Lire l'article →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TOUS LES ARTICLES -->
<section style="background: white;">
    <div class="blog-container">
        <h2 class="section-title">📖 Tous les articles</h2>
        
        <div class="blog-grid">
            <?php 
            $otherArticles = array_filter($articles, fn($a) => !($a['featured'] ?? false));
            foreach ($otherArticles as $article): 
            ?>
                <article class="article-card">
                    <div class="article-card-content">
                        <h3><?php echo h($article['title']); ?></h3>
                        <p><?php echo h($article['excerpt']); ?></p>
                    </div>
                    <div class="article-card-footer">
                        <span>⏱️ <?php echo h($article['readTime']); ?> min</span>
                        <a href="/blog/<?php echo h($article['slug']); ?>" class="article-card-link">Lire →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>