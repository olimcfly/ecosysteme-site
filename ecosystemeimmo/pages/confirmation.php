<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOSYSTEMEIMMO | Formulaire de qualification</title>
    <meta name="description" content="Dernière étape : vérifiez si votre zone est disponible et qualifiez votre demande en moins de 2 minutes.">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header class="header">
    <div class="container header-inner">
        <div class="logo">ECOSYSTEME<span>IMMO</span></div>
        <a href="#formulaire" class="btn btn-primary">Vérifier ma zone</a>
    </div>
</header>

<main class="section qualify-main">
    <div class="container qualify-shell">
        <p class="badge">PAGE 4 — FORMULAIRE + QUALIFICATION</p>
        <h1 class="qualify-title">Vérifiez si votre zone est encore disponible.</h1>
        <p class="qualify-intro">Quelques questions rapides, moins de 2 minutes. Elles nous permettent de préparer un échange utile et personnalisé.</p>

        <section class="panel important-box">
            <p><strong>⚠️ Avant de continuer</strong></p>
            <p>Ce formulaire est réservé aux conseillers immobiliers qui souhaitent réellement développer leur visibilité locale et obtenir plus de contacts vendeurs.</p>
            <p>Si vous cherchez juste à vous informer, cette étape n'est pas pour vous. Si vous êtes prêt à passer à l'action, continuez.</p>
        </section>

        <section class="panel qualify-form-wrap" id="formulaire">
            <h2>Le formulaire</h2>
            <form action="../scripts/process_lead.php" method="post" class="qualify-form">
                <fieldset>
                    <legend>Vos coordonnées</legend>
                    <label for="name">Prénom et Nom</label>
                    <input id="name" name="name" type="text" placeholder="Votre prénom et nom" required>

                    <label for="email">Adresse email</label>
                    <input id="email" name="email" type="email" placeholder="vous@exemple.com" required>

                    <label for="phone">Numéro de téléphone</label>
                    <input id="phone" name="phone" type="tel" placeholder="06 00 00 00 00" required>
                </fieldset>

                <fieldset>
                    <legend>Votre activité</legend>
                    <label for="zone">Votre zone géographique</label>
                    <input id="zone" name="zone" type="text" placeholder="Ville, secteur ou département" required>

                    <p class="field-label">Depuis combien de temps êtes-vous conseiller immobilier ?</p>
                    <label class="choice"><input type="radio" name="experience" value="moins-2-ans" required> Moins de 2 ans</label>
                    <label class="choice"><input type="radio" name="experience" value="2-5-ans"> Entre 2 et 5 ans</label>
                    <label class="choice"><input type="radio" name="experience" value="plus-5-ans"> Plus de 5 ans</label>
                </fieldset>

                <fieldset>
                    <legend>Votre situation actuelle</legend>
                    <p class="field-label">Recevez-vous actuellement des contacts vendeurs ?</p>
                    <label class="choice"><input type="radio" name="inbound_leads" value="oui-regulierement" required> Oui régulièrement</label>
                    <label class="choice"><input type="radio" name="inbound_leads" value="parfois"> Parfois</label>
                    <label class="choice"><input type="radio" name="inbound_leads" value="jamais"> Jamais</label>

                    <label for="goal">Quel est votre objectif principal ?</label>
                    <textarea id="goal" name="goal" rows="3" placeholder="En une ou deux phrases"></textarea>
                </fieldset>

                <fieldset>
                    <legend>Votre engagement</legend>
                    <p class="field-label">Êtes-vous prêt à investir dans votre visibilité locale ?</p>
                    <label class="choice"><input type="radio" name="ready_to_invest" value="oui-priorite" required> Oui</label>
                    <label class="choice"><input type="radio" name="ready_to_invest" value="non"> Non</label>
                </fieldset>

                <button class="btn btn-primary qualify-submit" type="submit">Valider ma demande et vérifier ma zone</button>
                <p class="qualify-note">🔒 Vos informations restent confidentielles. Elles ne sont jamais partagées.</p>
                <p class="qualify-scarcity">1 seul conseiller sélectionné par zone. Les demandes sont traitées dans l'ordre de réception.</p>
            </form>
        </section>
    </div>
</main>

<section class="section qualify-variants">
    <div class="container">
        <div class="section-title"><h2>Version courte</h2></div>
        <article class="panel">
            <h3>Votre zone est-elle encore disponible ?</h3>
            <p>Formulaire en moins de 2 minutes. Réservé aux conseillers prêts à passer à l'action.</p>
            <p>Nom, email, téléphone, zone, situation actuelle, engagement.</p>
            <a href="#formulaire" class="btn btn-primary">Vérifier ma zone</a>
            <p class="qualify-scarcity">1 conseiller par zone — accès limité.</p>
        </article>
    </div>
</section>

<section class="section qualify-variants">
    <div class="container">
        <div class="section-title"><h2>3 variantes de titres</h2></div>
        <div class="solution-grid">
            <article class="card"><p>Dernière étape — vérifiez si votre zone est encore libre.</p></article>
            <article class="card"><p>Accédez à ECOSYSTEMEIMMO — une seule place par secteur.</p></article>
            <article class="card"><p>Deux minutes pour savoir si on peut travailler ensemble.</p></article>
        </div>
    </div>
</section>

<section class="section qualify-variants">
    <div class="container">
        <div class="section-title"><h2>3 variantes de CTA</h2></div>
        <div class="hero-actions">
            <a href="#formulaire" class="btn btn-primary">→ Valider ma demande et vérifier ma zone</a>
            <a href="#formulaire" class="btn btn-primary">→ Accéder à mon rendez-vous personnalisé</a>
            <a href="#formulaire" class="btn btn-primary">→ Soumettre ma demande — zone limitée</a>
        </div>
    </div>
</section>

<section class="section qualify-variants">
    <div class="container">
        <div class="section-title"><h2>3 variantes du bloc important</h2></div>
        <div class="solution-grid">
            <article class="card"><p><strong>⚠️ Ce formulaire est sélectif.</strong><br>Réservé aux conseillers expérimentés prêts à agir.</p></article>
            <article class="card"><p><strong>🔒 Accès sur sélection.</strong><br>Nous travaillons uniquement avec des conseillers motivés et actifs.</p></article>
            <article class="card"><p><strong>💬 Avant de remplir ce formulaire.</strong><br>Si vous êtes dans une vraie démarche de développement, bienvenue.</p></article>
        </div>
    </div>
</section>

<section class="section qualify-variants premium-block">
    <div class="container panel">
        <div class="section-title"><h2>Version premium</h2></div>
        <p class="premium-lead">Une seule place par zone. Vérifiez si la vôtre est encore disponible.</p>
        <p>Nous sélectionnons nos partenaires avec soin. Ce formulaire nous aide à préparer un échange pertinent et efficace.</p>
        <p><strong>Accès sur sélection.</strong> Nous travaillons avec des conseillers expérimentés, engagés, et prêts à structurer leur visibilité locale.</p>
        <a href="#formulaire" class="btn btn-primary">Accéder à mon rendez-vous personnalisé</a>
        <p class="qualify-note">🔒 Données strictement confidentielles.</p>
        <p class="qualify-scarcity">Attribution exclusive : 1 conseiller par zone géographique. Traitement par ordre de réception.</p>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <p><strong>ECOSYSTEMEIMMO</strong> — qualification préalable pour garantir un accompagnement sérieux et personnalisé.</p>
    </div>
</footer>
</body>
</html>
