<?php
$pageTitle = "Tarifs - &Eacute;COSYST&Egrave;ME IMMO LOCAL+";
$pageDescription = 'Programme Fondateurs + Coaching Immobilier Digital. Acc&egrave;s anticip&eacute; en places limit&eacute;es.';
$currentPage = 'tarifs';

$schemaFAQ = [
 ['question' => 'Le tarif fondateur peut-il évoluer ?', 'answer' => 'Le tarif fondateur est réservé aux partenaires acceptés dans le Programme Fondateurs. Les conditions sont précisées avant validation.'],
 ['question' => 'Combien de places sont ouvertes ?', 'answer' => 'Le Programme Fondateurs est volontairement limité pour pr&eacute;server la qualit&eacute; d\'accompagnement et l\'exclusivit&eacute; territoriale.'],
 ['question' => 'Je dois être dans l\'immobilier ?', 'answer' => 'Oui. Conseillers indépendants (IAD, Safti, eXp...) ou agents solo. Autre profil ? Contacte-nous, on discute.'],
 ['question' => 'Quel contrat ? Je peux partir ?', 'answer' => 'On pr&eacute;f&egrave;re 3-6 mois pour laisser le temps au d&eacute;ploiement local. Mais on discute au cas par cas. L\'important : avancer s&eacute;rieusement.'],
 ['question' => 'Programme Fondateurs + coaching, compatible ?', 'answer' => 'Oui. L\'accès fondateur et le coaching peuvent être combinés pour accélérer la mise en place locale.'],
];

include '../../includes/header.php';
?>

<!-- HERO -->
<section class="hero" style="padding: 100px 0; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
 <div class="container">
 <div class="hero-content" style="color: white; max-width: 700px; margin: 0 auto;">
 <h1 style="font-size: 2.8rem; font-weight: 700; line-height: 1.2; margin-bottom: 20px; color: white;">
 Rejoignez le Programme Fondateurs
 </h1>
 <p class="hero-subtitle" style="font-size: 1.2rem; opacity: 0.95; line-height: 1.6; margin-bottom: 40px;">
 Acc&egrave;s anticip&eacute; en places limit&eacute;es. <strong>Deux chemins</strong> pour acc&eacute;der &agrave; l'&eacute;cosyst&egrave;me.
 <br>Tarif fondateur disponible selon votre zone.
 </p>
 <div class="hero-buttons" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
 <a href="/front/pages/contact.php?type=fondateur" class="btn btn-primary btn-lg" style="background: white; color: #667eea; font-weight: 600;">
 Demander un acc&egrave;s fondateur
 </a>
 <a href="#chemins" class="btn btn-secondary btn-lg" style="background: transparent; border: 2px solid white; color: white; font-weight: 600;">
 D&eacute;couvrir
 </a>
 </div>
 </div>
 </div>
</section>

<!-- STATUT FONDATEURS -->
<section class="bg-light" style="padding: 80px 0;">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #fee2e2; color: #991b1b; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> Statut du programme</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c; margin-bottom: 15px;">O&ugrave; en est-on aujourd'hui ?</h2>
 </div>

 <div style="max-width: 750px; margin: 0 auto; display: grid; gap: 15px;">
 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Partenaires fondateurs actifs</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Ils utilisent la plateforme au quotidien et partagent leurs retours terrain.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;">⏳</span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">+1 en cours d'onboarding</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Installation et configuration en cours sur son serveur d&eacute;di&eacute;.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #10b981;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">4 places encore disponibles</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Places fondateurs limit&eacute;es pour conserver un accompagnement premium.</p>
 </div>
 </div>
 </div>

 <div style="text-align: center; margin-top: 50px; padding: 30px; background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(102, 126, 234, 0.1); max-width: 650px; margin-left: auto; margin-right: auto;">
 <p style="font-size: 1.1rem; color: #1a202c; margin: 0; line-height: 1.8;">
 Le probl&egrave;me n'est pas votre <strong>motivation</strong>.<br>
 C'est l'absence d'un <strong>syst&egrave;me qui travaille pour vous</strong>.
 </p>
 </div>
 </div>
</section>

<!-- POURQUOI PAS DE GRILLE -->
<section style="padding: 80px 0;">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #fef3c7; color: #92400e; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> Notre approche</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c; margin-bottom: 30px;">Pourquoi pas de grille tarifaire ?</h2>
 </div>

 <div style="max-width: 700px; margin: 0 auto; text-align: center; margin-bottom: 50px;">
 <p style="font-size: 1.15rem; color: #4a5568; line-height: 1.8; margin-bottom: 25px;">
 Chaque conseiller immobilier a une zone diff&eacute;rente, un march&eacute; diff&eacute;rent, une ambition diff&eacute;rente.<br>
 Un tarif unique ne refl&egrave;terait pas la r&eacute;alit&eacute; de votre projet.
 </p>
 <p style="font-size: 1.25rem; color: #1a202c; line-height: 1.8; font-weight: 600; margin: 0;">
 On pr&eacute;f&egrave;re discuter, comprendre votre situation, et construire une offre adapt&eacute;e.
 </p>
 </div>

 <div style="padding: 30px; background: #f7fafc; border-left: 4px solid #667eea; border-radius: 0 12px 12px 0; max-width: 650px; margin: 0 auto; text-align: left;">
 <p style="color: #2d3748; margin: 0; font-style: italic; font-size: 1.05rem;">
 "Nous limitons volontairement les acc&egrave;s pour conserver un accompagnement haut niveau et une ex&eacute;cution locale de qualit&eacute;."
 </p>
 </div>
 </div>
</section>

<!-- DEUX CHEMINS -->
<section class="bg-light" style="padding: 80px 0;" id="chemins">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #dbeafe; color: #1e40af; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> Les deux chemins</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c; margin-bottom: 15px;">Deux fa&ccedil;ons d'avancer avec nous</h2>
 <p style="font-size: 1.1rem; color: #718096;">Selon ton niveau et tes objectifs</p>
 </div>

 <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; max-width: 900px; margin: 0 auto; margin-bottom: 50px;">
 <div style="padding: 30px; background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); text-align: center;">
 <div style="font-size: 2.5rem; margin-bottom: 15px;"></div>
 <h3 style="color: #1a202c; margin-bottom: 10px; font-size: 1.3rem;">Programme Fondateurs</h3>
 <p style="color: #667eea; font-weight: 600; margin-bottom: 12px;">Acc&egrave;s complet &agrave; la plateforme</p>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Vous activez un syst&egrave;me complet avec exclusivit&eacute; territoriale, onboarding personnalis&eacute; et accompagnement prioritaire.</p>
 </div>

 <div style="padding: 30px; background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); text-align: center;">
 <div style="font-size: 2.5rem; margin-bottom: 15px;"></div>
 <h3 style="color: #1a202c; margin-bottom: 10px; font-size: 1.3rem;">Coaching Digital Immobilier</h3>
 <p style="color: #667eea; font-weight: 600; margin-bottom: 12px;">Apprendre la strat&eacute;gie maintenant</p>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Audit digital, SEO local, Google My Business, tunnels de capture, publicit&eacute; digitale. Accompagnement 3-6 mois avec appels hebdo et Slack priv&eacute;.</p>
 </div>
 </div>

 <div style="padding: 30px; background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 700px; margin: 0 auto; text-align: center;">
 <h3 style="color: #1a202c; margin-bottom: 20px;"> La vraie diff&eacute;rence :</h3>
 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
 <div style="padding: 20px; background: #fee2e2; border-radius: 8px;">
 <strong style="color: #991b1b; display: block; margin-bottom: 8px;"> Un seul chemin</strong>
 <p style="color: #991b1b; margin: 0; font-size: 0.9rem;">Tu avances, mais &agrave; ton rythme</p>
 </div>
 <div style="padding: 20px; background: #d1fae5; border-radius: 8px;">
 <strong style="color: #065f46; display: block; margin-bottom: 8px;"> Fondateur + Coaching</strong>
 <p style="color: #065f46; margin: 0; font-size: 0.9rem;">Tu acc&eacute;l&egrave;res la courbe d'apprentissage</p>
 </div>
 </div>
 </div>
 </div>
</section>

<!-- CE QUE TU REÇOIS -->
<section style="padding: 80px 0;">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #e9d5ff; color: #6b21a8; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> Programme Fondateurs</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c; margin-bottom: 15px;">Ce que vous recevez avec l'acc&egrave;s fondateur</h2>
 <p style="font-size: 1.1rem; color: #718096;">Tout est inclus &mdash; sur devis selon ta zone et ton ambition</p>
 </div>

 <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto;">
 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Plateforme compl&egrave;te</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">43 modules install&eacute;s sur ton serveur : site, CRM, SEO, IA, automation.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;">️</div>
 <strong style="color: #1a202c;">Exclusivit&eacute; zone 50km</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Personne d'autre ne peut acheter le syst&egrave;me dans ta zone.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Onboarding personnalis&eacute;</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">2-3h de visio pour configurer et lancer ta machine.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Support direct</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Feedback loop permanent, corrections prioritaires.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Statut Fondateur</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">T&eacute;moignage de lancement + tarif pr&eacute;f&eacute;rentiel &agrave; vie.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Transition douce</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Vous conservez vos conditions fondateurs valid&eacute;es &agrave; l'entr&eacute;e.</p>
 </div>
 </div>
 </div>
</section>

<!-- CE QU'ON ATTEND -->
<section class="bg-light" style="padding: 80px 0;">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #fce7f3; color: #be123c; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> En &eacute;change</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c;">Ce qu'on attend de toi</h2>
 </div>

 <div style="max-width: 750px; margin: 0 auto;">
 <div style="display: grid; gap: 15px; margin-bottom: 40px;">
 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">S'engager 3-6 mois sur votre zone</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Activer le syst&egrave;me local au quotidien, pas seulement en surface.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Remonter les bugs et id&eacute;es</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Tes retours am&eacute;liorent le produit pour tout le monde.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Donner un avis honn&ecirc;te</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Positif ou n&eacute;gatif, c'est le feedback qui compte.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Partager tes r&eacute;sultats</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Si &ccedil;a marche pour toi, on veut pouvoir le montrer.</p>
 </div>
 </div>
 </div>

 <div style="text-align: center; padding: 20px; background: #fee2e2; border-radius: 12px; border: 1px solid #fecaca;">
 <p style="color: #991b1b; margin: 0; font-weight: 500;">
 ️ Villes d&eacute;j&agrave; r&eacute;serv&eacute;es : Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion
 </p>
 </div>
 </div>
 </div>
</section>

<!-- COACHING DÉTAIL -->
<section style="padding: 80px 0;">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #d1fae5; color: #065f46; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> Coaching Digital</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c; margin-bottom: 15px;">Apprendre la strat&eacute;gie sans attendre</h2>
 <p style="font-size: 1.1rem; color: #718096;">M&ecirc;me sans la plateforme, tu peux d&eacute;marrer ta pr&eacute;sence digitale</p>
 </div>

 <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto;">
 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #10b981;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Audit digital complet</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Analyse de ta pr&eacute;sence en ligne actuelle et recommandations.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #10b981;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">SEO local + GMB</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Strat&eacute;gie de r&eacute;f&eacute;rencement et fiche Google optimis&eacute;e.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #10b981;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;">️</div>
 <strong style="color: #1a202c;">Contenu + capture</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Plan contenu, articles, landing pages et lead magnets.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #10b981;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Publicit&eacute; digitale</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Facebook Ads, Google Ads, suivi et ajustement continu.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #10b981;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Appels hebdo</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">30-45 min chaque semaine pour avancer concr&egrave;tement.</p>
 </div>

 <div style="padding: 25px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #10b981;">
 <div style="font-size: 1.8rem; margin-bottom: 10px;"></div>
 <strong style="color: #1a202c;">Slack priv&eacute;</strong>
 <p style="color: #718096; margin: 8px 0 0 0; font-size: 0.9rem;">Support continu entre les appels, r&eacute;ponses rapides.</p>
 </div>
 </div>
 </div>
</section>

<!-- FAQ -->
<section class="bg-light" style="padding: 80px 0;">
 <div class="container">
 <div class="section-header" style="text-align: center; margin-bottom: 60px;">
 <span class="section-badge" style="display: inline-block; background: #c7d2fe; color: #3730a3; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px;"> Questions fr&eacute;quentes</span>
 <h2 class="section-title" style="font-size: 2.2rem; color: #1a202c;">On r&eacute;pond &agrave; vos questions</h2>
 </div>

 <div style="max-width: 750px; margin: 0 auto; display: grid; gap: 15px;">
 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Le tarif fondateur peut-il &eacute;voluer ?</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Le tarif fondateur est r&eacute;serv&eacute; aux partenaires accept&eacute;s dans le Programme Fondateurs. Les conditions sont pr&eacute;cis&eacute;es avant validation.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Combien de places restent ?</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Le Programme Fondateurs est volontairement limit&eacute; pour pr&eacute;server la qualit&eacute; d'accompagnement et l'exclusivit&eacute; territoriale.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Je dois &ecirc;tre dans l'immobilier ?</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Oui. Conseillers ind&eacute;pendants (IAD, Safti, eXp...) ou agents solo. Autre profil ? Contacte-nous, on discute.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Quel contrat ? Je peux partir ?</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">On pr&eacute;f&egrave;re 3-6 mois pour laisser le temps au d&eacute;ploiement local. Mais on discute au cas par cas. L'important : avancer s&eacute;rieusement.</p>
 </div>
 </div>

 <div style="display: flex; align-items: flex-start; gap: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #667eea;">
 <span style="font-size: 1.8rem; flex-shrink: 0;"></span>
 <div>
 <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Programme Fondateurs + coaching, compatible ?</strong>
 <p style="color: #718096; margin: 0; font-size: 0.95rem;">Oui. Le coaching acc&eacute;l&egrave;re la mise en place ; l'acc&egrave;s fondateur fournit l'&eacute;cosyst&egrave;me complet.</p>
 </div>
 </div>
 </div>
 </div>
</section>

<!-- CTA FINAL -->
<section style="padding: 80px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center;">
 <div class="container">
 <h2 style="font-size: 2.2rem; color: white; margin-bottom: 15px;">Votre ville est-elle encore disponible ?</h2>
 <p style="font-size: 1.1rem; opacity: 0.95; margin-bottom: 35px; max-width: 600px; margin-left: auto; margin-right: auto;">
 Que vous souhaitiez activer le syst&egrave;me local ou apprendre la strat&eacute;gie d&egrave;s maintenant, parlons-en.
 </p>
 <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
 <a href="/front/pages/contact.php?type=fondateur" class="btn btn-lg" style="background: white; color: #667eea; font-weight: 600; padding: 15px 35px; text-decoration: none; border-radius: 8px; display: inline-block;">
 Acc&egrave;s Fondateur
 </a>
 <a href="/front/pages/contact.php?type=coaching" class="btn btn-lg" style="background: transparent; border: 2px solid white; color: white; font-weight: 600; padding: 13px 33px; text-decoration: none; border-radius: 8px; display: inline-block;">
 Coaching Digital
 </a>
 </div>
 </div>
</section>

<?php include '../../includes/footer.php'; ?>
