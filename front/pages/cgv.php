<?php
$currentPage = 'cgv';
$pageTitle = 'Conditions Générales de Vente';
$pageDescription = 'Conditions Générales de Vente de ÉCOSYSTÈME IMMO LOCAL+ - SAS OCDM Agency';
$additionalCSS = 'css/legal.css';
include '../../includes/header.php';
?>

<!-- Hero -->
<section class="legal-hero">
    <div class="container">
        <h1>Conditions Générales de Vente</h1>
        <p class="last-update">Dernière mise à jour : <?php echo date('d/m/Y'); ?></p>
    </div>
</section>

<!-- Content -->
<section class="legal-content">
    <div class="legal-container">
        
        <!-- Navigation légale -->
        <nav class="legal-nav">
            <a href="cgv.php" class="active">CGV</a>
            <a href="mentions-legales.php">Mentions légales</a>
            <a href="politique-confidentialite.php">Confidentialité</a>
        </nav>
        
        <!-- Table des matières -->
        <div class="legal-toc">
            <h3>📋 Sommaire</h3>
            <ol>
                <li><a href="#article-1">Objet et champ d'application</a></li>
                <li><a href="#article-2">Description des services</a></li>
                <li><a href="#article-3">Exclusivité territoriale</a></li>
                <li><a href="#article-4">Tarifs et conditions de paiement</a></li>
                <li><a href="#article-5">Durée et résiliation</a></li>
                <li><a href="#article-6">Garantie satisfait ou remboursé</a></li>
                <li><a href="#article-7">Obligations du client</a></li>
                <li><a href="#article-8">Propriété intellectuelle</a></li>
                <li><a href="#article-9">Protection des données</a></li>
                <li><a href="#article-10">Responsabilité</a></li>
                <li><a href="#article-11">Droit de rétractation</a></li>
                <li><a href="#article-12">Litiges et droit applicable</a></li>
            </ol>
        </div>
        
        <!-- Article 1 -->
        <div id="article-1" class="legal-section">
            <h2><span class="section-number">1</span> Objet et champ d'application</h2>
            <p>Les présentes Conditions Générales de Vente (CGV) régissent les relations contractuelles entre :</p>
            
            <div class="legal-info-card">
                <h4>Le Prestataire</h4>
                <p><strong>SAS OCDM Agency</strong></p>
                <p>Représentée par Olivier Colas</p>
                <p>SIRET : [Numéro SIRET]</p>
                <p>Siège social : [Adresse complète]</p>
                <p>Email : contact@ecosysteme-immo.fr</p>
            </div>
            
            <p>Et toute personne physique ou morale, professionnelle de l'immobilier, souscrivant à l'offre ÉCOSYSTÈME IMMO LOCAL+ (ci-après « le Client »).</p>
            
            <p>La souscription à nos services implique l'acceptation pleine et entière des présentes CGV. Ces conditions prévalent sur tout autre document du Client, sauf accord écrit contraire.</p>
        </div>
        
        <!-- Article 2 -->
        <div id="article-2" class="legal-section">
            <h2><span class="section-number">2</span> Description des services</h2>
            <p>ÉCOSYSTÈME IMMO LOCAL+ est une plateforme SaaS (Software as a Service) destinée aux conseillers immobiliers indépendants, comprenant :</p>
            
            <h3>2.1 Présence digitale</h3>
            <ul>
                <li>Site web professionnel personnalisé et hébergé</li>
                <li>Pages localités optimisées pour le référencement local</li>
                <li>Blog avec articles pré-rédigés et modifiables</li>
                <li>Maintenance technique et mises à jour incluses</li>
            </ul>
            
            <h3>2.2 Outils métier</h3>
            <ul>
                <li>CRM (Customer Relationship Management) immobilier</li>
                <li>Gestion des leads et prospects</li>
                <li>Estimateur de biens en ligne</li>
                <li>Tableau de bord et statistiques</li>
            </ul>
            
            <h3>2.3 Intelligence artificielle</h3>
            <ul>
                <li>Assistant IA pour la génération de contenu</li>
                <li>Réponses automatiques aux prospects</li>
                <li>Analyse de marché</li>
            </ul>
            
            <h3>2.4 Marketing et acquisition</h3>
            <ul>
                <li>Templates de publicités (Facebook, Google)</li>
                <li>Séquences emails automatisées</li>
                <li>Formation au marketing digital</li>
            </ul>
            
            <p>La liste des fonctionnalités peut évoluer. Le Prestataire s'engage à informer les Clients de toute modification substantielle.</p>
        </div>
        
        <!-- Article 3 -->
        <div id="article-3" class="legal-section">
            <h2><span class="section-number">3</span> Exclusivité territoriale</h2>
            
            <div class="legal-highlight">
                <p><strong>Principe fondamental :</strong> Chaque zone géographique est attribuée à un seul Client. Cette exclusivité est garantie tant que le Client reste abonné au service.</p>
            </div>
            
            <h3>3.1 Définition de la zone</h3>
            <p>La zone territoriale est définie lors de la souscription en accord avec le Client. Elle peut correspondre à une commune, un quartier, ou un ensemble de communes adjacentes.</p>
            
            <h3>3.2 Protection de l'exclusivité</h3>
            <ul>
                <li>Aucun autre Client ne pourra souscrire sur la même zone</li>
                <li>L'exclusivité est maintenue tant que l'abonnement est actif</li>
                <li>En cas de résiliation, la zone redevient disponible après un délai de 30 jours</li>
            </ul>
            
            <h3>3.3 Changement de zone</h3>
            <p>Le Client peut demander un changement de zone sous réserve de disponibilité. Cette demande doit être formulée par écrit et sera traitée sous 7 jours ouvrés.</p>
        </div>
        
        <!-- Article 4 -->
        <div id="article-4" class="legal-section">
            <h2><span class="section-number">4</span> Tarifs et conditions de paiement</h2>
            
            <h3>4.1 Tarification</h3>
            <table class="legal-table">
                <tr>
                    <th>Offre</th>
                    <th>Tarif mensuel</th>
                    <th>Conditions</th>
                </tr>
                <tr>
                    <td>Offre Fondateur (100 premiers)</td>
                    <td>47€ HT/mois</td>
                    <td>Tarif garanti à vie</td>
                </tr>
                <tr>
                    <td>Offre Standard</td>
                    <td>97€ HT/mois</td>
                    <td>Après les 100 premiers inscrits</td>
                </tr>
            </table>
            <p>Tous les tarifs sont indiqués hors taxes. La TVA applicable sera ajoutée selon la réglementation en vigueur.</p>
            
            <h3>4.2 Modalités de paiement</h3>
            <ul>
                <li><strong>Fréquence :</strong> Prélèvement mensuel à date anniversaire</li>
                <li><strong>Moyens acceptés :</strong> Carte bancaire, prélèvement SEPA</li>
                <li><strong>Sécurisation :</strong> Paiements sécurisés via Stripe</li>
            </ul>
            
            <h3>4.3 Retard de paiement</h3>
            <p>En cas de retard de paiement, des pénalités de retard égales à 3 fois le taux d'intérêt légal seront appliquées, ainsi qu'une indemnité forfaitaire de 40€ pour frais de recouvrement.</p>
            
            <p>L'accès aux services pourra être suspendu après 15 jours de retard et une relance préalable restée sans effet.</p>
        </div>
        
        <!-- Article 5 -->
        <div id="article-5" class="legal-section">
            <h2><span class="section-number">5</span> Durée et résiliation</h2>
            
            <h3>5.1 Durée</h3>
            <p>L'abonnement est souscrit sans engagement de durée minimale. Il se renouvelle tacitement chaque mois.</p>
            
            <h3>5.2 Résiliation par le Client</h3>
            <ul>
                <li>Résiliation possible à tout moment depuis l'espace client</li>
                <li>Effet à la fin de la période de facturation en cours</li>
                <li>Aucun frais de résiliation</li>
            </ul>
            
            <h3>5.3 Résiliation par le Prestataire</h3>
            <p>Le Prestataire se réserve le droit de résilier l'abonnement en cas de :</p>
            <ul>
                <li>Non-paiement persistant malgré relances</li>
                <li>Utilisation frauduleuse ou abusive des services</li>
                <li>Violation des présentes CGV</li>
                <li>Atteinte à l'image de la plateforme</li>
            </ul>
            
            <h3>5.4 Conséquences de la résiliation</h3>
            <p>À la résiliation, le Client conserve la propriété de ses données personnelles et de ses contenus. Un export sera fourni sur demande dans un délai de 30 jours.</p>
        </div>
        
        <!-- Article 6 -->
        <div id="article-6" class="legal-section">
            <h2><span class="section-number">6</span> Garantie satisfait ou remboursé</h2>
            
            <div class="legal-success">
                <p><strong>Garantie 30 jours :</strong> Tout nouveau Client dispose d'un délai de 30 jours après sa première souscription pour demander le remboursement intégral de son premier mois, sans justification.</p>
            </div>
            
            <h3>6.1 Conditions</h3>
            <ul>
                <li>Demande formulée dans les 30 jours suivant la souscription</li>
                <li>Demande envoyée par email à support@ecosysteme-immo.fr</li>
                <li>Applicable uniquement au premier mois d'abonnement</li>
            </ul>
            
            <h3>6.2 Remboursement</h3>
            <p>Le remboursement est effectué sous 48h ouvrées par le même moyen de paiement utilisé lors de la souscription.</p>
        </div>
        
        <!-- Article 7 -->
        <div id="article-7" class="legal-section">
            <h2><span class="section-number">7</span> Obligations du client</h2>
            
            <p>Le Client s'engage à :</p>
            <ul>
                <li>Fournir des informations exactes lors de l'inscription</li>
                <li>Maintenir la confidentialité de ses identifiants de connexion</li>
                <li>Utiliser les services conformément à leur destination professionnelle</li>
                <li>Respecter la législation en vigueur, notamment en matière immobilière</li>
                <li>Ne pas porter atteinte à l'image et à la réputation de la plateforme</li>
                <li>Ne pas tenter de contourner les mesures de sécurité</li>
            </ul>
            
            <div class="legal-warning">
                <p>Le Client est seul responsable du contenu qu'il publie via la plateforme. Il garantit disposer des droits nécessaires sur les contenus (textes, images, etc.) qu'il utilise.</p>
            </div>
        </div>
        
        <!-- Article 8 -->
        <div id="article-8" class="legal-section">
            <h2><span class="section-number">8</span> Propriété intellectuelle</h2>
            
            <h3>8.1 Droits du Prestataire</h3>
            <p>La plateforme ÉCOSYSTÈME IMMO LOCAL+, son code source, son architecture, ses templates et contenus préexistants demeurent la propriété exclusive de SAS OCDM Agency.</p>
            
            <h3>8.2 Licence d'utilisation</h3>
            <p>Le Client bénéficie d'une licence d'utilisation non exclusive, personnelle et non cessible, pour la durée de son abonnement.</p>
            
            <h3>8.3 Contenus du Client</h3>
            <p>Le Client reste propriétaire des contenus qu'il crée ou importe. Il accorde au Prestataire une licence d'utilisation limitée aux fins de fourniture du service.</p>
        </div>
        
        <!-- Article 9 -->
        <div id="article-9" class="legal-section">
            <h2><span class="section-number">9</span> Protection des données personnelles</h2>
            
            <p>Le Prestataire s'engage à respecter la réglementation en vigueur relative à la protection des données personnelles, notamment le RGPD.</p>
            
            <p>Pour plus d'informations sur la collecte et le traitement des données, veuillez consulter notre <a href="politique-confidentialite.php">Politique de Confidentialité</a>.</p>
            
            <h3>9.1 Données collectées</h3>
            <p>Les données collectées sont nécessaires à la fourniture du service et à la gestion de la relation commerciale.</p>
            
            <h3>9.2 Sous-traitance</h3>
            <p>Le Prestataire peut faire appel à des sous-traitants (hébergement, paiement) dans le respect du RGPD.</p>
        </div>
        
        <!-- Article 10 -->
        <div id="article-10" class="legal-section">
            <h2><span class="section-number">10</span> Responsabilité</h2>
            
            <h3>10.1 Engagements du Prestataire</h3>
            <p>Le Prestataire s'engage à fournir ses services avec diligence et professionnalisme. Il s'agit d'une obligation de moyens.</p>
            
            <h3>10.2 Limitations</h3>
            <p>Le Prestataire ne saurait être tenu responsable :</p>
            <ul>
                <li>Des dommages indirects (perte de chiffre d'affaires, préjudice commercial)</li>
                <li>Des interruptions temporaires liées à la maintenance</li>
                <li>Des dysfonctionnements imputables à des tiers</li>
                <li>De l'utilisation faite par le Client des services</li>
                <li>Des résultats commerciaux obtenus par le Client</li>
            </ul>
            
            <h3>10.3 Plafond de responsabilité</h3>
            <p>En tout état de cause, la responsabilité du Prestataire est limitée au montant des sommes versées par le Client au cours des 12 derniers mois.</p>
        </div>
        
        <!-- Article 11 -->
        <div id="article-11" class="legal-section">
            <h2><span class="section-number">11</span> Droit de rétractation</h2>
            
            <p>Conformément à l'article L221-28 du Code de la consommation, le droit de rétractation ne peut être exercé pour les contrats de fourniture d'un contenu numérique non fourni sur un support matériel dont l'exécution a commencé après accord préalable exprès du consommateur.</p>
            
            <p>Toutefois, la garantie satisfait ou remboursé de 30 jours (Article 6) offre une protection supérieure au droit légal de rétractation.</p>
        </div>
        
        <!-- Article 12 -->
        <div id="article-12" class="legal-section">
            <h2><span class="section-number">12</span> Litiges et droit applicable</h2>
            
            <h3>12.1 Droit applicable</h3>
            <p>Les présentes CGV sont soumises au droit français.</p>
            
            <h3>12.2 Médiation</h3>
            <p>En cas de litige, le Client peut recourir gratuitement au service de médiation de la consommation. Le médiateur compétent est : [Nom du médiateur].</p>
            
            <h3>12.3 Juridiction compétente</h3>
            <p>À défaut de résolution amiable, tout litige sera soumis aux tribunaux compétents du ressort de [Ville du siège social].</p>
        </div>
        
        <!-- Contact -->
        <div class="legal-contact">
            <h4>Une question sur nos CGV ?</h4>
            <p>Notre équipe est à votre disposition pour toute clarification.</p>
            <p>📧 <a href="mailto:contact@ecosysteme-immo.fr">contact@ecosysteme-immo.fr</a></p>
        </div>
        
        <!-- Back link -->
        <div class="legal-back">
            <a href="index.php">← Retour à l'accueil</a>
        </div>
        
    </div>
</section>

<?php include '../../includes/footer.php'; ?>