<?php
/**
 * GMB Module - Sidebar Navigation
 * Inclure dans toutes les pages GMB
 */
$currentPage = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$stats = $gmbStats ?? [];
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="/admin/crm" class="sidebar-logo">
            <span class="logo-icon">🏢</span>
            <span class="logo-text">ÉCOSYSTÈME IMMO LOCAL+</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">Google Business Profile</span>
            <a href="/admin/gmb/" class="nav-item <?= $currentPage === 'index' ? 'active' : '' ?>">
                <span class="nav-icon">📊</span>
                <span class="nav-label">Dashboard GMB</span>
            </a>
            <a href="/admin/gmb/listings" class="nav-item <?= $currentPage === 'listings' ? 'active' : '' ?>">
                <span class="nav-icon">📍</span>
                <span class="nav-label">Fiches GBP</span>
                <?php if (!empty($stats['total_listings'])): ?>
                    <span class="nav-badge"><?= $stats['total_listings'] ?></span>
                <?php endif; ?>
            </a>
            <a href="/admin/gmb/reviews" class="nav-item <?= $currentPage === 'reviews' ? 'active' : '' ?>">
                <span class="nav-icon">⭐</span>
                <span class="nav-label">Avis</span>
                <?php if (!empty($stats['pending_replies'])): ?>
                    <span class="nav-badge badge-offre"><?= $stats['pending_replies'] ?></span>
                <?php endif; ?>
            </a>
            <a href="/admin/gmb/posts" class="nav-item <?= $currentPage === 'posts' ? 'active' : '' ?>">
                <span class="nav-icon">📝</span>
                <span class="nav-label">Publications</span>
                <?php if (!empty($stats['scheduled_posts'])): ?>
                    <span class="nav-badge badge-ressource"><?= $stats['scheduled_posts'] ?></span>
                <?php endif; ?>
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Suivi & Analyse</span>
            <a href="/admin/gmb/positions" class="nav-item <?= $currentPage === 'positions' ? 'active' : '' ?>">
                <span class="nav-icon">🗺️</span>
                <span class="nav-label">Positions Maps</span>
            </a>
            <a href="/admin/gmb/citations" class="nav-item <?= $currentPage === 'citations' ? 'active' : '' ?>">
                <span class="nav-icon">🔗</span>
                <span class="nav-label">Citations NAP</span>
                <?php if (!empty($stats['nap_alerts'])): ?>
                    <span class="nav-badge" style="background:var(--danger);color:white"><?= $stats['nap_alerts'] ?></span>
                <?php endif; ?>
            </a>
            <a href="/admin/gmb/reports" class="nav-item <?= $currentPage === 'reports' ? 'active' : '' ?>">
                <span class="nav-icon">📄</span>
                <span class="nav-label">Rapports</span>
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Navigation</span>
            <a href="/admin/crm" class="nav-item">
                <span class="nav-icon">🏠</span>
                <span class="nav-label">Retour CRM</span>
            </a>
            <a href="/admin/crm/leads" class="nav-item">
                <span class="nav-icon">👥</span>
                <span class="nav-label">Leads</span>
            </a>
            <a href="/admin/emails" class="nav-item">
                <span class="nav-icon">📧</span>
                <span class="nav-label">Emails</span>
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <span class="user-email"><?= htmlspecialchars($_SESSION['admin_email'] ?? '') ?></span>
        </div>
        <a href="/admin/auth/logout" class="logout-btn">Déconnexion</a>
    </div>
</aside>
