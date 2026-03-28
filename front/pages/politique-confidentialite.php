<?php
$currentPage = 'confidentialite';
$pageTitle = 'Politique de Confidentialité';
$pageDescription = 'Politique de confidentialité et protection des données personnelles - ÉCOSYSTÈME IMMO LOCAL+';
$additionalCSS = 'css/legal.css';
include '../../includes/header.php';
?>

<!-- Hero -->
<section class="legal-hero">
    <div class="container">
        <h1>Politique de Confidentialité</h1>
        <p class="last-update">Dernière mise à jour : <?php echo date('d/m/Y'); ?></p>
    </div>
</section>

<!-- Content -->
<section class="legal-content">
    <div class="legal-container">
        
        <!-- Navigation légale -->
        <nav class="legal-nav">
            <a href="cgv.php">CGV</a>
            <a href="mentions-legales.php">Mentions légales</a>
            <a href="politique-confidentialite.php" class="active">Confidentialité</a>
        </nav>
        
        <!-- Introduction -->
        <div class="legal-highlight">
            <p><strong>Votre vie privée est importante pour nous.</strong> Cette politique explique quelles données nous collectons, pourquoi, et comment nous les protégeons. SAS OCDM Agency s'engage à respecter le RGPD et la législation française en matière de protection des données.</p>
        </div>
        
        <!-- Table des matières -->
        <div class="legal-toc">
            <h3>📋 Sommaire</h3>
            <ol>
                <li><a href="#responsable">Responsable du traitement</a></li>
                <li><a href="#donnees-collectees">Données collectées</a></li>
                <li><a href="#finalites">Finalités du traitement</a></li>
                <li><a href="#base-legale">Base légale</a></li>
                <li><a href="#destinataires">Destinataires des données</a></li>
                <li><a href="#duree-conservation">Durée de conservation</a></li>
                <li><a href="#securite">Sécurité des données</a></li>
                <li><a href="#cookies">Cookies et traceurs</a></li>
                <li><a href="#droits">Vos droits</a></li>
                <li><a href="#transferts">Transferts internationaux</a></li>
                <li><a href="#modifications">Modifications</a></li>
                <li><a href="#contact-dpo">Contact DPO</a></li>
            </ol>
        </div>
        
        <!-- Article 1 - Responsable -->
        <div id="responsable" class="legal-section">
            <h2><span class="section-number">1</span> Responsable du traitement</h2>
            
            <div class="legal-info-card">
                <h4>🏢 Identité du responsable</h4>
                <p><strong>SAS OCDM Agency</strong></p>
                <p>Représentée par Olivier Colas, Président</p>
                <p><strong>Adresse :</strong> [Adresse complète]</p>
                <p><strong>SIRET :</strong> [Numéro SIRET]</p>
                <p><strong>Email :</strong> contact@ecosysteme-immo.fr</p>
            </div>
            
            <p>SAS OCDM Agency est responsable du traitement des données personnelles collectées sur le site ecosysteme-immo.fr et via la plateforme ÉCOSYSTÈME IMMO LOCAL+.</p>
        </div>
        
        <!-- Article 2 - Données collectées -->
        <div id="donnees-collectees" class="legal-section">
            <h2><span class="section-number">2</span> Données collectées</h2>
            
            <h3>2.1 Données que vous nous fournissez</h3>
            <table class="legal-table">
                <tr>
                    <th>Catégorie</th>
                    <th>Données</th>
                    <th>Moment de collecte</th>
                </tr>
                <tr>
                    <td>Identité</td>
                    <td>Nom, prénom, civilité</td>
                    <td>Inscription, formulaires</td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td>Email, téléphone, adresse</td>
                    <td>Inscription, commande</td>
                </tr>
                <tr>
                    <td>Professionnelles</td>
                    <td>Société, fonction, zone d'activité</td>
                    <td>Inscription</td>
                </tr>
                <tr>
                    <td>Paiement</td>
                    <td>IBAN (partiellement masqué)</td>
                    <td>Souscription</td>
                </tr>
                <tr>
                    <td>Connexion</td>
                    <td>Email, mot de passe (hashé)</td>
                    <td>Création de compte</td>
                </tr>
            </table>
            
            <h3>2.2 Données collectées automatiquement</h3>
            <ul>
                <li><strong>Données techniques :</strong> adresse IP, type de navigateur, système d'exploitation, résolution d'écran</li>
                <li><strong>Données de navigation :</strong> pages visitées, durée de visite, parcours sur le site</li>
                <li><strong>Données de connexion :</strong> date et heure de connexion, logs de sécurité</li>
            </ul>
            
            <h3>2.3 Données de vos clients (sous-traitance)</h3>
            <p>Dans le cadre de l'utilisation du CRM, vous pouvez stocker des données de vos propres clients. Vous restez responsable de ces données. Nous agissons en tant que sous-traitant conformément à l'article 28 du RGPD.</p>
        </div>
        
        <!-- Article 3 - Finalités -->
        <div id="finalites" class="legal-section">
            <h2><span class="section-number">3</span> Finalités du traitement</h2>
            
            <p>Vos données personnelles sont traitées pour les finalités suivantes :</p>
            
            <table class="legal-table">
                <tr>
                    <th>Finalité</th>
                    <th>Description</th>
                    <th>Base légale</th>
                </tr>
                <tr>
                    <td>Fourniture du service</td>
                    <td>Création de compte, accès à la plateforme, support</td>
                    <td>Exécution du contrat</td>
                </tr>
                <tr>
                    <td>Gestion des paiements</td>
                    <td>Facturation, prélèvements, comptabilité</td>
                    <td>Exécution du contrat</td>
                </tr>
                <tr>
                    <td>Communication</td>
                    <td>Newsletters, mises à jour du service</td>
                    <td>Consentement / Intérêt légitime</td>
                </tr>
                <tr>
                    <td>Amélioration du service</td>
                    <td>Statistiques, analyse d'usage, tests</td>
                    <td>Intérêt légitime</td>
                </tr>
                <tr>
                    <td>Sécurité</td>
                    <td>Prévention des fraudes, protection des données</td>
                    <td>Intérêt légitime / Obligation légale</td>
                </tr>
                <tr>
                    <td>Prospection commerciale</td>
                    <td>Offres personnalisées, promotions</td>
                    <td>Consentement</td>
                </tr>
            </table>
        </div>
        
        <!-- Article 4 - Base légale -->
        <div id="base-legale" class="legal-section">
            <h2><span class="section-number">4</span> Base légale des traitements</h2>
            
            <p>Conformément au RGPD, tout traitement de données personnelles doit reposer sur une base légale. Voici les bases que nous utilisons :</p>
            
            <ul>
                <li><strong>Exécution du contrat (Art. 6.1.b) :</strong> traitement nécessaire à la fourniture du service que vous avez commandé</li>
                <li><strong>Consentement (Art. 6.1.a) :</strong> pour l'envoi de communications marketing, certains cookies</li>
                <li><strong>Intérêt légitime (Art. 6.1.f) :</strong> amélioration du service, sécurité, prévention des fraudes</li>
                <li><strong>Obligation légale (Art. 6.1.c) :</strong> conservation des factures, réponses aux autorités</li>
            </ul>
        </div>
        
        <!-- Article 5 - Destinataires -->
        <div id="destinataires" class="legal-section">
            <h2><span class="section-number">5</span> Destinataires des données</h2>
            
            <h3>5.1 Au sein de notre organisation</h3>
            <p>Seules les personnes habilitées ont accès à vos données dans le cadre de leurs fonctions : équipe support, comptabilité, direction.</p>
            
            <h3>5.2 Sous-traitants</h3>
            <p>Nous faisons appel à des sous-traitants soigneusement sélectionnés :</p>
            
            <table class="legal-table">
                <tr>
                    <th>Catégorie</th>
                    <th>Sous-traitant</th>
                    <th>Localisation</th>
                </tr>
                <tr>
                    <td>Hébergement</td>
                    <td>[Nom hébergeur]</td>
                    <td>Union Européenne</td>
                </tr>
                <tr>
                    <td>Paiement</td>
                    <td>Stripe</td>
                    <td>UE (données bancaires)</td>
                </tr>
                <tr>
                    <td>Emailing</td>
                    <td>[Nom service email]</td>
                    <td>Union Européenne</td>
                </tr>
                <tr>
                    <td>Analytics</td>
                    <td>Google Analytics / Matomo</td>
                    <td>UE / France</td>
                </tr>
                <tr>
                    <td>Support</td>
                    <td>[Nom outil support]</td>
                    <td>Union Européenne</td>
                </tr>
            </table>
            
            <p>Tous nos sous-traitants sont liés par des clauses contractuelles garantissant la protection de vos données conformément au RGPD.</p>
            
            <h3>5.3 Autorités</h3>
            <p>Vos données peuvent être communiquées aux autorités compétentes sur demande légale (CNIL, administration fiscale, autorités judiciaires).</p>
        </div>
        
        <!-- Article 6 - Durée de conservation -->
        <div id="duree-conservation" class="legal-section">
            <h2><span class="section-number">6</span> Durée de conservation</h2>
            
            <table class="legal-table">
                <tr>
                    <th>Type de données</th>
                    <th>Durée de conservation</th>
                    <th>Justification</th>
                </tr>
                <tr>
                    <td>Données de compte</td>
                    <td>Durée de l'abonnement + 3 ans</td>
                    <td>Prescription commerciale</td>
                </tr>
                <tr>
                    <td>Données de facturation</td>
                    <td>10 ans</td>
                    <td>Obligation légale comptable</td>
                </tr>
                <tr>
                    <td>Données de prospection</td>
                    <td>3 ans après dernier contact</td>
                    <td>CNIL recommandation</td>
                </tr>
                <tr>
                    <td>Logs de connexion</td>
                    <td>1 an</td>
                    <td>Obligation légale (LCEN)</td>
                </tr>
                <tr>
                    <td>Cookies</td>
                    <td>13 mois maximum</td>
                    <td>Recommandation CNIL</td>
                </tr>
                <tr>
                    <td>Données CRM (vos clients)</td>
                    <td>Durée de votre abonnement</td>
                    <td>Exécution du contrat</td>
                </tr>
            </table>
            
            <p>À l'issue de ces durées, les données sont supprimées ou anonymisées de manière irréversible.</p>
        </div>
        
        <!-- Article 7 - Sécurité -->
        <div id="securite" class="legal-section">
            <h2><span class="section-number">7</span> Sécurité des données</h2>
            
            <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données :</p>
            
            <h3>7.1 Mesures techniques</h3>
            <ul>
                <li>Chiffrement SSL/TLS de toutes les communications</li>
                <li>Hashage des mots de passe (bcrypt)</li>
                <li>Pare-feu et systèmes de détection d'intrusion</li>
                <li>Sauvegardes régulières chiffrées</li>
                <li>Mises à jour de sécurité régulières</li>
                <li>Tests de pénétration périodiques</li>
            </ul>
            
            <h3>7.2 Mesures organisationnelles</h3>
            <ul>
                <li>Accès restreint aux données sur base du besoin</li>
                <li>Formation du personnel à la protection des données</li>
                <li>Politique de mots de passe renforcée</li>
                <li>Procédures de gestion des incidents</li>
            </ul>
            
            <div class="legal-success">
                <p><strong>En cas de violation de données</strong> susceptible d'engendrer un risque élevé pour vos droits et libertés, nous vous en informerons dans les meilleurs délais conformément à l'article 34 du RGPD.</p>
            </div>
        </div>
        
        <!-- Article 8 - Cookies -->
        <div id="cookies" class="legal-section">
            <h2><span class="section-number">8</span> Cookies et traceurs</h2>
            
            <h3>8.1 Qu'est-ce qu'un cookie ?</h3>
            <p>Un cookie est un petit fichier texte déposé sur votre appareil lors de la visite d'un site web. Il permet de mémoriser certaines informations pour améliorer votre expérience.</p>
            
            <h3>8.2 Cookies que nous utilisons</h3>
            
            <table class="legal-table">
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Finalité</th>
                    <th>Durée</th>
                </tr>
                <tr>
                    <td>session_id</td>
                    <td>Essentiel</td>
                    <td>Maintien de la session</td>
                    <td>Session</td>
                </tr>
                <tr>
                    <td>cookie_consent</td>
                    <td>Essentiel</td>
                    <td>Mémoriser vos choix cookies</td>
                    <td>12 mois</td>
                </tr>
                <tr>
                    <td>_ga, _gid</td>
                    <td>Analytique</td>
                    <td>Google Analytics - statistiques</td>
                    <td>13 mois</td>
                </tr>
                <tr>
                    <td>_fbp</td>
                    <td>Marketing</td>
                    <td>Facebook Pixel - publicité</td>
                    <td>3 mois</td>
                </tr>
            </table>
            
            <h3>8.3 Gérer vos préférences</h3>
            <p>Vous pouvez à tout moment :</p>
            <ul>
                <li>Modifier vos choix via le bandeau cookies du site</li>
                <li>Configurer votre navigateur pour refuser les cookies</li>
                <li>Utiliser des outils comme YourOnlineChoices pour les cookies publicitaires</li>
            </ul>
            
            <div class="legal-warning">
                <p><strong>Attention :</strong> Le refus de certains cookies peut limiter les fonctionnalités du site ou de votre espace client.</p>
            </div>
        </div>
        
        <!-- Article 9 - Vos droits -->
        <div id="droits" class="legal-section">
            <h2><span class="section-number">9</span> Vos droits</h2>
            
            <p>Conformément au RGPD, vous disposez des droits suivants sur vos données personnelles :</p>
            
            <div class="legal-info-card">
                <h4>📋 Droit d'accès</h4>
                <p>Obtenir la confirmation que vos données sont traitées et en recevoir une copie complète.</p>
            </div>
            
            <div class="legal-info-card">
                <h4>✏️ Droit de rectification</h4>
                <p>Faire corriger des données inexactes ou compléter des données incomplètes.</p>
            </div>
            
            <div class="legal-info-card">
                <h4>🗑️ Droit à l'effacement</h4>
                <p>Demander la suppression de vos données dans les cas prévus par le RGPD.</p>
            </div>
            
            <div class="legal-info-card">
                <h4>⏸️ Droit à la limitation</h4>
                <p>Demander la suspension du traitement de vos données dans certaines circonstances.</p>
            </div>
            
            <div class="legal-info-card">
                <h4>📤 Droit à la portabilité</h4>
                <p>Récupérer vos données dans un format structuré, lisible par machine.</p>
            </div>
            
            <div class="legal-info-card">
                <h4>🚫 Droit d'opposition</h4>
                <p>Vous opposer au traitement de vos données pour motifs légitimes ou à la prospection.</p>
            </div>
            
            <div class="legal-info-card">
                <h4>⚰️ Directives post-mortem</h4>
                <p>Définir des directives relatives au sort de vos données après votre décès.</p>
            </div>
            
            <h3>9.1 Comment exercer vos droits ?</h3>
            <p>Envoyez votre demande par email à <strong>dpo@ecosysteme-immo.fr</strong> en précisant :</p>
            <ul>
                <li>Votre identité (nom, prénom, email associé au compte)</li>
                <li>Le droit que vous souhaitez exercer</li>
                <li>Une copie d'un justificatif d'identité</li>
            </ul>
            <p>Nous répondrons dans un délai maximum de 30 jours.</p>
            
            <h3>9.2 Réclamation auprès de la CNIL</h3>
            <p>Si vous estimez que vos droits ne sont pas respectés, vous pouvez introduire une réclamation auprès de la Commission Nationale de l'Informatique et des Libertés (CNIL) :</p>
            <ul>
                <li><strong>Site web :</strong> <a href="https://www.cnil.fr" target="_blank" rel="noopener">www.cnil.fr</a></li>
                <li><strong>Adresse :</strong> 3 Place de Fontenoy, TSA 80715, 75334 PARIS CEDEX 07</li>
            </ul>
        </div>
        
        <!-- Article 10 - Transferts -->
        <div id="transferts" class="legal-section">
            <h2><span class="section-number">10</span> Transferts internationaux</h2>
            
            <p>Nous privilégions des prestataires situés dans l'Union Européenne. Lorsqu'un transfert hors UE est nécessaire, nous nous assurons qu'il est encadré par :</p>
            
            <ul>
                <li>Une décision d'adéquation de la Commission européenne</li>
                <li>Des clauses contractuelles types (CCT) approuvées par la Commission</li>
                <li>Des règles d'entreprise contraignantes (BCR)</li>
            </ul>
            
            <p>Vous pouvez obtenir une copie des garanties appropriées en nous contactant.</p>
        </div>
        
        <!-- Article 11 - Modifications -->
        <div id="modifications" class="legal-section">
            <h2><span class="section-number">11</span> Modifications de cette politique</h2>
            
            <p>Nous pouvons mettre à jour cette politique de confidentialité pour refléter les évolutions de nos pratiques ou de la réglementation.</p>
            
            <p>En cas de modification substantielle, nous vous en informerons par :</p>
            <ul>
                <li>Email à l'adresse associée à votre compte</li>
                <li>Notification dans votre espace client</li>
                <li>Bandeau d'information sur le site</li>
            </ul>
            
            <p>La date de dernière mise à jour est indiquée en haut de cette page.</p>
        </div>
        
        <!-- Article 12 - Contact DPO -->
        <div id="contact-dpo" class="legal-section">
            <h2><span class="section-number">12</span> Contact</h2>
            
            <p>Pour toute question relative à cette politique ou à vos données personnelles :</p>
            
            <div class="legal-contact">
                <h4>📧 Délégué à la Protection des Données</h4>
                <p><strong>Email :</strong> <a href="mailto:dpo@ecosysteme-immo.fr">dpo@ecosysteme-immo.fr</a></p>
                <p><strong>Courrier :</strong> SAS OCDM Agency - DPO<br>[Adresse complète]</p>
            </div>
        </div>
        
        <!-- Back link -->
        <div class="legal-back">
            <a href="index.php">← Retour à l'accueil</a>
        </div>
        
    </div>
</section>

<?php include '../../includes/footer.php'; ?>