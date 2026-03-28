<?php
/**
 * GMB Module - Common Header
 */
session_start();

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../config/admin-config.php';
require_once __DIR__ . '/../../../includes/GMBService.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

$gmb = new GMBService($pdo);
$gmbStats = $gmb->getDashboardStats();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $pageTitle ?? 'Google Business Profile' ?> - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin-crm.css">
    <style>
        /* GMB Specific Styles */
        .health-score-big {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            position: relative;
        }
        .health-score-big .score-value {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
        }
        .health-score-big .score-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }
        .health-excellent { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
        .health-good { background: linear-gradient(135deg, #dbeafe, #93c5fd); color: #1e40af; }
        .health-average { background: linear-gradient(135deg, #fef3c7, #fcd34d); color: #92400e; }
        .health-poor { background: linear-gradient(135deg, #fee2e2, #fca5a5); color: #991b1b; }

        .health-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .health-bar-label {
            width: 160px;
            font-size: 0.85rem;
            color: var(--gray-600);
        }
        .health-bar-track {
            flex: 1;
            height: 10px;
            background: var(--gray-200);
            border-radius: 5px;
            overflow: hidden;
        }
        .health-bar-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.5s ease;
        }
        .health-bar-value {
            width: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            text-align: right;
        }

        .stars { color: #f59e0b; letter-spacing: 2px; }
        .stars-gray { color: var(--gray-300); }

        .review-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--gray-200);
        }
        .review-card.rating-5 { border-left-color: #10b981; }
        .review-card.rating-4 { border-left-color: #3b82f6; }
        .review-card.rating-3 { border-left-color: #f59e0b; }
        .review-card.rating-2 { border-left-color: #f97316; }
        .review-card.rating-1 { border-left-color: #ef4444; }

        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        .review-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem;
        }
        .review-meta { flex: 1; }
        .review-name { font-weight: 600; font-size: 0.95rem; }
        .review-date { font-size: 0.8rem; color: var(--gray-500); }
        .review-text { color: var(--gray-700); line-height: 1.6; margin-bottom: 10px; }
        .review-reply {
            background: var(--gray-50);
            border-radius: var(--radius-sm);
            padding: 12px;
            margin-top: 10px;
            border-left: 3px solid var(--primary);
        }
        .review-reply-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .post-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: var(--shadow);
        }
        .post-type-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .post-type-update { background: #dbeafe; color: #1e40af; }
        .post-type-offer { background: #fef3c7; color: #92400e; }
        .post-type-event { background: #ede9fe; color: #7c3aed; }
        .post-type-product { background: #d1fae5; color: #065f46; }

        .post-status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-draft { background: var(--gray-200); color: var(--gray-600); }
        .status-scheduled { background: #dbeafe; color: #1e40af; }
        .status-published { background: #d1fae5; color: #065f46; }
        .status-expired { background: #fee2e2; color: #991b1b; }

        .grid-position {
            display: inline-flex;
            width: 40px; height: 40px;
            border-radius: 8px;
            align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
            margin: 2px;
        }
        .pos-1 { background: #10b981; color: white; }
        .pos-2 { background: #34d399; color: white; }
        .pos-3 { background: #6ee7b7; color: #065f46; }
        .pos-top5 { background: #fcd34d; color: #78350f; }
        .pos-top10 { background: #fed7aa; color: #9a3412; }
        .pos-top20 { background: #fecaca; color: #991b1b; }
        .pos-none { background: var(--gray-200); color: var(--gray-500); }

        .citation-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .citation-verified { background: #d1fae5; color: #065f46; }
        .citation-mismatch { background: #fee2e2; color: #991b1b; }
        .citation-not_found { background: var(--gray-200); color: var(--gray-600); }
        .citation-pending { background: #fef3c7; color: #92400e; }

        .nap-match { color: #10b981; }
        .nap-mismatch { color: #ef4444; font-weight: 600; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; font-size: 0.85rem; color: var(--gray-700); margin-bottom: 5px; }
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(102,126,234,0.15); }
        textarea.form-control { resize: vertical; min-height: 100px; }
        select.form-control { cursor: pointer; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        .card { background: white; border-radius: var(--radius); padding: 25px; box-shadow: var(--shadow); margin-bottom: 20px; }
        .card-title { font-size: 1.1rem; font-weight: 600; color: var(--gray-800); margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }

        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { background: #059669; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-warning { background: var(--warning); color: white; }
        .btn-warning:hover { background: #d97706; }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }

        .tabs {
            display: flex;
            border-bottom: 2px solid var(--gray-200);
            margin-bottom: 20px;
            gap: 5px;
        }
        .tab {
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--gray-500);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
            text-decoration: none;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
        }
        .tab:hover { color: var(--gray-700); }
        .tab.active { color: var(--primary); border-bottom-color: var(--primary); font-weight: 600; }

        .alert {
            padding: 15px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }

        .flex { display: flex; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .flex-center { display: flex; align-items: center; }
        .gap-10 { gap: 10px; }
        .gap-20 { gap: 20px; }
        .mb-0 { margin-bottom: 0; }
        .mb-10 { margin-bottom: 10px; }
        .mb-20 { margin-bottom: 20px; }
        .mt-20 { margin-top: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-muted { color: var(--gray-500); }
        .text-sm { font-size: 0.85rem; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }

        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
            .dashboard-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
    </style>
</head>
<body>
<div class="crm-layout">
