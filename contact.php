<?php
$page_title = 'Contact — Écosystème Immo';
$meta_description = 'Contactez Écosystème Immo pour toute question sur nos guides, demander un audit gratuit de votre présence digitale ou discuter de votre projet immobilier.';

$guide_param = isset($_GET['guide']) ? htmlspecialchars($_GET['guide']) : '';

include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Contact</span>
    </div>
    <h1 class="page-header-title">Parlons de votre activité<br><span style="color: var(--accent-400);">et de vos objectifs</span></h1>
    <p class="page-header-subtitle">Une question sur un guide ? Vous souhaitez un audit de votre présence digitale ? Vous avez un projet spécifique ? On est là.</p>
  </div>
</section>

<!-- MAIN CONTACT -->
<section class="section">
  <div class="container">
    <div class="contact-layout">

      <!-- FORM -->
      <div class="contact-form-wrapper">
        <h2 style="font-size: 1.375rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 8px;">Envoyez-nous un message</h2>
        <p style="font-size: .9375rem; color: var(--neutral-600); margin-bottom: 28px;">Nous répondons à toutes les demandes sous 24h ouvrées.</p>

        <div class="form-success" id="form-success" style="display: none; flex-direction: column; gap: 4px;">
          <p style="font-weight: 600;">✓ Message envoyé avec succès !</p>
          <p style="font-size: .875rem;">Nous vous répondons sous 24h ouvrées. À très vite.</p>
        </div>

        <form id="contact-form" action="#" method="post">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="prenom">Prénom *</label>
              <input type="text" id="prenom" name="prenom" class="form-input" placeholder="Jean" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="nom">Nom *</label>
              <input type="text" id="nom" name="nom" class="form-input" placeholder="Dupont" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="email">Email *</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="jean.dupont@email.fr" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" class="form-input" placeholder="06 12 34 56 78">
          </div>

          <div class="form-group">
            <label class="form-label" for="sujet">Sujet de votre demande *</label>
            <select id="sujet" name="sujet" class="form-select" required>
              <option value="">Sélectionnez un sujet</option>
              <option value="guide" <?= $guide_param ? 'selected' : '' ?>>Question sur un guide</option>
              <option value="audit">Demande d'audit gratuit</option>
              <option value="pack">Offre multi-guides</option>
              <option value="partenariat">Partenariat / Réseau</option>
              <option value="autre">Autre question</option>
            </select>
          </div>

          <?php if ($guide_param): ?>
          <div class="form-group">
            <label class="form-label">Guide concerné</label>
            <input type="text" class="form-input" value="<?= $guide_param ?>" readonly style="background: var(--neutral-100); color: var(--neutral-600);">
          </div>
          <?php endif; ?>

          <div class="form-group">
            <label class="form-label" for="message">Votre message *</label>
            <textarea id="message" name="message" class="form-textarea" placeholder="Décrivez votre situation, vos objectifs, ou posez-nous directement votre question..." required></textarea>
          </div>

          <div class="form-group" style="display: flex; align-items: flex-start; gap: 10px;">
            <input type="checkbox" id="rgpd" name="rgpd" style="margin-top: 3px; width: 16px; height: 16px; flex-shrink: 0; accent-color: var(--primary-600);" required>
            <label for="rgpd" style="font-size: .875rem; color: var(--neutral-600); cursor: pointer; line-height: 1.5;">
              J'accepte que mes données soient utilisées pour traiter ma demande. Aucune utilisation commerciale sans consentement explicite. <a href="#" style="color: var(--primary-600);">Politique de confidentialité</a>
            </label>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 16px; font-size: 1.0625rem; margin-top: 8px;">
            Envoyer ma demande →
          </button>
        </form>
      </div>

      <!-- INFO SIDEBAR -->
      <div>
        <h2 style="font-size: 1.375rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 24px;">Ce que nous pouvons faire pour vous</h2>

        <div class="contact-info-cards">
          <div class="contact-info-card">
            <div class="contact-info-icon">📚</div>
            <div>
              <h4>Questions sur les guides</h4>
              <p>Vous avez une question sur un guide en particulier, son contenu ou si il correspond à votre situation. On vous répond avec honnêteté.</p>
            </div>
          </div>
          <div class="contact-info-card">
            <div class="contact-info-icon">🎯</div>
            <div>
              <h4>Audit de présence digitale</h4>
              <p>Vous ne savez pas par où commencer ? Nous analysons votre situation actuelle et vous proposons les actions prioritaires.</p>
              <span class="badge badge-success" style="margin-top: 8px; display: inline-block;">Gratuit</span>
            </div>
          </div>
          <div class="contact-info-card">
            <div class="contact-info-icon">📦</div>
            <div>
              <h4>Offres multi-guides</h4>
              <p>Vous souhaitez accéder à plusieurs guides ou à l'intégralité de la collection. Contactez-nous pour une proposition personnalisée.</p>
            </div>
          </div>
          <div class="contact-info-card">
            <div class="contact-info-icon">🤝</div>
            <div>
              <h4>Partenariats & Réseaux</h4>
              <p>Vous êtes animateur de réseau, directeur d'agence ou organisateur de formation ? Discutons d'un partenariat adapté.</p>
            </div>
          </div>
        </div>

        <div style="background: linear-gradient(135deg, var(--primary-50), var(--primary-100)); border: 1px solid var(--primary-200); border-radius: var(--radius-lg); padding: 28px; margin-top: 24px;">
          <div style="font-size: 1.5rem; margin-bottom: 12px;">⏱️</div>
          <h4 style="font-size: 1rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 8px;">Réponse sous 24h</h4>
          <p style="font-size: .9375rem; color: var(--neutral-600); line-height: 1.65;">
            Nous répondons à chaque message personnellement, sous 24h ouvrées. Pas de réponse automatique, pas de bot — une vraie personne vous lira et vous répondra.
          </p>
        </div>

        <div style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: var(--radius-lg); padding: 24px; margin-top: 16px; text-align: center;">
          <p style="font-size: .875rem; color: var(--neutral-500); margin-bottom: 12px;">Email direct</p>
          <p style="font-size: 1rem; font-weight: 600; color: var(--primary-800);">📧 contact@ecosysteme-immo.fr</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FAQ CONTACT -->
<section class="section bg-light" style="border-top: 1px solid var(--neutral-200);">
  <div class="container container-md">
    <div class="section-header center">
      <h2 class="section-title">Questions fréquentes</h2>
    </div>
    <div class="faq-list">
      <div class="faq-item">
        <button class="faq-question">
          Comment se passe l'achat d'un guide ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Après avoir sélectionné un guide, vous êtes redirigé vers notre page de paiement sécurisée. Une fois le paiement confirmé, vous recevez par email le lien de téléchargement de votre guide au format PDF. L'accès est immédiat.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Proposez-vous des remises pour les réseaux immobiliers ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Oui. Si vous souhaitez proposer nos guides à vos conseillers ou les intégrer à vos outils de formation, contactez-nous. Nous proposons des conditions spéciales pour les réseaux et les groupements.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          En quoi consiste l'audit gratuit ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>L'audit gratuit est un échange de 20 à 30 minutes par email ou visioconférence. Nous analysons votre présence digitale actuelle (site, GMB, réseaux, email) et vous proposons les 3 actions prioritaires à mettre en place selon votre situation.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Est-il possible d'obtenir une facture pour mon achat ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Oui. Une facture est automatiquement générée et envoyée avec votre confirmation d'achat. Si vous avez besoin d'une facture spécifique ou d'un justificatif, contactez-nous et nous vous l'enverrons dans les 24h.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="section cta-section">
  <div class="container container-md">
    <div class="section-header center" style="margin-bottom: 0;">
      <h2 class="section-title" style="color: var(--white);">Prêt à développer votre activité ?</h2>
      <p class="section-subtitle" style="color: rgba(255,255,255,.75); margin-top: 16px;">
        Commencez par le guide qui correspond à votre besoin le plus urgent. 47€ et une heure de lecture peuvent changer beaucoup de choses.
      </p>
      <div class="cta-buttons">
        <a href="guides.php" class="btn btn-primary btn-lg">Voir les 12 guides</a>
        <a href="methode.php" class="btn btn-outline-white">Comprendre la méthode</a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
