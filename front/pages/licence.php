<?php
$pageTitle = "Licence &amp; Acc&egrave;s &mdash; Votre position digitale dans votre ville";
$pageDescription = '&Eacute;COSYST&Egrave;ME IMMO LOCAL+ : licence territoriale exclusive, 1 ville = 1 partenaire. D&eacute;couvrez ce que comprend l\'acc&egrave;s &agrave; la plateforme.';
$currentPage = 'licence';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes pdot   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }

.lic-badge {
    display: inline-flex; align-items: center; gap: 8px;
    border-radius: 30px; padding: 6px 18px;
    font-size: 0.84rem; font-weight: 600; margin-bottom: 22px;
}
.lic-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.lic-section-badge {
    display: inline-block; padding: 6px 16px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    margin-bottom: 14px;
}

.lic-card {
    background: white; border-radius: 14px;
    box-shadow: 0 3px 16px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
}
.lic-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,0.13); }

.lic-flow-box {
    background: white; border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 20px; font-size: 0.89rem;
    font-weight: 600; color: #2d3748; white-space: nowrap;
}
.lic-flow-arr { font-size:1.3rem; color:#667eea; padding:0 6px; flex-shrink:0; }

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
        <div style="color:white; max-width:740px; margin:0 auto; animation:fadeUp 0.6s ease both;">

            <div class="lic-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
                <span class="lic-pulse" style="background:#FDCB6E;"></span>
                1 licence par ville &mdash; exclusivit&eacute; garantie
            </div>

            <h1 style="font-size:2.7rem; font-weight:800; line-height:1.2; color:white; margin-bottom:20px;">
                Votre position digitale dans votre ville
            </h1>

            <p style="font-size:1.12rem; opacity:0.95; line-height:1.8; margin-bottom:14px;">
                &Eacute;COSYST&Egrave;ME IMMO n'est pas un simple logiciel.<br>
                C'est un &eacute;cosyst&egrave;me digital complet con&ccedil;u pour attirer des vendeurs localement.
            </p>

            <p style="font-size:1.05rem; opacity:0.9; margin-bottom:40px;">
                Et surtout&nbsp;: <strong>&#128737; une exclusivit&eacute; territoriale.</strong><br>
                1 ville = 1 seul partenaire.
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

<!-- ═══ EXCLUSIVITÉ ═══ -->
<section style="padding:90px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:820px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:50px;">
                <span class="lic-section-badge" style="background:#fce7f3; color:#be123c;">&#127942; L'Exclusivit&eacute; territoriale</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Nous limitons volontairement l'acc&egrave;s</h2>
                <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin:0;">
                    Contrairement aux plateformes classiques qui cherchent des milliers d'utilisateurs&hellip;<br>
                    &Eacute;COSYST&Egrave;ME IMMO fait l'inverse pour <strong>prot&eacute;ger votre territoire</strong>.
                </p>
            </div>

            <div style="padding:26px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; text-align:center; margin-bottom:36px;">
                <p style="font-size:1.4rem; color:white; font-weight:700; margin:0;">
                    1 ville = 1 seul partenaire &Eacute;COSYST&Egrave;ME IMMO
                </p>
            </div>

            <div style="display:grid; gap:16px;">
                <?php
                $garanties = [
                    ['&#128683;', 'Aucune concurrence interne',
                     'Votre concurrent local ne pourra jamais utiliser le m&ecirc;me syst&egrave;me que vous dans votre zone.'],
                    ['&#128200;', 'Une visibilit&eacute; locale prot&eacute;g&eacute;e',
                     'Votre contenu et votre r&eacute;f&eacute;rencement ne sont pas dilu&eacute;s par d\'autres utilisateurs.'],
                    ['&#128081;', 'Une position dominante dans votre secteur',
                     'Vous construisez une pr&eacute;sence digitale difficile &agrave; rattraper pour vos concurrents.'],
                ];
                foreach ($garanties as $g):
                ?>
                <div class="lic-card" style="display:flex; align-items:flex-start; gap:16px; padding:22px; border-left:4px solid #667eea;">
                    <span style="font-size:1.6rem; flex-shrink:0;"><?= $g[0] ?></span>
                    <div>
                        <strong style="color:#1a202c; display:block; margin-bottom:5px;"><?= $g[1] ?></strong>
                        <p style="color:#718096; margin:0; font-size:0.93rem; line-height:1.6;"><?= $g[2] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CE QUE COMPREND LA LICENCE ═══ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="max-width:1000px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:55px;">
                <span class="lic-section-badge" style="background:#dbeafe; color:#1e40af;">&#128640; Ce que vous obtenez</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:12px;">Tout ce qu'inclut la licence</h2>
                <p style="font-size:1.05rem; color:#718096; margin:0;">Un &eacute;cosyst&egrave;me complet, pas un simple outil.</p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px;">
                <?php
                $modules = [
                    ['&#127760;', 'Site immobilier optimis&eacute; SEO',
                     'Un site con&ccedil;u pour attirer les vendeurs de votre ville. Pages g&eacute;olocalis&eacute;es, optimis&eacute;es pour Google.'],
                    ['&#128221;', 'Moteur de contenu local',
                     'Articles et contenus qui vous positionnent comme expert immobilier local dans votre secteur.'],
                    ['&#128203;', 'CRM immobilier centralis&eacute;',
                     'Tous vos leads, contacts et mandats au m&ecirc;me endroit. Pipeline complet int&eacute;gr&eacute;.'],
                    ['&#9889;', 'Syst&egrave;me d\'automatisation marketing',
                     'Emails, SMS et relances automatiques. Le syst&egrave;me continue de travailler pendant vos visites.'],
                    ['&#129302;', 'Assistant IA immobilier',
                     'Cr&eacute;ation rapide de contenus, messages et communications adapt&eacute;s &agrave; votre march&eacute; local.'],
                    ['&#127968;', 'Estimateur immobilier en ligne',
                     'Un tunnel con&ccedil;u pour transformer les visiteurs de votre site en vendeurs qualifi&eacute;s.'],
                ];
                foreach ($modules as $m):
                ?>
                <div class="lic-card" style="padding:26px; border-left:4px solid #667eea;">
                    <div style="font-size:1.8rem; margin-bottom:10px;"><?= $m[0] ?></div>
                    <strong style="color:#1a202c; display:block; margin-bottom:8px; font-size:0.97rem;"><?= $m[1] ?></strong>
                    <p style="color:#718096; margin:0; font-size:0.88rem; line-height:1.55;"><?= $m[2] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FONCTIONNEMENT ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:860px; margin:0 auto; text-align:center;">
            <span class="lic-section-badge" style="background:#e9d5ff; color:#6b21a8;">&#9881;&#65039; Le fonctionnement</span>
            <h2 style="font-size:2rem; color:#1a202c; margin-bottom:14px;">De la recherche Google au mandat sign&eacute;</h2>
            <p style="font-size:1.02rem; color:#718096; margin-bottom:36px;">Comment l'&eacute;cosyst&egrave;me transforme un simple visiteur en mandat.</p>

            <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); padding:36px;">
                <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0; margin-bottom:18px;">
                    <?php
                    $flow = ['Recherche Google','Article local','Estimation','Lead CRM','RDV vendeur','Mandat sign&eacute;'];
                    foreach ($flow as $fi => $f):
                    ?>
                    <div class="lic-flow-box"><?= $f ?></div>
                    <?php if ($fi < count($flow)-1): ?><span class="lic-flow-arr">&#8594;</span><?php endif; endforeach; ?>
                </div>
                <p style="font-size:0.87rem; color:#718096; margin:0;">
                    Le syst&egrave;me travaille 24h/24, m&ecirc;me lorsque vous &ecirc;tes en visite.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ ACCÈS & TARIF ═══ -->
<section style="padding:90px 0;">
    <div class="container">
        <div style="max-width:820px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:50px;">
                <span class="lic-section-badge" style="background:#c7d2fe; color:#3730a3;">&#128176; L'acc&egrave;s &agrave; l'&eacute;cosyst&egrave;me</span>
                <h2 style="font-size:2rem; color:#1a202c; margin-bottom:12px;">Deux &eacute;l&eacute;ments pour acc&eacute;der</h2>
                <p style="font-size:1.02rem; color:#718096; margin:0;">L'acc&egrave;s &agrave; &Eacute;COSYST&Egrave;ME IMMO repose sur deux &eacute;l&eacute;ments compl&eacute;mentaires.</p>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:36px;">

                <!-- Licence -->
                <div class="lic-card" style="padding:32px; text-align:center; border-top:4px solid #667eea;">
                    <div style="font-size:2rem; margin-bottom:14px;">&#128737;&#65039;</div>
                    <h3 style="color:#1a202c; margin-bottom:12px; font-size:1.2rem;">Licence territoriale</h3>
                    <p style="color:#718096; font-size:0.9rem; line-height:1.7; margin-bottom:18px;">
                        Une licence exclusive est attribu&eacute;e pour chaque ville afin de garantir&nbsp;:
                    </p>
                    <div style="display:grid; gap:8px; text-align:left;">
                        <?php foreach (['Une exclusivit&eacute; locale','Une visibilit&eacute; prot&eacute;g&eacute;e','Une position digitale forte'] as $p): ?>
                        <div style="display:flex; align-items:center; gap:9px; font-size:0.88rem; color:#2d3748;">
                            <span style="color:#667eea;">&#10003;</span> <?= $p ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Abonnement -->
                <div class="lic-card" style="padding:32px; text-align:center; border-top:4px solid #764ba2;">
                    <div style="font-size:2rem; margin-bottom:14px;">&#9889;</div>
                    <h3 style="color:#1a202c; margin-bottom:12px; font-size:1.2rem;">Acc&egrave;s &agrave; la plateforme</h3>
                    <p style="color:#718096; font-size:0.9rem; line-height:1.7; margin-bottom:18px;">
                        Un abonnement permet d'acc&eacute;der &agrave;&nbsp;:
                    </p>
                    <div style="display:grid; gap:8px; text-align:left;">
                        <?php foreach (['L\'ensemble des 43 modules','Les mises &agrave; jour continues','Les nouvelles fonctionnalit&eacute;s'] as $p): ?>
                        <div style="display:flex; align-items:center; gap:9px; font-size:0.88rem; color:#2d3748;">
                            <span style="color:#764ba2;">&#10003;</span> <?= $p ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <!-- Note tarif -->
            <div style="padding:22px 28px; background:#f7fafc; border-left:4px solid #667eea; border-radius:0 12px 12px 0; text-align:center;">
                <p style="color:#2d3748; margin:0; font-size:1rem; line-height:1.7;">
                    &#128205; Les d&eacute;tails tarifaires sont pr&eacute;sent&eacute;s lors de la d&eacute;monstration personnalis&eacute;e.<br>
                    <a href="/front/pages/demo.php" style="color:#667eea; font-weight:600; text-decoration:none;">&#8594; R&eacute;server une d&eacute;mo gratuite</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ VILLES RÉSERVÉES ═══ -->
<section style="padding:60px 0; background:#f7fafc;">
    <div class="container">
        <div style="max-width:680px; margin:0 auto; text-align:center;">
            <h3 style="font-size:1.3rem; color:#1a202c; margin-bottom:18px;">&#9888;&#65039; Villes d&eacute;j&agrave; r&eacute;serv&eacute;es</h3>
            <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-bottom:18px;">
                <?php foreach (['Bordeaux','Nantes','Aix-en-Provence','Lannion'] as $v): ?>
                <span class="ville-tag">&#9888;&#65039; <?= $v ?></span>
                <?php endforeach; ?>
            </div>
            <p style="color:#718096; font-size:0.9rem; margin:0;">
                Une fois une ville r&eacute;serv&eacute;e, elle est <strong>d&eacute;finitivement verrouill&eacute;e</strong>.
            </p>
        </div>
    </div>
</section>

<!-- ═══ CTA FINAL ═══ -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
    <div class="container">
        <div style="max-width:620px; margin:0 auto;">
            <div class="lic-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
                <span class="lic-pulse" style="background:#FDCB6E;"></span>
                V&eacute;rifiez avant qu'un concurrent ne r&eacute;serve
            </div>
            <h2 style="font-size:2.1rem; color:white; font-weight:800; margin-bottom:16px;">
                V&eacute;rifiez la disponibilit&eacute; de votre ville
            </h2>
            <p style="font-size:1.08rem; opacity:0.95; line-height:1.75; margin-bottom:36px;">
                Chaque ville ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul professionnel immobilier.<br>
                Si votre concurrent r&eacute;serve la zone avant vous, l'acc&egrave;s sera d&eacute;finitivement ferm&eacute;.
            </p>
            <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
                <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:14px 32px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
                    &#128205; V&eacute;rifier la disponibilit&eacute; de ma ville
                </a>
                <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:12px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    &#127909; Voir la d&eacute;monstration
                </a>
            </div>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>