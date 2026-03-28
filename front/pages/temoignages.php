<?php
$pageTitle = "T&eacute;moignages &mdash; Ce que disent les professionnels qui utilisent IMMO LOCAL+";
$pageDescription = 'D&eacute;couvrez les retours des agents et mandataires immobiliers qui ont adopt&eacute; &Eacute;COSYST&Egrave;ME IMMO LOCAL+ pour d&eacute;velopper leur pr&eacute;sence digitale locale.';
$currentPage = 'temoignages';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';

$temoignages = [
    [
        'initiales' => 'SH',
        'nom'       => 'St&eacute;phanie H.',
        'role'      => 'Conseill&egrave;re immobili&egrave;re',
        'region'    => 'Bretagne',
        'reseau'    => 'Ind&eacute;pendante',
        'titre'     => 'Enfin un syst&egrave;me qui travaille pour moi',
        'texte'     => 'Avant IMMO LOCAL+, j\'utilisais plusieurs outils diff&eacute;rents. Un CRM, un site, des posts sur Facebook&hellip; mais rien n\'&eacute;tait vraiment connect&eacute;. Aujourd\'hui tout est centralis&eacute;. Le site attire des vendeurs, les demandes arrivent dans le CRM et les relances sont automatiques. J\'ai enfin un syst&egrave;me qui travaille pendant que je suis en visite.',
        'note'      => 5,
        'couleur'   => '#667eea',
        'tag'       => 'Beta testeur',
    ],
    [
        'initiales' => 'MR',
        'nom'       => 'Marie R.',
        'role'      => 'Conseill&egrave;re immobili&egrave;re',
        'region'    => 'Occitanie',
        'reseau'    => 'Mandataire ind&eacute;pendante',
        'titre'     => 'La diff&eacute;rence, c\'est la m&eacute;thode',
        'texte'     => 'J\'avais d&eacute;j&agrave; essay&eacute; plusieurs outils marketing. Le probl&egrave;me n\'&eacute;tait pas l\'outil&hellip; c\'&eacute;tait que je ne savais pas quoi en faire. Avec IMMO LOCAL+, j\'ai compris comment structurer mon marketing&nbsp;: Persona &rarr; Contenu &rarr; Trafic. L\'assistant IA m\'aide &agrave; cr&eacute;er les bons contenus pour ma zone.',
        'note'      => 5,
        'couleur'   => '#764ba2',
        'tag'       => 'Beta testeur',
    ],
    [
        'initiales' => 'ED',
        'nom'       => 'Eduardo D.',
        'role'      => 'Agent immobilier',
        'region'    => 'Nouvelle-Aquitaine',
        'reseau'    => 'Agence ind&eacute;pendante',
        'titre'     => 'La propri&eacute;t&eacute; des donn&eacute;es est un vrai plus',
        'texte'     => 'La plupart des plateformes gardent toutes les donn&eacute;es chez elles. Ici, le syst&egrave;me est install&eacute; sur mon propre h&eacute;bergement. Mon site, mes articles et mes leads m\'appartiennent vraiment. C\'est un &eacute;norme avantage sur le long terme.',
        'note'      => 5,
        'couleur'   => '#48bb78',
        'tag'       => 'Beta testeur',
    ],
];

$resultats = [
    'Plus de visibilit&eacute; locale sur Google',
    'Plus de demandes d\'estimation entrants',
    'Moins de d&eacute;pendance aux portails',
    'Un syst&egrave;me marketing automatis&eacute;',
];
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes pdot   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
@keyframes starIn { from{opacity:0;transform:scale(0.5)} to{opacity:1;transform:scale(1)} }

.tm-badge {
    display: inline-flex; align-items: center; gap: 8px;
    border-radius: 30px; padding: 6px 18px;
    font-size: 0.84rem; font-weight: 600; margin-bottom: 22px;
}
.tm-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.tm-section-badge {
    display: inline-block; padding: 6px 16px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    margin-bottom: 14px;
}

.tm-card {
    background: white; border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    padding: 32px; position: relative;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex; flex-direction: column;
}
.tm-card:hover { transform: translateY(-3px); box-shadow: 0 10px 32px rgba(102,126,234,0.15); }

.tm-quote {
    font-size: 3.5rem; line-height: 1; font-family: Georgia, serif;
    position: absolute; top: 18px; right: 24px;
    opacity: 0.08; color: #667eea;
}

.tm-avatar {
    width: 50px; height: 50px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1.1rem; color: white;
    flex-shrink: 0;
}

.tm-stars { display: flex; gap: 3px; margin-top: 16px; }
.tm-star  { color: #f59e0b; font-size: 1.1rem; animation: starIn 0.3s ease both; }

.tm-tag {
    display: inline-block; padding: 3px 10px;
    background: rgba(102,126,234,0.1); color: #667eea;
    border-radius: 20px; font-size: 0.75rem; font-weight: 700;
    letter-spacing: 0.05em; text-transform: uppercase;
}

.tm-result-item {
    display: flex; align-items: center; gap: 14px;
    padding: 16px 20px; background: white; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-left: 4px solid #667eea;
}

/* Bandeau confiance */
.tm-trust {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr));
    gap: 18px; max-width: 800px; margin: 0 auto;
}
.tm-trust-item {
    text-align: center; padding: 20px 16px;
    background: white; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
</style>

<!-- ═══ HERO ═══ -->
<section style="padding:90px 0 70px; text-align:center; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
    <div class="container">
        <div style="color:white; max-width:700px; margin:0 auto; animation:fadeUp 0.6s ease both;">
            <div class="tm-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
                <span class="tm-pulse" style="background:#FDCB6E;"></span>
                Beta testeurs actifs &mdash; retours r&eacute;els
            </div>
            <h1 style="font-size:2.6rem; font-weight:800; line-height:1.2; color:white; margin-bottom:18px;">
                Ce que disent les professionnels qui utilisent IMMO LOCAL+
            </h1>
            <p style="font-size:1.1rem; opacity:0.95; line-height:1.75; margin:0;">
                Adopter un nouveau syst&egrave;me digital peut sembler complexe.<br>
                C'est pourquoi nous accompagnons chaque partenaire dans la mise en place de son &eacute;cosyst&egrave;me immobilier local.
            </p>
        </div>
    </div>
</section>

<!-- ═══ BANDEAU CONFIANCE ═══ -->
<section style="padding:60px 0; background:#f7fafc;">
    <div class="container">
        <div class="tm-trust">
            <?php
            $trust = [
                ['&#11088;', '5/5', 'Note moyenne'],
                ['&#129309;', '100%', 'Accompagnement inclus'],
                ['&#128737;&#65039;', '1', 'Licence par ville'],
                ['&#129302;', '43+', 'Modules int&eacute;gr&eacute;s'],
            ];
            foreach ($trust as $t):
            ?>
            <div class="tm-trust-item">
                <div style="font-size:1.8rem; margin-bottom:8px;"><?= $t[0] ?></div>
                <div style="font-size:1.7rem; font-weight:800; color:#667eea; line-height:1;"><?= $t[1] ?></div>
                <div style="font-size:0.82rem; color:#718096; margin-top:4px;"><?= $t[2] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ TÉMOIGNAGES ═══ -->
<section style="padding:80px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:55px;">
            <span class="tm-section-badge" style="background:#c7d2fe; color:#3730a3;">&#11088; T&eacute;moignages</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:12px;">Retours de nos partenaires beta</h2>
            <p style="font-size:1.02rem; color:#718096; margin:0;">Des professionnels qui ont d&eacute;cid&eacute; de construire leur pr&eacute;sence digitale diff&eacute;remment.</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:24px; max-width:1040px; margin:0 auto;">
            <?php foreach ($temoignages as $i => $t): ?>
            <div class="tm-card" style="border-top:4px solid <?= $t['couleur'] ?>;">
                <span class="tm-quote">&ldquo;</span>

                <!-- Header -->
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:20px;">
                    <div class="tm-avatar" style="background:<?= $t['couleur'] ?>;">
                        <?= $t['initiales'] ?>
                    </div>
                    <div>
                        <strong style="color:#1a202c; display:block; font-size:0.97rem;"><?= $t['nom'] ?></strong>
                        <span style="font-size:0.84rem; color:#718096;"><?= $t['role'] ?> &mdash; <?= $t['region'] ?></span><br>
                        <span class="tm-tag" style="margin-top:4px;"><?= $t['tag'] ?></span>
                    </div>
                </div>

                <!-- Titre -->
                <h3 style="font-size:1.05rem; color:#1a202c; margin-bottom:12px; font-style:italic;">
                    &laquo;&nbsp;<?= $t['titre'] ?>&nbsp;&raquo;
                </h3>

                <!-- Texte -->
                <p style="color:#4a5568; font-size:0.93rem; line-height:1.75; margin:0; flex:1;">
                    <?= $t['texte'] ?>
                </p>

                <!-- Étoiles -->
                <div class="tm-stars">
                    <?php for ($s = 0; $s < $t['note']; $s++): ?>
                    <span class="tm-star" style="animation-delay:<?= $s * 0.08 ?>s;">&#9733;</span>
                    <?php endfor; ?>
                </div>

                <!-- Réseau -->
                <div style="margin-top:14px; padding-top:14px; border-top:1px solid #f0f4f8; display:flex; align-items:center; gap:7px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:<?= $t['couleur'] ?>;display:inline-block;"></span>
                    <span style="font-size:0.8rem; color:#a0aec0;"><?= $t['reseau'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ RÉSULTATS OBSERVÉS ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:780px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:45px;">
                <span class="tm-section-badge" style="background:#d1fae5; color:#065f46;">&#128640; R&eacute;sultats observ&eacute;s</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:12px;">Ce que constatent nos partenaires</h2>
                <p style="font-size:1.02rem; color:#718096; margin:0;">
                    Les professionnels qui utilisent IMMO LOCAL+ constatent g&eacute;n&eacute;ralement&nbsp;:
                </p>
            </div>

            <div style="display:grid; gap:14px; margin-bottom:40px;">
                <?php foreach ($resultats as $ri => $r): ?>
                <div class="tm-result-item">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <p style="margin:0; color:#2d3748; font-size:0.96rem; font-weight:500;"><?= $r ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pourquoi c'est possible -->
            <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); padding:30px;">
                <p style="font-size:0.88rem; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:18px; text-align:center;">&#129517; Pourquoi ces r&eacute;sultats sont possibles</p>
                <p style="color:#4a5568; font-size:0.96rem; line-height:1.8; margin-bottom:18px; text-align:center;">
                    Le syst&egrave;me combine trois &eacute;l&eacute;ments que peu d'agents poss&egrave;dent simultan&eacute;ment&nbsp;:
                </p>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px;">
                    <?php
                    $why = [
                        ['&#129517;', 'M&eacute;thode marketing claire', 'Persona &rarr; Contenu &rarr; Trafic'],
                        ['&#9881;&#65039;', '&Eacute;cosyst&egrave;me complet', 'Tous les outils connect&eacute;s'],
                        ['&#128737;&#65039;', 'Exclusivit&eacute; territoriale', '1 licence par zone'],
                    ];
                    foreach ($why as $w):
                    ?>
                    <div style="text-align:center; padding:18px 14px; background:#f7fafc; border-radius:10px;">
                        <div style="font-size:1.5rem; margin-bottom:8px;"><?= $w[0] ?></div>
                        <strong style="color:#1a202c; display:block; font-size:0.88rem; margin-bottom:4px;"><?= $w[1] ?></strong>
                        <p style="color:#718096; margin:0; font-size:0.8rem;"><?= $w[2] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ ENCART BETA ═══ -->
<section style="padding:70px 0;">
    <div class="container">
        <div style="max-width:760px; margin:0 auto; background:linear-gradient(135deg,#f0f4ff,#faf0ff); border-radius:16px; border:1px solid rgba(102,126,234,0.2); padding:36px; text-align:center;">
            <div style="font-size:2rem; margin-bottom:14px;">&#128101;</div>
            <h3 style="font-size:1.3rem; color:#1a202c; margin-bottom:12px;">Vous &ecirc;tes professionnel de l'immobilier&nbsp;?</h3>
            <p style="color:#4a5568; font-size:0.97rem; line-height:1.8; margin-bottom:24px;">
                IMMO LOCAL+ est actuellement en phase beta.<br>
                Si vous souhaitez faire partie des premiers partenaires et b&eacute;n&eacute;ficier de <strong>conditions pr&eacute;f&eacute;rentielles &agrave; vie</strong>, v&eacute;rifiez si votre zone est encore disponible.
            </p>
            <div style="display:inline-flex; align-items:center; gap:7px; background:rgba(102,126,234,0.1); border:1px solid rgba(102,126,234,0.3); padding:9px 18px; border-radius:20px; font-size:0.87rem; font-weight:600; color:#667eea; margin-bottom:24px;">
                &#9200; Places limit&eacute;es &mdash; beta en cours
            </div>
            <br>
            <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:linear-gradient(135deg,#667eea,#764ba2); color:white; font-weight:700; font-size:0.97rem; padding:13px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 6px 20px rgba(102,126,234,0.3);">
                    &#128205; V&eacute;rifier ma zone
                </a>
                <a href="/front/pages/demo.php" style="background:white; border:2px solid #667eea; color:#667eea; font-weight:600; font-size:0.97rem; padding:11px 26px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA FINAL ═══ -->
<section style="padding:80px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
    <div class="container">
        <div style="max-width:580px; margin:0 auto;">
            <div class="tm-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
                <span class="tm-pulse" style="background:#FDCB6E;"></span>
                1 licence par zone &mdash; places limit&eacute;es
            </div>
            <h2 style="font-size:2rem; color:white; font-weight:800; margin-bottom:16px;">
                V&eacute;rifiez si votre zone est disponible
            </h2>
            <p style="font-size:1.05rem; opacity:0.95; line-height:1.75; margin-bottom:34px;">
                Chaque zone ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul partenaire IMMO LOCAL+.<br>
                Si un autre professionnel r&eacute;serve avant vous, elle devient d&eacute;finitivement ferm&eacute;e.
            </p>
            <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:14px 32px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
                    &#128205; V&eacute;rifier ma zone
                </a>
                <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:12px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>