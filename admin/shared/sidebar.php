<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Sidebar CRM partagée
 * Style sombre inspiré du design "Estimation Angers"
 *
 * Variable attendue : $activePage (ex: 'dashboard', 'leads', 'pipeline', etc.)
 */
$activePage = $activePage ?? '';
?>
<style>
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

    .sidebar-sub-item {
        padding-left: 3.2rem;
        font-size: 0.82rem;
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

    .main {
        margin-left: 240px;
        flex: 1;
        padding: 2rem;
        min-height: 100vh;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
        .sidebar-menu { max-height: 50vh; }
        .main { margin-left: 0; }
    }
</style>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">🏠</div>
        <div>
            <div class="sidebar-brand-text"><?= SITE_NAME ?? 'Ecosysteme Immo' ?></div>
            <div class="sidebar-brand-sub">Administration</div>
        </div>
    </div>

    <nav class="sidebar-menu">
        <!-- PRINCIPAL -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Principal</div>
            <a href="/admin/crm/index.php" class="sidebar-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
                <span class="icon">📊</span> Tableau de bord
            </a>
            <a href="/admin/crm/leads.php" class="sidebar-item <?= $activePage === 'leads' ? 'active' : '' ?>">
                <span class="icon">👥</span> Leads
            </a>
            <a href="/admin/crm/pipeline.php" class="sidebar-item <?= $activePage === 'pipeline' ? 'active' : '' ?>">
                <span class="icon">📋</span> Pipeline
            </a>
            <a href="/admin/crm/contacts.php" class="sidebar-item <?= $activePage === 'contacts' ? 'active' : '' ?>">
                <span class="icon">🤝</span> Partenaires
            </a>
            <a href="/admin/crm/calls.php" class="sidebar-item <?= $activePage === 'calls' ? 'active' : '' ?>">
                <span class="icon">📞</span> Appels
            </a>
            <a href="/admin/crm/tasks.php" class="sidebar-item <?= $activePage === 'tasks' ? 'active' : '' ?>">
                <span class="icon">✅</span> Taches
            </a>
        </div>

        <!-- CONTENU & SEO -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Contenu & SEO</div>
            <a href="/admin/crm/blog.php" class="sidebar-item <?= $activePage === 'blog' ? 'active' : '' ?>">
                <span class="icon">📝</span> Articles Blog
            </a>
            <a href="/admin/crm/seo.php" class="sidebar-item <?= $activePage === 'seo' ? 'active' : '' ?>">
                <span class="icon">🔍</span> SEO Hub
            </a>
            <a href="/admin/crm/images-ia.php" class="sidebar-item <?= $activePage === 'images-ia' ? 'active' : '' ?>">
                <span class="icon">🎨</span> Images IA
            </a>
        </div>

        <!-- VENTES -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Ventes</div>
            <a href="/admin/crm/offers.php" class="sidebar-item <?= $activePage === 'offers' ? 'active' : '' ?>">
                <span class="icon">🎁</span> Offres
            </a>
            <a href="/admin/crm/tunnels.php" class="sidebar-item <?= $activePage === 'tunnels' ? 'active' : '' ?>">
                <span class="icon">🔄</span> Tunnels
            </a>
            <a href="/admin/crm/invoices.php" class="sidebar-item <?= $activePage === 'invoices' ? 'active' : '' ?>">
                <span class="icon">🧾</span> Factures
            </a>
        </div>

        <!-- MARKETING -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Marketing</div>
            <a href="/admin/crm/automation.php" class="sidebar-item <?= $activePage === 'automation' ? 'active' : '' ?>">
                <span class="icon">⚡</span> Automation
            </a>
            <a href="/admin/crm/analytics.php" class="sidebar-item <?= $activePage === 'analytics' ? 'active' : '' ?>">
                <span class="icon">📈</span> Analytics
            </a>
            <a href="/admin/crm/editor.php" class="sidebar-item <?= $activePage === 'editor' ? 'active' : '' ?>">
                <span class="icon">📧</span> Email Marketing
            </a>
        </div>

        <!-- PARAMETRES -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Systeme</div>
            <a href="/admin/crm/settings.php" class="sidebar-item <?= $activePage === 'settings' ? 'active' : '' ?>">
                <span class="icon">⚙️</span> Parametres
            </a>
            <a href="/" class="sidebar-item" target="_blank">
                <span class="icon">🌐</span> Voir le site
            </a>
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
        <a href="/admin/logout" class="sidebar-logout">
            <span>🚪</span> Deconnexion
        </a>
    </div>
</aside>
