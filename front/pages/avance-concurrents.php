<?php
$pageTitle = "Pourquoi vos concurrents ne pourront jamais vous rattraper";
$pageDescription = 'Exclusivit&eacute; territoriale, SEO cumulatif, syst&egrave;me connect&eacute;&nbsp;: d&eacute;couvrez pourquoi votre avance digitale avec &Eacute;COSYST&Egrave;ME IMMO devient impossible &agrave; combler.';
$currentPage = 'avance';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes pdot   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }

.av-badge {
    display: inline-flex; align-items: center; gap: 8px;
    border-radius: 30px; padding: 6px 18px;
    font-size: 0.84rem; font-weight: 600; margin-bottom: 22px;
}
.av-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.av-section-badge {
    display: inline-block; padding: 6px 16px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    margin-bottom: 14px;
}

.av-card {
    background: white; border-radius: 14px;
    box-shadow: 0 3px 16px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
}
.av-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,0.13); }

.av-point {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 11px 0; border-bottom: 1px solid #f0f4ff;
    font-size: 0.92rem; color: #2d3748;
}
.av-point:last-child { border-bottom: none; padding-bottom: 0; }
.av-point .av-ok  { color: #667eea; flex-shrink: 0; margin-top: 2px; }
.av-point .av-no  { color: #e53e3e; flex-shrink: 0; margin-top: 2px; }

.av-raison {
    background: white; border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 36px;
}
</style>

<!-- ═══ HERO ═══ -->
<section style="padding:95px 0 80px; text-align:center; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
    <div class="container">
        <div style="color:white; max-width:760px; margin:0 auto; animation:fadeUp 0.6s ease both;">

            <div class="av-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
                <span class="av-pulse" style="background:#FDCB6E;"></span>
                Exclusivit&eacute; territoriale &mdash; position prot&eacute;g&eacute;e
            </div>

            <h1 style="font-size:2.7rem; font-weight:800; line-height:1.2; color:white; margin-bottom:20px;">
                Pourquoi vos concurrents ne pourront jamais vous rattraper
            </h1>

            <p style="font-size:1.12rem; opacity:0.95; line-height:1.8; margin-bottom:14px;">
                Dans l'immobilier, la visibilit&eacute; locale est un jeu de position.<br>
                Les agents qui dominent Google aujourd'hui ne sont pas forc&eacute;ment les meilleurs.
            </p>
            <p style="font-size:1.05rem; opacity:0.9; margin-bottom:40px;">
                <strong>Ce sont simplement ceux qui ont commenc&eacute; avant les autres.</strong>
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

<!-- ═══ ACCROCHE AVANCE ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:720px; margin:0 auto; text-align:center;">
            <span class="av-section-badge" style="background:#c7d2fe; color:#3730a3;">&#128081; L'avance digitale</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:20px;">Une avance difficile &agrave; combler</h2>
            <p style="font-size:1.1rem; color:#4a5568; line-height:1.85; margin-bottom:32px;">
                Avec &Eacute;COSYST&Egrave;ME IMMO, vous prenez une avance digitale que vos concurrents auront <strong>enormement de mal &agrave; rattraper</strong>&nbsp;: exclusivit&eacute; territoriale, SEO cumulatif, syst&egrave;me connect&eacute;.
            </p>
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px;">
                <?php
                $chiffres = [
                    ['&#9889;', '5', 'raisons cl&eacute;s'],
                    ['&#127760;', '24/7', 'syst&egrave;me actif'],
                    ['&#128205;', '1', 'ville = 1 licence'],
                ];
                foreach ($chiffres as $c):
                ?>
                <div class="av-card" style="padding:22px; text-align:center;">
                    <div style="font-size:1.6rem; margin-bottom:6px;"><?= $c[0] ?></div>
                    <div style="font-size:2rem; font-weight:800; color:#667eea; line-height:1;"><?= $c[1] ?></div>
                    <div style="font-size:0.84rem; color:#718096; margin-top:4px;"><?= $c[2] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══ 5 RAISONS ═══ -->
<section style="padding:30px 0 90px;">
    <div class="container">
        <div style="max-width:960px; margin:0 auto; display:grid; gap:28px;">

            <!-- 1 - Exclusivité -->
            <div class="av-raison" style="border-left:5px solid #667eea;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="flex-shrink:0;">
                        <div style="width:58px; height:58px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.7rem;">&#9889;</div>
                        <p style="text-align:center; font-size:0.75rem; font-weight:700; color:#a0aec0; letter-spacing:0.1em; margin-top:6px;">01</p>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h3 style="font-size:1.4rem; color:#1a202c; margin-bottom:10px;">Une exclusivit&eacute; territoriale</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:18px;">
                            Contrairement aux logiciels classiques, &Eacute;COSYST&Egrave;ME IMMO limite volontairement l'acc&egrave;s &agrave; la plateforme.
                        </p>
                        <div style="padding:20px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:12px; text-align:center; margin-bottom:18px;">
                            <p style="color:white; font-size:1.15rem; font-weight:700; margin:0;">1 ville = 1 seul partenaire</p>
                        </div>
                        <div style="display:grid; gap:0;">
                            <?php foreach (['Votre concurrent local ne peut pas utiliser le syst&egrave;me','Il ne peut pas copier votre strat&eacute;gie','Il ne peut pas acc&eacute;der aux m&ecirc;mes outils'] as $p): ?>
                            <div class="av-point"><span class="av-ok">&#10003;</span><?= $p ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div style="margin-top:16px; display:inline-flex; align-items:center; gap:7px; background:#f0f4ff; padding:9px 16px; border-radius:8px; font-size:0.87rem; font-weight:600; color:#667eea;">
                            &#128737;&#65039; Votre position est prot&eacute;g&eacute;e.
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 - Domination Google -->
            <div class="av-raison" style="border-left:5px solid #48bb78;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="flex-shrink:0;">
                        <div style="width:58px; height:58px; background:linear-gradient(135deg,#48bb78,#38a169); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.7rem;">&#128200;</div>
                        <p style="text-align:center; font-size:0.75rem; font-weight:700; color:#a0aec0; letter-spacing:0.1em; margin-top:6px;">02</p>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h3 style="font-size:1.4rem; color:#1a202c; margin-bottom:10px;">Une domination progressive sur Google</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:18px;">
                            Le r&eacute;f&eacute;rencement local fonctionne comme un <strong>effet cumulatif</strong>.<br>
                            Chaque contenu publi&eacute; renforce votre visibilit&eacute;. Chaque article am&eacute;liore votre autorit&eacute; locale.
                        </p>
                        <div style="display:grid; gap:0; margin-bottom:16px;">
                            <?php foreach (['Votre site devient une r&eacute;f&eacute;rence','Vos contenus apparaissent dans Google','Votre nom devient associ&eacute; &agrave; l\'immobilier dans votre ville'] as $p): ?>
                            <div class="av-point"><span class="av-ok">&#10003;</span><?= $p ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div style="padding:18px 22px; background:#f0fdf4; border-left:4px solid #48bb78; border-radius:0 10px 10px 0; font-size:0.92rem; color:#276749; font-weight:500; line-height:1.65;">
                            &#128073; Plus vous commencez t&ocirc;t, plus votre avance devient difficile &agrave; rattraper.
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3 - Données -->
            <div class="av-raison" style="border-left:5px solid #ed8936;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="flex-shrink:0;">
                        <div style="width:58px; height:58px; background:linear-gradient(135deg,#ed8936,#dd6b20); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.7rem;">&#129504;</div>
                        <p style="text-align:center; font-size:0.75rem; font-weight:700; color:#a0aec0; letter-spacing:0.1em; margin-top:6px;">03</p>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h3 style="font-size:1.4rem; color:#1a202c; margin-bottom:10px;">Un syst&egrave;me qui apprend avec votre march&eacute;</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:18px;">
                            Votre &eacute;cosyst&egrave;me digital s'am&eacute;liore au fil du temps. Il collecte des donn&eacute;es sur vos visiteurs, vos leads et vos conversions pour optimiser votre strat&eacute;gie.
                        </p>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div style="padding:18px; background:#fff7ed; border-radius:10px; border-top:3px solid #ed8936;">
                                <p style="font-size:0.83rem; font-weight:700; color:#c05621; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.06em;">Vos concurrents</p>
                                <?php foreach (['D&eacute;pendent des portails','Paient pour chaque lead','Prospectent manuellement'] as $p): ?>
                                <div style="display:flex; align-items:center; gap:7px; font-size:0.87rem; color:#744210; padding:5px 0;">
                                    <span>&#10060;</span><?= $p ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div style="padding:18px; background:#f0fdf4; border-radius:10px; border-top:3px solid #48bb78;">
                                <p style="font-size:0.83rem; font-weight:700; color:#276749; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.06em;">Vous</p>
                                <?php foreach (['Donn&eacute;es visiteurs','Analyse des leads','Optimisation continue'] as $p): ?>
                                <div style="display:flex; align-items:center; gap:7px; font-size:0.87rem; color:#276749; padding:5px 0;">
                                    <span>&#10003;</span><?= $p ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 - Système complet -->
            <div class="av-raison" style="border-left:5px solid #764ba2;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="flex-shrink:0;">
                        <div style="width:58px; height:58px; background:linear-gradient(135deg,#764ba2,#667eea); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.7rem;">&#9881;&#65039;</div>
                        <p style="text-align:center; font-size:0.75rem; font-weight:700; color:#a0aec0; letter-spacing:0.1em; margin-top:6px;">04</p>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h3 style="font-size:1.4rem; color:#1a202c; margin-bottom:10px;">Un syst&egrave;me complet que peu d'agents poss&egrave;dent</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:18px;">
                            La majorit&eacute; des agents utilisent plusieurs outils s&eacute;par&eacute;s. Tr&egrave;s peu disposent d'un &eacute;cosyst&egrave;me complet et connect&eacute;.
                        </p>
                        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:10px;">
                            <?php foreach (['Site immobilier','SEO local','CRM','Automatisations','Estimateur','Intelligence artificielle'] as $m): ?>
                            <div style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#f7f0ff; border-radius:8px; font-size:0.87rem; color:#5b21b6; font-weight:500;">
                                <span style="color:#667eea;">&#10003;</span><?= $m ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div style="margin-top:16px; display:inline-flex; align-items:center; gap:7px; background:#f0f4ff; padding:9px 16px; border-radius:8px; font-size:0.87rem; font-weight:600; color:#667eea;">
                            &#128073; Tout fonctionne ensemble.
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5 - Autorité locale -->
            <div class="av-raison" style="border-left:5px solid #e53e3e;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="flex-shrink:0;">
                        <div style="width:58px; height:58px; background:linear-gradient(135deg,#e53e3e,#c53030); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.7rem;">&#128081;</div>
                        <p style="text-align:center; font-size:0.75rem; font-weight:700; color:#a0aec0; letter-spacing:0.1em; margin-top:6px;">05</p>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h3 style="font-size:1.4rem; color:#1a202c; margin-bottom:10px;">Une autorit&eacute; locale qui se construit avec le temps</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:18px;">
                            Lorsque votre pr&eacute;sence digitale se d&eacute;veloppe, vos articles apparaissent sur Google, votre site attire des visiteurs et votre nom devient visible dans votre secteur.
                        </p>
                        <div style="padding:22px; background:#fff5f5; border-left:4px solid #e53e3e; border-radius:0 12px 12px 0; margin-bottom:16px;">
                            <p style="color:#742a2a; font-style:italic; font-size:0.97rem; line-height:1.75; margin:0;">
                                &laquo;&nbsp;Les vendeurs commencent &agrave; vous identifier <strong>avant m&ecirc;me de vous rencontrer</strong>.&nbsp;&raquo;
                            </p>
                        </div>
                        <div style="display:grid; gap:0;">
                            <?php foreach (['Vous devenez LE r&eacute;f&eacute;rent immobilier de votre ville','Les leads arrivent sans prospection','Votre r&eacute;putation se construit automatiquement'] as $p): ?>
                            <div class="av-point"><span class="av-ok">&#10003;</span><?= $p ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══ LE VRAI AVANTAGE ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:760px; margin:0 auto; text-align:center;">
            <span class="av-section-badge" style="background:#fce7f3; color:#be123c;">&#128737;&#65039; Le vrai avantage</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:20px;">Le syst&egrave;me + le temps</h2>
            <p style="font-size:1.1rem; color:#4a5568; line-height:1.85; margin-bottom:32px;">
                Ce qui rend votre avance difficile &agrave; rattraper, ce n'est pas un outil.<br>
                C'est le <strong>syst&egrave;me combin&eacute; au temps</strong>.
            </p>

            <div style="padding:32px; background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:28px;">
                <div style="display:grid; grid-template-columns:1fr auto 1fr; align-items:center; gap:20px;">
                    <div style="text-align:center; padding:20px; background:#f7f0ff; border-radius:12px;">
                        <div style="font-size:1.6rem; margin-bottom:8px;">&#9889;</div>
                        <strong style="color:#667eea; display:block; margin-bottom:6px;">Syst&egrave;me</strong>
                        <p style="color:#718096; font-size:0.85rem; margin:0;">Site + SEO + CRM + IA + Automatisations</p>
                    </div>
                    <div style="font-size:2rem; color:#667eea; font-weight:700;">+</div>
                    <div style="text-align:center; padding:20px; background:#f0fdf4; border-radius:12px;">
                        <div style="font-size:1.6rem; margin-bottom:8px;">&#8987;</div>
                        <strong style="color:#38a169; display:block; margin-bottom:6px;">Temps</strong>
                        <p style="color:#718096; font-size:0.85rem; margin:0;">Contenu cumulatif, autorit&eacute; locale croissante</p>
                    </div>
                </div>
                <div style="margin-top:20px; padding:18px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:12px;">
                    <p style="color:white; font-weight:700; font-size:1.1rem; margin:0;">= Une position que votre concurrent ne peut pas reproduire</p>
                </div>
            </div>

            <p style="font-size:0.97rem; color:#718096; line-height:1.75;">
                Et comme <strong>une seule licence est attribu&eacute;e par ville</strong>, votre concurrent ne peut pas acc&eacute;der au m&ecirc;me syst&egrave;me &mdash; m&ecirc;me s'il le voulait.
            </p>
        </div>
    </div>
</section>

<!-- ═══ CTA FINAL ═══ -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
    <div class="container">
        <div style="max-width:620px; margin:0 auto;">
            <div class="av-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
                <span class="av-pulse" style="background:#FDCB6E;"></span>
                1 licence par ville &mdash; places limit&eacute;es
            </div>
            <h2 style="font-size:2.1rem; color:white; font-weight:800; margin-bottom:16px;">
                V&eacute;rifiez si votre ville est encore disponible
            </h2>
            <p style="font-size:1.08rem; opacity:0.95; line-height:1.75; margin-bottom:36px;">
                Chaque ville ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul professionnel immobilier.<br>
                Si votre concurrent r&eacute;serve la zone avant vous, l'acc&egrave;s sera d&eacute;finitivement ferm&eacute;.
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