<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Navigation CRM partagée
 *
 * Variable attendue : $activePage (ex: 'dashboard', 'leads', 'pipeline', etc.)
 */
$activePage = $activePage ?? '';

$pageMeta = [
    'dashboard' => ['title' => 'Accueil', 'icon' => '🏠'],
    'leads' => ['title' => 'Leads', 'icon' => '👥'],
    'pipeline' => ['title' => 'Pipeline', 'icon' => '📋'],
    'contacts' => ['title' => 'Contacts', 'icon' => '🤝'],
    'calls' => ['title' => 'Appels', 'icon' => '📞'],
    'tasks' => ['title' => 'Taches', 'icon' => '✅'],
    'blog' => ['title' => 'Blog', 'icon' => '📝'],
    'seo' => ['title' => 'SEO Hub', 'icon' => '🔍'],
    'images-ia' => ['title' => 'Images IA', 'icon' => '🎨'],
    'offers' => ['title' => 'Offres', 'icon' => '🎁'],
    'tunnels' => ['title' => 'Tunnels', 'icon' => '🔄'],
    'invoices' => ['title' => 'Factures', 'icon' => '🧾'],
    'automation' => ['title' => 'Automation', 'icon' => '⚡'],
    'analytics' => ['title' => 'Analytics', 'icon' => '📈'],
    'editor' => ['title' => 'Email', 'icon' => '📧'],
    'settings' => ['title' => 'Parametres', 'icon' => '⚙️'],
];

$currentTitle = $pageMeta[$activePage]['title'] ?? 'Administration';
$showBack = $activePage !== 'dashboard';
?>
<style>
    .app-shell {
        min-height: 100vh;
        background: var(--gray-50, #f9fafb);
        display: block;
    }

    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 58px;
        background: #ffffff;
        border-bottom: 1px solid var(--gray-200, #e5e7eb);
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 0 0.85rem;
        z-index: 220;
    }

    .topbar-left,
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .topbar-right {
        justify-content: flex-end;
    }

    .topbar-title {
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--gray-900, #111827);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0 0.75rem;
    }

    .topbar-btn,
    .topbar-logo {
        min-width: 2rem;
        height: 2rem;
        border-radius: 0.6rem;
        border: 1px solid var(--gray-200, #e5e7eb);
        background: #ffffff;
        color: var(--gray-800, #1f2937);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 600;
        padding: 0 0.55rem;
    }

    .topbar-logo {
        width: auto;
        font-size: 0.78rem;
        letter-spacing: 0.2px;
    }

    .bottom-nav {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0;
        padding: 0.4rem 0.45rem calc(0.45rem + env(safe-area-inset-bottom));
        background: #ffffff;
        border-top: 1px solid var(--gray-200, #e5e7eb);
        z-index: 220;
    }

    .bottom-nav-item {
        min-height: 3.1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: var(--gray-500, #6b7280);
        border-radius: 0.75rem;
        font-size: 0.72rem;
        font-weight: 600;
        line-height: 1.2;
        gap: 0.2rem;
    }

    .bottom-nav-item .icon {
        font-size: 1rem;
    }

    .bottom-nav-item.active {
        background: rgba(192, 57, 43, 0.12);
        color: #c0392b;
    }

    .app-content {
        min-height: 100vh;
        padding: calc(58px + 1rem) 1rem calc(88px + env(safe-area-inset-bottom));
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .topbar {
            height: 62px;
            padding: 0 1rem;
        }

        .topbar-title {
            font-size: 1rem;
        }

        .bottom-nav {
            max-width: 720px;
            left: 50%;
            transform: translateX(-50%);
            border: 1px solid var(--gray-200, #e5e7eb);
            border-bottom: none;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            box-shadow: 0 -6px 18px rgba(17,24,39,0.08);
        }

        .app-content {
            padding: calc(62px + 1.25rem) 1.25rem calc(94px + env(safe-area-inset-bottom));
        }
    }

    .sidebar {
        display: none;
    }

    @media (min-width: 992px) {
        .app-shell {
            display: flex;
        }

        .topbar,
        .bottom-nav {
            display: none;
        }

        .sidebar {
            width: 240px;
            background: #1e1e2d;
            color: #c5c5d2;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            display: flex;
            flex-direction: column;
            font-size: 0.88rem;
        }

        .app-content {
            margin-left: 240px;
            flex: 1;
            padding: 2rem;
            min-height: 100vh;
        }
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 1.25rem;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .sidebar-brand-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        background: #c0392b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
    }

    .sidebar-brand-text {
        font-weight: 700;
        color: #fff;
        font-size: 0.9rem;
        line-height: 1.2;
    }

    .sidebar-brand-sub {
        font-size: 0.65rem;
        color: #7b7b8e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-menu {
        flex: 1;
        padding: 0.75rem 0;
        overflow-y: auto;
    }

    .sidebar-section {
        margin-bottom: 0.5rem;
    }

    .sidebar-section-title {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #5a5a6e;
        padding: 0.75rem 1.25rem 0.4rem;
        letter-spacing: 0.8px;
    }

    .sidebar-item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.55rem 1.25rem;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        color: #a0a0b5;
        font-size: 0.85rem;
        border-left: 3px solid transparent;
    }

    .sidebar-item:hover {
        background: rgba(255,255,255,0.04);
        color: #e0e0e8;
    }

    .sidebar-item.active {
        background: rgba(192,57,43,0.15);
        color: #e74c3c;
        border-left-color: #e74c3c;
        font-weight: 600;
    }

    .sidebar-item .icon {
        width: 1.25rem;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .sidebar-item .badge {
        margin-left: auto;
        background: rgba(255,255,255,0.08);
        padding: 0.15rem 0.45rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #8a8a9e;
    }

    .sidebar-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid rgba(255,255,255,0.06);
        margin-top: auto;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.75rem;
    }

    .sidebar-user-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: #c0392b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        color: white;
        flex-shrink: 0;
    }

    .sidebar-user-info {
        flex: 1;
        min-width: 0;
    }

    .sidebar-user-name {
        font-weight: 600;
        display: block;
        color: #e0e0e8;
        font-size: 0.82rem;
    }

    .sidebar-user-role {
        font-size: 0.65rem;
        color: #c0392b;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .sidebar-user-email {
        color: #5a5a6e;
        font-size: 0.7rem;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sidebar-logout {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b6b80;
        text-decoration: none;
        font-size: 0.82rem;
        padding: 0.4rem 0;
        transition: color 0.15s;
    }

    .sidebar-logout:hover {
        color: #e74c3c;
    }
</style>

<header class="topbar">
    <div class="topbar-left">
        <?php if ($showBack): ?>
            <button type="button" class="topbar-btn" onclick="history.back()" aria-label="Retour">←</button>
        <?php else: ?>
            <a href="/admin/crm/index.php" class="topbar-logo" aria-label="Accueil admin">ECO+</a>
        <?php endif; ?>
    </div>

    <div class="topbar-title"><?= h($currentTitle) ?></div>

    <div class="topbar-right">
        <a href="/admin/emails/index.php" class="topbar-btn" aria-label="Notifications">🔔</a>
        <a href="/admin/crm/leads.php" class="topbar-btn" aria-label="Ajouter un element">＋</a>
    </div>
</header>

<nav class="bottom-nav" aria-label="Navigation principale mobile">
    <a href="/admin/crm/index.php" class="bottom-nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
        <span class="icon">🏠</span>
        <span>Accueil</span>
    </a>
    <a href="/admin/crm/contacts.php" class="bottom-nav-item <?= $activePage === 'contacts' ? 'active' : '' ?>">
        <span class="icon">👥</span>
        <span>Contacts</span>
    </a>
    <a href="/admin/crm/pipeline.php" class="bottom-nav-item <?= $activePage === 'pipeline' ? 'active' : '' ?>">
        <span class="icon">📋</span>
        <span>Pipeline</span>
    </a>
    <a href="/admin/crm/settings.php" class="bottom-nav-item <?= in_array($activePage, ['settings', 'offers', 'tunnels', 'invoices', 'blog', 'seo', 'images-ia', 'editor', 'tasks', 'calls', 'automation', 'analytics', 'leads'], true) && !in_array($activePage, ['contacts', 'pipeline'], true) ? 'active' : '' ?>">
        <span class="icon">☰</span>
        <span>Plus</span>
    </a>
</nav>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">🏠</div>
        <div>
            <div class="sidebar-brand-text"><?= SITE_NAME ?? 'Ecosysteme Immo Local+' ?></div>
            <div class="sidebar-brand-sub">Administration</div>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Principal</div>
            <a href="/admin/crm/index.php" class="sidebar-item <?= $activePage === 'dashboard' ? 'active' : '' ?>"><span class="icon">📊</span> Tableau de bord</a>
            <a href="/admin/crm/leads.php" class="sidebar-item <?= $activePage === 'leads' ? 'active' : '' ?>"><span class="icon">👥</span> Leads</a>
            <a href="/admin/crm/pipeline.php" class="sidebar-item <?= $activePage === 'pipeline' ? 'active' : '' ?>"><span class="icon">📋</span> Pipeline</a>
            <a href="/admin/crm/contacts.php" class="sidebar-item <?= $activePage === 'contacts' ? 'active' : '' ?>"><span class="icon">🤝</span> Partenaires</a>
            <a href="/admin/crm/calls.php" class="sidebar-item <?= $activePage === 'calls' ? 'active' : '' ?>"><span class="icon">📞</span> Appels</a>
            <a href="/admin/crm/tasks.php" class="sidebar-item <?= $activePage === 'tasks' ? 'active' : '' ?>"><span class="icon">✅</span> Taches</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Contenu & SEO</div>
            <a href="/admin/crm/blog.php" class="sidebar-item <?= $activePage === 'blog' ? 'active' : '' ?>"><span class="icon">📝</span> Articles Blog</a>
            <a href="/admin/crm/seo.php" class="sidebar-item <?= $activePage === 'seo' ? 'active' : '' ?>"><span class="icon">🔍</span> SEO Hub</a>
            <a href="/admin/crm/images-ia.php" class="sidebar-item <?= $activePage === 'images-ia' ? 'active' : '' ?>"><span class="icon">🎨</span> Images IA</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Ventes</div>
            <a href="/admin/crm/offers.php" class="sidebar-item <?= $activePage === 'offers' ? 'active' : '' ?>"><span class="icon">🎁</span> Offres</a>
            <a href="/admin/crm/tunnels.php" class="sidebar-item <?= $activePage === 'tunnels' ? 'active' : '' ?>"><span class="icon">🔄</span> Tunnels</a>
            <a href="/admin/crm/invoices.php" class="sidebar-item <?= $activePage === 'invoices' ? 'active' : '' ?>"><span class="icon">🧾</span> Factures</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Marketing</div>
            <a href="/admin/crm/automation.php" class="sidebar-item <?= $activePage === 'automation' ? 'active' : '' ?>"><span class="icon">⚡</span> Automation</a>
            <a href="/admin/crm/analytics.php" class="sidebar-item <?= $activePage === 'analytics' ? 'active' : '' ?>"><span class="icon">📈</span> Analytics</a>
            <a href="/admin/crm/editor.php" class="sidebar-item <?= $activePage === 'editor' ? 'active' : '' ?>"><span class="icon">📧</span> Email Marketing</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Systeme</div>
            <a href="/admin/crm/settings.php" class="sidebar-item <?= $activePage === 'settings' ? 'active' : '' ?>"><span class="icon">⚙️</span> Parametres</a>
            <a href="/" class="sidebar-item" target="_blank"><span class="icon">🌐</span> Voir le site</a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar"><?= strtoupper(substr($_SESSION['admin_firstname'] ?? 'A', 0, 1)) ?></div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?= h($_SESSION['admin_firstname'] ?? 'Admin') ?></span>
                <span class="sidebar-user-role">Administrateur</span>
                <span class="sidebar-user-email"><?= h($_SESSION['admin_email'] ?? '') ?></span>
            </div>
        </div>
        <a href="/admin/logout" class="sidebar-logout"><span>🚪</span> Deconnexion</a>
    </div>
</aside>
