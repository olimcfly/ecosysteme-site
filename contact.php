<?php
$page_title = 'Contact — Écosystème Immo';
$meta_description = 'Contactez Écosystème Immo : une question sur les guides, le système ou votre situation ? Réponse sous 48h.';
include 'includes/header.php';
?>

<main>

<!-- ============================================================
     PAGE HEADER
============================================================ -->
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Contact</span>
    </div>
    <h1 class="page-header-title">
      Une question ? Une situation particulière ?<br>
      <span style="color: var(--accent-400);">On vous répond sous 48h</span>
    </h1>
    <p class="page-header-subtitle">
      Pas un formulaire qui disparaît dans le vide. Un vrai échange pour vous orienter vers ce qui correspond à votre situation.
    </p>
  </div>
</section>

<!-- ============================================================
     CONTACT PRINCIPAL
============================================================ -->
<section class="section" id="contact">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: start;">

      <!-- COLONNE GAUCHE — Contexte -->
      <div>
        <span class="section-tag">Avant d'écrire</span>
        <h2 class="section-title" style="margin-top: 16px; font-size: 1.75rem;">
          À qui s'adresse ce formulaire ?
        </h2>
        <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-top: 16px;">
          Écosystème Immo s'adresse aux conseillers immobiliers indépendants, mandataires et agents qui veulent structurer leur acquisition locale — sans dépendre des portails ni d'un réseau.
        </p>

        <div style="display: flex; flex-direction: column; gap: 20px; margin-top: 36px;">

          <div style="display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-50); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.125rem;">📚</div>
            <div>
              <div style="font-weight: 600; color: var(--neutral-900); margin-bottom: 4px;">Une question sur un guide</div>
              <div style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.6;">
                Vous hésitez entre plusieurs guides, vous voulez savoir lequel correspond à votre situation ? Dites-nous où vous en êtes.
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-50); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.125rem;">🔍</div>
            <div>
              <div style="font-weight: 600; color: var(--neutral-900); margin-bottom: 4px;">Un audit de votre situation</div>
              <div style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.6;">
                Vous voulez un regard extérieur sur votre positionnement, votre communication ou votre système d'acquisition ? On peut regarder ça ensemble.
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-50); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.125rem;">💬</div>
            <div>
              <div style="font-weight: 600; color: var(--neutral-900); margin-bottom: 4px;">Une simple question</div>
              <div style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.6;">
                Sur la méthode ANCRE, sur le système, sur la façon dont vous pourriez l'appliquer à votre secteur ou à votre profil.
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-50); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.125rem;">🤝</div>
            <div>
              <div style="font-weight: 600; color: var(--neutral-900); margin-bottom: 4px;">Un partenariat ou une collaboration</div>
              <div style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.6;">
                Réseau immobilier, formateur, outil ou média qui partage nos convictions ? On est ouverts à la discussion.
              </div>
            </div>
          </div>

        </div>

        <!-- RÉASSURANCE -->
        <div style="margin-top: 40px; padding: 24px; background: var(--neutral-50); border-radius: 12px; border-left: 3px solid var(--primary-500);">
          <div style="font-weight: 600; color: var(--neutral-900); margin-bottom: 8px;">Ce que vous pouvez attendre</div>
          <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
            <li style="display: flex; gap: 10px; align-items: center; font-size: 0.9375rem; color: var(--neutral-700);">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--primary-500)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Une réponse personnelle sous 48h ouvrées
            </li>
            <li style="display: flex; gap: 10px; align-items: center; font-size: 0.9375rem; color: var(--neutral-700);">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--primary-500)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Pas de relance commerciale si ce n'est pas le bon moment
            </li>
            <li style="display: flex; gap: 10px; align-items: center; font-size: 0.9375rem; color: var(--neutral-700);">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--primary-500)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Un conseil honnête, même si ce n'est pas nous la bonne solution
            </li>
            <li style="display: flex; gap: 10px; align-items: center; font-size: 0.9375rem; color: var(--neutral-700);">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--primary-500)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Vos données restent privées et ne sont pas revendues
            </li>
          </ul>
        </div>
      </div>

      <!-- COLONNE DROITE — Formulaire -->
      <div>
        <div style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: 16px; padding: 40px; box-shadow: 0 4px 24px rgba(0,0,0,.06);">

          <div style="margin-bottom: 32px;">
            <h3 style="font-size: 1.375rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 8px;">Écrivez-nous</h3>
            <p style="font-size: 0.9375rem; color: var(--neutral-600);">Réponse sous 48h ouvrées. Pas de spam, jamais.</p>
          </div>

          <form id="contact-form" style="display: flex; flex-direction: column; gap: 20px;">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--neutral-700); margin-bottom: 6px;">
                  Prénom <span style="color: var(--primary-500);">*</span>
                </label>
                <input
                  type="text"
                  name="prenom"
                  required
                  placeholder="Jean"
                  style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--neutral-200); border-radius: 8px; font-size: 0.9375rem; color: var(--neutral-900); background: var(--white); transition: border-color .2s; box-sizing: border-box;"
                  onfocus="this.style.borderColor='var(--primary-500)'"
                  onblur="this.style.borderColor='var(--neutral-200)'"
                >
              </div>
              <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--neutral-700); margin-bottom: 6px;">
                  Nom <span style="color: var(--primary-500);">*</span>
                </label>
                <input
                  type="text"
                  name="nom"
                  required
                  placeholder="Dupont"
                  style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--neutral-200); border-radius: 8px; font-size: 0.9375rem; color: var(--neutral-900); background: var(--white); transition: border-color .2s; box-sizing: border-box;"
                  onfocus="this.style.borderColor='var(--primary-500)'"
                  onblur="this.style.borderColor='var(--neutral-200)'"
                >
              </div>
            </div>

            <div>
              <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--neutral-700); margin-bottom: 6px;">
                Email professionnel <span style="color: var(--primary-500);">*</span>
              </label>
              <input
                type="email"
                name="email"
                required
                placeholder="jean.dupont@email.com"
                style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--neutral-200); border-radius: 8px; font-size: 0.9375rem; color: var(--neutral-900); background: var(--white); transition: border-color .2s; box-sizing: border-box;"
                onfocus="this.style.borderColor='var(--primary-500)'"
                onblur="this.style.borderColor='var(--neutral-200)'"
              >
            </div>

            <div>
              <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--neutral-700); margin-bottom: 6px;">
                Votre situation
              </label>
              <select
                name="situation"
                style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--neutral-200); border-radius: 8px; font-size: 0.9375rem; color: var(--neutral-700); background: var(--white); transition: border-color .2s; box-sizing: border-box; appearance: none; cursor: pointer;"
                onfocus="this.style.borderColor='var(--primary-500)'"
                onblur="this.style.borderColor='var(--neutral-200)'"
              >
                <option value="" disabled selected>Choisissez votre profil</option>
                <option value="mandataire">Mandataire immobilier indépendant</option>
                <option value="agent">Agent immobilier en agence</option>
                <option value="agent-independant">Agent immobilier indépendant</option>
                <option value="debutant">Je démarre dans l'immobilier</option>
                <option value="partenariat">Partenariat / collaboration</option>
                <option value="autre">Autre</option>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--neutral-700); margin-bottom: 6px;">
                Objet de votre message <span style="color: var(--primary-500);">*</span>
              </label>
              <select
                name="objet"
                required
                style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--neutral-200); border-radius: 8px; font-size: 0.9375rem; color: var(--neutral-700); background: var(--white); transition: border-color .2s; box-sizing: border-box; appearance: none; cursor: pointer;"
                onfocus="this.style.borderColor='var(--primary-500)'"
                onblur="this.style.borderColor='var(--neutral-200)'"
              >
                <option value="" disabled selected>Sélectionnez un objet</option>
                <option value="question-guide">Question sur un guide</option>
                <option value="audit">Demande d'audit gratuit</option>
                <option value="methode">Question sur la méthode ANCRE</option>
                <option value="systeme">Question sur le système</option>
                <option value="partenariat">Partenariat ou collaboration</option>
                <option value="autre">Autre</option>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--neutral-700); margin-bottom: 6px;">
                Votre message <span style="color: var(--primary-500);">*</span>
              </label>
              <textarea
                name="message"
                required
                rows="5"
                placeholder="Décrivez votre situation, votre question ou ce sur quoi vous aimeriez qu'on échange…"
                style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--neutral-200); border-radius: 8px; font-size: 0.9375rem; color: var(--neutral-900); background: var(--white); transition: border-color .2s; box-sizing: border-box; resize: vertical; font-family: inherit; line-height: 1.6;"
                onfocus="this.style.borderColor='var(--primary-500)'"
                onblur="this.style.borderColor='var(--neutral-200)'"
              ></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px 24px; font-size: 1rem;">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
              </svg>
              Envoyer mon message
            </button>

            <p style="font-size: 0.8125rem; color: var(--neutral-500); text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;">
              <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              Vos données restent privées. Aucun spam, jamais.
            </p>

          </form>

          <!-- MESSAGE DE CONFIRMATION -->
          <div id="contact-success" style="display: none; text-align: center; padding: 32px 16px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--primary-50); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
              <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--primary-500)" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 8px;">Message envoyé !</h3>
            <p style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.7;">
              Merci pour votre message. Vous recevrez une réponse personnelle sous 48h ouvrées.
            </p>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============================================================
     FAQ RAPIDE
============================================================ -->
<section class="section" style="background: var(--neutral-50);">
  <div class="container container-md">
    <div class="section-header center">
      <span class="section-tag">Questions fréquentes</span>
      <h2 class="section-title" style="margin-top: 12px;">Avant d'écrire, peut-être que votre réponse est ici</h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px; margin-top: 40px;">

      <details style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: 12px; padding: 20px 24px; cursor: pointer;">
        <summary style="font-weight: 600; color: var(--neutral-900); font-size: 1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
          Par quel guide est-ce que je devrais commencer ?
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </summary>
        <p style="margin-top: 12px; font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.7;">
          Ça dépend de votre blocage principal. Si vous manquez de visibilité : commencez par le guide SEO local ou Google Business Profile. Si vous avez des contacts mais ne convertissez pas : le guide tunnel vendeur ou emails. Si tout est flou : commencez par le guide positionnement. En cas de doute, écrivez-nous — on vous orientera.
        </p>
      </details>

      <details style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: 12px; padding: 20px 24px; cursor: pointer;">
        <summary style="font-weight: 600; color: var(--neutral-900); font-size: 1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
          Les guides conviennent-ils aux débutants ?
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </summary>
        <p style="margin-top: 12px; font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.7;">
          Oui. Les guides ont été rédigés sans jargon technique, avec une logique progressive. Que vous démarriez dans l'immobilier ou que vous ayez plusieurs années d'expérience, vous trouverez des éléments concrets à appliquer rapidement.
        </p>
      </details>

      <details style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: 12px; padding: 20px 24px; cursor: pointer;">
        <summary style="font-weight: 600; color: var(--neutral-900); font-size: 1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
          Qu'est-ce qu'un audit gratuit exactement ?
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </summary>
        <p style="margin-top: 12px; font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.7;">
          C'est un regard extérieur sur votre situation actuelle : positionnement, communication, outils, points de friction visibles. Pas un argumentaire commercial — un diagnostic honnête pour identifier ce qui freine votre acquisition locale.
        </p>
      </details>

      <details style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: 12px; padding: 20px 24px; cursor: pointer;">
        <summary style="font-weight: 600; color: var(--neutral-900); font-size: 1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
          Est-ce que les guides fonctionnent pour tous les réseaux ?
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </summary>
        <p style="margin-top: 12px; font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.7;">
          Oui. Les méthodes sont indépendantes de tout réseau ou enseigne. Que vous soyez chez IAD, Optimhome, EffiCity, en agence traditionnelle ou totalement indépendant — les leviers d'acquisition locale restent les mêmes.
        </p>
      </details>

      <details style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: 12px; padding: 20px 24px; cursor: pointer;">
        <summary style="font-weight: 600; color: var(--neutral-900); font-size: 1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
          Puis-je acheter plusieurs guides en même temps ?
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </summary>
        <p style="margin-top: 12px; font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.7;">
          Oui, tout à fait. Chaque guide est disponible à 47€ à l'unité sur <a href="https://guides.ecosystemeimmo.fr" target="_blank" rel="noopener noreferrer" style="color: var(--primary-500); font-weight: 500;">guides.ecosystemeimmo.fr</a>. Si vous souhaitez accéder à l'ensemble de la collection, contactez-nous pour voir les options disponibles.
        </p>
      </details>

    </div>
  </div>
</section>

<!-- ============================================================
     CTA FINAL
============================================================ -->
<section class="section cta-section">
  <div class="container container-md">
    <div class="section-header center" style="margin-bottom: 0;">
      <span class="section-tag" style="background: rgba(245,158,11,.15); color: var(--accent-400);">Pas encore prêt à écrire ?</span>
      <h2 class="section-title" style="color: var(--white); margin-top: 16px;">
        Explorez les guides ou découvrez le système
      </h2>
      <p class="section-subtitle" style="color: rgba(255,255,255,.75); margin-top: 16px;">
        47€ par guide. Téléchargement immédiat. Applicable dès aujourd'hui.<br>
        Pas d'abonnement. Pas de jargon. Pas de perte de temps.
      </p>
      <div class="cta-buttons">
        <a href="https://guides.ecosystemeimmo.fr" class="btn btn-primary btn-lg" target="_blank" rel="noopener noreferrer">
          Voir les 12 guides ↗
        </a>
        <a href="demonstration.php" class="btn btn-outline-white btn-lg">Voir la démonstration</a>
      </div>
    </div>
  </div>
</section>

</main>

<script>
document.getElementById('contact-form').addEventListener('submit', function(e) {
  e.preventDefault();
  // Remplacer ici par votre logique d'envoi (fetch, formspree, etc.)
  this.style.display = 'none';
  document.getElementById('contact-success').style.display = 'block';
});
</script>

<?php include 'includes/footer.php'; ?>
