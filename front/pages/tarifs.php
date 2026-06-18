<?php
$pageTitle = "Tarifs — &Eacute;COSYST&Egrave;ME IMMO LOCAL+";
$pageDescription = 'Syst&egrave;me d\'acquisition local vendeurs pour conseillers immobiliers ind&eacute;pendants. Estimateur, syst&egrave;me complet ou offre annuelle avec exclusivit&eacute; territoriale.';
$currentPage = 'tarifs';

include '../../includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.tarif-grid {
 display: grid;
 grid-template-columns: repeat(3, minmax(0, 1fr));
 gap: 20px;
 max-width: 1040px;
 margin: 0 auto 24px;
}

.tarif-card {
 background: #ffffff;
 border: 1.5px solid #e2e8f0;
 border-radius: 18px;
 padding: 28px 24px;
 box-shadow: 0 4px 16px rgba(0,0,0,0.05);
 position: relative;
 display: flex;
 flex-direction: column;
}

.tarif-card.is-featured {
 border: 2px solid #667eea;
 box-shadow: 0 12px 36px rgba(102,126,234,0.16);
}

.tarif-label {
 display: inline-block;
 font-size: 0.75rem;
 font-weight: 700;
 letter-spacing: 0.04em;
 text-transform: uppercase;
 border-radius: 999px;
 padding: 5px 11px;
 margin-bottom: 16px;
}

.tarif-name {
 font-size: 1.15rem;
 font-weight: 700;
 color: #0f172a;
 margin-bottom: 10px;
}

.tarif-price {
 font-size: 2.1rem;
 font-weight: 800;
 color: #0f172a;
 line-height: 1.1;
 margin-bottom: 3px;
}

.tarif-price-sub {
 font-size: 0.88rem;
 color: #64748b;
 margin-bottom: 18px;
}

.tarif-features {
 list-style: none;
 padding: 0;
 margin: 0 0 20px;
 display: grid;
 gap: 9px;
 flex: 1;
}

.tarif-features li {
 display: flex;
 align-items: flex-start;
 gap: 9px;
 color: #334155;
 font-size: 0.9rem;
 line-height: 1.45;
}

.tarif-features li::before {
 content: "";
 color: #4f46e5;
 font-weight: 700;
 flex-shrink: 0;
 margin-top: 1px;
}

.tarif-cta-primary {
 display: block;
 text-align: center;
 background: #667eea;
 color: #fff;
 font-weight: 700;
 font-size: 0.97rem;
 padding: 13px 16px;
 border-radius: 11px;
 text-decoration: none;
 transition: opacity 0.2s, transform 0.2s;
 margin-bottom: 9px;
}
.tarif-cta-primary:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }

.tarif-cta-ghost {
 display: block;
 text-align: center;
 background: transparent;
 color: #667eea;
 border: 1.5px solid #c7d2fe;
 font-weight: 600;
 font-size: 0.92rem;
 padding: 11px 16px;
 border-radius: 11px;
 text-decoration: none;
 transition: background 0.2s;
}
.tarif-cta-ghost:hover { background: #eef2ff; }

.tarif-note-box {
 max-width: 900px;
 margin: 0 auto 24px;
 background: #eef2ff;
 border: 1px solid #c7d2fe;
 border-radius: 12px;
 padding: 14px 18px;
 font-size: 0.91rem;
 color: #3730a3;
 text-align: center;
 line-height: 1.6;
}

.tarif-option-box {
 max-width: 900px;
 margin: 0 auto;
 background: #fff;
 border: 1.5px solid #e2e8f0;
 border-radius: 14px;
 padding: 22px 24px;
 display: flex;
 align-items: center;
 justify-content: space-between;
 gap: 20px;
 flex-wrap: wrap;
 box-shadow: 0 3px 14px rgba(15,23,42,0.05);
}

.tarif-faq-grid {
 max-width: 900px;
 margin: 32px auto 0;
 display: grid;
 grid-template-columns: repeat(2, minmax(0,1fr));
 gap: 14px;
}

.tarif-faq-item {
 background: #fff;
 border: 1px solid #e2e8f0;
 border-radius: 12px;
 padding: 18px;
}

.tarif-faq-item strong {
 display: block;
 color: #0f172a;
 font-size: 0.94rem;
 margin-bottom: 7px;
}

.tarif-faq-item p {
 margin: 0;
 color: #64748b;
 font-size: 0.88rem;
 line-height: 1.55;
}

.fondateur-box {
 max-width: 900px;
 margin: 0 auto;
 background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
 border: 1.5px solid #c7d2fe;
 border-radius: 16px;
 padding: 28px 32px;
 display: grid;
 grid-template-columns: 1fr auto;
 gap: 24px;
 align-items: center;
}

@media (max-width: 992px) {
 .tarif-grid { grid-template-columns: 1fr; max-width: 560px; }
 .tarif-card.is-featured { border: 2px solid #667eea; }
 .tarif-faq-grid { grid-template-columns: 1fr; }
 .fondateur-box { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
 .tarif-price { font-size: 1.8rem; }
 .tarif-card { padding: 22px 18px; }
 .tarif-option-box { flex-direction: column; gap: 14px; }
}
</style>

<!-- HERO -->
<section style="padding:90px 0 76px; text-align:center; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); animation:fadeUp 0.6s ease both;">
 <div class="container">
 <div style="color:white; max-width:720px; margin:0 auto;">
 <span style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; border-radius:30px; padding:6px 18px; font-size:0.84rem; font-weight:600; margin-bottom:22px;">
 <span style="width:7px;height:7px;border-radius:50%;background:#FDCB6E;display:inline-block;"></span>
 Exclusivit&eacute; territoriale garantie &mdash; 1 conseiller par zone
 </span>
 <h1 style="font-size:2.7rem; font-weight:800; line-height:1.2; color:white; margin-bottom:18px;">
 Choisissez votre rythme de d&eacute;ploiement local
 </h1>
 <p style="font-size:1.1rem; opacity:0.95; line-height:1.75; margin-bottom:32px; max-width:640px; margin-left:auto; margin-right:auto;">
 Des offres pens&eacute;es pour un seul objectif&nbsp;: g&eacute;n&eacute;rer des vendeurs qualifi&eacute;s dans votre zone et convertir en mandats.
 </p>
 <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
 <a href="/verifier-ma-ville" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:14px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18);">
 V&eacute;rifier si ma ville est disponible
 </a>
 <a href="/rdv" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:12px 28px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
 R&eacute;server un appel
 </a>
 </div>
 </div>
 </div>
</section>

<!-- PRICING GRID -->
<section style="padding:90px 0; background:#f8fafc;">
 <div class="container">
 <div style="text-align:center; margin-bottom:50px;">
 <span style="display:inline-block; background:#dbeafe; color:#1e40af; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;">Tarifs transparents</span>
 <h2 style="font-size:2.05rem; color:#0f172a; margin-bottom:12px;">Trois formats selon votre objectif</h2>
 <p style="font-size:1rem; color:#64748b; margin:0; max-width:680px; margin-left:auto; margin-right:auto;">
 Un seul mandat peut rentabiliser plusieurs mois d'abonnement. Chaque format inclut l'acc&egrave;s fondateur et l'exclusivit&eacute; sur votre zone.
 </p>
 </div>

 <div class="tarif-grid">

 <!-- Estimateur seul -->
 <article class="tarif-card">
 <span class="tarif-label" style="background:#f1f5f9; color:#475569;">Entr&eacute;e rapide</span>
 <div class="tarif-name">Estimateur seul</div>
 <div class="tarif-price">27&euro;<span style="font-size:1.1rem; font-weight:500; color:#64748b;">/mois</span></div>
 <div class="tarif-price-sub">+ 197&euro; setup unique</div>
 <ul class="tarif-features">
 <li>Estimateur local install&eacute; sur votre site</li>
 <li>Capture vendeurs 24h/24 sur vos pages</li>
 <li>Suivi des leads entrants</li>
 <li>Configuration et mise en ligne incluses</li>
 </ul>
 <a href="/verifier-ma-ville" class="tarif-cta-primary">V&eacute;rifier ma ville</a>
 <a href="/rdv" class="tarif-cta-ghost">R&eacute;server un appel</a>
 </article>

 <!-- Standard mensuel — featured -->
 <article class="tarif-card is-featured">
 <span class="tarif-label" style="background:#ede9fe; color:#5b21b6;">Recommand&eacute;</span>
 <div class="tarif-name">Syst&egrave;me complet mensuel</div>
 <div class="tarif-price">97&euro;<span style="font-size:1.1rem; font-weight:500; color:#64748b;">/mois</span></div>
 <div class="tarif-price-sub">+ 497&euro; setup &bull; 3 premiers mois pr&eacute;pay&eacute;s</div>
 <ul class="tarif-features">
 <li>Syst&egrave;me d'acquisition local complet</li>
 <li>Tunnel vendeur&nbsp;: visibilit&eacute; &rarr; estimation &rarr; RDV</li>
 <li>CRM, automatisations, blog SEO local</li>
 <li>Assistant IA + GMB int&eacute;gr&eacute;</li>
 <li>Accompagnement d&eacute;ploiement inclus</li>
 </ul>
 <a href="/verifier-ma-ville" class="tarif-cta-primary" style="background:linear-gradient(135deg,#667eea,#764ba2); box-shadow:0 6px 20px rgba(102,126,234,0.3);">V&eacute;rifier ma ville</a>
 <a href="/rdv" class="tarif-cta-ghost">R&eacute;server un appel</a>
 </article>

 <!-- Annuel -->
 <article class="tarif-card">
 <span class="tarif-label" style="background:#ecfdf5; color:#065f46;">Position dominante</span>
 <div class="tarif-name">Annuel &mdash; Exclusivit&eacute; incluse</div>
 <div class="tarif-price">897&euro;<span style="font-size:1.1rem; font-weight:500; color:#64748b;">/an</span></div>
 <div class="tarif-price-sub">Setup offert &bull; exclusivit&eacute; territoriale int&eacute;gr&eacute;e</div>
 <ul class="tarif-features">
 <li>Tout le syst&egrave;me complet mensuel inclus</li>
 <li>Exclusivit&eacute; territoriale verrouill&eacute;e sur votre zone</li>
 <li>D&eacute;ploiement prioritaire</li>
 <li>Co&ucirc;t optimis&eacute; sur 12 mois vs mensuel</li>
 </ul>
 <a href="/verifier-ma-ville" class="tarif-cta-primary">V&eacute;rifier ma ville</a>
 <a href="/rdv" class="tarif-cta-ghost">R&eacute;server un appel</a>
 </article>

 </div>

 <p class="tarif-note-box">
 Les 3 mois pr&eacute;pay&eacute;s sur l'offre standard laissent le temps au syst&egrave;me local de produire ses premiers r&eacute;sultats mesurables.
 </p>

 <!-- Option exclusivité -->
 <div class="tarif-option-box">
 <div>
 <strong style="display:block; color:#0f172a; font-size:1rem; margin-bottom:5px;">Option&nbsp;: Exclusivit&eacute; verrouill&eacute;e</strong>
 <p style="color:#64748b; font-size:0.9rem; line-height:1.55; margin:0;">
 Disponible en compl&eacute;ment de certaines offres. Votre zone est verrouill&eacute;e d&eacute;finitivement, m&ecirc;me si vous choisissez de mettre en pause votre abonnement.
 </p>
 </div>
 <div style="flex-shrink:0; text-align:right;">
 <div style="font-size:1.7rem; font-weight:800; color:#0f172a;">900&euro;</div>
 <div style="font-size:0.85rem; color:#64748b;">paiement unique</div>
 </div>
 </div>
 </div>
</section>

<!-- PROGRAMME FONDATEURS -->
<section style="padding:80px 0; background:#fff;">
 <div class="container">
 <div style="text-align:center; margin-bottom:44px;">
 <span style="display:inline-block; background:#fce7f3; color:#be123c; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;">Programme Fondateurs</span>
 <h2 style="font-size:2rem; color:#0f172a; margin-bottom:12px;">Un acc&egrave;s fondateur, pour ceux qui s'engagent t&ocirc;t</h2>
 <p style="font-size:1rem; color:#64748b; margin:0; max-width:680px; margin-left:auto; margin-right:auto;">
 Les premiers partenaires b&eacute;n&eacute;ficient de conditions pr&eacute;f&eacute;rentielles &agrave; vie, en &eacute;change d'un engagement actif sur leur zone et de retours terrain r&eacute;guliers.
 </p>
 </div>

 <div class="fondateur-box">
 <div>
 <div style="display:grid; gap:12px; margin-bottom:20px;">
 <?php
 $fBenefs = [
 'Conditions tarifaires pr&eacute;f&eacute;rentielles conserv&eacute;es &agrave; vie',
 'Accompagnement prioritaire et onboarding d&eacute;di&eacute;',
 'Statut fondateur avec exclusivit&eacute; territoriale garantie',
 'Feedback loop direct avec l\'&eacute;quipe produit',
 ];
 foreach ($fBenefs as $b):
 ?>
 <div style="display:flex; align-items:center; gap:10px; font-size:0.92rem; color:#334155;">
 <span style="color:#4f46e5; font-weight:700; flex-shrink:0;"></span>
 <?= $b ?>
 </div>
 <?php endforeach; ?>
 </div>
 <div style="padding:14px 16px; background:#fee2e2; border-radius:10px; border:1px solid #fecaca;">
 <p style="color:#991b1b; margin:0; font-size:0.89rem; font-weight:600;">
 Villes d&eacute;j&agrave; r&eacute;serv&eacute;es&nbsp;: Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion.
 Les nouvelles admissions sont sur validation de zone uniquement.
 </p>
 </div>
 </div>
 <div style="flex-shrink:0; text-align:center;">
 <a href="/verifier-ma-ville" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#667eea,#764ba2); color:white; font-weight:700; font-size:0.97rem; padding:13px 24px; border-radius:11px; text-decoration:none; box-shadow:0 6px 20px rgba(102,126,234,0.28); white-space:nowrap;">
 V&eacute;rifier ma zone
 </a>
 <p style="color:#94a3b8; font-size:0.8rem; margin:10px 0 0;">R&eacute;ponse sous 24h</p>
 </div>
 </div>
 </div>
</section>

<!-- FAQ TARIFS -->
<section style="padding:80px 0; background:#f8fafc;">
 <div class="container">
 <div style="text-align:center; margin-bottom:44px;">
 <span style="display:inline-block; background:#ede9fe; color:#5b21b6; padding:6px 16px; border-radius:20px; font-size:0.85rem; font-weight:600; margin-bottom:14px;">FAQ</span>
 <h2 style="font-size:2rem; color:#0f172a; margin-bottom:0;">Questions avant de valider votre zone</h2>
 </div>

 <?php
 $faqItems = [
 ['q' => 'Pourquoi 3 mois pr&eacute;pay&eacute;s sur l\'offre standard&nbsp;?',
 'a' => 'Pour laisser le temps au syst&egrave;me local de produire ses premiers r&eacute;sultats mesurables. Un syst&egrave;me SEO + contenu + automatisations n\'est pas instantan&eacute; &mdash; 90 jours est le d&eacute;lai m&eacute;dian avant les premiers RDV vendeurs entrants.'],
 ['q' => 'L\'exclusivit&eacute; &agrave; 900&euro; est-elle obligatoire&nbsp;?',
 'a' => 'Non. C\'est une option compl&eacute;mentaire selon votre zone et votre strat&eacute;gie. L\'offre annuelle inclut d&eacute;j&agrave; l\'exclusivit&eacute; territoriale.'],
 ['q' => 'Puis-je arr&ecirc;ter quand je veux&nbsp;?',
 'a' => 'Oui. Les modalit&eacute;s de sortie sont clarifi&eacute;es avant signature. L\'objectif est un partenariat utile, pas un engagement subi.'],
 ['q' => 'Combien de temps avant d\'&ecirc;tre en ligne&nbsp;?',
 'a' => 'G&eacute;n&eacute;ralement quelques jours apr&egrave;s validation de votre zone et des &eacute;l&eacute;ments de base (logo, descriptif, zone g&eacute;o).'],
 ['q' => 'Compatible avec mon r&eacute;seau actuel&nbsp;?',
 'a' => 'Oui. IAD, SAFTI, eXp, ind&eacute;pendant ou agence. On adapte l\'int&eacute;gration &agrave; votre contexte pour &eacute;viter de repartir de z&eacute;ro inutilement.'],
 ['q' => 'Est-ce adapt&eacute; aux petites villes&nbsp;?',
 'a' => 'Oui, tant qu\'il y a une demande locale. L\'approche SEO local est plus facile &agrave; dominer dans une ville moyenne que dans une grande agglom&eacute;ration.'],
 ];
 ?>

 <div class="tarif-faq-grid">
 <?php foreach ($faqItems as $item): ?>
 <div class="tarif-faq-item">
 <strong><?= $item['q'] ?></strong>
 <p><?= $item['a'] ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
</section>

<!-- CTA FINAL -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); text-align:center;">
 <div class="container">
 <div style="max-width:620px; margin:0 auto; color:white;">
 <span style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; border-radius:30px; padding:6px 18px; font-size:0.84rem; font-weight:600; margin-bottom:22px;">
 <span style="width:7px;height:7px;border-radius:50%;background:#FDCB6E;display:inline-block;"></span>
 V&eacute;rifiez avant qu'un concurrent ne r&eacute;serve
 </span>
 <h2 style="font-size:2.2rem; color:white; margin-bottom:16px; font-weight:800;">Votre ville est-elle encore disponible&nbsp;?</h2>
 <p style="font-size:1.1rem; opacity:0.95; margin-bottom:36px; line-height:1.7;">
 Chaque ville ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul professionnel.<br>
 Une fois r&eacute;serv&eacute;e, l'acc&egrave;s est d&eacute;finitivement ferm&eacute;.
 </p>
 <div style="display:flex; justify-content:center; gap:14px; flex-wrap:wrap;">
 <a href="/verifier-ma-ville" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:15px 34px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.2);">
 V&eacute;rifier ma ville maintenant
 </a>
 <a href="/rdv" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:13px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
 R&eacute;server un appel
 </a>
 </div>
 <p style="font-size:0.86rem; opacity:0.78; margin-top:20px; margin-bottom:0;">
 V&eacute;rification gratuite &bull; r&eacute;ponse sous 24h &bull; aucune obligation
 </p>
 </div>
 </div>
</section>

<?php include '../../includes/footer.php'; ?>
