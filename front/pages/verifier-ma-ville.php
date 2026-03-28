<?php
$pageTitle = "V&eacute;rifier si ma ville est disponible";
$pageDescription = 'V&eacute;rifiez si votre ville est encore disponible sur &Eacute;COSYST&Egrave;ME IMMO LOCAL+. 1 seule licence par ville &mdash; exclusivit&eacute; territoriale garantie.';
$currentPage = 'villes';

if (session_status() === PHP_SESSION_NONE) {
 session_start();
}

include 'includes/header.php';
$formErrors = $_SESSION['form_errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_data']);
?>

<style>
@keyframes pdot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.vv-badge {
 display: inline-flex; align-items: center; gap: 8px;
 border-radius: 30px; padding: 6px 18px;
 font-size: 0.84rem; font-weight: 600;
}
.vv-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.vv-card {
 background: white; border-radius: 14px;
 box-shadow: 0 3px 16px rgba(0,0,0,0.07);
 transition: transform 0.2s, box-shadow 0.2s;
}
.vv-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,0.13); }

.vv-flow-box {
 background: white; border-radius: 10px;
 border: 1px solid #e2e8f0;
 padding: 13px 22px; font-size: 0.9rem;
 font-weight: 600; color: #2d3748; white-space: nowrap;
}
.vv-flow-arr { font-size:1.3rem; color:#667eea; padding:0 6px; flex-shrink:0; }

/* Formulaire */
.vv-form-group { margin-bottom: 18px; }
.vv-form-group label {
 display: block; font-size: 0.88rem; font-weight: 600;
 color: #4a5568; margin-bottom: 6px;
}
.vv-form-group input {
 width: 100%; padding: 13px 16px;
 border: 1.5px solid #e2e8f0; border-radius: 10px;
 font-size: 0.97rem; color: #1a202c;
 transition: border-color 0.2s, box-shadow 0.2s;
 outline: none; box-sizing: border-box;
 font-family: inherit;
}
.vv-form-group input:focus {
 border-color: #667eea;
 box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
}
.vv-form-group input::placeholder { color: #a0aec0; }

.vv-submit {
 width: 100%; padding: 15px;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: white; font-size: 1.02rem; font-weight: 700;
 border: none; border-radius: 12px; cursor: pointer;
 display: flex; align-items: center; justify-content: center; gap: 10px;
 transition: opacity 0.2s, transform 0.2s;
 box-shadow: 0 6px 20px rgba(102,126,234,0.35);
 font-family: inherit;
}
.vv-submit:hover { opacity: 0.92; transform: translateY(-1px); }

.vv-step {
 display: flex; align-items: flex-start; gap: 16px;
 padding: 20px; background: white; border-radius: 12px;
 box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.vv-step-num {
 width: 36px; height: 36px; flex-shrink: 0;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: white; border-radius: 50%;
 display: flex; align-items: center; justify-content: center;
 font-weight: 700; font-size: 0.95rem;
}

.vv-ville-tag {
 display: inline-flex; align-items: center; gap: 6px;
 background: #fee2e2; color: #991b1b;
 border: 1px solid #fecaca;
 padding: 6px 14px; border-radius: 20px;
 font-size: 0.87rem; font-weight: 600;
}

.vv-conv-grid {
 display:grid;
 grid-template-columns:1fr 1fr;
 gap:50px;
 max-width:980px;
 margin:0 auto;
 align-items:start;
}

@media (max-width: 992px) {
 .vv-conv-grid {
 grid-template-columns: 1fr;
 gap: 26px;
 max-width: 620px;
 }
}
</style>

<!-- ═══ HERO ═══ -->
<section style="padding:90px 0 70px; text-align:center; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
 <div class="container">
 <div style="color:white; max-width:680px; margin:0 auto; animation:fadeUp 0.6s ease both;">
 <div class="vv-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:22px;">
 <span class="vv-pulse" style="background:#FDCB6E;"></span>
 Places limit&eacute;es &mdash; 1 licence par ville
 </div>
 <h1 style="font-size:2.6rem; font-weight:800; line-height:1.2; color:white; margin-bottom:18px;">
 Votre ville est-elle encore disponible&nbsp;?
 </h1>
 <p style="font-size:1.1rem; opacity:0.95; line-height:1.75; margin:0;">
 &Eacute;COSYST&Egrave;ME IMMO fonctionne avec un principe simple&nbsp;:<br>
 <strong> une seule licence par ville.</strong><br>
 Si votre concurrent r&eacute;serve avant vous, l'acc&egrave;s est d&eacute;finitivement ferm&eacute;.
 </p>
 </div>
 </div>
</section>

<!-- ═══ 3 GARANTIES ═══ -->
<section style="padding:70px 0; background:#f7fafc;">
 <div class="container">
 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:18px; max-width:820px; margin:0 auto;">
 <?php
 $garanties = [
 ['', 'Aucune concurrence interne', 'Votre concurrent local ne peut pas acheter le m&ecirc;me syst&egrave;me.'],
 ['', 'SEO local prot&eacute;g&eacute;', 'Votre r&eacute;f&eacute;rencement n\'est jamais dilu&eacute; par d\'autres utilisateurs.'],
 ['', 'Position dominante', 'Vous devenez LE r&eacute;f&eacute;rent immobilier de votre secteur.'],
 ];
 foreach ($garanties as $g):
 ?>
 <div class="vv-card" style="padding:26px; text-align:center;">
 <div style="font-size:1.9rem; margin-bottom:10px;"><?= $g[0] ?></div>
 <strong style="color:#1a202c; font-size:0.97rem;"><?= $g[1] ?></strong>
 <p style="color:#718096; margin:7px 0 0; font-size:0.88rem; line-height:1.5;"><?= $g[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
</section>

<!-- ═══ POURQUOI ON LIMITE ═══ -->
<section style="padding:80px 0;">
 <div class="container">
 <div style="max-width:720px; margin:0 auto;">
 <div style="text-align:center; margin-bottom:40px;">
 <span style="display:inline-block; background:#e9d5ff; color:#6b21a8; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;"> Pourquoi nous limitons les licences</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Nous faisons l'inverse des autres plateformes</h2>
 <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin:0;">
 Les plateformes classiques cherchent des milliers d'utilisateurs.<br>
 Nous faisons l'inverse&nbsp;: nous limitons volontairement le nombre de partenaires pour <strong>prot&eacute;ger votre territoire</strong>.
 </p>
 </div>

 <div style="padding:28px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; text-align:center; margin-bottom:32px;">
 <p style="font-size:1.35rem; color:white; font-weight:700; margin:0; line-height:1.4;">
 1 ville = 1 professionnel immobilier
 </p>
 </div>

 <div style="display:grid; gap:12px;">
 <?php
 $points = [
 'Vous &ecirc;tes le seul &agrave; utiliser le syst&egrave;me dans votre zone',
 'Votre r&eacute;f&eacute;rencement local n\'est pas dilu&eacute;',
 'Votre position devient difficile &agrave; rattraper pour vos concurrents',
 ];
 foreach ($points as $p):
 ?>
 <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#f7fafc; border-radius:10px; border-left:4px solid #667eea;">
 <span style="color:#667eea; font-size:1.1rem; flex-shrink:0;"></span>
 <p style="margin:0; color:#2d3748; font-size:0.96rem;"><?= $p ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
 </div>
</section>

<!-- ═══ CE QUE LA LICENCE INCLUT ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
 <div class="container">
 <div style="max-width:820px; margin:0 auto;">
 <div style="text-align:center; margin-bottom:50px;">
 <span style="display:inline-block; background:#dbeafe; color:#1e40af; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;"> Ce que la licence inclut</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:0;">Votre &eacute;cosyst&egrave;me digital immobilier complet</h2>
 </div>

 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:16px; margin-bottom:44px;">
 <?php
 $inclus = [
 ['', 'Site immobilier SEO', 'Optimis&eacute; pour Google, g&eacute;olocalis&eacute; sur votre secteur.'],
 ['', 'Blog local', 'Articles SEO qui attirent des vendeurs de votre zone.'],
 ['', 'CRM immobilier', 'Suivi leads, mandats, pipeline complet.'],
 ['', 'Automatisations', 'Emails, SMS, relances &mdash; le syst&egrave;me tourne 24/7.'],
 ['', 'Avis de valeur en ligne', 'Capture des vendeurs directement sur votre site.'],
 ['', 'Assistant IA', 'G&eacute;n&eacute;ration de contenus, emails et posts en quelques clics.'],
 ];
 foreach ($inclus as $i):
 ?>
 <div class="vv-card" style="padding:20px; border-left:4px solid #667eea;">
 <div style="font-size:1.5rem; margin-bottom:8px;"><?= $i[0] ?></div>
 <strong style="color:#1a202c; font-size:0.94rem;"><?= $i[1] ?></strong>
 <p style="color:#718096; margin:5px 0 0; font-size:0.86rem; line-height:1.5;"><?= $i[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>

 <!-- Flux -->
 <div style="background:white; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,0.07); padding:30px; text-align:center;">
 <p style="font-size:0.85rem; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:20px;"> Comment le syst&egrave;me g&eacute;n&egrave;re des vendeurs</p>
 <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0;">
 <?php
 $flow = ['Recherche Google','Article SEO local','Estimation','Lead CRM','RDV vendeur','Mandat sign&eacute;'];
 foreach ($flow as $fi => $f):
 ?>
 <div class="vv-flow-box"><?= $f ?></div>
 <?php if ($fi < count($flow)-1): ?><span class="vv-flow-arr">&#8594;</span><?php endif; endforeach; ?>
 </div>
 <p style="margin:16px 0 0; font-size:0.87rem; color:#718096;">Le syst&egrave;me travaille 24h/24, m&ecirc;me quand vous &ecirc;tes en visite.</p>
 </div>
 </div>
 </div>
</section>

<!-- ═══ VILLES DÉJÀ RÉSERVÉES ═══ -->
<section style="padding:60px 0;">
 <div class="container">
 <div style="max-width:700px; margin:0 auto; text-align:center;">
 <h3 style="font-size:1.3rem; color:#1a202c; margin-bottom:20px;"> Villes d&eacute;j&agrave; r&eacute;serv&eacute;es</h3>
 <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-bottom:20px;">
 <?php
 $villes = ['Bordeaux','Nantes','Aix-en-Provence','Lannion','Nandy'];
 foreach ($villes as $v):
 ?>
 <span class="vv-ville-tag"><?= $v ?></span>
 <?php endforeach; ?>
 </div>
 <p style="color:#718096; font-size:0.92rem; margin:0;">
 Une fois une ville r&eacute;serv&eacute;e, elle est <strong>d&eacute;finitivement verrouill&eacute;e</strong>.
 </p>
 </div>
 </div>
</section>

<!-- ═══ FORMULAIRE + SUITE ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
 <div class="container">
 <div class="vv-conv-grid">

 <!-- Formulaire -->
 <div>
 <div style="margin-bottom:28px;">
 <span style="display:inline-block; background:#fce7f3; color:#be123c; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;"> V&eacute;rifier ma ville</span>
 <h2 style="font-size:1.8rem; color:#1a202c; margin-bottom:10px;">Validation rapide de votre zone</h2>
 <p style="color:#718096; font-size:0.95rem; line-height:1.6; margin:0;">
 5 champs, 1 minute. Nous qualifions votre demande puis vous orientons vers l'appel d&eacute;couverte.
 </p>
 </div>

 <form action="/traitement-ville" method="POST" style="background:white; padding:32px; border-radius:16px; box-shadow:0 4px 20px rgba(102,126,234,0.1);">
 <?= csrfField() ?>
 <?php if (!empty($formErrors)): ?>
 <div style="margin-bottom:16px; padding:12px 14px; border-radius:10px; background:#fff1f2; border:1px solid #fecdd3; color:#be123c; font-size:0.86rem; line-height:1.5;">
 <?php foreach ($formErrors as $err): ?>
 <div>&bull; <?= h($err) ?></div>
 <?php endforeach; ?>
 </div>
 <?php endif; ?>
 <div class="vv-form-group">
 <label for="prenom">Pr&eacute;nom *</label>
 <input type="text" id="prenom" name="prenom" placeholder="Jean" value="<?= h($formData['prenom'] ?? '') ?>" required>
 </div>
 <div class="vv-form-group">
 <label for="email">Email *</label>
 <input type="email" id="email" name="email" placeholder="jean@exemple.fr" value="<?= h($formData['email'] ?? '') ?>" required>
 </div>
 <div class="vv-form-group">
 <label for="telephone">T&eacute;l&eacute;phone (recommand&eacute;)</label>
 <input type="tel" id="telephone" name="telephone" placeholder="06 xx xx xx xx" value="<?= h($formData['telephone'] ?? '') ?>">
 </div>
 <div class="vv-form-group">
 <label for="ville">Votre ville *</label>
 <input type="text" id="ville" name="ville" placeholder="Ex&nbsp;: Lyon, Rennes, Bordeaux&hellip;" value="<?= h($formData['ville'] ?? '') ?>" required>
 </div>
 <div class="vv-form-group">
 <label for="reseau">R&eacute;seau / statut</label>
 <input type="text" id="reseau" name="reseau" placeholder="IAD, SAFTI, ind&eacute;pendant, agence..." value="<?= h($formData['reseau'] ?? '') ?>">
 </div>
 <div class="vv-form-group" style="margin-bottom:24px;">
 <label for="besoin">Besoin prioritaire</label>
 <input type="text" id="besoin" name="besoin" placeholder="Ex : plus d'estimations vendeurs, plus de mandats..." value="<?= h($formData['besoin'] ?? '') ?>">
 </div>
 <button type="submit" class="vv-submit">
 <span class="vv-pulse" style="background:#FDCB6E; width:8px; height:8px;"></span>
 V&eacute;rifier la disponibilit&eacute; de ma ville
 </button>
 <p style="text-align:center; margin:14px 0 0; font-size:0.82rem; color:#a0aec0;">
 Sans engagement &mdash; confirmation imm&eacute;diate puis redirection vers l'appel d&eacute;couverte
 </p>
 </form>
 </div>

 <!-- Ce qui se passe ensuite -->
 <div>
 <div style="margin-bottom:28px;">
 <span style="display:inline-block; background:#c7d2fe; color:#3730a3; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;"> Que se passe-t-il ensuite&nbsp;?</span>
 <h2 style="font-size:1.8rem; color:#1a202c; margin-bottom:0;">En 3 &eacute;tapes simples</h2>
 </div>

 <div style="display:grid; gap:14px; margin-bottom:32px;">
 <?php
 $steps = [
 ['1', 'Qualification express', 'Nous v&eacute;rifions la disponibilit&eacute; de votre ville et votre contexte local.'],
 ['2', 'Confirmation claire', 'Vous recevez la validation de r&eacute;ception avec les prochaines &eacute;tapes.'],
 ['3', 'Appel d&eacute;couverte', 'Vous choisissez un cr&eacute;neau pour cadrer votre zone et votre d&eacute;ploiement.'],
 ];
 foreach ($steps as $s):
 ?>
 <div class="vv-step">
 <div class="vv-step-num"><?= $s[0] ?></div>
 <div>
 <strong style="color:#1a202c; display:block; margin-bottom:4px; font-size:0.96rem;"><?= $s[1] ?></strong>
 <p style="color:#718096; margin:0; font-size:0.88rem; line-height:1.55;"><?= $s[2] ?></p>
 </div>
 </div>
 <?php endforeach; ?>
 </div>

 <!-- Alerte urgence -->
 <div style="padding:20px 24px; background:#fff7ed; border:1px solid #fed7aa; border-radius:12px; border-left:4px solid #f97316;">
 <p style="margin:0; color:#9a3412; font-size:0.92rem; line-height:1.65;">
 <strong> Important</strong><br>
 Certaines villes sont actuellement en discussion avec d'autres professionnels.
 Si votre zone est encore disponible, nous vous recommandons de la r&eacute;server rapidement.
 </p>
 </div>
 </div>

 </div>
 </div>
</section>

<!-- ═══ CTA FINAL ═══ -->
<section style="padding:80px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
 <div class="container">
 <div style="max-width:580px; margin:0 auto;">
 <h2 style="font-size:2rem; color:white; margin-bottom:14px; font-weight:800;">
 Ne laissez pas votre concurrent r&eacute;server en premier
 </h2>
 <p style="font-size:1.05rem; opacity:0.95; margin-bottom:32px; line-height:1.7;">
 Une fois la ville r&eacute;serv&eacute;e, l'acc&egrave;s est d&eacute;finitivement ferm&eacute;.
 </p>
 <a href="#nom" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:15px 34px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
 V&eacute;rifier la disponibilit&eacute; de ma ville
 </a>
 </div>
 </div>
</section>

<?php include 'includes/footer.php'; ?>
