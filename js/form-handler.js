/**
 * form-handler.js
 * Gère tous les formulaires de capture avec data-resource-form
 * Envoie vers /api/save-lead.php et redirige vers merci-*.php
 */

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form.lead-form');

    if (!forms.length) {
        return;
    }

    const redirectMap = {
        'neuropersona': '/front/ressources/merci-neuropersona.php',
        'seo': '/front/ressources/merci-seo.php',
        'mere': '/front/ressources/merci-mere.php',
        'journal-gmb': '/front/ressources/merci-gmb.php',
        'audit-visibilite': '/front/ressources/merci-ressource-audit.php',
        'estimateur': '/front/ressources/merci-ressource-estimateur.php',
        'calculateur-roi': '/front/ressources/merci-ressource-roi.php'
    };

    const resourceIntentMap = {
        'calculateur-roi': 'outil',
        'audit-visibilite': 'outil',
        'estimateur': 'outil',
        'journal-gmb': 'ressource',
        'neuropersona': 'ressource',
        'seo': 'ressource',
        'mere': 'ressource'
    };

    forms.forEach((form) => {
        const resourceType = form.getAttribute('data-resource-form') || form.getAttribute('data-resource');
        if (!resourceType) {
            return;
        }

        form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Collecte les données du formulaire
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Ajoute le type de ressource
        data.resource = resourceType;
        data.type = resourceIntentMap[resourceType] || 'ressource';
        data.source = 'ressources'; // Source identifiée
        
        // Désactive le bouton de soumission
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = '⏳ Traitement en cours...';
        
        // Envoie les données à save-lead.php
        fetch('/api/save-lead.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            // Vérifie si la réponse est valide
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.success) {
                // Succès ! Redirige vers la page de remerciement
                const redirectUrl = redirectMap[resourceType];
                
                if (redirectUrl) {
                    // Redirige après une petite pause pour laisser le lead se créer
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 500);
                } else {
                    console.error('URL de redirection non trouvée pour', resourceType);
                    alert('Erreur : page de remerciement non trouvée. Veuillez contacter le support.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            } else {
                // Erreur du serveur
                console.error('Erreur save-lead.php:', result.error);
                alert(`Erreur : ${result.error || 'Impossible de traiter votre demande.'}`);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(error => {
            // Erreur réseau ou parse
            console.error('Erreur réseau:', error);
            alert(`Erreur de connexion : ${error.message || 'Veuillez réessayer.'}`);
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
        });
    });
});
