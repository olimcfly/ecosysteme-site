<?php
$pageTitle = "La Plateforme &mdash; Un &eacute;cosyst&egrave;me complet pour attirer et g&eacute;rer vos vendeurs";
$pageDescription = '&Eacute;COSYST&Egrave;ME IMMO LOCAL+ : 40+ modules int&eacute;gr&eacute;s pour les pros de l\'immobilier. Site SEO, CRM, IA, automatisations, estimateur &mdash; tout centralis&eacute;.';
$currentPage = 'plateforme';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes pdot   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }

.plt-badge {
    display: inline-flex; align-items: center; gap: 8px;
    border-radius: 30px; padding: 6px 18px;
    font-size: 0.84rem; font-weight: 600; margin-bottom: 22px;
}
.plt-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.plt-section-badge {
    display: inline-block; padding: 6px 16px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    margin-bottom: 14px;
}

.plt-card {
    background: white; border-radius: 14px;
    box-shadow: 0 3px 16px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
}
.plt-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,0.13); }

.plt-module {
    background: white; border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 36px; border-left: 5px solid #667eea;
}

.plt-feature {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 0; border-bottom: 1px solid #f0f4ff;
    font-size: 0.91rem; color: #2d3748;
}
.plt-feature:last-child { border-bottom: none; padding-bottom: 0; }
.plt-feature span { color: #667eea; flex-shrink: 0; }

.plt-flow-box {
    background: white; border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 20px; font-size: 0.89rem;
    font-weight: 600; color: #2d3748; white-space: nowrap;
}
.plt-flow-arr { font-size:1.3rem; color:#667eea; padding:0 6px; flex-shrink:0; }

.ville-tag {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fee2e2; color: #991b1b;
    border: 1px solid #fecaca;
    padding: 5px 13px; border-radius: 20px;
    font-size: 0.86rem; font-weight: 600;
}
</style>

<!-- ═══ HERO ═══ -->
<section style="padding:95px 0 80px; text-align:center; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
    <div class="container">
        <div style="color:white; max-width:760px; margin:0 auto; animation:fadeUp 0.6s ease both;">

            <div class="plt-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
                <span class="plt-pulse" style="background:#FDCB6E;"></span>
                40+ modules &mdash; tout int&eacute;gr&eacute;
            </div>

            <h1 style="font-size:2.7rem; font-weight:800; line-height:1.2; color:white; margin-bottom:20px;">
                Un &eacute;cosyst&egrave;me complet pour attirer, convertir et g&eacute;rer vos vendeurs
            </h1>

            <p style="font-size:1.12rem; opacity:0.95; line-height:1.8; margin-bottom:14px;">
                &Eacute;COSYST&Egrave;ME IMMO rassemble tout dans <strong>une seule plateforme</strong>.<br>
                Vos leads, vos contenus, vos statistiques et vos actions marketing centralis&eacute;s.
            </p>

            <p style="font-size:1.02rem; opacity:0.88; margin-bottom:40px;">
                100% con&ccedil;u pour les professionnels de l'immobilier &mdash; pas un template g&eacute;n&eacute;rique.
            </p>

            <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:14px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
                    &#128205; V&eacute;rifier si ma ville est disponible
                </a>
                <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:12px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══ PROBLÈME OUTILS SÉPARÉS ═══ -->
<section style="padding:90px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:820px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:50px;">
                <span class="plt-section-badge" style="background:#fee2e2; color:#991b1b;">&#128295; Le probl&egrave;me</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Des outils qui fonctionnent s&eacute;par&eacute;ment</h2>
                <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin:0;">
                    La plupart des agents utilisent d&eacute;j&agrave; un site, un CRM, un emailing, des publicit&eacute;s, des r&eacute;seaux sociaux&hellip;<br>
                    Mais rien n'est connect&eacute;.
                </p>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div style="padding:26px; background:white; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.06); border-top:3px solid #e2e8f0;">
                    <p style="font-size:0.84rem; font-weight:700; color:#a0aec0; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:14px;">Outils s&eacute;par&eacute;s</p>
                    <?php foreach (['Perte de temps','Donn&eacute;es dispers&eacute;es','Marketing difficile &agrave; g&eacute;rer'] as $r): ?>
                    <div style="display:flex; align-items:center; gap:9px; padding:9px 0; border-bottom:1px solid #f7fafc; font-size:0.9rem; color:#991b1b;">
                        <span>&#10060;</span> <?= $r ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div style="padding:26px; background:white; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.06); border-top:3px solid #667eea;">
                    <p style="font-size:0.84rem; font-weight:700; color:#667eea; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:14px;">&Eacute;cosyst&egrave;me Immo</p>
                    <?php foreach (['Tout centralis&eacute;','Donn&eacute;es connect&eacute;es','Marketing automatis&eacute;'] as $r): ?>
                    <div style="display:flex; align-items:center; gap:9px; padding:9px 0; border-bottom:1px solid #f7fafc; font-size:0.9rem; color:#065f46;">
                        <span>&#10003;</span> <?= $r ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ VUE D'ENSEMBLE MODULES ═══ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:55px;">
            <span class="plt-section-badge" style="background:#e9d5ff; color:#6b21a8;">&#129520; La plateforme</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:12px;">40+ modules int&eacute;gr&eacute;s</h2>
            <p style="font-size:1.02rem; color:#718096; margin:0;">Tout con&ccedil;u sp&eacute;cifiquement pour le m&eacute;tier immobilier.</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:14px; max-width:1000px; margin:0 auto;">
            <?php
            $apercu = [
                ['&#127760;', 'Site immobilier SEO'],
                ['&#9999;&#65039;', 'Blog SEO local'],
                ['&#127919;', 'CRM immobilier'],
                ['&#9889;', 'Automatisations'],
                ['&#129302;', 'Assistant IA'],
                ['&#127968;', 'Estimateur en ligne'],
                ['&#128202;', 'Tableau de bord'],
                ['&#127988;', 'Pages de capture'],
            ];
            foreach ($apercu as $a):
            ?>
            <div class="plt-card" style="padding:18px 20px; display:flex; align-items:center; gap:12px; border-left:3px solid #667eea;">
                <span style="font-size:1.4rem; flex-shrink:0;"><?= $a[0] ?></span>
                <span style="font-size:0.88rem; font-weight:600; color:#1a202c;"><?= $a[1] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ MODULES DÉTAILLÉS ═══ -->
<section style="padding:20px 0 90px;">
    <div class="container">
        <div style="max-width:960px; margin:0 auto; display:grid; gap:28px;">

            <?php
            $modules = [
                [
                    'icon' => '&#127760;',
                    'num'  => '01',
                    'titre'=> 'Site immobilier optimis&eacute; SEO',
                    'intro'=> 'Votre site devient un v&eacute;ritable outil d\'acquisition de vendeurs &mdash; pas seulement une vitrine.',
                    'cta'  => 'Il devient un moteur de visibilit&eacute; locale.',
                    'items'=> ['&Eacute;diteur visuel simple &agrave; utiliser','Pages g&eacute;olocalis&eacute;es par ville et quartier','Design professionnel','Optimisation SEO native','Navigation optimis&eacute;e mobile'],
                ],
                [
                    'icon' => '&#128221;',
                    'num'  => '02',
                    'titre'=> 'Blog SEO local',
                    'intro'=> 'Le contenu est la cl&eacute; pour appara&icirc;tre sur Google quand un vendeur cherche.',
                    'cta'  => 'Appara&icirc;tre sur "estimer maison + ville" et "prix immobilier + ville".',
                    'items'=> ['Blog immobilier int&eacute;gr&eacute;','Suggestions de sujets locaux','Optimisation SEO automatique','Assistant IA pour r&eacute;diger les articles'],
                ],
                [
                    'icon' => '&#128203;',
                    'num'  => '03',
                    'titre'=> 'CRM immobilier',
                    'intro'=> 'Tous vos contacts et leads centralis&eacute;s. Vous savez exactement o&ugrave; en est chaque prospect.',
                    'cta'  => 'Un pipeline clair, des donn&eacute;es exploitables.',
                    'items'=> ['Fiches contacts compl&egrave;tes','Historique des interactions','Pipeline commercial','Suivi des mandats','Segmentation des prospects'],
                ],
                [
                    'icon' => '&#127988;',
                    'num'  => '04',
                    'titre'=> 'Pages de capture',
                    'intro'=> 'Transformez vos visiteurs en prospects. Chaque formulaire envoie automatiquement les leads dans votre CRM.',
                    'cta'  => 'Z&eacute;ro lead perdu.',
                    'items'=> ['Demande d\'estimation','T&eacute;l&eacute;chargement de guides','Demande de rendez-vous'],
                ],
                [
                    'icon' => '&#9889;',
                    'num'  => '05',
                    'titre'=> 'Automatisations marketing',
                    'intro'=> 'Le syst&egrave;me travaille pendant que vous &ecirc;tes sur le terrain. Vos prospects restent en contact sans effort manuel.',
                    'cta'  => 'Le marketing tourne 24h/24.',
                    'items'=> ['Emails de suivi','Relances automatiques','Rappels de rendez-vous','Newsletters immobili&egrave;res'],
                ],
                [
                    'icon' => '&#129302;',
                    'num'  => '06',
                    'titre'=> 'Assistant IA immobilier',
                    'intro'=> 'Un assistant intelligent int&eacute;gr&eacute; &agrave; la plateforme. Tout est adapt&eacute; au march&eacute; immobilier et &agrave; votre zone.',
                    'cta'  => 'Du contenu professionnel en quelques clics.',
                    'items'=> ['Articles de blog','Descriptions de biens','Emails','Posts r&eacute;seaux sociaux'],
                ],
                [
                    'icon' => '&#127968;',
                    'num'  => '07',
                    'titre'=> 'Estimateur immobilier en ligne',
                    'intro'=> 'Un outil essentiel pour capter des vendeurs. Chaque estimation devient un prospect qualifi&eacute;.',
                    'cta'  => 'Le meilleur tunnel vendeur de votre site.',
                    'items'=> ['Tunnel d\'estimation multi-&eacute;tapes','G&eacute;n&eacute;ration automatique de leads','Rapport d\'estimation'],
                ],
                [
                    'icon' => '&#128202;',
                    'num'  => '08',
                    'titre'=> 'Tableau de bord &amp; statistiques',
                    'intro'=> 'Suivez vos performances en temps r&eacute;el. Pilotez votre activit&eacute; avec des donn&eacute;es concr&egrave;tes.',
                    'cta'  => 'Vous savez ce qui fonctionne.',
                    'items'=> ['Trafic de votre site','Sources de leads','Taux de conversion','Rendez-vous g&eacute;n&eacute;r&eacute;s'],
                ],
            ];

            foreach ($modules as $m):
            ?>
            <div class="plt-module">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="flex-shrink:0; text-align:center;">
                        <div style="width:58px; height:58px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.7rem; margin-bottom:6px;">
                            <?= $m['icon'] ?>
                        </div>
                        <span style="font-size:0.76rem; font-weight:700; color:#a0aec0; letter-spacing:0.1em;"><?= $m['num'] ?></span>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h3 style="font-size:1.35rem; color:#1a202c; margin-bottom:8px;"><?= $m['titre'] ?></h3>
                        <p style="color:#4a5568; font-size:0.96rem; line-height:1.75; margin-bottom:18px;"><?= $m['intro'] ?></p>
                        <div style="display:grid; gap:0; margin-bottom:16px;">
                            <?php foreach ($m['items'] as $feat): ?>
                            <div class="plt-feature">
                                <span>&#10003;</span>
                                <?= $feat ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div style="display:inline-flex; align-items:center; gap:7px; background:#f0f4ff; padding:9px 16px; border-radius:8px; font-size:0.87rem; font-weight:600; color:#667eea;">
                            &#128073; <?= $m['cta'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- ═══ SYSTÈME CONNECTÉ ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:860px; margin:0 auto; text-align:center;">
            <span class="plt-section-badge" style="background:#dbeafe; color:#1e40af;">&#128279; Tout est connect&eacute;</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:14px;">Un syst&egrave;me entier&agrave;ement reli&eacute;</h2>
            <p style="font-size:1.02rem; color:#718096; margin-bottom:36px;">
                Contrairement aux outils classiques, tout communique entre eux.
            </p>

            <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); padding:36px;">
                <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0; margin-bottom:18px;">
                    <?php
                    $flow = ['Visiteur du site','Estimation','Lead CRM','Email auto','RDV','Mandat'];
                    foreach ($flow as $fi => $f):
                    ?>
                    <div class="plt-flow-box"><?= $f ?></div>
                    <?php if ($fi < count($flow)-1): ?><span class="plt-flow-arr">&#8594;</span><?php endif; endforeach; ?>
                </div>
                <p style="font-size:0.87rem; color:#718096; margin:0;">
                    Le syst&egrave;me travaille 24h/24 pour votre activit&eacute;.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ EXCLUSIVITÉ ═══ -->
<section style="padding:80px 0;">
    <div class="container">
        <div style="max-width:720px; margin:0 auto; text-align:center;">
            <span class="plt-section-badge" style="background:#fce7f3; color:#be123c;">&#127942; Exclusivit&eacute; territoriale</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Une plateforme prot&eacute;g&eacute;e par l'exclusivit&eacute;</h2>
            <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin-bottom:30px;">
                &Eacute;COSYST&Egrave;ME IMMO fonctionne avec un principe unique&nbsp;:<br>
                <strong>1 ville = 1 seul partenaire.</strong>
            </p>

            <div style="padding:24px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; margin-bottom:28px;">
                <p style="font-size:1.3rem; color:white; font-weight:700; margin:0;">
                    &#128737; Aucune concurrence interne &mdash; SEO local prot&eacute;g&eacute; &mdash; Position forte
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA FINAL ═══ -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
    <div class="container">
        <div style="max-width:620px; margin:0 auto;">
            <div class="plt-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
                <span class="plt-pulse" style="background:#FDCB6E;"></span>
                1 licence par ville &mdash; places limit&eacute;es
            </div>
            <h2 style="font-size:2.1rem; color:white; font-weight:800; margin-bottom:16px;">
                V&eacute;rifiez si votre ville est disponible
            </h2>
            <p style="font-size:1.08rem; opacity:0.95; line-height:1.75; margin-bottom:36px;">
                Chaque ville ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul professionnel immobilier.<br>
                Si votre concurrent r&eacute;serve la zone avant vous, elle devient d&eacute;finitivement ferm&eacute;e.
            </p>
            <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:14px 32px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
                    &#128205; V&eacute;rifier si ma ville est disponible
                </a>
                <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:12px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>