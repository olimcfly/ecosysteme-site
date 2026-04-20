<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Diagnostic stratégique pour conseillers immobiliers";
require_once '../../config/config.php';
require_once '../../includes/header.php';
?>

<div class="survey-landing">
    <section class="survey-hero section">
        <div class="container">
            <div class="survey-hero__content">
                <p class="survey-kicker">Diagnostic stratégique immobilier</p>
                <h1>Et si ton problème n’était pas le marché… mais ta stratégie ?</h1>
                <p class="survey-lead">
                    Découvre en quelques minutes ce qui bloque réellement ton activité immobilière,
                    ce qui te freine, et ce que tu dois changer pour avancer.
                </p>
                <a href="#diagnostic" class="btn btn-primary btn-large">Faire le diagnostic gratuit</a>
            </div>
        </div>
    </section>

    <section class="survey-section section" id="diagnostic">
        <div class="container">
            <div class="survey-card survey-card--cta">
                <h2>Diagnostic EPPE — parcours guidé</h2>
                <p class="survey-card__intro">Réponds étape par étape. C’est rapide, lisible sur mobile, et tu peux revenir en arrière à tout moment.</p>

                <div class="survey-progress" aria-hidden="true">
                    <div class="survey-progress__meta">
                        <span id="survey-step-label">Étape 1 sur 7</span>
                        <span id="survey-step-percent">14%</span>
                    </div>
                    <p id="survey-step-topic" class="survey-progress__topic">Section en cours : EXPÉRIENCE</p>
                    <div class="survey-progress__track">
                        <div id="survey-progress-bar" class="survey-progress__bar"></div>
                    </div>
                </div>

                <form id="strategic-diagnostic-form" class="survey-wizard" novalidate>
                    <input type="hidden" name="source" value="sondage_conseillers_2026">

                    <fieldset class="survey-wizard__step is-active" data-step="1" data-step-title="EXPÉRIENCE">
                        <legend>Section 1 — EXPÉRIENCE</legend>

                        <div class="survey-field">
                            <label for="experience_years">Depuis combien de temps es-tu conseiller immobilier ?</label>
                            <select id="experience_years" name="experience_years" required>
                                <option value="">Sélectionne une réponse</option>
                                <option value="moins_1_an">Moins d'un an</option>
                                <option value="1_3_ans">1 à 3 ans</option>
                                <option value="3_7_ans">3 à 7 ans</option>
                                <option value="7_10_ans">7 à 10 ans</option>
                                <option value="plus_10_ans">Plus de 10 ans</option>
                            </select>
                        </div>

                        <div class="survey-field">
                            <label for="network_status">Dans quel réseau / statut travailles-tu aujourd’hui ?</label>
                            <input id="network_status" name="network_status" type="text" placeholder="Ex: indépendant, réseau national, agence locale" required>
                        </div>

                        <div class="survey-field-grid">
                            <div class="survey-field">
                                <label for="mandates_per_month">Combien de mandats rentres-tu en moyenne par mois ?</label>
                                <input id="mandates_per_month" name="mandates_per_month" type="number" min="0" max="100" required>
                            </div>
                            <div class="survey-field">
                                <label for="sales_per_year">Combien de ventes réalises-tu par an ?</label>
                                <input id="sales_per_year" name="sales_per_year" type="number" min="0" max="300" required>
                            </div>
                        </div>

                        <div class="survey-field">
                            <label for="clients_source">D’où viennent principalement tes clients aujourd’hui ?</label>
                            <textarea id="clients_source" name="clients_source" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <p class="survey-field__label">Utilises-tu déjà des outils digitaux pour générer des leads ?</p>
                            <div class="survey-cards" role="radiogroup" aria-label="Outils digitaux">
                                <label class="survey-option-card">
                                    <input type="radio" name="digital_tools" value="oui_structures" required>
                                    <span>Oui, de façon structurée</span>
                                </label>
                                <label class="survey-option-card">
                                    <input type="radio" name="digital_tools" value="un_peu" required>
                                    <span>Un peu, mais sans système clair</span>
                                </label>
                                <label class="survey-option-card">
                                    <input type="radio" name="digital_tools" value="non" required>
                                    <span>Non, pas encore</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="survey-wizard__step" data-step="2" data-step-title="PROBLÈME">
                        <legend>Section 2 — PROBLÈME</legend>

                        <div class="survey-field">
                            <label for="blocker_mandates">Qu’est-ce qui te bloque aujourd’hui pour rentrer plus de mandats ?</label>
                            <textarea id="blocker_mandates" name="blocker_mandates" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <label for="current_difficulty">Quelle est ta plus grosse difficulté actuelle ?</label>
                            <textarea id="current_difficulty" name="current_difficulty" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <label for="prospect_type_difficulty">As-tu du mal à trouver des vendeurs, des acheteurs, ou les deux ?</label>
                            <select id="prospect_type_difficulty" name="prospect_type_difficulty" required>
                                <option value="">Sélectionne une réponse</option>
                                <option value="vendeurs">Surtout les vendeurs</option>
                                <option value="acheteurs">Surtout les acheteurs</option>
                                <option value="les_deux">Les deux</option>
                                <option value="aucun">Aucun de ces deux points</option>
                            </select>
                        </div>

                        <div class="survey-field">
                            <p class="survey-field__label">As-tu l’impression d’être en concurrence avec trop d’autres agents ?</p>
                            <div class="survey-inline-options">
                                <label><input type="radio" name="high_competition" value="oui" required> Oui</label>
                                <label><input type="radio" name="high_competition" value="non" required> Non</label>
                                <label><input type="radio" name="high_competition" value="parfois" required> Parfois</label>
                            </div>
                        </div>

                        <div class="survey-field">
                            <label for="main_frustration">Qu’est-ce qui te frustre le plus dans ton activité aujourd’hui ?</label>
                            <textarea id="main_frustration" name="main_frustration" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <label for="marketing_tests">As-tu déjà testé des solutions marketing ? Avec quels résultats ?</label>
                            <textarea id="marketing_tests" name="marketing_tests" rows="3" required></textarea>
                        </div>
                    </fieldset>

                    <fieldset class="survey-wizard__step" data-step="3" data-step-title="PROJECTION">
                        <legend>Section 3 — PROJECTION</legend>

                        <div class="survey-field-grid">
                            <div class="survey-field">
                                <label for="target_mandates_month">Combien de mandats aimerais-tu rentrer chaque mois ?</label>
                                <input id="target_mandates_month" name="target_mandates_month" type="number" min="0" max="300" required>
                            </div>
                            <div class="survey-field">
                                <label for="target_sales_year">Combien de ventes viserais-tu idéalement par an ?</label>
                                <input id="target_sales_year" name="target_sales_year" type="number" min="0" max="500" required>
                            </div>
                        </div>

                        <div class="survey-field">
                            <label for="target_income">Quel revenu mensuel souhaites-tu atteindre ?</label>
                            <input id="target_income" name="target_income" type="number" min="0" step="100" required>
                        </div>

                        <div class="survey-field">
                            <label for="ideal_activity">Si tout fonctionnait parfaitement, à quoi ressemblerait ton activité idéale ?</label>
                            <textarea id="ideal_activity" name="ideal_activity" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <p class="survey-field__label">Préfères-tu prospecter activement ou attirer des clients automatiquement ?</p>
                            <div class="survey-cards" role="radiogroup" aria-label="Préférence d'acquisition">
                                <label class="survey-option-card">
                                    <input type="radio" name="acquisition_preference" value="prospection_active" required>
                                    <span>Prospection active</span>
                                </label>
                                <label class="survey-option-card">
                                    <input type="radio" name="acquisition_preference" value="inbound_automatique" required>
                                    <span>Attraction automatique</span>
                                </label>
                                <label class="survey-option-card">
                                    <input type="radio" name="acquisition_preference" value="mixte" required>
                                    <span>Mix des deux</span>
                                </label>
                            </div>
                        </div>

                        <div class="survey-field">
                            <label for="expected_results_3_6">Quels résultats aimerais-tu obtenir dans les 3 à 6 prochains mois ?</label>
                            <textarea id="expected_results_3_6" name="expected_results_3_6" rows="3" required></textarea>
                        </div>
                    </fieldset>

                    <fieldset class="survey-wizard__step" data-step="4" data-step-title="EMPÊCHEMENT">
                        <legend>Section 4 — EMPÊCHEMENT</legend>

                        <div class="survey-field">
                            <label for="current_obstacle">Qu’est-ce qui t’empêche aujourd’hui d’atteindre tes objectifs ?</label>
                            <textarea id="current_obstacle" name="current_obstacle" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <label for="main_obstacle_type">Est-ce surtout un problème de temps, méthode, visibilité, budget ou confiance ?</label>
                            <select id="main_obstacle_type" name="main_obstacle_type" required>
                                <option value="">Sélectionne une réponse</option>
                                <option value="temps">Temps</option>
                                <option value="methode">Méthode</option>
                                <option value="visibilite">Visibilité</option>
                                <option value="budget">Budget</option>
                                <option value="confiance">Confiance</option>
                                <option value="mixte">Mix de plusieurs freins</option>
                            </select>
                        </div>

                        <div class="survey-field">
                            <label for="investment_brake">Qu’est-ce qui te freine le plus pour investir dans ton développement ?</label>
                            <textarea id="investment_brake" name="investment_brake" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <p class="survey-field__label">As-tu déjà essayé de changer les choses sans réussir ?</p>
                            <div class="survey-inline-options">
                                <label><input type="radio" name="already_tried_changes" value="oui" required> Oui</label>
                                <label><input type="radio" name="already_tried_changes" value="non" required> Non</label>
                            </div>
                        </div>

                        <div class="survey-field">
                            <label for="need_to_progress">De quoi aurais-tu besoin pour avancer avec plus de clarté ?</label>
                            <textarea id="need_to_progress" name="need_to_progress" rows="3" required></textarea>
                        </div>

                        <div class="survey-field">
                            <label for="primary_brake">Quel est ton principal frein aujourd’hui ?</label>
                            <textarea id="primary_brake" name="primary_brake" rows="3" required></textarea>
                        </div>
                    </fieldset>

                    <fieldset class="survey-wizard__step" data-step="5" data-step-title="QUALIFICATION">
                        <legend>Section 5 — QUALIFICATION</legend>

                        <div class="survey-field">
                            <p class="survey-field__label">Es-tu prêt à investir dans ton développement si la solution est adaptée ?</p>
                            <div class="survey-inline-options">
                                <label><input type="radio" name="ready_to_invest" value="oui" required> Oui</label>
                                <label><input type="radio" name="ready_to_invest" value="peut_etre" required> Peut-être</label>
                                <label><input type="radio" name="ready_to_invest" value="non" required> Non</label>
                            </div>
                        </div>

                        <div class="survey-field">
                            <label for="desired_timeline">Sous combien de temps veux-tu des résultats ?</label>
                            <select id="desired_timeline" name="desired_timeline" required>
                                <option value="">Sélectionne une réponse</option>
                                <option value="0_30_jours">0 à 30 jours</option>
                                <option value="1_3_mois">1 à 3 mois</option>
                                <option value="3_6_mois">3 à 6 mois</option>
                                <option value="6_mois_plus">Plus de 6 mois</option>
                            </select>
                        </div>

                        <div class="survey-field">
                            <label for="motivation_score">Sur une échelle de 1 à 10, à quel point es-tu motivé ?</label>
                            <div class="survey-range">
                                <input id="motivation_score" name="motivation_score" type="range" min="1" max="10" value="7" required>
                                <output for="motivation_score" id="motivation_score_output">7/10</output>
                            </div>
                        </div>

                        <div class="survey-field">
                            <p class="survey-field__label">Acceptes-tu de changer ta manière de travailler si nécessaire ?</p>
                            <div class="survey-inline-options">
                                <label><input type="radio" name="open_to_change" value="oui" required> Oui</label>
                                <label><input type="radio" name="open_to_change" value="non" required> Non</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="survey-wizard__step" data-step="6" data-step-title="SYNTHÈSE">
                        <legend>Avant ta synthèse</legend>
                        <p class="survey-lead-capture-copy">Entre ton email pour recevoir ta synthèse et accéder à la suite.</p>
                        <p class="survey-lead-capture-note">Promis : pas de spam, seulement des insights utiles pour ton activité.</p>

                        <div class="survey-field-grid">
                            <div class="survey-field">
                                <label for="contact_email">Email professionnel</label>
                                <input id="contact_email" name="email" type="email" autocomplete="email" required>
                            </div>
                            <div class="survey-field">
                                <label for="contact_nom">Prénom (optionnel)</label>
                                <input id="contact_nom" name="nom" type="text" autocomplete="given-name" placeholder="Ex: Sarah">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="survey-wizard__step" data-step="7" data-step-title="FINALISATION">
                        <legend>Dernière étape</legend>
                        <div class="survey-final-step">
                            <h3>Tout est prêt ✅</h3>
                            <p>Tu vas recevoir ta synthèse stratégique et la suite logique selon ton profil.</p>
                            <ul>
                                <li>Analyse de tes réponses EPPE</li>
                                <li>Priorité stratégique recommandée</li>
                                <li>Prochaine action concrète à mettre en place</li>
                            </ul>
                        </div>
                    </fieldset>

                    <div id="survey-step-error" class="survey-step-error" role="alert" aria-live="polite"></div>

                    <div class="survey-wizard__actions">
                        <button type="button" id="survey-prev" class="btn btn-secondary">Précédent</button>
                        <button type="button" id="survey-next" class="btn btn-primary">Suivant</button>
                        <button type="submit" id="survey-submit" class="btn btn-primary">Recevoir ma synthèse</button>
                    </div>

                    <p class="survey-form__hint">Réponse estimée : 4 à 6 minutes. Tu peux revenir en arrière à tout moment.</p>
                    <p id="survey-form-feedback" class="survey-form__feedback" aria-live="polite"></p>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="<?= ASSETS_URL ?>js/survey-form.js"></script>

<?php require_once '../../includes/footer.php'; ?>
