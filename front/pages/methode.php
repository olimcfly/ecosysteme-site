<?php
$pageTitle = "La M&eacute;thode &mdash; Pourquoi &Eacute;COSYST&Egrave;ME IMMO attire des vendeurs";
$pageDescription = 'D&eacute;couvrez la m&eacute;thode Persona / Contenu / Trafic qui permet aux pros de l\'immobilier d\'attirer des vendeurs sans portails ni publicit&eacute;.';
$currentPage = 'methode';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes pdot   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }

.met-badge {
    display: inline-flex; align-items: center; gap: 8px;
    border-radius: 30px; padding: 6px 18px;
    font-size: 0.84rem; font-weight: 600; margin-bottom: 22px;
}
.met-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.met-section-badge {
    display: inline-block; padding: 6px 16px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    margin-bottom: 14px;
}

.met-card {
    background: white; border-radius: 14px;
    box-shadow: 0 3px 16px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
}
.met-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,0.13); }

.met-levier {
    background: white; border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 36px;
}

.met-flow-box {
    background: white; border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 20px; font-size: 0.89rem;
    font-weight: 600; color: #2d3748; white-space: nowrap;
}
.met-flow-arr { font-size:1.3rem; color:#667eea; padding:0 6px; flex-shrink:0; }

.met-check {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 11px 0; border-bottom: 1px solid #f0f4ff;
    font-size: 0.93rem; color: #2d3748;
}
.met-check:last-child { border-bottom: none; padding-bottom: 0; }
.met-check span { color: #667eea; flex-shrink: 0; margin-top: 2px; }
</style>

<!-- ═══ HERO ═══ -->
<section style="padding:95px 0 80px; text-align:center; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
    <div class="container">
        <div style="color:white; max-width:740px; margin:0 auto; animation:fadeUp 0.6s ease both;">

            <div class="met-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
                <span class="met-pulse" style="background:#FDCB6E;"></span>
                Persona &rarr; Contenu &rarr; Trafic
            </div>

            <h1 style="font-size:2.7rem; font-weight:800; line-height:1.2; color:white; margin-bottom:20px;">
                Les agents qui r&eacute;ussissent ont un syst&egrave;me.<br>Pas seulement des outils.
            </h1>

            <p style="font-size:1.12rem; opacity:0.95; line-height:1.8; margin-bottom:40px;">
                La m&eacute;thode derri&egrave;re &Eacute;COSYST&Egrave;ME IMMO&nbsp;:<br>
                <strong>attirer les vendeurs avant qu'ils ne contactent un agent.</strong>
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

<!-- ═══ LE PROBLÈME ═══ -->
<section style="padding:90px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:760px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:50px;">
                <span class="met-section-badge" style="background:#fee2e2; color:#991b1b;">&#128544; Le probl&egrave;me</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Les outils ne suffisent pas</h2>
                <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin:0;">
                    La plupart des professionnels de l'immobilier utilisent d&eacute;j&agrave; un CRM, un site web, des r&eacute;seaux sociaux et des portails immobiliers.<br>
                    Mais ces outils fonctionnent souvent <strong>s&eacute;par&eacute;ment</strong>.
                </p>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:36px;">
                <div style="padding:24px; background:white; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.06); border-top:3px solid #e2e8f0;">
                    <p style="font-size:0.85rem; font-weight:700; color:#a0aec0; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:14px;">R&eacute;sultat sans m&eacute;thode</p>
                    <?php foreach (['Peu de visibilit&eacute; sur Google','Peu de leads vendeurs','D&eacute;pendance aux portails et &agrave; la pub'] as $r): ?>
                    <div style="display:flex; align-items:center; gap:9px; padding:8px 0; border-bottom:1px solid #f7fafc; font-size:0.9rem; color:#991b1b;">
                        <span>&#10060;</span> <?= $r ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div style="padding:24px; background:white; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.06); border-top:3px solid #667eea;">
                    <p style="font-size:0.85rem; font-weight:700; color:#667eea; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:14px;">Avec la m&eacute;thode</p>
                    <?php foreach (['Visible quand le vendeur cherche','Leads qualifi&eacute;s en continu','Ind&eacute;pendant des portails'] as $r): ?>
                    <div style="display:flex; align-items:center; gap:9px; padding:8px 0; border-bottom:1px solid #f7fafc; font-size:0.9rem; color:#065f46;">
                        <span>&#10003;</span> <?= $r ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="padding:26px 32px; background:white; border-left:4px solid #667eea; border-radius:0 12px 12px 0; text-align:center;">
                <p style="color:#1a202c; margin:0; font-size:1.08rem; line-height:1.75;">
                    &#128073; Le probl&egrave;me n'est pas <strong>l'outil</strong>.<br>
                    &#128073; Le probl&egrave;me est l'absence de <strong>m&eacute;thode</strong>.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ LES 3 LEVIERS ═══ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:60px;">
            <span class="met-section-badge" style="background:#dbeafe; color:#1e40af;">&#129517; La M&eacute;thode</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:12px;">3 leviers fondamentaux</h2>
            <p style="font-size:1.05rem; color:#718096; margin:0;">Pour attirer les vendeurs avant qu'ils ne contactent un concurrent.</p>
        </div>

        <div style="max-width:960px; margin:0 auto; display:grid; gap:28px;">

            <!-- PERSONA -->
            <div class="met-levier" style="border-left:5px solid #667eea;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="width:60px; height:60px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; flex-shrink:0;">&#128100;</div>
                    <div style="flex:1; min-width:240px;">
                        <p style="font-size:0.82rem; font-weight:700; color:#667eea; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:6px;">Levier 1</p>
                        <h3 style="font-size:1.5rem; color:#1a202c; margin-bottom:10px;">PERSONA &mdash; Comprendre vos vendeurs</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:20px;">
                            Tous les vendeurs ne sont pas les m&ecirc;mes. Dans votre ville, vous pouvez trouver des vendeurs seniors, des familles qui d&eacute;m&eacute;nagent, des investisseurs ou des propri&eacute;taires qui veulent estimer leur bien.<br><br>
                            Chaque profil a ses <strong>motivations</strong>, ses <strong>peurs</strong> et ses <strong>objections</strong>.
                        </p>
                        <div style="background:#f7fafc; border-radius:10px; padding:18px;">
                            <p style="font-size:0.85rem; font-weight:600; color:#667eea; margin-bottom:10px;">&#129302; Ce que fait l'assistant IA</p>
                            <p style="color:#4a5568; font-size:0.9rem; margin:0; line-height:1.7;">
                                Il vous aide &agrave; d&eacute;finir ces profils afin de parler aux bonnes personnes avec le bon message &mdash; pas &agrave; tout le monde avec le m&ecirc;me discours g&eacute;n&eacute;rique.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENU -->
            <div class="met-levier" style="border-left:5px solid #764ba2;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="width:60px; height:60px; background:linear-gradient(135deg,#764ba2,#667eea); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; flex-shrink:0;">&#9999;&#65039;</div>
                    <div style="flex:1; min-width:240px;">
                        <p style="font-size:0.82rem; font-weight:700; color:#764ba2; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:6px;">Levier 2</p>
                        <h3 style="font-size:1.5rem; color:#1a202c; margin-bottom:10px;">CONTENU &mdash; Dire la bonne chose au bon moment</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:20px;">
                            Une fois les profils identifi&eacute;s, la prochaine &eacute;tape consiste &agrave; cr&eacute;er les bons contenus.<br>
                            Chaque contenu correspond &agrave; une &eacute;tape du parcours vendeur pour faire progresser le prospect jusqu'&agrave; la prise de contact.
                        </p>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <?php foreach (['Articles de blog','Guides vendeurs','Emails cibl&eacute;s','Posts r&eacute;seaux sociaux'] as $c): ?>
                            <div style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#f7fafc; border-radius:8px; font-size:0.88rem; color:#2d3748;">
                                <span style="color:#764ba2;">&#10003;</span> <?= $c ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TRAFIC -->
            <div class="met-levier" style="border-left:5px solid #48bb78;">
                <div style="display:flex; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                    <div style="width:60px; height:60px; background:linear-gradient(135deg,#48bb78,#38a169); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; flex-shrink:0;">&#128225;</div>
                    <div style="flex:1; min-width:240px;">
                        <p style="font-size:0.82rem; font-weight:700; color:#38a169; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:6px;">Levier 3</p>
                        <h3 style="font-size:1.5rem; color:#1a202c; margin-bottom:10px;">TRAFIC &mdash; Diffuser au bon endroit</h3>
                        <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:20px;">
                            Une fois les contenus cr&eacute;&eacute;s, ils sont diffus&eacute;s sur les bons canaux pour &ecirc;tre visible au moment o&ugrave; un vendeur commence &agrave; se poser des questions.
                        </p>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <?php foreach (['Google (SEO local)','Blog immobilier','Fiche Google','R&eacute;seaux sociaux'] as $c): ?>
                            <div style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#f0fdf4; border-radius:8px; font-size:0.88rem; color:#2d3748;">
                                <span style="color:#38a169;">&#10003;</span> <?= $c ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══ SYSTÈME COMPLET ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:860px; margin:0 auto; text-align:center;">
            <span class="met-section-badge" style="background:#e9d5ff; color:#6b21a8;">&#9881;&#65039; Le syst&egrave;me complet</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:14px;">De la recherche Google au mandat sign&eacute;</h2>
            <p style="font-size:1.02rem; color:#718096; margin-bottom:36px;">
                Le syst&egrave;me travaille 24h/24 pour attirer des vendeurs dans votre secteur.
            </p>

            <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); padding:36px;">
                <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0; margin-bottom:20px;">
                    <?php
                    $flow = ['Recherche Google','Article local','Estimation','Lead CRM','RDV vendeur','Mandat sign&eacute;'];
                    foreach ($flow as $fi => $f):
                    ?>
                    <div class="met-flow-box"><?= $f ?></div>
                    <?php if ($fi < count($flow)-1): ?><span class="met-flow-arr">&#8594;</span><?php endif; endforeach; ?>
                </div>
                <p style="font-size:0.87rem; color:#718096; margin:0;">
                    Le syst&egrave;me travaille 24h/24, m&ecirc;me lorsque vous &ecirc;tes en visite.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ POURQUOI ÇA MARCHE ═══ -->
<section style="padding:80px 0;">
    <div class="container">
        <div style="max-width:820px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:50px;">
                <span class="met-section-badge" style="background:#fef3c7; color:#92400e;">&#129504; Pourquoi &ccedil;a fonctionne</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Nous ne vendons pas. Nous accompagnons.</h2>
                <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin:0;">
                    La majorit&eacute; des agents essaie de vendre <strong>imm&eacute;diatement</strong>.<br>
                    &Eacute;COSYST&Egrave;ME IMMO fait l'inverse.
                </p>
            </div>

            <div style="padding:28px 32px; background:#f7fafc; border-left:4px solid #667eea; border-radius:0 12px 12px 0; margin-bottom:36px;">
                <p style="color:#2d3748; margin:0; font-style:italic; font-size:1.05rem; line-height:1.75;">
                    &laquo;&nbsp;Le syst&egrave;me accompagne le prospect &agrave; chaque &eacute;tape de son parcours, jusqu'&agrave; ce qu'il soit pr&ecirc;t &agrave; passer &agrave; l'action.&nbsp;&raquo;
                </p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:18px; margin-bottom:40px;">
                <?php
                $resultats = [
                    ['&#129392;', 'Prospects qualifi&eacute;s', 'Vous ne parlez qu\'aux vendeurs qui ont d&eacute;j&agrave; exprim&eacute; un int&eacute;r&ecirc;t.'],
                    ['&#129309;', 'Confiance cr&eacute;&eacute;e', 'Vos contenus &eacute;tablissent votre expertise avant le premier contact.'],
                    ['&#128197;', 'RDV vendeurs', 'Des prospects qui vous contactent, pas l\'inverse.'],
                ];
                foreach ($resultats as $r):
                ?>
                <div class="met-card" style="padding:24px; text-align:center;">
                    <div style="font-size:1.8rem; margin-bottom:10px;"><?= $r[0] ?></div>
                    <strong style="color:#1a202c; display:block; margin-bottom:7px;"><?= $r[1] ?></strong>
                    <p style="color:#718096; margin:0; font-size:0.87rem; line-height:1.5;"><?= $r[2] ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Résultats finaux -->
            <div style="padding:28px; background:white; border-radius:14px; box-shadow:0 4px 18px rgba(0,0,0,0.07);">
                <p style="font-size:0.88rem; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:16px; text-align:center;">&#128640; Ce que &ccedil;a permet</p>
                <div style="display:grid; gap:0;">
                    <?php
                    foreach (['Attirer des vendeurs sans prospecter','R&eacute;duire la d&eacute;pendance aux portails immobiliers','Construire une autorit&eacute; locale forte et durable'] as $r):
                    ?>
                    <div class="met-check">
                        <span>&#10003;</span>
                        <?= $r ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA FINAL ═══ -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
    <div class="container">
        <div style="max-width:620px; margin:0 auto;">
            <div class="met-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
                <span class="met-pulse" style="background:#FDCB6E;"></span>
                1 licence par ville &mdash; exclusivit&eacute; garantie
            </div>
            <h2 style="font-size:2.1rem; color:white; font-weight:800; margin-bottom:16px;">
                V&eacute;rifiez si votre ville est disponible
            </h2>
            <p style="font-size:1.08rem; opacity:0.95; line-height:1.75; margin-bottom:36px;">
                &Eacute;COSYST&Egrave;ME IMMO fonctionne avec un principe simple&nbsp;:<br>
                <strong>&#128737; une seule licence par ville.</strong><br>
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