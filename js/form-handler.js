/**
 * form-handler.js
 * Gère tous les formulaires de capture avec data-resource-form
 * Envoie vers /api/save-lead.php et redirige vers merci-*.php
 */

document.addEventListener('DOMContentLoaded', function() {
    // Récupère le formulaire avec l'attribut data-resource-form
    const form = document.getElementById('form-capture');
    
    if (!form) {
        console.warn('Formulaire #form-capture non trouvé');
        return;
    }
    
    // Récupère le type de ressource depuis data-resource-form
    const resourceType = form.getAttribute('data-resource-form');
    
    if (!resourceType) {
        console.warn('Attribut data-resource-form manquant');
        return;
    }
    
    // Mapping des ressources vers les pages de remerciement
    const redirectMap = {
        'neuropersona': '/front/ressources/merci-neuropersona.php',
        'seo': '/front/ressources/merci-seo.php',
        'mere': '/front/ressources/merci-mere.php',
        'journal-gmb': '/front/ressources/merci-gmb.php',
        'audit-visibilite': '/front/ressources/audit-visibilite.php',
        'estimateur': '/front/ressources/estimateur.php',
        'calculateur-roi': '/front/ressources/calculateur-roi.php'
    };
    
    // Gère la soumission du formulaire
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Collecte les données du formulaire
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Ajoute le type de ressource
        data.resource = resourceType;
        data.type = 'contact'; // Type par défaut
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
    
    // Log pour débugger
    console.log('form-handler.js chargé avec succès');
    console.log('Ressource détectée:', resourceType);
    console.log('Redirection vers:', redirectMap[resourceType] || 'NON CONFIGURÉE');
});