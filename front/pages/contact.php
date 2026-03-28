<?php
$type = isset($_GET['type']) ? $_GET['type'] : 'fondateur';
if (!in_array($type, ['fondateur', 'coaching'], true)) {
 $type = 'fondateur';
}
$pageTitle = $type === 'coaching' ? 'Coaching Digital Immobilier &mdash; Candidater' : 'Programme Fondateurs &mdash; Candidater';
$pageDescription = 'Candidatez au Programme Fondateurs ou au coaching digital immobilier. Places limit&eacute;es.';
$currentPage = 'contact';

include '../../includes/header.php';

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (!validateCsrfToken()) {
 $errors[] = 'Token de sécurité invalide. Veuillez réessayer.';
 }
 $prenom = trim($_POST['prenom'] ?? '');
 $nom = trim($_POST['nom'] ?? '');
 $email = trim($_POST['email'] ?? '');
 $telephone = trim($_POST['telephone'] ?? '');
 $ville = trim($_POST['ville'] ?? '');
 $activite = trim($_POST['activite'] ?? '');
 $message = trim($_POST['message'] ?? '');
 $offre = trim($_POST['offre'] ?? $type);

 if (empty($prenom)) $errors[] = 'Le pr&eacute;nom est obligatoire.';
 if (empty($nom)) $errors[] = 'Le nom est obligatoire.';
 if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
 if (empty($ville)) $errors[] = 'La ville est obligatoire.';
 if (empty($activite)) $errors[] = 'Votre activit&eacute; est obligatoire.';

 if (empty($errors)) {
 $log = date('Y-m-d H:i:s') . " | $offre | $prenom $nom | $email | $ville | $activite\n";
 @file_put_contents(__DIR__ . '/../../logs/contacts.log', $log, FILE_APPEND);
 $success = true;
 }
}
?>

<style>
/* ---- CONTACT PAGE ---- */
.contact-grid {
 display: grid;
 grid-template-columns: 1fr 1.4fr;
 gap: 40px;
 max-width: 1000px;
 margin: 0 auto;
 padding: 60px 20px 80px;
 align-items: start;
}

.cinfo-card {
 padding: 28px;
 background: #f7fafc;
 border-radius: 14px;
 margin-bottom: 18px;
}
.cinfo-card.violet { border-left: 4px solid #667eea; }
.cinfo-card.vert { border-left: 4px solid #10b981; }
.cinfo-card h3 { color: #1a202c; font-size: 1.05rem; margin: 0 0 16px 0; }

.ccheck { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; font-size: 0.93rem; color: #4a5568; }
.ccheck .i { font-weight: 700; flex-shrink: 0; }
.ccheck .i.v { color: #667eea; }
.ccheck .i.g { color: #10b981; }

.calert { padding: 15px 18px; border-radius: 10px; text-align: center; margin-bottom: 14px; font-size: 0.88rem; font-weight: 500; }
.calert.rouge { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }
.calert.bleu { background: #dbeafe; color: #1e40af; }
.calert.vert { background: #d1fae5; color: #065f46; font-weight: 600; }

.cswitcher { margin-top: 18px; padding: 18px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center; }
.cswitcher p { color: #718096; margin: 0 0 10px 0; font-size: 0.88rem; }
.cswitcher a { color: #667eea; font-weight: 600; font-size: 0.93rem; text-decoration: none; }

.cform-card { padding: 38px; background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.cform-card h2 { color: #1a202c; font-size: 1.35rem; margin: 0 0 6px 0; }
.cform-card > p { color: #718096; font-size: 0.93rem; margin: 0 0 26px 0; }

.cform-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; }
.cfield { margin-bottom: 16px; }
.cfield label { display: block; color: #4a5568; font-size: 0.88rem; font-weight: 600; margin-bottom: 6px; }
.cfield input,
.cfield select,
.cfield textarea {
 width: 100%;
 padding: 11px 14px;
 border: 1.5px solid #e2e8f0;
 border-radius: 8px;
 font-size: 0.93rem;
 color: #1a202c;
 background: white;
 font-family: 'Inter', sans-serif;
 outline: none;
 box-sizing: border-box;
 transition: border-color 0.2s, box-shadow 0.2s;
}
.cfield input:focus,
.cfield select:focus,
.cfield textarea:focus {
 border-color: #667eea;
 box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}
.cfield .hint { color: #a0aec0; font-size: 0.8rem; margin: 4px 0 0 0; }

.csubmit {
 width: 100%;
 padding: 15px;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: white;
 border: none;
 border-radius: 10px;
 font-size: 1rem;
 font-weight: 700;
 cursor: pointer;
 font-family: 'Inter', sans-serif;
 transition: opacity 0.2s, transform 0.2s;
}
.csubmit:hover { opacity: 0.9; transform: translateY(-1px); }

.cerrors { padding: 14px 18px; background: #fee2e2; border-left: 4px solid #e53e3e; border-radius: 10px; margin-bottom: 22px; }
.cerrors p { color: #991b1b; margin: 3px 0; font-size: 0.88rem; }

.csuccess { padding: 50px 30px; background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); text-align: center; }
.csuccess .big { font-size: 3.5rem; margin-bottom: 18px; }
.csuccess h2 { color: #1a202c; margin-bottom: 14px; }
.csuccess p { color: #4a5568; line-height: 1.8; margin-bottom: 22px; }
.csuccess .recap { padding: 16px; background: #f7fafc; border-radius: 10px; margin-bottom: 22px; font-size: 0.93rem; color: #718096; }
.csuccess a { display: inline-block; background: #667eea; color: white; padding: 13px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; }

@media (max-width: 768px) {
 .contact-grid {
 grid-template-columns: 1fr;
 padding: 30px 15px 60px;
 gap: 25px;
 }
 /* Formulaire en premier sur mobile */
 .contact-grid .cform-wrap { order: 1; }
 .contact-grid .cinfo-wrap { order: 2; }

 .cform-row { grid-template-columns: 1fr; gap: 0; }
 .cform-card { padding: 24px 18px; }
}
</style>

<!-- HERO -->
<section class="hero" style="padding: 55px 0 40px;">
 <div class="container">
 <div style="max-width: 100%; padding: 0 10px; box-sizing: border-box;">
 <?php if ($type === 'coaching'): ?>
 <span class="hero-badge"> Coaching Digital Immobilier</span>
 <h1 style="color: white;">Apprendre la strat&eacute;gie digitale maintenant</h1>
 <p class="hero-subtitle">Audit, SEO local, tunnels de capture, pub digitale &mdash; accompagnement 3&ndash;6 mois.</p>
 <?php else: ?>
 <span class="hero-badge"> Programme Fondateurs</span>
 <h1 style="color: white;">Demander un acc&egrave;s anticip&eacute;</h1>
 <p class="hero-subtitle">Places limit&eacute;es. Exclusivit&eacute; zone 50km. Tarif fondateur prioritaire.</p>
 <?php endif; ?>
 </div>
 </div>
</section>

<!-- CONTENU -->
<section style="background: #f7fafc;">
 <div class="container">
 <div class="contact-grid">

 <!-- INFOS -->
 <div class="cinfo-wrap">
 <?php if ($type === 'coaching'): ?>
 <div class="cinfo-card vert">
 <h3> Ce que comprend le coaching</h3>
 <div class="ccheck"><span class="i g"></span> Audit digital complet de votre pr&eacute;sence en ligne</div>
 <div class="ccheck"><span class="i g"></span> Strat&eacute;gie SEO local + optimisation GMB</div>
 <div class="ccheck"><span class="i g"></span> Plan contenu, tunnels de capture, lead magnets</div>
 <div class="ccheck"><span class="i g"></span> Facebook Ads &amp; Google Ads guid&eacute;s</div>
 <div class="ccheck"><span class="i g"></span> Appels hebdo 30&ndash;45 min + Slack priv&eacute;</div>
 </div>
 <div class="calert vert">Accompagnement 3&ndash;6 mois &mdash; sur devis</div>
 <?php else: ?>
 <div class="cinfo-card violet">
 <h3> Ce que vous recevez en acc&egrave;s fondateur</h3>
 <div class="ccheck"><span class="i v"></span> 43 modules install&eacute;s sur ton serveur</div>
 <div class="ccheck"><span class="i v"></span> Exclusivit&eacute; zone 50km verrouill&eacute;e</div>
 <div class="ccheck"><span class="i v"></span> Onboarding personnalis&eacute; 2&ndash;3h de visio</div>
 <div class="ccheck"><span class="i v"></span> Support direct &amp; corrections prioritaires</div>
 <div class="ccheck"><span class="i v"></span> Statut Fondateur + tarif pr&eacute;f&eacute;rentiel &agrave; vie</div>
 </div>
 <div class="calert rouge">️ Villes r&eacute;serv&eacute;es : Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion</div>
 <div class="calert bleu">
 <strong>Places limit&eacute;es</strong><br>
 <span style="font-weight:400; font-size:0.85rem;">Premier arriv&eacute;, premier servi</span>
 </div>
 <?php endif; ?>

 <div class="cswitcher">
 <p>Vous cherchez l'autre offre ?</p>
 <?php if ($type === 'coaching'): ?>
 <a href="?type=fondateur"> Programme Fondateurs &rarr;</a>
 <?php else: ?>
 <a href="?type=coaching"> Coaching Digital &rarr;</a>
 <?php endif; ?>
 </div>
 </div>

 <!-- FORMULAIRE -->
 <div class="cform-wrap">
 <?php if ($success): ?>
 <div class="csuccess">
 <div class="big"></div>
 <h2>Candidature re&ccedil;ue !</h2>
 <p>Merci <strong><?php echo h($_POST['prenom']); ?></strong> &mdash; on revient vers toi sous 48h pour valider ta zone et pr&eacute;ciser les prochaines &eacute;tapes.</p>
 <div class="recap"> Confirmation envoy&eacute;e &agrave; <strong><?php echo h($_POST['email']); ?></strong></div>
 <a href="/villes-pilotes">️ Voir les zones pilotes</a>
 </div>

 <?php else: ?>
 <div class="cform-card">
 <h2><?php echo $type === 'coaching' ? 'Demande de coaching' : 'Votre candidature'; ?></h2>
 <p>Champs * obligatoires.</p>

 <?php if (!empty($errors)): ?>
 <div class="cerrors">
 <?php foreach ($errors as $e): ?>
 <p>️ <?php echo $e; ?></p>
 <?php endforeach; ?>
 </div>
 <?php endif; ?>

 <form method="POST" action="">
 <input type="hidden" name="offre" value="<?php echo h($type); ?>">

 <div class="cform-row">
 <div class="cfield" style="margin:0;">
 <label>Pr&eacute;nom *</label>
 <input type="text" name="prenom" value="<?php echo h($_POST['prenom'] ?? ''); ?>" placeholder="Jean" required>
 </div>
 <div class="cfield" style="margin:0;">
 <label>Nom *</label>
 <input type="text" name="nom" value="<?php echo h($_POST['nom'] ?? ''); ?>" placeholder="Dupont" required>
 </div>
 </div>

 <div class="cfield">
 <label>Email *</label>
 <input type="email" name="email" value="<?php echo h($_POST['email'] ?? ''); ?>" placeholder="jean.dupont@email.fr" required>
 </div>

 <div class="cfield">
 <label>T&eacute;l&eacute;phone</label>
 <input type="tel" name="telephone" value="<?php echo h($_POST['telephone'] ?? ''); ?>" placeholder="06 12 34 56 78">
 </div>

 <div class="cfield">
 <label>Votre ville principale *</label>
 <input type="text" name="ville" value="<?php echo h($_POST['ville'] ?? ''); ?>" placeholder="Lyon, Paris, Rennes..." required>
 <p class="hint">On v&eacute;rifiera la disponibilit&eacute; de votre zone 50km</p>
 </div>

 <div class="cfield">
 <label>Votre activit&eacute; *</label>
 <select name="activite" required>
 <option value="">-- S&eacute;lectionnez --</option>
 <option value="conseiller-independant" <?php echo (($_POST['activite'] ?? '') === 'conseiller-independant') ? 'selected' : ''; ?>>Conseiller immobilier ind&eacute;pendant</option>
 <option value="mandataire-reseau" <?php echo (($_POST['activite'] ?? '') === 'mandataire-reseau') ? 'selected' : ''; ?>>Mandataire en r&eacute;seau (IAD, Safti, eXp...)</option>
 <option value="agent-agence" <?php echo (($_POST['activite'] ?? '') === 'agent-agence') ? 'selected' : ''; ?>>Agent en agence</option>
 <option value="petite-equipe" <?php echo (($_POST['activite'] ?? '') === 'petite-equipe') ? 'selected' : ''; ?>>Petite &eacute;quipe (2&ndash;5 personnes)</option>
 <option value="autre" <?php echo (($_POST['activite'] ?? '') === 'autre') ? 'selected' : ''; ?>>Autre</option>
 </select>
 </div>

 <div class="cfield">
 <label>Votre situation en quelques mots</label>
 <textarea name="message" rows="3" placeholder="Votre zone, vos objectifs, vos questions..." style="resize:vertical;"><?php echo h($_POST['message'] ?? ''); ?></textarea>
 </div>

 <button type="submit" class="csubmit">
 <?php echo $type === 'coaching' ? ' Envoyer ma demande de coaching' : ' Envoyer ma candidature b&ecirc;ta'; ?>
 </button>

 <p style="color:#a0aec0; font-size:0.8rem; text-align:center; margin:14px 0 0 0;">
 Donn&eacute;es s&eacute;curis&eacute;es, jamais partag&eacute;es.
 </p>
 </form>
 </div>
 <?php endif; ?>
 </div>

 </div>
 </div>
</section>

<?php include '../../includes/footer.php'; ?>
