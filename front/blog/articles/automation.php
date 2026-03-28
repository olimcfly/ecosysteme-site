<?php
// ========================================
// TEMPLATE ARTICLE BLOG
// ========================================
// 
// COMMENT UTILISER:
// 1. Copie ce fichier et renomme-le (ex: automation.php)
// 2. Remplace %TITLE%, %DESC%, et %CONTENT% par ton contenu
// 3. Le style et la structure sont automatiques
// 
// ========================================

$currentPage = 'blog';
$pageTitle = '%TITLE% | Blog ÉCOSYSTÈME IMMO+';
$pageDescription = '%DESC%';
include '../../../includes/header.php';
?>

<style>
.article-hero {
    background: linear-gradient(135deg, #5B5EC7 0%, #8B5CF6 100%);
    padding: 60px 0 40px;
    color: white;
    text-align: center;
}
.article-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 16px 0;
}
.article-meta {
    font-size: 0.9rem;
    opacity: 0.9;
}
.article-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 60px 20px;
}
.article-content {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #333;
}
.article-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1a202c;
    margin: 40px 0 20px 0;
}
.article-content h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #5B5EC7;
    margin: 30px 0 15px 0;
}
.article-content p {
    margin-bottom: 20px;
}
.article-content ul {
    margin: 20px 0;
    padding-left: 30px;
}
.article-content li {
    margin-bottom: 12px;
}
.article-cta {
    background: #f7fafc;
    border-left: 4px solid #5B5EC7;
    padding: 30px;
    border-radius: 12px;
    margin: 50px 0;
}
.article-cta h3 {
    margin-top: 0;
}
.btn-primary {
    display: inline-block;
    padding: 12px 28px;
    background: linear-gradient(135deg, #5B5EC7, #8B5CF6);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: opacity 0.2s;
}
.btn-primary:hover {
    opacity: 0.9;
}
</style>

<section class="article-hero">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <h1>%TITLE%</h1>
        <div class="article-meta">
            📅 16 Mars 2026 • ⏱️ 8 min de lecture • 👤 Olivier Colas
        </div>
    </div>
</section>

<article class="article-container">
    <div class="article-content">
        <!-- 
        ========================================
        CONTENU DE L'ARTICLE (800-1200 mots)
        ========================================
        
        Structure recommandée:
        - 1 intro (2-3 paragraphes) 
        - 3-4 sections H2
        - Chaque section: 1-2 sous-sections H3 + détails
        - Conclusion
        
        Remplace %CONTENT% par le contenu complet
        -->
        %CONTENT%

        <div class="article-cta">
            <h3>🚀 Prêt à transformer votre immobilier ?</h3>
            <p>
                L'ÉCOSYSTÈME IMMO+ automatise tout : lead magnets, email nurturing, 
                et analytics. Découvrez comment les meilleurs agents dominent leur marché.
            </p>
            <a href="/demo" class="btn-primary">Voir la démo →</a>
        </div>

        <h2>En résumé</h2>
        <p>
            Complète cette partie avec un résumé de 2-3 paragraphes 
            récapitulant les points clés de l'article.
        </p>
    </div>
</article>

<?php include '../../../includes/footer.php'; ?>

<!-- 
========================================
EXEMPLES DE CONTENU À AJOUTER

Pour "Automation marketing immobilier":

<p>
    10 heures par semaine : c'est le temps que les meilleurs agents 
    économisent en automatisant leurs tâches répétitives. Email, SMS, 
    réseaux sociaux — tout fonctionne sans intervention manuelle.
</p>

<p>
    Mais l'automation n'est pas juste pour gagner du temps. C'est surtout 
    pour <strong>faire les choses à la bonne heure, au bon moment.</strong>
</p>

<h2>Les 5 tâches à automatiser en priorité</h2>

<h3>1. Email de bienvenue (lead magnet)</h3>
<ul>
    <li>Déclenché automatiquement après opt-in</li>
    <li>Envoie le fichier PDF/estimateur</li>
    <li>Lance la sequence de nurturing</li>
</ul>

...etc

========================================
-->