<?php
$pageTitle = "Coach IA Pro — Testez votre stratégie digitale en 5 minutes";
$pageDescription = "Testez gratuitement le Coach IA Pro d'Écosystème Immo. Obtenez votre promesse commerciale, votre plan SEO local et vos accroches publicitaires — personnalisés pour votre ville.";
$currentPage = 'assistant';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
:root {
    --brand:  #1a2e1a;
    --gold:   #c8a96e;
    --violet: #667eea;
    --purple: #764ba2;
    --green:  #10b981;
    --light:  #f7fafc;
    --white:  #ffffff;
    --text:   #1a202c;
    --muted:  #718096;
    --radius: 14px;
}

/* HERO */
.ai-hero { background: var(--brand); padding: 80px 0 60px; position: relative; overflow: hidden; }
.ai-hero::before {
    content: ''; position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 60% 50% at 80% 50%, rgba(102,126,234,0.18) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(200,169,110,0.12) 0%, transparent 60%);
    pointer-events: none;
}
.ai-hero .container { position: relative; z-index: 1; display: grid; grid-template-columns: 1fr 420px; gap: 60px; align-items: center; }
.ai-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(200,169,110,0.15); border: 1px solid rgba(200,169,110,0.3); color: var(--gold); padding: 6px 16px; border-radius: 30px; font-size: 0.83rem; font-weight: 600; margin-bottom: 22px; }
.ai-badge .dot { width: 7px; height: 7px; background: var(--green); border-radius: 50%; animation: pdot 2s infinite; }
@keyframes pdot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.7)} }
.ai-hero h1 { font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 800; color: #fff; line-height: 1.18; margin: 0 0 18px; letter-spacing: -0.02em; }
.ai-hero h1 span { background: linear-gradient(135deg, var(--gold), #e8c87a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.ai-hero p { font-family: 'Inter', sans-serif; color: rgba(255,255,255,0.78); font-size: 1.05rem; line-height: 1.75; margin: 0 0 32px; max-width: 480px; }
.ai-ctas { display: flex; gap: 14px; flex-wrap: wrap; }
.btn-ai-primary { display: inline-flex; align-items: center; gap: 9px; background: linear-gradient(135deg, var(--violet), var(--purple)); color: #fff; padding: 14px 28px; border-radius: 10px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.97rem; text-decoration: none; transition: opacity 0.2s, transform 0.2s; }
.btn-ai-primary:hover { opacity: 0.88; transform: translateY(-2px); }
.btn-ai-ghost { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.85); padding: 13px 24px; border-radius: 10px; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 0.97rem; text-decoration: none; transition: background 0.2s; }
.btn-ai-ghost:hover { background: rgba(255,255,255,0.14); }
.trust-row { margin-top: 22px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.trust-item { display: flex; align-items: center; gap: 6px; font-family: 'Inter', sans-serif; font-size: 0.82rem; color: rgba(255,255,255,0.6); }

/* MOCKUP */
.ai-mockup { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; overflow: hidden; }
.ai-mockup-bar { background: rgba(255,255,255,0.08); padding: 12px 18px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); }
.ai-mockup-bar .dots { display: flex; gap: 6px; }
.ai-mockup-bar .dots span { width: 10px; height: 10px; border-radius: 50%; }
.ai-mockup-bar .dots span:nth-child(1) { background: #ff5f57; }
.ai-mockup-bar .dots span:nth-child(2) { background: #ffbd2e; }
.ai-mockup-bar .dots span:nth-child(3) { background: #28ca41; }
.ai-mockup-label { font-family: 'Inter', sans-serif; font-size: 0.78rem; color: rgba(255,255,255,0.5); margin-left: 6px; }
.ai-mockup-body { padding: 20px 18px; display: flex; flex-direction: column; gap: 12px; }
.chat-msg { display: flex; gap: 10px; align-items: flex-start; animation: fadeUp 0.4s ease both; }
.chat-msg.user { flex-direction: row-reverse; }
.chat-avatar { width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; font-family: 'Inter', sans-serif; }
.chat-avatar.ai   { background: var(--brand); color: var(--gold); border: 1px solid rgba(200,169,110,0.3); }
.chat-avatar.user { background: linear-gradient(135deg, var(--violet), var(--purple)); color: #fff; }
.chat-bubble { max-width: 78%; padding: 9px 13px; border-radius: 12px; font-family: 'Inter', sans-serif; font-size: 0.82rem; line-height: 1.6; }
.chat-bubble.ai   { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.9); border: 1px solid rgba(255,255,255,0.08); }
.chat-bubble.user { background: linear-gradient(135deg, var(--violet), var(--purple)); color: #fff; }
.chat-bubble strong { display: block; font-size: 0.78rem; color: var(--gold); margin-bottom: 4px; }
.chat-opts { display: flex; flex-direction: column; gap: 5px; margin-top: 8px; }
.chat-opt { padding: 6px 10px; background: rgba(102,126,234,0.2); border: 1px solid rgba(102,126,234,0.3); border-radius: 7px; font-size: 0.77rem; color: rgba(255,255,255,0.85); font-family: 'Inter', sans-serif; }
@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

/* STATS */
.ai-stats { background: #f0f4ff; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; padding: 24px 0; }
.ai-stats .container { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; }
.ai-stat { text-align: center; padding: 10px; }
.ai-stat .val { font-family: 'Poppins', sans-serif; font-size: 1.9rem; font-weight: 800; color: var(--brand); line-height: 1; margin-bottom: 5px; }
.ai-stat .lbl { font-family: 'Inter', sans-serif; font-size: 0.82rem; color: var(--muted); line-height: 1.4; }

/* SECTIONS */
.ai-section { padding: 80px 0; }
.ai-section.bg-light { background: var(--light); }
.ai-section.bg-white { background: var(--white); }
.section-tag { display: inline-block; padding: 5px 14px; border-radius: 20px; font-family: 'Inter', sans-serif; font-size: 0.82rem; font-weight: 600; margin-bottom: 14px; }
.section-tag.violet { background: #ede9fe; color: #5b21b6; }
.section-tag.green  { background: #d1fae5; color: #065f46; }
.section-tag.gold   { background: #fef3c7; color: #92400e; }
.section-title { font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 800; color: var(--text); line-height: 1.25; margin: 0 0 14px; letter-spacing: -0.02em; }
.section-sub { font-family: 'Inter', sans-serif; font-size: 1rem; color: var(--muted); line-height: 1.7; max-width: 540px; margin: 0 0 40px; }

/* DELIVERABLES */
.deliverables-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 20px; }
.deliv-card { background: var(--white); border: 1px solid #e2e8f0; border-radius: var(--radius); padding: 28px; transition: transform 0.2s, box-shadow 0.2s; position: relative; overflow: hidden; }
.deliv-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.deliv-card.c1::before { background: linear-gradient(90deg, var(--violet), var(--purple)); }
.deliv-card.c2::before { background: linear-gradient(90deg, var(--green), #059669); }
.deliv-card.c3::before { background: linear-gradient(90deg, var(--gold), #e8c87a); }
.deliv-card.c4::before { background: linear-gradient(90deg, #f59e0b, #ef4444); }
.deliv-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
.deliv-num { font-family: 'Inter', sans-serif; font-size: 0.72rem; font-weight: 700; color: var(--muted); letter-spacing: 0.08em; margin-bottom: 10px; }
.deliv-title { font-family: 'Poppins', sans-serif; font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }
.deliv-desc { font-family: 'Inter', sans-serif; font-size: 0.9rem; color: var(--muted); line-height: 1.65; margin-bottom: 16px; }
.deliv-items { display: flex; flex-direction: column; gap: 5px; }
.deliv-item { display: flex; align-items: flex-start; gap: 8px; font-family: 'Inter', sans-serif; font-size: 0.86rem; color: #4a5568; }
.deliv-item::before { content: '→'; color: var(--violet); font-weight: 700; flex-shrink: 0; margin-top: 1px; }

/* STEPS */
.steps-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; position: relative; }
.steps-grid::before { content: ''; position: absolute; top: 32px; left: 10%; right: 10%; height: 1px; background: linear-gradient(90deg, var(--violet), var(--purple)); opacity: 0.3; }
.step-card { background: var(--white); border: 1px solid #e2e8f0; border-radius: var(--radius); padding: 28px 22px; text-align: center; position: relative; transition: transform 0.2s, box-shadow 0.2s; }
.step-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.09); }
.step-num { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--violet), var(--purple)); color: #fff; font-family: 'Poppins', sans-serif; font-size: 1.1rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; position: relative; z-index: 1; }
.step-title { font-family: 'Poppins', sans-serif; font-size: 0.97rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }
.step-desc { font-family: 'Inter', sans-serif; font-size: 0.85rem; color: var(--muted); line-height: 1.6; }

/* DIFF */
.diff-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.diff-col { border-radius: var(--radius); padding: 32px; }
.diff-col.before { background: #fff5f5; border: 1px solid #fed7d7; }
.diff-col.after  { background: linear-gradient(135deg, var(--brand) 0%, #2d4a2d 100%); border: 1px solid rgba(200,169,110,0.2); }
.diff-col-title  { font-family: 'Poppins', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.diff-col.before .diff-col-title { color: #c53030; }
.diff-col.after  .diff-col-title { color: var(--gold); }
.diff-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.05); font-family: 'Inter', sans-serif; font-size: 0.9rem; line-height: 1.5; }
.diff-col.after .diff-item { border-bottom-color: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); }
.diff-item:last-child { border-bottom: none; }

/* INTEGRATION */
.integration-flow { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0; }
.int-box { background: var(--white); border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; text-align: center; min-width: 140px; transition: transform 0.2s; }
.int-box:hover { transform: translateY(-2px); }
.int-box .icon { font-size: 1.8rem; margin-bottom: 8px; }
.int-box .lbl { font-family: 'Poppins', sans-serif; font-size: 0.82rem; font-weight: 700; color: var(--text); margin-bottom: 3px; }
.int-box .sub { font-family: 'Inter', sans-serif; font-size: 0.75rem; color: var(--muted); }
.int-box.highlight { background: linear-gradient(135deg, var(--brand), #2d4a2d); border-color: rgba(200,169,110,0.3); }
.int-box.highlight .lbl { color: var(--gold); }
.int-box.highlight .sub { color: rgba(255,255,255,0.6); }
.int-arrow { font-size: 1.4rem; color: var(--violet); padding: 0 10px; font-weight: 700; }

/* TESTI */
.testi-strip { background: #f0f4ff; border-radius: var(--radius); padding: 28px 32px; display: flex; gap: 24px; align-items: flex-start; margin-bottom: 24px; }
.testi-avatar { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--violet), var(--purple)); color: #fff; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.testi-text { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #2d3748; line-height: 1.7; font-style: italic; margin-bottom: 10px; }
.testi-meta { font-family: 'Inter', sans-serif; font-size: 0.82rem; color: var(--muted); }
.testi-meta strong { color: var(--text); font-style: normal; }

/* CTA FINAL */
.ai-cta-final { background: linear-gradient(135deg, var(--violet) 0%, var(--purple) 100%); padding: 80px 0; text-align: center; position: relative; overflow: hidden; }
.ai-cta-final::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 80% at 50% 110%, rgba(200,169,110,0.18) 0%, transparent 70%); }
.ai-cta-final h2 { font-family: 'Poppins', sans-serif; font-size: 2.2rem; font-weight: 800; color: #fff; margin-bottom: 14px; position: relative; letter-spacing: -0.02em; }
.ai-cta-final p { font-family: 'Inter', sans-serif; color: rgba(255,255,255,0.82); font-size: 1.05rem; margin-bottom: 36px; position: relative; }
.btn-white { display: inline-flex; align-items: center; gap: 10px; background: #fff; color: var(--violet); padding: 16px 36px; border-radius: 12px; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1.05rem; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; position: relative; }
.btn-white:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
.btn-outline-final { display: inline-flex; align-items: center; gap: 8px; background: transparent; border: 2px solid rgba(255,255,255,0.5); color: #fff; padding: 14px 28px; border-radius: 12px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 1rem; text-decoration: none; margin-left: 16px; transition: background 0.2s; }
.btn-outline-final:hover { background: rgba(255,255,255,0.1); }

/* RESPONSIVE */
@media (max-width: 900px) {
    .ai-hero .container { grid-template-columns: 1fr; gap: 40px; }
    .ai-hero h1 { font-size: 2rem; }
    .ai-stats .container { grid-template-columns: repeat(2,1fr); }
    .deliverables-grid { grid-template-columns: 1fr; }
    .steps-grid { grid-template-columns: repeat(2,1fr); }
    .steps-grid::before { display: none; }
    .diff-grid { grid-template-columns: 1fr; }
    .int-arrow { display: none; }
    .testi-strip { flex-direction: column; gap: 14px; }
}
@media (max-width: 600px) {
    .ai-hero { padding: 50px 0 40px; }
    .ai-hero h1 { font-size: 1.7rem; }
    .section-title { font-size: 1.6rem; }
    .ai-cta-final h2 { font-size: 1.7rem; }
    .btn-outline-final { margin-left: 0; margin-top: 12px; }
    .ai-ctas { flex-direction: column; }
}
</style>

<!-- HERO -->
<section class="ai-hero">
    <div class="container">
        <div>
            <div class="ai-badge"><span class="dot"></span> Coach IA Pro &mdash; &Eacute;cosyst&egrave;me Immo</div>
            <h1>Votre strat&eacute;gie digitale<br><span>en 5 minutes</span>, pas en 5 semaines</h1>
            <p>Testez gratuitement le Coach IA Pro. Obtenez votre promesse commerciale, votre plan SEO local et vos accroches publicitaires &mdash; personnalis&eacute;s pour votre ville et votre persona.</p>
            <div class="ai-ctas">
                <a href="https://assistant.ecosystemeimmo.fr" class="btn-ai-primary" target="_blank">🤖 Tester le Coach IA gratuitement</a>
                <a href="/front/pages/verifier-ma-ville.php" class="btn-ai-ghost">📍 V&eacute;rifier ma ville &rarr;</a>
            </div>
            <div class="trust-row">
                <div class="trust-item"><span style="color:#10b981">✓</span> Aucun compte requis</div>
                <div class="trust-item"><span style="color:#10b981">✓</span> R&eacute;sultats instantan&eacute;s</div>
                <div class="trust-item"><span style="color:#10b981">✓</span> 100% personnalis&eacute; pour votre zone</div>
            </div>
        </div>
        <div class="ai-mockup">
            <div class="ai-mockup-bar">
                <div class="dots"><span></span><span></span><span></span></div>
                <span class="ai-mockup-label">assistant.ecosystemeimmo.fr</span>
            </div>
            <div class="ai-mockup-body">
                <div class="chat-msg" style="animation-delay:0.1s">
                    <div class="chat-avatar ai">IA</div>
                    <div class="chat-bubble ai">
                        <strong>Coach IA Pro &mdash; &Eacute;cosyst&egrave;me Immo</strong>
                        Bienvenue 👋 Sur quelle ville travaillez-vous ?
                        <div class="chat-opts">
                            <div class="chat-opt">&rarr; Agent ind&eacute;pendant &agrave; Nice</div>
                            <div class="chat-opt">&rarr; Mandataire IAD &agrave; Lyon</div>
                            <div class="chat-opt">&rarr; Pr&eacute;ciser ma ville...</div>
                        </div>
                    </div>
                </div>
                <div class="chat-msg user" style="animation-delay:0.3s">
                    <div class="chat-avatar user">Vous</div>
                    <div class="chat-bubble user">Mandataire &agrave; Bordeaux, je cible les vendeurs seniors</div>
                </div>
                <div class="chat-msg" style="animation-delay:0.5s">
                    <div class="chat-avatar ai">IA</div>
                    <div class="chat-bubble ai">
                        Parfait. Votre promesse : <em>&laquo;&nbsp;J'aide les propri&eacute;taires seniors de Bordeaux &agrave; vendre sereinement, au bon prix, en 60&nbsp;jours.&nbsp;&raquo;</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="ai-stats">
    <div class="container">
        <div class="ai-stat"><div class="val">4</div><div class="lbl">Livrables g&eacute;n&eacute;r&eacute;s<br>par session</div></div>
        <div class="ai-stat"><div class="val">5 min</div><div class="lbl">Pour votre<br>strat&eacute;gie compl&egrave;te</div></div>
        <div class="ai-stat"><div class="val">43</div><div class="lbl">Modules int&eacute;gr&eacute;s<br>dans la suite</div></div>
        <div class="ai-stat"><div class="val">1</div><div class="lbl">Ville = 1 licence<br>exclusive</div></div>
    </div>
</section>

<!-- LIVRABLES -->
<section class="ai-section bg-light">
    <div class="container">
        <div style="text-align:center; margin-bottom:48px;">
            <span class="section-tag violet">Ce que vous obtenez</span>
            <div class="section-title" style="max-width:560px; margin:0 auto 14px;">4 documents actionnables, g&eacute;n&eacute;r&eacute;s en quelques minutes</div>
            <p class="section-sub" style="margin:0 auto; text-align:center;">Des livrables que vous auriez mis des semaines &agrave; produire seul &mdash; ou plusieurs milliers d'euros &agrave; faire faire par un consultant.</p>
        </div>
        <div class="deliverables-grid">
            <div class="deliv-card c1">
                <div class="deliv-num">LIVRABLE 01</div>
                <div class="deliv-title">Promesse commerciale</div>
                <div class="deliv-desc">Votre positionnement en une phrase, ancr&eacute; dans votre ville et votre persona. Plus un angle diff&eacute;renciateur et 3 accroches pr&ecirc;tes &agrave; l'emploi.</div>
                <div class="deliv-items">
                    <div class="deliv-item">Promesse au format "J'aide [persona] &agrave; [r&eacute;sultat] gr&acirc;ce &agrave; [m&eacute;thode]"</div>
                    <div class="deliv-item">1 angle diff&eacute;renciateur m&eacute;morable</div>
                    <div class="deliv-item">3 messages cl&eacute;s pour votre site et vos r&eacute;seaux</div>
                    <div class="deliv-item">Nom de votre offre signature</div>
                </div>
            </div>
            <div class="deliv-card c2">
                <div class="deliv-num">LIVRABLE 02</div>
                <div class="deliv-title">Plan SEO local</div>
                <div class="deliv-desc">10 mots-cl&eacute;s locaux prioritaires + les 3 premiers articles piliers &agrave; cr&eacute;er, avec leur structure compl&egrave;te et leur niveau de conscience cibl&eacute;.</div>
                <div class="deliv-items">
                    <div class="deliv-item">10 mots-cl&eacute;s avec intention et niveau de concurrence</div>
                    <div class="deliv-item">3 articles piliers : titre SEO, H2, meta description</div>
                    <div class="deliv-item">Calendrier de publication sur 3 mois</div>
                    <div class="deliv-item">Architecture en silos adapt&eacute;e &agrave; votre zone</div>
                </div>
            </div>
            <div class="deliv-card c3">
                <div class="deliv-num">LIVRABLE 03</div>
                <div class="deliv-title">Plan de campagnes</div>
                <div class="deliv-desc">Votre plan Meta Ads et Google Ads avec les accroches, les audiences, le budget recommand&eacute; et les KPIs &agrave; suivre chaque semaine.</div>
                <div class="deliv-items">
                    <div class="deliv-item">R&eacute;partition budget Meta / Google / Retargeting</div>
                    <div class="deliv-item">2 accroches publicitaires pr&ecirc;tes &agrave; publier</div>
                    <div class="deliv-item">KPIs cibles : CPL, CTR, taux de conversion</div>
                    <div class="deliv-item">Calendrier des 30 premiers jours</div>
                </div>
            </div>
            <div class="deliv-card c4">
                <div class="deliv-num">LIVRABLE 04</div>
                <div class="deliv-title">S&eacute;quence email / SMS</div>
                <div class="deliv-desc">5 messages de relance automatique de J+0 &agrave; J+30, r&eacute;dig&eacute;s et adapt&eacute;s &agrave; votre persona et votre ville. Pr&ecirc;ts &agrave; charger dans votre CRM.</div>
                <div class="deliv-items">
                    <div class="deliv-item">Email de bienvenue J+0 (envoi imm&eacute;diat)</div>
                    <div class="deliv-item">SMS de relance J+1 (160 caract&egrave;res)</div>
                    <div class="deliv-item">Emails J+3 et J+7 avec donn&eacute;es march&eacute; local</div>
                    <div class="deliv-item">Relances J+15 et J+30 entretien relation</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- COMMENT CA MARCHE -->
<section class="ai-section bg-white">
    <div class="container">
        <div style="text-align:center; margin-bottom:52px;">
            <span class="section-tag green">Comment &ccedil;a marche</span>
            <div class="section-title" style="max-width:500px; margin:0 auto 14px;">4 &eacute;tapes. 5 minutes. Une strat&eacute;gie compl&egrave;te.</div>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-title">Votre profil</div>
                <div class="step-desc">Statut, ville, type de clients cibles. 3 questions pour personnaliser toute la suite.</div>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-title">Votre persona</div>
                <div class="step-desc">Vendeur senior, primo-acc&eacute;dant, investisseur &mdash; le Coach active les bonnes m&eacute;thodes NeuroPersona.</div>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <div class="step-title">Vos livrables</div>
                <div class="step-desc">Promesse, SEO, campagne, s&eacute;quences. G&eacute;n&eacute;r&eacute;s automatiquement, ancr&eacute;s dans votre ville r&eacute;elle.</div>
            </div>
            <div class="step-card">
                <div class="step-num">4</div>
                <div class="step-title">Installation compl&egrave;te</div>
                <div class="step-desc">Int&eacute;ress&eacute; par la suite ? On v&eacute;rifie votre ville et on installe les 43 modules sur votre serveur.</div>
            </div>
        </div>
        <div style="text-align:center; margin-top:44px;">
            <a href="https://assistant.ecosystemeimmo.fr" target="_blank" class="btn-ai-primary" style="padding:15px 32px; font-size:1rem;">🤖 Lancer le Coach IA maintenant</a>
        </div>
    </div>
</section>

<!-- AVANT APRES -->
<section class="ai-section bg-light">
    <div class="container">
        <div style="text-align:center; margin-bottom:48px;">
            <span class="section-tag gold">Avant / Apr&egrave;s</span>
            <div class="section-title" style="max-width:500px; margin:0 auto;">La diff&eacute;rence concr&egrave;te</div>
        </div>
        <div class="diff-grid">
            <div class="diff-col before">
                <div class="diff-col-title"><span>&times;</span> Sans le Coach IA</div>
                <div class="diff-item"><span>&mdash;</span> Des heures &agrave; chercher quoi &eacute;crire sur votre zone</div>
                <div class="diff-item"><span>&mdash;</span> Des messages g&eacute;n&eacute;riques qui ne parlent &agrave; personne</div>
                <div class="diff-item"><span>&mdash;</span> Pas de strat&eacute;gie SEO locale structur&eacute;e</div>
                <div class="diff-item"><span>&mdash;</span> Des campagnes Ads lanc&eacute;es au hasard</div>
                <div class="diff-item"><span>&mdash;</span> Des relances manuelles ou inexistantes</div>
                <div class="diff-item"><span>&mdash;</span> Un positionnement flou impossible &agrave; expliquer</div>
            </div>
            <div class="diff-col after">
                <div class="diff-col-title"><span style="color:var(--green)">✓</span> Avec le Coach IA Pro</div>
                <div class="diff-item"><span style="color:var(--green)">✓</span> Votre promesse commerciale r&eacute;dig&eacute;e en 3 minutes</div>
                <div class="diff-item"><span style="color:var(--green)">✓</span> Messages adapt&eacute;s &agrave; votre persona et sa motivation r&eacute;elle</div>
                <div class="diff-item"><span style="color:var(--green)">✓</span> 10 mots-cl&eacute;s locaux + 3 articles piliers planifi&eacute;s</div>
                <div class="diff-item"><span style="color:var(--green)">✓</span> Accroches Meta Ads pr&ecirc;tes &agrave; copier-coller</div>
                <div class="diff-item"><span style="color:var(--green)">✓</span> S&eacute;quence J+0 &agrave; J+30 automatis&eacute;e dans votre CRM</div>
                <div class="diff-item"><span style="color:var(--green)">✓</span> Un positionnement clair que tout le monde comprend</div>
            </div>
        </div>
    </div>
</section>

<!-- INTEGRATION -->
<section class="ai-section bg-white">
    <div class="container">
        <div style="text-align:center; margin-bottom:48px;">
            <span class="section-tag violet">Int&eacute;gration compl&egrave;te</span>
            <div class="section-title" style="max-width:600px; margin:0 auto 14px;">Le Coach IA est le point d'entr&eacute;e de votre &eacute;cosyst&egrave;me complet</div>
            <p class="section-sub" style="margin:0 auto; text-align:center;">Les strat&eacute;gies g&eacute;n&eacute;r&eacute;es s'appliquent directement dans les 43 modules install&eacute;s sur votre serveur.</p>
        </div>
        <div class="integration-flow">
            <div class="int-box"><div class="icon">🤖</div><div class="lbl">Coach IA Pro</div><div class="sub">Strat&eacute;gie en 5 min</div></div>
            <div class="int-arrow">&rarr;</div>
            <div class="int-box"><div class="icon">🌐</div><div class="lbl">Site SEO</div><div class="sub">Articles + pages locales</div></div>
            <div class="int-arrow">&rarr;</div>
            <div class="int-box highlight"><div class="icon" style="font-size:1.8rem;margin-bottom:8px;">⚡</div><div class="lbl">CRM Int&eacute;gr&eacute;</div><div class="sub">Leads + s&eacute;quences auto</div></div>
            <div class="int-arrow">&rarr;</div>
            <div class="int-box"><div class="icon">📊</div><div class="lbl">Trafic &amp; Ads</div><div class="sub">Campagnes locales</div></div>
            <div class="int-arrow">&rarr;</div>
            <div class="int-box"><div class="icon">🏠</div><div class="lbl">Mandats</div><div class="sub">Exclusifs &amp; pr&eacute;visibles</div></div>
        </div>
        <div style="margin-top:36px; padding:24px 32px; background:#f0f4ff; border-radius:var(--radius); display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:240px;">
                <p style="font-family:'Poppins',sans-serif; font-weight:700; font-size:1rem; color:var(--text); margin:0 0 6px;">Install&eacute; sur votre serveur. Vos donn&eacute;es vous appartiennent.</p>
                <p style="font-family:'Inter',sans-serif; font-size:0.88rem; color:var(--muted); margin:0; line-height:1.6;">Contrairement aux SaaS, &Eacute;cosyst&egrave;me Immo LOCAL+ est d&eacute;ploy&eacute; chez vous. Votre site, vos leads, votre contenu &mdash; ils sont &agrave; vous, pour toujours. Exclusivit&eacute; territoriale 50km garantie.</p>
            </div>
            <a href="/front/pages/verifier-ma-ville.php" style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;padding:13px 24px;border-radius:10px;text-decoration:none;font-family:'Inter',sans-serif;font-weight:600;font-size:0.93rem;white-space:nowrap;">📍 V&eacute;rifier ma ville &rarr;</a>
        </div>
    </div>
</section>

<!-- TEMOIGNAGES -->
<section class="ai-section bg-light">
    <div class="container" style="max-width:760px;">
        <div style="text-align:center; margin-bottom:36px;">
            <span class="section-tag green">Ils l'utilisent d&eacute;j&agrave;</span>
            <div class="section-title" style="max-width:480px; margin:0 auto;">Ce que disent les b&ecirc;ta testeurs</div>
        </div>
        <div class="testi-strip">
            <div class="testi-avatar">MR</div>
            <div>
                <p class="testi-text">&laquo;&nbsp;J'avais d&eacute;j&agrave; essay&eacute; plusieurs outils marketing. Le probl&egrave;me n'&eacute;tait pas l'outil &mdash; c'&eacute;tait que je ne savais pas quoi en faire. Avec le Coach IA, j'ai compris comment structurer mon marketing&nbsp;: Persona &rarr; Contenu &rarr; Trafic. En 10 minutes, j'avais ma promesse commerciale et mes premiers mots-cl&eacute;s pour ma zone.&nbsp;&raquo;</p>
                <div class="testi-meta"><strong>Marie R.</strong> &mdash; Conseill&egrave;re immobili&egrave;re, Occitanie &mdash; Mandataire ind&eacute;pendante <span style="color:#f59e0b; margin-left:8px;">&#9733;&#9733;&#9733;&#9733;&#9733;</span></div>
            </div>
        </div>
        <div class="testi-strip">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#10b981,#059669);">ED</div>
            <div>
                <p class="testi-text">&laquo;&nbsp;La plupart des plateformes gardent toutes les donn&eacute;es chez elles. Ici, le syst&egrave;me est install&eacute; sur mon propre h&eacute;bergement. Mon site, mes articles et mes leads m'appartiennent vraiment. Le Coach IA m'a aid&eacute; &agrave; structurer ma strat&eacute;gie d&egrave;s le premier jour.&nbsp;&raquo;</p>
                <div class="testi-meta"><strong>Eduardo D.</strong> &mdash; Agent immobilier, Nouvelle-Aquitaine &mdash; Agence ind&eacute;pendante <span style="color:#f59e0b; margin-left:8px;">&#9733;&#9733;&#9733;&#9733;&#9733;</span></div>
            </div>
        </div>
        <div style="text-align:center; margin-top:8px;">
            <a href="/front/pages/temoignages.php" style="font-family:'Inter',sans-serif; font-size:0.9rem; color:var(--violet); text-decoration:none; font-weight:600;">Voir tous les t&eacute;moignages &rarr;</a>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="ai-cta-final">
    <div class="container">
        <h2>Testez le Coach IA maintenant.<br>Gratuit, sans inscription.</h2>
        <p>Obtenez votre strat&eacute;gie compl&egrave;te en 5 minutes.<br>Si votre ville est disponible, on installe le syst&egrave;me complet sur votre serveur.</p>
        <div>
            <a href="https://assistant.ecosystemeimmo.fr" target="_blank" class="btn-white">🤖 D&eacute;marrer avec le Coach IA</a>
            <a href="/front/pages/verifier-ma-ville.php" class="btn-outline-final">📍 V&eacute;rifier ma ville</a>
        </div>
        <p style="margin-top:24px; font-size:0.82rem; opacity:0.65;">Aucun compte requis &middot; R&eacute;sultats instantan&eacute;s &middot; 4 places b&ecirc;ta restantes</p>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>