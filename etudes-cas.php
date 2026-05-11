<?php
$page_title = 'Études de cas — Conseillers, territoires, écosystèmes digitaux';
$meta_description = 'Des écosystèmes immobiliers réels : Bordeaux, Nantes, Aix, Nandy, Lannion. Aperçus (captures), liens vers les sites en ligne, contexte et parcours.';

/**
 * Retourne l’URL publique d’une capture si le fichier existe (webp → jpg → png).
 * Sinon null : la vue affiche un placeholder sans requête 404.
 */
function cas_image_url(string $slug): ?string
{
  $exts  = ['webp', 'jpg', 'jpeg', 'png'];
  $dir   = __DIR__ . '/assets/images/cas/';
  $pub   = '/assets/images/cas/';
  foreach ($exts as $ext) {
    if (is_file($dir . $slug . '.' . $ext)) {
      return $pub . $slug . '.' . $ext;
    }
  }
  return null;
}

$cas = [
  [
    'slug'         => 'eduardo-de-sul',
    'url'          => 'https://eduardo-desul-immobilier.fr/',
    'nom'          => 'Eduardo De Sul',
    'ville'        => 'Bordeaux et périphérie',
    'type'         => 'Écosystème Pro — agglomération dense',
    'objectif'     => 'Se démarquer sur un marché saturé et capter des vendeurs qualifiés, sans nager dans le générique « agence du centre ».',
    'livrables'    => [
      'Site structuré autour d’un positionnement clair (offre, secteurs, prise de contact)',
      'Parcours vendeur : estimation, pages quartiers, preuves et appels à l’action cohérents',
      'Socle prêt pour le SEO local et le suivi des leads dans le CRM',
    ],
    'contexte'     => 'Bordeaux : forte concurrence, recherche localisée, besoin d’une identité propre au conseiller, pas d’un quatrième discours flou « comme les autres ».',
    'probleme'     => 'Présence en ligne incomplète ou éparpillée : messages peu différenciants, manque d’un fil conducteur entre visibilité, contenus et suivi. Risque d’acheter des clics… sans relève.',
    'solution'     => 'Construction d’un écosystème cohérent : persona vendeur, pages secteurs, vitrine propre à Eduardo, raccourcis de contact, base pour automatisations et contenus ciblés selon l’agglomération.',
    'modules'      => [
      'Site et image de marque terrain',
      'SEO local (structure, titres, pages « lieu »)',
      'Formulaires et intégration des leads',
      'CRM (pipeline, statuts, rappels)',
    ],
    'benefice'     => 'Un cadre de travail unique : moins d’improvisation au quotidien, plus de clarté sur quoi montrer, à qui parler, et comment faire remonter un contact chaud. Le gain se mesure en constance et en conversations utiles, pas en promesse de volume fixe.',
  ],
  [
    'slug'         => 'brice-chupin-nantes',
    'url'          => 'https://brice-chupin-immobilier-nantes.fr/',
    'nom'          => 'Brice Chupin',
    'ville'        => 'Nantes et Nantes Métropole',
    'type'         => 'Relance digitale + structuration Pro',
    'objectif'     => 'Tirer parti du territoire nantais avec un site crédible, des contenus travaillables et un suivi simple des prospects venus du web.',
    'livrables'    => [
      'Refonte cadrée : navigation, preuves, offre de service locale',
      'Connexion entre acquisition (recherche, annonces, réseaux) et le CRM',
      'Rythme de contenus et pages ciblées « Nantes + besoins vendeur »',
    ],
    'contexte'     => 'Métropole étendue, comportements de recherche variés (centre, communes, estuaire) : l’enjeu est d’adresser des intentions locales sans se diluer en « toute la France ».',
    'probleme'     => 'Un existant (site ou comptes) qui ne remonte pas assez de signaux utiles, ou un parcours qui se coupe en route vers la prise de rendez-vous. Peu de relecture sur « ce qui est prioritaire en local ».',
    'solution'     => 'Mise en place d’un tronc commun Écosystème Immo : structure des pages, points de contact, intégration des leads, socle contenu. Brice gagne en lisibilité sur son périmètre nantais.',
    'modules'      => [
      'Site (pages d’intention : vendre, acheter, secteur, estimation)',
      'CRM (vue pipeline, tâches)',
      'Gabarits de contenus et thématiques locales',
      'Métriques d’accès (base pour ajustements)',
    ],
    'benefice'     => 'Moins d’outils bancals empilés, plus d’un seul endroit pour voir d’où vient l’intérêt. Meilleure capacité à prioriser le terrain (rappel, relance) sur de la demande web réelle.',
  ],
  [
    'slug'         => 'pascal-hamm-aix',
    'url'          => 'https://pascal-hamm-immobilier-aix-en-provence.fr/',
    'nom'          => 'Pascal Hamm',
    'ville'        => 'Aix-en-Provence et secteurs voisins',
    'type'         => 'Positionnement haut de gamme, clarté d’offre',
    'objectif'     => 'Cadrer l’image et l’expertise sur un marché où le « premium » se joue en détail (preuve, cohérence, disponibilité).',
    'livrables'    => [
      'Hiérarchie d’offre lisible (qui aide vraiment, sur quel périmètre)',
      'Estimation / mandat : parcours court et crédible',
      'Pages et visuels adaptés à la promesse (sans catalogue générique)',
    ],
    'contexte'     => 'Aix et alentours : attentes élevées côté vendeurs, beaucoup d’acteurs. La différenciation ne tient plus à un slogan, mais à un système (message + moyen + suivi).',
    'probleme'     => 'Un positionnement perçu comme flou, ou un site beau sur la surface qui ne supporte pas la conversion. Manque d’équivalent « offline » (suivi) pour les contacts entrants.',
    'solution'     => 'Alignement site–CRM : messages, offres, preuves, prise de contact, réponses standardisables. Ajustements possibles quand l’arbitrage se fait en estimation ou en exclusivité.',
    'modules'      => [
      'Site et pages d’expertise',
      'Outils d’estimation côté visiteur (selon formule)',
      'CRM (mandats, relances, sources)',
      'Accompagnement contenu ciblé secteur / typologie de bien',
    ],
    'benefice'     => 'Une expérience plus homogène du premier clic au rappel : moins d’inconnues sur « d’où vient le lead » et quoi en faire dans les 15 minutes qui suivent.',
  ],
  [
    'slug'         => 'fatima-rabia-nandy',
    'url'          => 'https://fatima-rabia-immobilier-nandy.fr/',
    'nom'          => 'Fatima Rabia',
    'ville'        => 'Nandy et petites communes d’influence',
    'type'         => 'Visibilité de proximité, territoire serré',
    'objectif'     => 'Être la référence localement sans copier le playbook des grosses agglomérations : message simple, ancrage réel, contact direct.',
    'livrables'    => [
      'Site clair, rapide, orienté confiance (visages, chiffres, secteur)',
      'SEO local ciblé « petite maille » (communes, projets, besoins concrets)',
      'Capture simple : moins d’obstacles entre curiosité et prise de nouvelles',
    ],
    'contexte'     => 'Hors cœur urbain, le bouche-à-oreille pèse — mais seuls ceux qu’on trouve en ligne quand on cherche entrent en plus dans le entonnoir. Il faut cohérence, pas de la complexité inutile.',
    'probleme'     => 'Manque d’outils unifié ou d’équivalents d’agences nationales, avec la même exigence de professionnalisme. Risque d’une présence légère ou d’un site vétuste qui n’inspire pas la confiance.',
    'solution'     => 'Pack adapté : vitrine propre, mots de la zone, parcours vendeur, base CRM. Priorité à la clarté et à la reproductibilité de petites actions (post, fiche, relance) plutôt qu’au volume de pages inutile.',
    'modules'      => [
      'Site (structure essentielle, mobile-first)',
      'Formulaires et rappel',
      'CRM léger (suivi des contacts, sources)',
      'Contenus brefs orientés local',
    ],
    'benefice'     => 'Un socle crédible rapidement, sans « usine à gaz » : chaque heure gagnée côté admin est de l’heure remise sur le terrain. Utile quand l’entité sert d’abord de quartier, pas toute la région.',
  ],
  [
    'slug'         => 'stephanie-hulen-lannion',
    'url'          => 'https://stephanie-hulen-immobilier-lannion.fr/',
    'nom'          => 'Stéphanie Hulen',
    'ville'        => 'Lannion, littoral et périphérie',
    'type'         => 'Lifestyle, cadre, attractivité du territoire',
    'objectif'     => 'Traduire en ligne la réalité du secteur (résidence, mobilité, achat « projet de vie ») et capter un vendeur qui s’y reconnaît dans le discours, pas seulement dans l’adresse.',
    'livrables'    => [
      'Mise en avant du positionnement (qui aide, sur quel type de parcours)',
      'Pages et angles adaptés au littoral / pôle pro / familles',
      'Alignement contenus ↔ parcours contact ↔ suivi en CRM',
    ],
    'contexte'     => 'Territoire avec une forte identité : les recherches mêlent lieu de vie, offre, et figure du conseiller. L’enjeu est de raconter l’histoire localement sans tomber en catalogue.',
    'probleme'     => 'Discours parfois trop « national » sur un site, ou inversement site trop minimal pour porter l’expertise. Friction entre promesse d’accompagnement et ressenti dès la première visite web.',
    'solution'     => 'Cadrage Écosystème Immo : pages utiles, preuves, itinéraires d’intention, connexion opérationnelle au CRM. Stéphanie garde le contrôle sur le ton ; le système porte l’infrastructure et la mesure.',
    'modules'      => [
      'Site thématisé (vivre, vendre, secteurs, estimation)',
      'Contenus périphériques (templates, thèmes, SEO)',
      'CRM (sources, statuts, rappel)',
      'Outils d’accompagnement (selon palier, automatisations possibles)',
    ],
    'benefice'     => 'Alignement entre l’intention recherchée (Google) et l’histoire contée sur le site : moins d’incompris, plus d’entretiens qualifiés, avec une piste d’où vient l’intérêt.',
  ],
];

$body_class = 'page-etudes-cas';
include 'includes/nav.php';
?>

<main class="main-etudes-cas" id="contenu-principal">

  <section class="page-header page-header--cas">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Études de cas</span>
      </div>
      <h1 class="page-header-title">Des écosystèmes immobiliers construits pour des conseillers réels</h1>
      <p class="page-header-subtitle page-header-subtitle--wide">Chaque conseiller a son territoire, son positionnement, son image et son <strong>système de capture</strong>. Aperçus et explications ici, sans quitter le parcours.</p>
    </div>
  </section>

  <div class="cas-kpi-bar" aria-label="Aperçu de la page">
    <div class="container">
      <ul class="cas-kpi-bar__list">
        <li class="cas-kpi-bar__item"><span class="cas-kpi-bar__n">5</span> profils de terrain</li>
        <li class="cas-kpi-bar__item">Agglo dense à maille serrée</li>
        <li class="cas-kpi-bar__item">Même cadrage que la <a href="/methode">méthode</a> &amp; <a href="/fonctionnalites">le système</a></li>
        <li class="cas-kpi-bar__item">Résultat &amp; logique, pas d’emballement</li>
      </ul>
    </div>
  </div>

  <section class="section cas-list-section" id="liste">
    <div class="container">
      <div class="section-header center cas-list-header">
        <span class="section-tag">Aperçus</span>
        <h2 class="section-title">Cinq mises en situation</h2>
        <p class="section-subtitle cas-list-lede">Chaque fiche inclut une <strong>capture d’écran</strong> (aperçu) et un <strong>lien</strong> vers le <strong>site en ligne</strong> (nouvel onglet) — le détail du dispositif reste lisible ici sur cette page.</p>
      </div>

      <div class="cas-grid">
        <?php foreach ($cas as $c) :
          $imgUrl = cas_image_url($c['slug']);
          $siteUrl = isset($c['url']) ? (string) $c['url'] : '';
          ?>
        <article class="cas-card cas-card--premium" id="carte-<?= htmlspecialchars($c['slug'], ENT_QUOTES, 'UTF-8') ?>">
          <div class="cas-card__media-wrap">
            <?php if ($imgUrl !== null) : ?>
            <div class="cas-card__media">
              <?php if ($siteUrl !== '') : ?>
              <a class="cas-card__img-link" href="<?= htmlspecialchars($siteUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" aria-label="Ouvrir le site de <?= htmlspecialchars($c['nom'], ENT_QUOTES, 'UTF-8') ?> (nouvel onglet)">
                <img class="cas-card__img" src="<?= htmlspecialchars($imgUrl) ?>"
                     alt="Aperçu du site — <?= htmlspecialchars($c['nom'] . ' (' . $c['ville'] . ')', ENT_QUOTES, 'UTF-8') ?>"
                     width="800" height="450" loading="lazy" decoding="async">
              </a>
              <?php else : ?>
              <img class="cas-card__img" src="<?= htmlspecialchars($imgUrl) ?>"
                   alt="Aperçu du site — <?= htmlspecialchars($c['nom'] . ' (' . $c['ville'] . ')', ENT_QUOTES, 'UTF-8') ?>"
                   width="800" height="450" loading="lazy" decoding="async">
              <?php endif; ?>
            </div>
            <?php else : ?>
            <div class="cas-card__media cas-card__media--placeholder" role="img" aria-label="Aperçu visuel non encore intégré — <?= htmlspecialchars($c['nom'], ENT_QUOTES, 'UTF-8') ?>">
              <div class="cas-card__ph-mock" aria-hidden="true">
                <span class="cas-card__ph-mock__dot"></span>
                <span class="cas-card__ph-mock__dot"></span>
                <span class="cas-card__ph-mock__dot"></span>
              </div>
              <div class="cas-card__ph-inner">
                <span class="cas-card__ph-ico" aria-hidden="true"></span>
                <span class="cas-card__ph-label">Aperçu site</span>
                <span class="cas-card__ph-hint">Capture bientôt disponible</span>
              </div>
            </div>
            <?php endif; ?>
          </div>
          <div class="cas-card__body">
            <h3 class="cas-card__title"><?= htmlspecialchars($c['nom']) ?></h3>
            <p class="cas-card__place">
              <span class="cas-card__place-ico" aria-hidden="true">◎</span>
              <?= htmlspecialchars($c['ville'], ENT_QUOTES, 'UTF-8') ?>
            </p>
            <p class="cas-card__type"><span class="cas-card__type-badge"><?= htmlspecialchars($c['type'], ENT_QUOTES, 'UTF-8') ?></span></p>
            <p class="cas-card__objectif"><strong>Objectif :</strong> <?= htmlspecialchars($c['objectif'], ENT_QUOTES, 'UTF-8') ?></p>
            <ul class="cas-card__livr">
              <?php foreach ($c['livrables'] as $li) : ?>
              <li><?= htmlspecialchars($li, ENT_QUOTES, 'UTF-8') ?></li>
              <?php endforeach; ?>
            </ul>
            <div class="cas-card__actions">
              <a class="btn btn-secondary" href="#cas-<?= htmlspecialchars($c['slug'], ENT_QUOTES, 'UTF-8') ?>">Voir le cas</a>
              <?php if ($siteUrl !== '') : ?>
              <a class="btn btn-primary" href="<?= htmlspecialchars($siteUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer">Ouvrir le site</a>
              <?php endif; ?>
              <a class="btn btn-secondary" href="/rdv">Demander une démo similaire</a>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section bg-light cas-detail-outer" id="detail">
    <div class="container">
      <div class="section-header center cas-detail-header">
        <span class="section-tag">Détail</span>
        <h2 class="section-title">Contexte, problème, solution</h2>
        <p class="section-subtitle cas-detail-intro">Pour chaque conseiller, le même cadre d’analyse. Les <strong>bénéfices</strong> sont des orientations, pas des résultats chiffrés garantis.</p>
      </div>

      <div class="cas-detail-list">
        <?php foreach ($cas as $c) :
          $dSite = isset($c['url']) ? (string) $c['url'] : '';
          ?>
        <div class="cas-detail" id="cas-<?= htmlspecialchars($c['slug'], ENT_QUOTES, 'UTF-8') ?>">
          <p class="cas-detail__kicker">
            <a class="cas-detail__back" href="#liste">↑ Retour à la liste</a>
          </p>
          <h3 class="cas-detail__name"><?= htmlspecialchars($c['nom'], ENT_QUOTES, 'UTF-8') ?> <span class="cas-detail__ville">· <?= htmlspecialchars($c['ville'], ENT_QUOTES, 'UTF-8') ?></span></h3>
          <?php if ($dSite !== '') : ?>
          <p class="cas-detail__site">
            <a class="cas-detail__site-a" href="<?= htmlspecialchars($dSite, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($dSite, ENT_QUOTES, 'UTF-8') ?></a>
            <span class="cas-detail__site-hint" aria-hidden="true">(nouvel onglet)</span>
          </p>
          <?php endif; ?>
          <div class="cas-detail__grid">
            <div>
              <h4 class="cas-detail__h4">Contexte</h4>
              <p class="cas-detail__p"><?= htmlspecialchars($c['contexte'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div>
              <h4 class="cas-detail__h4">Problème initial</h4>
              <p class="cas-detail__p"><?= htmlspecialchars($c['probleme'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div>
              <h4 class="cas-detail__h4">Solution mise en place</h4>
              <p class="cas-detail__p"><?= htmlspecialchars($c['solution'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div>
              <h4 class="cas-detail__h4">Modules utilisés</h4>
              <ul class="cas-detail__modules">
                <?php foreach ($c['modules'] as $m) : ?>
                <li><?= htmlspecialchars($m, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="cas-detail__benefit">
              <h4 class="cas-detail__h4">Bénéfice attendu</h4>
              <p class="cas-detail__p"><?= htmlspecialchars($c['benefice'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section cta-section cas-cta" id="cta-cas">
    <div class="container container-md">
      <div class="section-header center cas-cta-header">
        <h2 class="section-title cas-cta-title">Vous voulez un écosystème similaire dans votre ville ?</h2>
        <p class="section-subtitle cas-cta-sub">Vérifiez d’abord la <strong>disponibilité</strong> de votre territoire, ou passez un <strong>diagnostic 30 min</strong> — sans muscler la vente.</p>
        <div class="cas-cta-row">
          <a class="btn btn-primary btn-lg" href="/verifier-ma-ville">Vérifier ma ville</a>
          <a class="btn btn-outline-white btn-lg" href="/rdv">Réserver un diagnostic</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include 'includes/footer.php'; ?>
