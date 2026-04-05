<section class="tab-panel" data-panel="settings">
    <div class="panel-card">
        <h2>Paramètres</h2>
        <form id="settings-form" class="settings-form">
            <label for="refreshInterval">Rafraîchissement auto (secondes)</label>
            <input id="refreshInterval" name="refreshInterval" type="number" min="15" step="5" value="60">

            <label>
                <input type="checkbox" id="compactMode" name="compactMode">
                Activer l'affichage compact sur mobile
            </label>

            <button class="btn btn-primary" type="submit">Sauvegarder</button>
        </form>
    </div>
</section>
