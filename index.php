<?php
$pageTitle = "L'&eacute;cosyst&egrave;me digital que vos concurrents ne pourront jamais avoir";
$pageDescription = '&Eacute;COSYST&Egrave;ME IMMO LOCAL+ : la plateforme tout-en-un pour les pros immobiliers avec exclusivit&eacute; territoriale garantie. Site, SEO, CRM, IA et m&eacute;thode guid&eacute;e.';
$currentPage = 'accueil';

include 'includes/header.php';
?>

<style>
@keyframes pdot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

.pi-badge {
    display: inline-flex; align-items: center; gap: 8px;
    border-radius: 30px; padding: 6px 18px;
    font-size: 0.84rem; font-weight: 600; letter-spacing: 0.02em;
    margin-bottom: 22px;
}
.pi-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.pi-section-badge {
    display: inline-block; padding: 6px 16px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    margin-bottom: 14px;
}

.pi-card {
    background: white; border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
}
.pi-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.13); }

.pi-flow-step {
    display: flex; align-items: center; gap: 0;
    justify-content: center; flex-wrap: wrap; gap: 0;
}
.pi-flow-box {
    background: white; border-radius: 10px;
    border: 1px solid #e9ecf5;
    padding: 14px 22px; text-align: center;
    font-size: 0.9rem; font-weight: 600; color: #2d3748;
    white-space: nowrap;
}
.pi-flow-arrow {
    font-size: 1.4rem; color: #667eea; padding: 0 8px; flex-shrink: 0;
}
</style>

<!-- ═══════════ HERO ═══════════ -->
<section style="padding: 100px 0 90px; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div style="color:white; max-width:760px; margin:0 auto; animation: fadeUp 0.7s ease both;">

            <div class="pi-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
                <span class="pi-pulse" style="background:#FDCB6E;"></span>
                1 licence par ville &mdash; places limit&eacute;es
            </div>

            <h1 style="font-size:2.9rem; font-weight:800; line-height:1.2; margin-bottom:22px; color:white;">
                L'&eacute;cosyst&egrave;me digital que vos concurrents ne pourront jamais avoir
            </h1>

            <p style="font-size:1.18rem; opacity:0.95; line-height:1.75; margin-bottom:14px;">
                Site immobilier + SEO local + CRM + automatisations + IA.<br>
                <strong>Un syst&egrave;me complet con&ccedil;u pour attirer des vendeurs automatiquement.</strong>
            </p>

            <p style="font-size:1.05rem; opacity:0.9; margin-bottom:40px; line-height:1.7;">
                Et surtout : <strong>&#128737; une seule licence par ville.</strong><br>
                Si un concurrent r&eacute;serve votre zone avant vous, l'acc&egrave;s sera d&eacute;finitivement ferm&eacute;.
            </p>

            <div style="display:flex; gap:15px; justify-content:center; flex-wrap:wrap; margin-bottom:28px;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:15px 32px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18); transition:transform 0.2s;">
                    &#128205; V&eacute;rifier si ma ville est disponible
                </a>
                <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:13px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:background 0.2s;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>

            <p style="font-size:0.88rem; opacity:0.72; margin:0;">
                &#9989; Beta test actif &nbsp;&bull;&nbsp; &#9989; Z&eacute;ro engagement &nbsp;&bull;&nbsp; &#9989; Exclusivit&eacute; territoriale garantie
            </p>
        </div>
    </div>
</section>

<!-- ═══════════ PROBLÈME ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;">
    <div class="container">
        <div style="text-align:center; margin-bottom:55px;">
            <span class="pi-section-badge" style="background:#fee2e2; color:#991b1b;">&#128544; Le Probl&egrave;me</span>
            <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">Si vous &ecirc;tes agent ou mandataire,<br>vous vivez probablement &ccedil;a</h2>
        </div>

        <div style="max-width:760px; margin:0 auto; display:grid; gap:14px;">

            <?php
            $problems = [
                ['&#128295;', 'Trop d\'outils, pas de syst&egrave;me',
                 'Un CRM, un site, des emails, des r&eacute;seaux sociaux&hellip; Mais rien n\'est r&eacute;ellement connect&eacute;. R&eacute;sultat&nbsp;: vous passez votre temps &agrave; copier-coller entre les outils.'],
                ['&#128123;', 'Invisible sur Google',
                 'Votre site existe. Mais quand un vendeur tape &laquo;&nbsp;Estimer maison + votre ville&nbsp;&raquo;, vous n\'apparaissez pas.'],
                ['&#128184;', 'D&eacute;pendance aux portails et &agrave; la pub',
                 'SeLoger. LeBonCoin. Facebook Ads. Vous payez pour exister. Coupez la pub et les leads disparaissent.'],
                ['&#9203;', 'Pas le temps de faire du marketing',
                 'Entre les visites, les estimations, les relances et les compromis&nbsp;: le marketing digital devient impossible &agrave; g&eacute;rer seul.'],
            ];
            foreach ($problems as $p):
            ?>
            <div class="pi-card" style="display:flex; align-items:flex-start; gap:16px; padding:22px; border-left:4px solid #667eea;">
                <span style="font-size:1.7rem; flex-shrink:0;"><?= $p[0] ?></span>
                <div>
                    <strong style="color:#1a202c; display:block; margin-bottom:5px;"><?= $p[1] ?></strong>
                    <p style="color:#718096; margin:0; font-size:0.94rem; line-height:1.6;"><?= $p[2] ?></p>
                </div>
            </div>
            <?php endforeach; ?>

        </div>

        <div style="text-align:center; margin-top:44px; padding:28px 36px; background:white; border-radius:14px; box-shadow:0 2px 14px rgba(102,126,234,0.1); max-width:620px; margin-left:auto; margin-right:auto;">
            <p style="font-size:1.1rem; color:#1a202c; margin:0; line-height:1.85;">
                &#128073; Le probl&egrave;me n'est pas votre <strong>motivation</strong>.<br>
                &#128073; C'est l'absence d'un <strong>syst&egrave;me qui travaille pour vous</strong>.
            </p>
        </div>
    </div>
</section>

<!-- ═══════════ DÉCLIC ═══════════ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:50px;">
            <span class="pi-section-badge" style="background:#fef3c7; color:#92400e;">&#128161; Le D&eacute;clic</span>
            <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">Les outils sans m&eacute;thode ne servent &agrave; rien</h2>
        </div>

        <div style="max-width:680px; margin:0 auto; text-align:center; margin-bottom:44px;">
            <p style="font-size:1.15rem; color:#4a5568; line-height:1.85; margin-bottom:20px;">
                Vous pouvez avoir&nbsp;: le meilleur CRM, un beau site, des campagnes publicitaires.<br>
                Mais si vous ne savez pas <strong>&agrave; qui parler</strong>, <strong>quoi dire</strong> et <strong>o&ugrave; le diffuser</strong>&hellip;
            </p>
            <p style="font-size:1.25rem; color:#1a202c; font-weight:700; margin:0;">
                &hellip;vous avez simplement un outil de plus qui prend la poussi&egrave;re.
            </p>
        </div>

        <div style="padding:28px 32px; background:#f7fafc; border-left:4px solid #667eea; border-radius:0 12px 12px 0; max-width:640px; margin:0 auto;">
            <p style="color:#2d3748; margin:0; font-style:italic; font-size:1.05rem; line-height:1.7;">
                &laquo;&nbsp;La diff&eacute;rence entre un ind&eacute;pendant qui gal&egrave;re et un ind&eacute;pendant qui cartonne&nbsp;? Ce n'est pas le talent. C'est le syst&egrave;me.&nbsp;&raquo;
            </p>
        </div>
    </div>
</section>

<!-- ═══════════ MÉTHODE ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;" id="methode">
    <div class="container">
        <div style="text-align:center; margin-bottom:60px;">
            <span class="pi-section-badge" style="background:#dbeafe; color:#1e40af;">&#129517; La M&eacute;thode</span>
            <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:12px;">3 leviers pour attirer vos vendeurs</h2>
            <p style="font-size:1.05rem; color:#718096; margin:0;">Sans pub, sans portails, sans d&eacute;pendance</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(270px,1fr)); gap:24px; max-width:920px; margin:0 auto 50px;">
            <?php
            $steps = [
                ['&#128100;', '1 &mdash; PERSONA', 'Comprendre vos vendeurs',
                 'Qui sont-ils&nbsp;? vendeurs seniors, familles qui d&eacute;m&eacute;nagent, investisseurs&hellip; L\'assistant IA identifie leurs motivations, leurs blocages et leurs objections.'],
                ['&#9999;&#65039;', '2 &mdash; CONTENU', 'Savoir quoi leur dire',
                 'L\'IA g&eacute;n&egrave;re automatiquement&nbsp;: articles SEO, posts r&eacute;seaux, emails, guides vendeurs. Chaque contenu correspond &agrave; une &eacute;tape du parcours vendeur.'],
                ['&#128225;', '3 &mdash; TRAFIC', 'Les atteindre au bon endroit',
                 'Vos contenus sont diffus&eacute;s sur Google, votre blog, votre fiche Google, vos r&eacute;seaux. Objectif&nbsp;: attirer des vendeurs avant m&ecirc;me qu\'ils contactent un agent.'],
            ];
            foreach ($steps as $s):
            ?>
            <div class="pi-card" style="padding:32px; text-align:center;">
                <div style="font-size:2.4rem; margin-bottom:14px;"><?= $s[0] ?></div>
                <h3 style="color:#1a202c; margin-bottom:8px; font-size:1.1rem; letter-spacing:0.04em;"><?= $s[1] ?></h3>
                <p style="color:#667eea; font-weight:600; margin-bottom:12px; font-size:0.95rem;"><?= $s[2] ?></p>
                <p style="color:#718096; margin:0; font-size:0.91rem; line-height:1.6;"><?= $s[3] ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Flux mandat -->
        <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); max-width:860px; margin:0 auto; padding:36px; text-align:center;">
            <p style="font-size:0.88rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:22px;">&#9881;&#65039; Comment le syst&egrave;me g&eacute;n&egrave;re des mandats</p>
            <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0;">
                <?php
                $flow = ['Recherche Google','Article local','Estimation','Lead CRM','RDV vendeur','Mandat sign&eacute;'];
                foreach ($flow as $i => $f):
                ?>
                <div class="pi-flow-box"><?= $f ?></div>
                <?php if ($i < count($flow)-1): ?>
                <span class="pi-flow-arrow">&#8594;</span>
                <?php endif; endforeach; ?>
            </div>
            <p style="margin-top:18px; font-size:0.88rem; color:#718096; margin-bottom:0;">Le syst&egrave;me travaille 24h/24, m&ecirc;me quand vous &ecirc;tes en visite.</p>
        </div>

        <!-- SaaS vs Écosystème -->
        <div style="padding:28px; background:white; border-radius:14px; box-shadow:0 4px 18px rgba(0,0,0,0.07); max-width:620px; margin:30px auto 0; text-align:center;">
            <p style="font-size:0.9rem; font-weight:700; color:#1a202c; margin-bottom:18px; text-transform:uppercase; letter-spacing:0.05em;">La vraie diff&eacute;rence</p>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div style="padding:18px; background:#fee2e2; border-radius:10px;">
                    <strong style="color:#991b1b; display:block; margin-bottom:6px;">&#10060; SaaS classiques</strong>
                    <p style="color:#b91c1c; margin:0; font-size:0.87rem;">&laquo;&nbsp;Voici les outils, d&eacute;brouille-toi&nbsp;&raquo;</p>
                </div>
                <div style="padding:18px; background:#d1fae5; border-radius:10px;">
                    <strong style="color:#065f46; display:block; margin-bottom:6px;">&#10003; &Eacute;COSYST&Egrave;ME IMMO</strong>
                    <p style="color:#047857; margin:0; font-size:0.87rem;">&laquo;&nbsp;Voici la m&eacute;thode + les outils&nbsp;&raquo;</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ MODULES ═══════════ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:60px;">
            <span class="pi-section-badge" style="background:#e9d5ff; color:#6b21a8;">&#129520; La Plateforme</span>
            <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:12px;">Une plateforme compl&egrave;te &mdash; tout est int&eacute;gr&eacute;</h2>
            <p style="font-size:1.05rem; color:#718096; margin:0;">Pas besoin d'empiler les outils. Tout est connect&eacute;.</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(255px,1fr)); gap:18px; max-width:1040px; margin:0 auto;">
            <?php
            $modules = [
                ['&#127760;', 'Site immobilier professionnel', 'Pages g&eacute;olocalis&eacute;es optimis&eacute;es pour Google.'],
                ['&#128221;', 'Blog SEO local', 'Articles con&ccedil;us pour attirer les vendeurs de votre secteur.'],
                ['&#127919;', 'Pages de capture', 'Landing pages illimit&eacute;es, templates optimis&eacute;s, suivi conversions.'],
                ['&#128203;', 'CRM immobilier', 'Suivi des contacts, leads, mandats. Pipeline complet.'],
                ['&#9889;', 'Automatisations', 'Emails, SMS et relances automatiques. Le syst&egrave;me tourne 24/7.'],
                ['&#129302;', 'Assistant IA', 'G&eacute;n&eacute;ration instantan&eacute;e de contenus, emails, posts, descriptions.'],
                ['&#128202;', 'Dashboard temps r&eacute;el', 'Leads, RDV, mandats, commissions en un coup d\'&#339;il.'],
                ['&#127968;', 'Estimateur en ligne', 'Un outil qui capture des vendeurs 24h/24 sur votre site.'],
                ['&#128205;', 'GMB int&eacute;gr&eacute;', 'Fiche Google optimis&eacute;e, avis, publications pilot&eacute;es depuis la plateforme.'],
            ];
            foreach ($modules as $m):
            ?>
            <div class="pi-card" style="padding:22px; border-left:4px solid #667eea;">
                <div style="font-size:1.7rem; margin-bottom:9px;"><?= $m[0] ?></div>
                <strong style="color:#1a202c; font-size:0.97rem;"><?= $m[1] ?></strong>
                <p style="color:#718096; margin:7px 0 0; font-size:0.88rem; line-height:1.5;"><?= $m[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════ EXCLUSIVITÉ ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;">
    <div class="container">
        <div style="text-align:center; margin-bottom:55px;">
            <span class="pi-section-badge" style="background:#fce7f3; color:#be123c;">&#127942; L'Exclusivit&eacute;</span>
            <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">L'avantage que personne ne peut copier</h2>
        </div>

        <div style="max-width:760px; margin:0 auto;">

            <div style="text-align:center; margin-bottom:36px; padding:30px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:16px;">
                <p style="font-size:1.45rem; color:white; font-weight:700; margin:0; line-height:1.4;">
                    1 ville = 1 seul partenaire &Eacute;COSYST&Egrave;ME IMMO
                </p>
            </div>

            <div style="display:grid; gap:16px; margin-bottom:36px;">
                <?php
                $excl = [
                    ['&#128737;&#65039;', 'Aucune concurrence interne',
                     'Votre concurrent local ne peut pas utiliser le m&ecirc;me syst&egrave;me que vous.'],
                    ['&#128200;', 'SEO local prot&eacute;g&eacute;',
                     'Votre r&eacute;f&eacute;rencement ne sera jamais dilu&eacute; par d\'autres utilisateurs dans votre zone.'],
                    ['&#128142;', 'Investissement s&eacute;curis&eacute;',
                     'La position digitale que vous construisez vous appartient. Personne ne peut la dupliquer.'],
                ];
                foreach ($excl as $e):
                ?>
                <div class="pi-card" style="display:flex; align-items:flex-start; gap:16px; padding:22px; border-left:4px solid #667eea;">
                    <span style="font-size:1.6rem; flex-shrink:0;"><?= $e[0] ?></span>
                    <div>
                        <strong style="color:#1a202c; display:block; margin-bottom:5px;"><?= $e[1] ?></strong>
                        <p style="color:#718096; margin:0; font-size:0.93rem; line-height:1.6;"><?= $e[2] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="padding:24px 28px; background:white; border-left:4px solid #667eea; border-radius:0 12px 12px 0; margin-bottom:24px;">
                <p style="color:#2d3748; margin:0; font-style:italic; font-size:1.0rem; line-height:1.7;">
                    &laquo;&nbsp;Les SaaS classiques veulent 10 000 clients. Nous sommes limit&eacute;s &agrave; ~500 zones. C'est ce qui garantit que le syst&egrave;me fonctionne <strong>pour vous</strong>.&nbsp;&raquo;
                </p>
            </div>

            <div style="text-align:center; padding:18px 24px; background:#fee2e2; border-radius:12px; border:1px solid #fecaca;">
                <p style="color:#991b1b; margin:0; font-weight:600; font-size:0.94rem;">
                    &#9888;&#65039; Villes d&eacute;j&agrave; r&eacute;serv&eacute;es&nbsp;: Bordeaux &mdash; Nantes &mdash; Nandy &mdash; Aix-en-Provence &mdash; Lannion<br>
                    <span style="font-weight:400; font-size:0.88rem;">Une fois r&eacute;serv&eacute;e, une ville est d&eacute;finitivement verrouill&eacute;e.</span>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ RÉSULTATS ═══════════ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:55px;">
            <span class="pi-section-badge" style="background:#c7d2fe; color:#3730a3;">&#128640; Ce que &ccedil;a change</span>
            <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">Ce que &ccedil;a change pour vous</h2>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(270px,1fr)); gap:18px; max-width:920px; margin:0 auto;">
            <?php
            $results = [
                ['&#129392;', 'Attirer sans prospecter', 'Les vendeurs viennent &agrave; vous gr&acirc;ce &agrave; votre pr&eacute;sence digitale.'],
                ['&#128184;', 'R&eacute;duire la d&eacute;pendance aux portails', 'Le SEO et le contenu travaillent en continu, sans budget pub.'],
                ['&#9203;&#65039;', 'Gagner du temps', 'Les automatisations et l\'IA g&egrave;rent le marketing r&eacute;p&eacute;titif.'],
                ['&#128081;', 'Devenir la r&eacute;f&eacute;rence locale', 'Votre nom devient associ&eacute; &agrave; l\'immobilier dans votre secteur.'],
                ['&#127919;', 'Prospects qualifi&eacute;s', 'Les tunnels filtrent&nbsp;: vous ne parlez qu\'aux pr&ecirc;ts &agrave; vendre.'],
                ['&#128737;&#65039;', 'Position prot&eacute;g&eacute;e', 'L\'exclusivit&eacute; garantit que vous restez seul sur votre zone.'],
            ];
            foreach ($results as $r):
            ?>
            <div class="pi-card" style="padding:26px; text-align:center;">
                <div style="font-size:1.8rem; margin-bottom:10px;"><?= $r[0] ?></div>
                <strong style="color:#1a202c; font-size:0.97rem;"><?= $r[1] ?></strong>
                <p style="color:#718096; margin:8px 0 0; font-size:0.88rem; line-height:1.55;"><?= $r[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════ CTA FINAL ═══════════ -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
    <div class="container">
        <div style="max-width:640px; margin:0 auto;">
            <div class="pi-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
                <span class="pi-pulse" style="background:#FDCB6E;"></span>
                V&eacute;rifiez avant qu'un concurrent ne r&eacute;serve
            </div>
            <h2 style="font-size:2.2rem; color:white; margin-bottom:16px; font-weight:800;">
                Votre ville est-elle encore disponible&nbsp;?
            </h2>
            <p style="font-size:1.1rem; opacity:0.95; margin-bottom:36px; line-height:1.7;">
                Chaque ville ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul professionnel.<br>
                Une fois r&eacute;serv&eacute;e, l'acc&egrave;s est d&eacute;finitivement ferm&eacute;.
            </p>
            <div style="display:flex; justify-content:center; gap:15px; flex-wrap:wrap;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:15px 34px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.2); transition:transform 0.2s;">
                    &#128205; V&eacute;rifier ma ville maintenant
                </a>
                <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:13px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>