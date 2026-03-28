<?php
$pageTitle = "D&eacute;mo &mdash; Voir comment &Eacute;cosyst&egrave;me Immo attire des vendeurs automatiquement";
$pageDescription = 'D&eacute;couvrez comment &Eacute;COSYST&Egrave;ME IMMO g&eacute;n&egrave;re des leads vendeurs via SEO local, CRM et automatisations. D&eacute;mo gratuite disponible.';
$currentPage = 'demo';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes pdot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }

.demo-badge {
 display: inline-flex; align-items: center; gap: 8px;
 border-radius: 30px; padding: 6px 18px;
 font-size: 0.84rem; font-weight: 600; margin-bottom: 22px;
}
.demo-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.demo-card {
 background: white; border-radius: 14px;
 box-shadow: 0 3px 16px rgba(0,0,0,0.07);
 transition: transform 0.2s, box-shadow 0.2s;
}
.demo-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,0.13); }

.demo-flow-box {
 background: white; border-radius: 10px;
 border: 1px solid #e2e8f0;
 padding: 12px 20px; font-size: 0.89rem;
 font-weight: 600; color: #2d3748; white-space: nowrap;
}
.demo-flow-arr { font-size:1.3rem; color:#667eea; padding:0 6px; flex-shrink:0; }

.demo-section-badge {
 display: inline-block; padding: 6px 16px;
 border-radius: 20px; font-size: 0.85rem; font-weight: 600;
 margin-bottom: 14px;
}

/* Formulaire RDV */
.rdv-group { margin-bottom: 16px; }
.rdv-group label {
 display: block; font-size: 0.87rem; font-weight: 600;
 color: #4a5568; margin-bottom: 5px;
}
.rdv-group input, .rdv-group select {
 width: 100%; padding: 12px 15px;
 border: 1.5px solid #e2e8f0; border-radius: 10px;
 font-size: 0.95rem; color: #1a202c;
 transition: border-color 0.2s, box-shadow 0.2s;
 outline: none; box-sizing: border-box; font-family: inherit;
 background: white;
}
.rdv-group input:focus, .rdv-group select:focus {
 border-color: #667eea;
 box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
}
.rdv-group input::placeholder { color: #a0aec0; }

.rdv-submit {
 width: 100%; padding: 14px;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: white; font-size: 1rem; font-weight: 700;
 border: none; border-radius: 12px; cursor: pointer;
 display: flex; align-items: center; justify-content: center; gap: 9px;
 transition: opacity 0.2s, transform 0.2s;
 box-shadow: 0 6px 20px rgba(102,126,234,0.35);
 font-family: inherit;
}
.rdv-submit:hover { opacity: 0.92; transform: translateY(-1px); }

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

 <div class="demo-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
 <span class="demo-pulse" style="background:#FDCB6E;"></span>
 D&eacute;mo gratuite &mdash; sans engagement
 </div>

 <h1 style="font-size:2.7rem; font-weight:800; line-height:1.2; color:white; margin-bottom:20px;">
 D&eacute;couvrez comment &Eacute;COSYST&Egrave;ME IMMO attire des vendeurs automatiquement
 </h1>

 <p style="font-size:1.12rem; opacity:0.95; line-height:1.8; margin-bottom:36px;">
 Dans cette d&eacute;monstration, vous allez voir comment un syst&egrave;me digital bien construit peut attirer des vendeurs depuis Google,
 transformer les visiteurs en demandes d'estimation et organiser les leads automatiquement dans votre CRM.<br><br>
 Et surtout&nbsp;: <strong>obtenir des mandats sans d&eacute;pendre des portails immobiliers.</strong>
 </p>

 <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
 <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:14px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
 V&eacute;rifier ma ville
 </a>
 <a href="#demo-video" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:12px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
 Voir la d&eacute;mo
 </a>
 </div>
 <p style="font-size:0.86rem; opacity:0.8; margin-top:14px;">Conseil : commencez par v&eacute;rifier votre ville pour acc&eacute;l&eacute;rer la qualification.</p>
 </div>
 </div>
</section>

<!-- ═══ VIDÉO PLACEHOLDER ═══ -->
<section id="demo-video" style="padding:80px 0; background:#f7fafc;">
 <div class="container">
 <div style="max-width:820px; margin:0 auto;">
 <div style="text-align:center; margin-bottom:36px;">
 <span class="demo-section-badge" style="background:#dbeafe; color:#1e40af;"> La d&eacute;monstration</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:0;">Le syst&egrave;me en action</h2>
 </div>

 <!-- Zone vid&eacute;o -->
 <div style="position:relative; background:#1a202c; border-radius:16px; overflow:hidden; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; box-shadow:0 12px 40px rgba(0,0,0,0.2);">
 <div style="text-align:center; color:white;">
 <div style="width:72px;height:72px;background:rgba(102,126,234,0.85);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;cursor:pointer;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
 <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
 </div>
 <p style="font-size:1.05rem; font-weight:600; opacity:0.9; margin:0;">D&eacute;monstration compl&egrave;te du syst&egrave;me</p>
 <p style="font-size:0.88rem; opacity:0.6; margin:6px 0 0;">Dur&eacute;e : ~10 minutes</p>
 </div>
 <!-- Remplacer par votre iframe vid&eacute;o : -->
 <!-- <iframe src="https://www.youtube.com/embed/VOTRE_ID" frameborder="0" allowfullscreen style="position:absolute;inset:0;width:100%;height:100%;"></iframe> -->
 </div>
 </div>
 </div>
</section>

<!-- ═══ PROBLÈME ═══ -->
<section style="padding:80px 0;">
 <div class="container">
 <div style="max-width:740px; margin:0 auto;">
 <div style="text-align:center; margin-bottom:44px;">
 <span class="demo-section-badge" style="background:#fee2e2; color:#991b1b;"> Le probl&egrave;me</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Pourquoi la plupart des agents n'obtiennent pas de leads via leur site</h2>
 <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin:0;">
 Aujourd'hui, la majorit&eacute; des sites immobiliers ont le m&ecirc;me probl&egrave;me&nbsp;:<br>
 ils sont beaux, ils pr&eacute;sentent des biens&hellip;<br>
 <strong>mais ils ne g&eacute;n&egrave;rent presque aucun contact.</strong>
 </p>
 </div>

 <div style="padding:28px 32px; background:#f7fafc; border-left:4px solid #667eea; border-radius:0 12px 12px 0; margin-bottom:36px;">
 <p style="color:#2d3748; margin:0; font-size:1.05rem; line-height:1.75;">
 Pourquoi&nbsp;? Parce qu'ils ne sont pas con&ccedil;us comme un <strong>syst&egrave;me d'acquisition de vendeurs</strong>.<br>
 Ils sont simplement con&ccedil;us comme des <strong>vitrines</strong>.
 </p>
 </div>

 <div style="padding:26px; background:white; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,0.07); text-align:center;">
 <p style="font-size:0.88rem; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:18px;">La diff&eacute;rence avec &Eacute;COSYST&Egrave;ME IMMO</p>
 <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
 <div style="padding:16px; background:#fee2e2; border-radius:10px;">
 <strong style="color:#991b1b; display:block; margin-bottom:6px; font-size:0.9rem;"> Site vitrine classique</strong>
 <p style="color:#b91c1c; margin:0; font-size:0.85rem;">&laquo;&nbsp;Beau site, z&eacute;ro lead&nbsp;&raquo;</p>
 </div>
 <div style="padding:16px; background:#d1fae5; border-radius:10px;">
 <strong style="color:#065f46; display:block; margin-bottom:6px; font-size:0.9rem;"> &Eacute;cosyst&egrave;me Immo</strong>
 <p style="color:#047857; margin:0; font-size:0.85rem;">&laquo;&nbsp;Syst&egrave;me d'acquisition de vendeurs&nbsp;&raquo;</p>
 </div>
 </div>
 </div>
 </div>
 </div>
</section>

<!-- ═══ COMMENT ÇA FONCTIONNE ═══ -->
<section style="padding:80px 0; background:#f7fafc;">
 <div class="container">
 <div style="max-width:860px; margin:0 auto;">
 <div style="text-align:center; margin-bottom:50px;">
 <span class="demo-section-badge" style="background:#e9d5ff; color:#6b21a8;"> Comment &ccedil;a fonctionne</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:14px;">Le parcours r&eacute;el d'un vendeur</h2>
 <p style="font-size:1.05rem; color:#718096; margin:0;">Le syst&egrave;me repose sur 3 &eacute;l&eacute;ments connect&eacute;s&nbsp;: le SEO local, les contenus immobiliers et les tunnels d'estimation.</p>
 </div>

 <!-- Flux -->
 <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); padding:36px; text-align:center; margin-bottom:40px;">
 <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0;">
 <?php
 $flow = ['Recherche Google','Article local','Avis de valeur','Lead CRM','Prise de RDV','Mandat sign&eacute;'];
 foreach ($flow as $fi => $f):
 ?>
 <div class="demo-flow-box"><?= $f ?></div>
 <?php if ($fi < count($flow)-1): ?><span class="demo-flow-arr">&#8594;</span><?php endif; endforeach; ?>
 </div>
 <p style="margin:18px 0 0; font-size:0.87rem; color:#718096;">Le syst&egrave;me travaille 24h/24, m&ecirc;me lorsque vous &ecirc;tes en visite.</p>
 </div>

 <!-- 3 leviers -->
 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:20px;">
 <?php
 $leviers = [
 ['', 'SEO local', 'Vos pages et articles apparaissent quand un vendeur cherche sur Google dans votre ville.'],
 ['', 'Contenus immobiliers', 'L\'IA g&eacute;n&egrave;re des articles, emails et posts cibl&eacute;s sur votre secteur.'],
 ['', 'Tunnels d\'estimation', 'Les visiteurs deviennent des prospects via l\'outil d\'estimation int&eacute;gr&eacute;.'],
 ];
 foreach ($leviers as $l):
 ?>
 <div class="demo-card" style="padding:26px; text-align:center;">
 <div style="font-size:2rem; margin-bottom:12px;"><?= $l[0] ?></div>
 <strong style="color:#1a202c; display:block; margin-bottom:8px;"><?= $l[1] ?></strong>
 <p style="color:#718096; margin:0; font-size:0.88rem; line-height:1.55;"><?= $l[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
 </div>
</section>

<!-- ═══ CE QUE VOUS ALLEZ VOIR ═══ -->
<section style="padding:80px 0;">
 <div class="container">
 <div style="max-width:860px; margin:0 auto;">
 <div style="text-align:center; margin-bottom:50px;">
 <span class="demo-section-badge" style="background:#c7d2fe; color:#3730a3;"> Ce que vous allez d&eacute;couvrir</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:0;">Dans cette d&eacute;monstration</h2>
 </div>

 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:18px;">
 <?php
 $modules = [
 ['', 'Le site immobilier optimis&eacute; SEO',
 'Des pages g&eacute;olocalis&eacute;es con&ccedil;ues pour appara&icirc;tre sur Google.'],
 ['', 'Le blog immobilier automatis&eacute;',
 'Des articles g&eacute;n&eacute;r&eacute;s avec l\'IA pour attirer les vendeurs de votre ville.'],
 ['', 'Le CRM immobilier int&eacute;gr&eacute;',
 'Contacts, leads et mandats centralis&eacute;s dans un seul syst&egrave;me.'],
 ['', 'Les automatisations marketing',
 'Emails, SMS et relances automatiques. Le syst&egrave;me continue pendant que vous &ecirc;tes sur le terrain.'],
 ['', 'L\'outil d\'estimation en ligne',
 'Un tunnel qui transforme les visiteurs en prospects vendeurs qualifi&eacute;s.'],
 ['', 'L\'assistant IA',
 'G&eacute;n&eacute;ration instantan&eacute;e de contenus, emails et posts en quelques clics.'],
 ];
 foreach ($modules as $m):
 ?>
 <div class="demo-card" style="padding:22px; border-left:4px solid #667eea;">
 <div style="font-size:1.6rem; margin-bottom:9px;"><?= $m[0] ?></div>
 <strong style="color:#1a202c; font-size:0.95rem;"><?= $m[1] ?></strong>
 <p style="color:#718096; margin:7px 0 0; font-size:0.87rem; line-height:1.5;"><?= $m[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
 </div>
</section>

<!-- ═══ EXCLUSIVITÉ ═══ -->
<section style="padding:70px 0; background:#f7fafc;">
 <div class="container">
 <div style="max-width:720px; margin:0 auto; text-align:center;">

 <span class="demo-section-badge" style="background:#fce7f3; color:#be123c;"> L'Exclusivit&eacute;</span>
 <h2 style="font-size:2rem; color:#1a202c; margin-bottom:16px;">Une seule licence par ville</h2>
 <p style="font-size:1.05rem; color:#4a5568; line-height:1.8; margin-bottom:30px;">
 Contrairement aux logiciels classiques, nous limitons volontairement le nombre d'utilisateurs.<br>
 Cela garantit&nbsp;: aucune concurrence interne, un SEO local prot&eacute;g&eacute; et une position digitale forte dans votre secteur.
 </p>

 <div style="padding:24px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:14px; margin-bottom:28px;">
 <p style="font-size:1.3rem; color:white; font-weight:700; margin:0;">
 1 ville = 1 seul professionnel immobilier
 </p>
 </div>

 <p style="font-size:0.92rem; font-weight:600; color:#718096; margin-bottom:16px;">Villes d&eacute;j&agrave; r&eacute;serv&eacute;es :</p>
 <div style="display:flex; flex-wrap:wrap; gap:9px; justify-content:center; margin-bottom:18px;">
 <?php foreach (['Bordeaux','Nantes','Aix-en-Provence','Lannion'] as $v): ?>
 <span class="ville-tag"><?= $v ?></span>
 <?php endforeach; ?>
 </div>
 <p style="font-size:0.88rem; color:#718096; margin:0;">
 Une fois une ville r&eacute;serv&eacute;e, elle est <strong>d&eacute;finitivement verrouill&eacute;e</strong>.
 </p>
 </div>
 </div>
</section>

<!-- ═══ RDV DEMO ═══ -->
<section id="rdv" style="padding:90px 0;">
 <div class="container">
 <div style="display:grid; grid-template-columns:1fr 1fr; gap:50px; max-width:980px; margin:0 auto; align-items:start;">

 <!-- Gauche : pourquoi -->
 <div>
 <span class="demo-section-badge" style="background:#d1fae5; color:#065f46;"> La prochaine &eacute;tape</span>
 <h2 style="font-size:1.9rem; color:#1a202c; margin-bottom:16px;">R&eacute;servez une d&eacute;mo personnalis&eacute;e</h2>
 <p style="color:#4a5568; font-size:1rem; line-height:1.8; margin-bottom:28px;">
 Si votre ville est encore disponible, vous pouvez r&eacute;server une d&eacute;monstration personnalis&eacute;e.<br>
 Lors de cet &eacute;change de 20 minutes, nous vous montrerons&nbsp;:
 </p>
 <div style="display:grid; gap:12px; margin-bottom:30px;">
 <?php
 $points = [
 'Comment le syst&egrave;me fonctionne dans votre secteur',
 'Comment attirer des vendeurs localement sans portails',
 'Comment r&eacute;server votre licence territoriale',
 ];
 foreach ($points as $p):
 ?>
 <div style="display:flex; align-items:center; gap:12px; padding:14px 18px; background:#f7fafc; border-radius:10px; border-left:4px solid #667eea;">
 <span style="color:#667eea; font-size:1rem; flex-shrink:0;"></span>
 <p style="margin:0; color:#2d3748; font-size:0.94rem;"><?= $p ?></p>
 </div>
 <?php endforeach; ?>
 </div>

 <a href="/front/pages/verifier-ma-ville.php" style="display:inline-flex; align-items:center; gap:8px; background:#f7fafc; border:2px solid #667eea; color:#667eea; font-weight:600; font-size:0.95rem; padding:12px 24px; border-radius:11px; text-decoration:none; transition:background 0.2s;">
 V&eacute;rifier si ma ville est disponible
 </a>
 </div>

 <!-- Droite : formulaire -->
 <div>
 <form action="/traitement-rdv.php" method="POST" style="background:white; padding:32px; border-radius:16px; box-shadow:0 4px 20px rgba(102,126,234,0.12);">
 <?= csrfField() ?>
 <p style="font-size:1.05rem; font-weight:700; color:#1a202c; margin:0 0 22px;"> R&eacute;server ma d&eacute;mo gratuite</p>

 <div class="rdv-group">
 <label for="rdv_nom">Nom complet *</label>
 <input type="text" id="rdv_nom" name="nom" placeholder="Jean Dupont" required>
 </div>
 <div class="rdv-group">
 <label for="rdv_email">Email *</label>
 <input type="email" id="rdv_email" name="email" placeholder="jean@exemple.fr" required>
 </div>
 <div class="rdv-group">
 <label for="rdv_telephone">T&eacute;l&eacute;phone *</label>
 <input type="tel" id="rdv_telephone" name="telephone" placeholder="06 xx xx xx xx" required>
 </div>
 <div class="rdv-group">
 <label for="rdv_ville">Votre ville *</label>
 <input type="text" id="rdv_ville" name="ville" placeholder="Ex&nbsp;: Lyon, Rennes&hellip;" required>
 </div>
 <div class="rdv-group" style="margin-bottom:22px;">
 <label for="rdv_reseau">Votre r&eacute;seau</label>
 <select id="rdv_reseau" name="reseau">
 <option value="">S&eacute;lectionnez&hellip;</option>
 <option>IAD</option>
 <option>Safti</option>
 <option>eXp Realty</option>
 <option>Megagence</option>
 <option>Ag&eacute;nce ind&eacute;pendante</option>
 <option>Autre</option>
 </select>
 </div>

 <button type="submit" class="rdv-submit">
 <span class="demo-pulse" style="background:#FDCB6E; width:8px; height:8px;"></span>
 R&eacute;server ma d&eacute;mo gratuite
 </button>
 <p style="text-align:center; margin:12px 0 0; font-size:0.81rem; color:#a0aec0;">
 Sans engagement &mdash; r&eacute;ponse sous 24h
 </p>
 </form>
 </div>

 </div>
 </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
