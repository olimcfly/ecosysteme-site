<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Réservez un appel découverte gratuit de 30 minutes avec Olivier Colas. Découvrez si IMMO LOCAL+ est fait pour vous.">
    <title>Réserver un Appel Découverte | ÉCOSYSTÈME IMMO LOCAL+</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📅</text></svg>">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: #f1f5f9;
    color: #0f172a;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* ── TOPBAR DISCRET ── */
.rdv-topbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    padding: 14px 24px;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.rdv-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
    transition: color 0.2s;
    padding: 8px 14px;
    border-radius: 8px;
}
.rdv-back:hover { color: #475569; background: rgba(0,0,0,0.04); }
.rdv-back svg { width: 14px; height: 14px; }

.rdv-logo {
    color: #94a3b8;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: color 0.2s;
}
.rdv-logo:hover { color: #64748b; }

/* ── CARD ── */
.rdv-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 25px 80px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);
    overflow: hidden;
    display: grid;
    grid-template-columns: 290px 1fr;
    max-width: 920px;
    width: 100%;
    margin-top: 40px;
}

/* ── SIDEBAR ── */
.rdv-sidebar {
    padding: 36px 28px;
    border-right: 1px solid #f1f5f9;
    background: #fafbfc;
}
.rdv-host-avatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.1rem; margin-bottom: 14px;
}
.rdv-host-name { font-size: 0.85rem; color: #64748b; margin-bottom: 3px; }
.rdv-meeting-title { font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; line-height: 1.3; }
.rdv-info { display: flex; flex-direction: column; gap: 12px; }
.rdv-info-item { display: flex; align-items: flex-start; gap: 10px; font-size: 0.88rem; color: #475569; line-height: 1.5; }
.rdv-info-icon { width: 18px; min-width: 18px; text-align: center; font-size: 0.95rem; margin-top: 1px; }
.rdv-divider { height: 1px; background: #e2e8f0; margin: 22px 0; }
.rdv-sidebar-desc { font-size: 0.85rem; color: #64748b; line-height: 1.7; }
.rdv-sidebar-desc strong { color: #334155; }

/* ── ZONE DROITE ── */
.rdv-main { padding: 36px; position: relative; min-height: 460px; }

.rdv-step { display: none; }
.rdv-step.active { display: block; animation: rdvIn 0.3s ease; }
@keyframes rdvIn { from { opacity: 0; transform: translateX(8px); } to { opacity: 1; transform: translateX(0); } }
.rdv-step-label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6366f1; margin-bottom: 16px; }

/* Calendrier */
.rdv-cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.rdv-cal-month { font-size: 1.05rem; font-weight: 700; color: #0f172a; }
.rdv-cal-nav { display: flex; gap: 5px; }
.rdv-cal-btn {
    width: 34px; height: 34px; border-radius: 10px; border: 1px solid #e2e8f0;
    background: white; cursor: pointer; display: flex; align-items: center;
    justify-content: center; font-size: 0.95rem; transition: all 0.15s; color: #475569;
}
.rdv-cal-btn:hover { background: #f1f5f9; }
.rdv-cal-btn:disabled { opacity: 0.25; cursor: not-allowed; }

.rdv-cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 3px; }
.rdv-cal-dow { text-align: center; font-size: 0.72rem; font-weight: 600; color: #94a3b8; padding: 6px 0; text-transform: uppercase; letter-spacing: 0.5px; }
.rdv-cal-day {
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    border-radius: 12px; font-size: 0.88rem; font-weight: 500; cursor: pointer;
    transition: all 0.15s; color: #0f172a; position: relative; border: 2px solid transparent;
}
.rdv-cal-day:hover:not(.disabled):not(.empty) { background: #eff6ff; border-color: #bfdbfe; }
.rdv-cal-day.today { font-weight: 700; color: #6366f1; }
.rdv-cal-day.today::after { content: ''; position: absolute; bottom: 3px; width: 4px; height: 4px; background: #6366f1; border-radius: 50%; }
.rdv-cal-day.selected { background: #6366f1 !important; color: white !important; font-weight: 700; border-color: #6366f1; }
.rdv-cal-day.selected::after { background: white; }
.rdv-cal-day.disabled { color: #d1d5db; cursor: not-allowed; }
.rdv-cal-day.empty { cursor: default; }

/* Créneaux */
.rdv-slots-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.rdv-selected-date { font-size: 1rem; font-weight: 700; color: #0f172a; }
.rdv-back-btn {
    display: inline-flex; align-items: center; gap: 5px; background: none;
    border: 1px solid #e2e8f0; border-radius: 10px; padding: 7px 12px;
    font-size: 0.82rem; color: #64748b; cursor: pointer; font-family: inherit; transition: all 0.15s;
}
.rdv-back-btn:hover { background: #f1f5f9; color: #334155; }

.rdv-slots-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(105px, 1fr));
    gap: 7px; max-height: 330px; overflow-y: auto; padding-right: 4px;
}
.rdv-slot {
    padding: 13px 8px; border: 2px solid #e2e8f0; border-radius: 12px;
    text-align: center; font-size: 0.92rem; font-weight: 600; color: #0f172a;
    cursor: pointer; transition: all 0.15s; background: white;
}
.rdv-slot:hover { border-color: #6366f1; background: #eff6ff; color: #4338ca; }
.rdv-slot.selected { border-color: #6366f1; background: #6366f1; color: white; }
.rdv-slot.taken { border-color: #f1f5f9; background: #f8fafc; color: #cbd5e1; cursor: not-allowed; text-decoration: line-through; }

.rdv-no-slots { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 0.92rem; }
.rdv-no-slots-icon { font-size: 2.2rem; margin-bottom: 10px; }

.rdv-confirm-slot { margin-top: 16px; display: none; }
.rdv-confirm-slot.visible { display: block; }

.rdv-btn-next {
    width: 100%; padding: 15px; border: none; border-radius: 12px;
    background: #6366f1; color: white; font-size: 0.95rem; font-weight: 700;
    cursor: pointer; font-family: inherit; transition: all 0.2s;
}
.rdv-btn-next:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(99,102,241,0.25); }
.rdv-btn-next:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

/* Formulaire */
.rdv-form-recap {
    background: #f8fafc; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px;
    display: flex; align-items: center; gap: 14px; border: 1px solid #e2e8f0;
}
.rdv-recap-icon {
    width: 44px; height: 44px; min-width: 44px; background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: white;
}
.rdv-recap-date { font-weight: 700; color: #0f172a; font-size: 0.95rem; }
.rdv-recap-time { color: #64748b; font-size: 0.85rem; margin-top: 2px; }

.rdv-form-group { margin-bottom: 16px; }
.rdv-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.rdv-label { display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 5px; }
.rdv-label .req { color: #ef4444; }
.rdv-input {
    width: 100%; padding: 13px 14px; border: 2px solid #e2e8f0; border-radius: 12px;
    font-size: 0.92rem; font-family: inherit; color: #0f172a; background: white;
    transition: all 0.2s; outline: none; box-sizing: border-box;
}
.rdv-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.rdv-input::placeholder { color: #94a3b8; }
textarea.rdv-input { resize: vertical; min-height: 70px; }

.rdv-gdpr { display: flex; align-items: flex-start; gap: 10px; margin: 18px 0; }
.rdv-gdpr input { margin-top: 3px; accent-color: #6366f1; }
.rdv-gdpr label { font-size: 0.78rem; color: #64748b; line-height: 1.5; cursor: pointer; }

/* ══════════════════════════════════════════════════════════
   PAGE DE REMERCIEMENT — Full screen
   ══════════════════════════════════════════════════════════ */
.rdv-thankyou {
    display: none;
    position: fixed; inset: 0;
    background: linear-gradient(160deg, #f0fdf4 0%, #ecfdf5 30%, #f0f9ff 70%, #eff6ff 100%);
    z-index: 1000; overflow-y: auto;
}
.rdv-thankyou.active { display: flex; align-items: center; justify-content: center; }

.rdv-ty-inner { max-width: 560px; width: 100%; padding: 40px 24px; text-align: center; }

.rdv-ty-check {
    width: 88px; height: 88px; background: white; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 8px 30px rgba(34,197,94,0.2), 0 0 0 8px rgba(34,197,94,0.06);
    animation: rdvPop 0.6s cubic-bezier(0.68,-0.55,0.265,1.55) 0.2s both;
}
@keyframes rdvPop { from { transform: scale(0); } to { transform: scale(1); } }

.rdv-ty-check svg { width: 44px; height: 44px; stroke: #22c55e; stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round; }
.rdv-ty-check svg .check-path { stroke-dasharray: 50; stroke-dashoffset: 50; animation: rdvDraw 0.5s ease 0.6s forwards; }
@keyframes rdvDraw { to { stroke-dashoffset: 0; } }

.rdv-ty-title { font-size: 1.6rem; font-weight: 900; color: #0f172a; margin-bottom: 8px; animation: rdvUp 0.5s ease 0.3s both; }
.rdv-ty-sub { font-size: 1rem; color: #64748b; margin-bottom: 32px; line-height: 1.6; animation: rdvUp 0.5s ease 0.4s both; }
.rdv-ty-sub strong { color: #334155; }
@keyframes rdvUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

.rdv-ty-card {
    background: white; border-radius: 20px; padding: 28px; text-align: left;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06); margin-bottom: 24px;
    animation: rdvUp 0.5s ease 0.5s both;
}
.rdv-ty-card-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 16px; }
.rdv-ty-line { display: flex; align-items: center; gap: 14px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
.rdv-ty-line:last-child { border-bottom: none; }
.rdv-ty-line-icon { width: 40px; height: 40px; min-width: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
.rdv-ty-line-label { font-size: 0.82rem; color: #94a3b8; }
.rdv-ty-line-value { font-size: 0.95rem; font-weight: 600; color: #0f172a; margin-top: 1px; }

.rdv-ty-next {
    background: white; border-radius: 20px; padding: 24px; text-align: left;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06); margin-bottom: 28px;
    animation: rdvUp 0.5s ease 0.6s both;
}
.rdv-ty-next h4 { font-size: 0.92rem; font-weight: 700; color: #0f172a; margin-bottom: 14px; }
.rdv-ty-next-item { display: flex; align-items: flex-start; gap: 12px; padding: 8px 0; font-size: 0.88rem; color: #475569; line-height: 1.5; }
.rdv-ty-next-num {
    width: 26px; height: 26px; min-width: 26px; background: #eff6ff; color: #6366f1;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 800; margin-top: 1px;
}

.rdv-ty-links { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; animation: rdvUp 0.5s ease 0.7s both; }
.rdv-ty-link {
    display: inline-flex; align-items: center; gap: 6px; padding: 12px 20px;
    border-radius: 12px; font-size: 0.88rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
}
.rdv-ty-link-primary { background: #6366f1; color: white; }
.rdv-ty-link-primary:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99,102,241,0.3); }
.rdv-ty-link-ghost { background: white; color: #64748b; border: 1px solid #e2e8f0; }
.rdv-ty-link-ghost:hover { background: #f8fafc; color: #334155; }

.rdv-ty-footer { margin-top: 30px; font-size: 0.78rem; color: #94a3b8; animation: rdvUp 0.5s ease 0.8s both; }

/* Loading */
.rdv-overlay {
    display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.85);
    backdrop-filter: blur(4px); z-index: 20; align-items: center; justify-content: center; border-radius: 24px;
}
.rdv-overlay.active { display: flex; }
.rdv-spin { width: 36px; height: 36px; border: 3px solid #e2e8f0; border-top-color: #6366f1; border-radius: 50%; animation: rdvSpin 0.6s linear infinite; }
@keyframes rdvSpin { to { transform: rotate(360deg); } }

/* Responsive */
@media (max-width: 768px) {
    body { padding: 10px; justify-content: flex-start; padding-top: 60px; }
    .rdv-card { grid-template-columns: 1fr; margin-top: 10px; }
    .rdv-sidebar { border-right: none; border-bottom: 1px solid #f1f5f9; padding: 24px 22px; }
    .rdv-main { padding: 24px 22px; min-height: 380px; }
    .rdv-form-row { grid-template-columns: 1fr; }
    .rdv-slots-grid { grid-template-columns: repeat(3, 1fr); }
    .rdv-ty-inner { padding: 30px 16px; }
    .rdv-ty-title { font-size: 1.3rem; }
}
@media (max-width: 480px) { .rdv-slots-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="rdv-topbar">
    <a href="/" class="rdv-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour au site
    </a>
    <a href="/" class="rdv-logo">ÉCOSYSTÈME IMMO+</a>
</div>

<!-- CARD -->
<div class="rdv-card">
    <div class="rdv-sidebar">
        <div class="rdv-host-avatar">OC</div>
        <div class="rdv-host-name">Olivier Colas</div>
        <div class="rdv-meeting-title">Appel Découverte</div>
        <div class="rdv-info">
            <div class="rdv-info-item"><span class="rdv-info-icon">🕐</span><span>30 min</span></div>
            <div class="rdv-info-item"><span class="rdv-info-icon">📞</span><span>Appel téléphonique ou visio</span></div>
            <div class="rdv-info-item"><span class="rdv-info-icon">🌍</span><span>Fuseau Europe/Paris (UTC+1)</span></div>
            <div class="rdv-info-item"><span class="rdv-info-icon">💰</span><span>Gratuit — sans engagement</span></div>
        </div>
        <div class="rdv-divider"></div>
        <div class="rdv-sidebar-desc">
            <strong>Pendant cet appel :</strong><br><br>
            ✅ On analyse votre situation actuelle<br>
            ✅ On vérifie si votre zone est disponible<br>
            ✅ On vous montre la plateforme en live<br>
            ✅ On répond à toutes vos questions<br><br>
            <strong>Aucune obligation d'achat.</strong>
        </div>
    </div>
    
    <div class="rdv-main">
        <div class="rdv-overlay" id="rdvOverlay"><div class="rdv-spin"></div></div>
        
        <!-- STEP 1 -->
        <div class="rdv-step active" id="rdvStep1">
            <div class="rdv-step-label">Étape 1 / 3 — Choisissez une date</div>
            <div class="rdv-cal-header">
                <span class="rdv-cal-month" id="calMonthLabel"></span>
                <div class="rdv-cal-nav">
                    <button class="rdv-cal-btn" id="calPrev" onclick="rdvNav(-1)">‹</button>
                    <button class="rdv-cal-btn" id="calNext" onclick="rdvNav(1)">›</button>
                </div>
            </div>
            <div class="rdv-cal-grid" id="calGrid">
                <div class="rdv-cal-dow">Lun</div><div class="rdv-cal-dow">Mar</div><div class="rdv-cal-dow">Mer</div>
                <div class="rdv-cal-dow">Jeu</div><div class="rdv-cal-dow">Ven</div><div class="rdv-cal-dow">Sam</div><div class="rdv-cal-dow">Dim</div>
            </div>
        </div>
        
        <!-- STEP 2 -->
        <div class="rdv-step" id="rdvStep2">
            <div class="rdv-step-label">Étape 2 / 3 — Choisissez un créneau</div>
            <div class="rdv-slots-header">
                <span class="rdv-selected-date" id="slotDateLabel"></span>
                <button class="rdv-back-btn" onclick="goStep(1)">← Date</button>
            </div>
            <div class="rdv-slots-grid" id="slotsGrid"></div>
            <div class="rdv-confirm-slot" id="slotConfirm">
                <button class="rdv-btn-next" onclick="goStep(3)">Continuer →</button>
            </div>
        </div>
        
        <!-- STEP 3 -->
        <div class="rdv-step" id="rdvStep3">
            <div class="rdv-step-label">Étape 3 / 3 — Vos coordonnées</div>
            <button class="rdv-back-btn" onclick="goStep(2)" style="margin-bottom:18px">← Créneau</button>
            <div class="rdv-form-recap">
                <div class="rdv-recap-icon">📅</div>
                <div><div class="rdv-recap-date" id="recapDate"></div><div class="rdv-recap-time" id="recapTime"></div></div>
            </div>
            <form id="rdvForm" onsubmit="return doSubmit(event)">
                <div class="rdv-form-row">
                    <div class="rdv-form-group"><label class="rdv-label">Prénom <span class="req">*</span></label><input type="text" class="rdv-input" id="fFN" placeholder="Votre prénom" required></div>
                    <div class="rdv-form-group"><label class="rdv-label">Nom <span class="req">*</span></label><input type="text" class="rdv-input" id="fLN" placeholder="Votre nom" required></div>
                </div>
                <div class="rdv-form-group"><label class="rdv-label">Email <span class="req">*</span></label><input type="email" class="rdv-input" id="fEM" placeholder="votre@email.com" required></div>
                <div class="rdv-form-group"><label class="rdv-label">Téléphone</label><input type="tel" class="rdv-input" id="fPH" placeholder="06 12 34 56 78"></div>
                <div class="rdv-form-group"><label class="rdv-label">Un mot sur votre situation ? <span style="color:#94a3b8">(optionnel)</span></label><textarea class="rdv-input" id="fMSG" placeholder="Ex: Je suis mandataire chez eXp à Lyon..."></textarea></div>
                <div class="rdv-gdpr"><input type="checkbox" id="fGDPR" required><label for="fGDPR">J'accepte d'être contacté par ÉCOSYSTÈME IMMO LOCAL+ dans le cadre de ce rendez-vous. Mes données sont traitées conformément au RGPD.</label></div>
                <button type="submit" class="rdv-btn-next" id="rdvBtn">✅ Confirmer mon rendez-vous</button>
            </form>
        </div>
    </div>
</div>

<!-- PAGE DE REMERCIEMENT -->
<div class="rdv-thankyou" id="rdvTY">
    <div class="rdv-ty-inner">
        <div class="rdv-ty-check">
            <svg viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="#22c55e" stroke-width="1.5" fill="none" opacity="0.2"/>
                <path class="check-path" d="M7 13l3 3 7-7"/>
            </svg>
        </div>
        <h2 class="rdv-ty-title">Rendez-vous confirmé !</h2>
        <p class="rdv-ty-sub">Un email de confirmation vient d'être envoyé à <strong id="tyEmail"></strong></p>
        
        <div class="rdv-ty-card">
            <div class="rdv-ty-card-title">Détails du rendez-vous</div>
            <div class="rdv-ty-line"><div class="rdv-ty-line-icon">📅</div><div><div class="rdv-ty-line-label">Date</div><div class="rdv-ty-line-value" id="tyDate"></div></div></div>
            <div class="rdv-ty-line"><div class="rdv-ty-line-icon">🕐</div><div><div class="rdv-ty-line-label">Heure (Paris)</div><div class="rdv-ty-line-value" id="tyTime"></div></div></div>
            <div class="rdv-ty-line"><div class="rdv-ty-line-icon">⏱️</div><div><div class="rdv-ty-line-label">Durée</div><div class="rdv-ty-line-value">30 minutes</div></div></div>
            <div class="rdv-ty-line"><div class="rdv-ty-line-icon">👤</div><div><div class="rdv-ty-line-label">Avec</div><div class="rdv-ty-line-value">Olivier Colas — ÉCOSYSTÈME IMMO+</div></div></div>
            <div class="rdv-ty-line"><div class="rdv-ty-line-icon">📞</div><div><div class="rdv-ty-line-label">Format</div><div class="rdv-ty-line-value">Appel téléphonique ou visio</div></div></div>
        </div>
        
        <div class="rdv-ty-next">
            <h4>📋 Prochaines étapes</h4>
            <div class="rdv-ty-next-item"><div class="rdv-ty-next-num">1</div><span>Vérifiez votre boîte mail (et les spams) pour l'email de confirmation</span></div>
            <div class="rdv-ty-next-item"><div class="rdv-ty-next-num">2</div><span>Préparez 2-3 questions sur votre situation pour maximiser la valeur de cet appel</span></div>
            <div class="rdv-ty-next-item"><div class="rdv-ty-next-num">3</div><span>Olivier vous appellera au numéro indiqué à l'heure convenue</span></div>
        </div>
        
        <div class="rdv-ty-links">
            <a href="/" class="rdv-ty-link rdv-ty-link-primary">🏠 Retour à l'accueil</a>
            <a href="/front/pages/verifier-zone.php" class="rdv-ty-link rdv-ty-link-ghost">📍 Vérifier ma zone</a>
        </div>
        <div class="rdv-ty-footer">© 2026 ÉCOSYSTÈME IMMO LOCAL+ — SAS OCDM Agency</div>
    </div>
</div>

<script>
var API='/api/bookings.php',S={y:null,m:null,date:null,time:null},
MOIS=['','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
JOURS=['','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'],
AV={1:{s:'09:00',e:'18:00',on:1},2:{s:'09:00',e:'18:00',on:1},3:{s:'09:00',e:'18:00',on:1},4:{s:'09:00',e:'18:00',on:1},5:{s:'09:00',e:'18:00',on:1},6:{s:'10:00',e:'13:00',on:0},7:{s:'00:00',e:'00:00',on:0}},
LU={s:'12:30',e:'14:00'},SL=30,LB={};

document.addEventListener('DOMContentLoaded',function(){var n=new Date();S.y=n.getFullYear();S.m=n.getMonth()+1;cal()});

function cal(){
    var y=S.y,m=S.m;$('calMonthLabel').textContent=MOIS[m]+' '+y;
    var n=new Date();$('calPrev').disabled=(y===n.getFullYear()&&m===n.getMonth()+1);
    var mx=n.getMonth()+3,my=n.getFullYear();if(mx>12){mx-=12;my++}
    $('calNext').disabled=(y>my||(y===my&&m>=mx));
    var g=$('calGrid'),dw=g.querySelectorAll('.rdv-cal-dow');g.innerHTML='';dw.forEach(function(d){g.appendChild(d)});
    var f=new Date(y,m-1,1),fd=f.getDay()||7,dm=new Date(y,m,0).getDate(),td=new Date();td.setHours(0,0,0,0);
    var mx2=new Date();mx2.setDate(mx2.getDate()+60);
    for(var e=1;e<fd;e++){var em=document.createElement('div');em.className='rdv-cal-day empty';g.appendChild(em)}
    for(var d=1;d<=dm;d++){
        var c=document.createElement('div');c.className='rdv-cal-day';c.textContent=d;
        var dt=new Date(y,m-1,d);dt.setHours(0,0,0,0);var dw2=dt.getDay()||7,ds=iso(y,m,d);
        if(dt<td||dt>mx2||!AV[dw2]||!AV[dw2].on)c.classList.add('disabled');
        else{c.dataset.date=ds;c.addEventListener('click',function(){selD(this.dataset.date)})}
        if(dt.getTime()===td.getTime())c.classList.add('today');
        if(ds===S.date)c.classList.add('selected');
        g.appendChild(c)
    }
}

function rdvNav(d){S.m+=d;if(S.m>12){S.m=1;S.y++}if(S.m<1){S.m=12;S.y--}cal()}

function selD(ds){
    S.date=ds;S.time=null;
    document.querySelectorAll('.rdv-cal-day').forEach(function(c){c.classList.remove('selected')});
    var s=document.querySelector('[data-date="'+ds+'"]');if(s)s.classList.add('selected');
    goStep(2);loadSlots(ds)
}

function loadSlots(ds){
    $('slotConfirm').classList.remove('visible');
    var p=ds.split('-'),dt=new Date(+p[0],+p[1]-1,+p[2]),dw=dt.getDay()||7;
    $('slotDateLabel').textContent=JOURS[dw]+' '+(+p[2])+' '+MOIS[+p[1]]+' '+p[0];
    ov(1);
    fetch(API+'?action=slots&date='+ds).then(function(r){return r.json()}).then(function(d){ov(0);d.slots?rSlots(d.slots):rLocal(ds,dw)}).catch(function(){ov(0);rLocal(ds,dw)})
}

function rLocal(ds,dw){
    var a=AV[dw];if(!a||!a.on){rSlots([]);return}
    var sl=[],sM=tm(a.s),eM=tm(a.e),lS=tm(LU.s),lE=tm(LU.e),
    n=new Date(),mn=n.getHours()*60+n.getMinutes()+120,
    it=ds===iso(n.getFullYear(),n.getMonth()+1,n.getDate()),bk=LB[ds]||[];
    for(var t=sM;t<eM;t+=SL){if(t>=lS&&t<lE)continue;if(it&&t<=mn)continue;
    var ts=ft(t);sl.push({time:ts,end:ft(t+SL),available:bk.indexOf(ts)===-1})}
    rSlots(sl)
}

function rSlots(sl){
    var g=$('slotsGrid');g.innerHTML='';
    if(!sl||!sl.length){g.innerHTML='<div class="rdv-no-slots" style="grid-column:1/-1"><div class="rdv-no-slots-icon">😔</div>Aucun créneau ce jour.<br>Essayez un autre jour.</div>';return}
    sl.forEach(function(s){
        var el=document.createElement('div');el.className='rdv-slot'+(s.available?'':' taken');el.textContent=s.time;
        if(s.available){el.dataset.time=s.time;el.dataset.end=s.end;el.addEventListener('click',function(){selT(this.dataset.time)})}
        if(s.time===S.time)el.classList.add('selected');g.appendChild(el)
    })
}

function selT(t){
    S.time=t;document.querySelectorAll('.rdv-slot').forEach(function(s){s.classList.remove('selected')});
    var s=document.querySelector('.rdv-slot[data-time="'+t+'"]');if(s)s.classList.add('selected');
    $('slotConfirm').classList.add('visible')
}

function goStep(n){
    for(var i=1;i<=3;i++)$('rdvStep'+i).classList.toggle('active',i===n);
    if(n===3&&S.date&&S.time){
        var p=S.date.split('-'),dt=new Date(+p[0],+p[1]-1,+p[2]),dw=dt.getDay()||7;
        $('recapDate').textContent=JOURS[dw]+' '+(+p[2])+' '+MOIS[+p[1]]+' '+p[0];
        $('recapTime').textContent=S.time+' — 30 min · Appel découverte'
    }
}

function doSubmit(e){
    e.preventDefault();
    var fn=$('fFN').value.trim(),ln=$('fLN').value.trim(),em=$('fEM').value.trim(),
    ph=$('fPH').value.trim(),msg=$('fMSG').value.trim();
    if(!fn||!ln||!em||!$('fGDPR').checked){alert('Veuillez remplir tous les champs obligatoires.');return false}
    var b=$('rdvBtn');b.disabled=1;b.textContent='Réservation en cours...';ov(1);
    fetch(API,{method:'POST',headers:{'Content-Type':'application/json'},
    body:JSON.stringify({action:'book',first_name:fn,last_name:ln,email:em,phone:ph,message:msg,date:S.date,time:S.time,source:gp('source')||'site'})
    }).then(function(r){return r.json()}).then(function(d){ov(0);if(d.success)tyShow(fn,em);else{alert(d.error||'Erreur.');b.disabled=0;b.textContent='✅ Confirmer mon rendez-vous'}
    }).catch(function(){ov(0);svLocal();tyShow(fn,em)});return false
}

function tyShow(name,email){
    var p=S.date.split('-'),dt=new Date(+p[0],+p[1]-1,+p[2]),dw=dt.getDay()||7;
    $('tyDate').textContent=JOURS[dw]+' '+(+p[2])+' '+MOIS[+p[1]]+' '+p[0];
    $('tyTime').textContent=S.time+' — '+ft(tm(S.time)+SL);
    $('tyEmail').textContent=email;
    $('rdvTY').classList.add('active');document.body.style.overflow='hidden'
}

function svLocal(){if(!LB[S.date])LB[S.date]=[];LB[S.date].push(S.time)}

function $(id){return document.getElementById(id)}
function iso(y,m,d){return y+'-'+String(m).padStart(2,'0')+'-'+String(d).padStart(2,'0')}
function tm(t){var p=t.split(':');return+p[0]*60+(+p[1])}
function ft(m){return String(Math.floor(m/60)).padStart(2,'0')+':'+String(m%60).padStart(2,'0')}
function ov(on){$('rdvOverlay').classList.toggle('active',!!on)}
function gp(n){return new URLSearchParams(window.location.search).get(n)}
</script>
</body>
</html>