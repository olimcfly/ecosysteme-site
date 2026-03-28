<?php
$currentPage = 'villes-pilotes';
$pageTitle = 'Villes Pilotes | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Explorez les zones disponibles et rejoignez notre réseau de conseillers immobiliers partenaires.';
include '../../includes/header.php';
?>

<style>
/* ---- VILLES PILOTES PAGE ---- */

/* Hero Section */
.villes-hero {
    background: linear-gradient(135deg, #5B5EC7 0%, #8B5CF6 100%);
    padding: 80px 0 100px;
    color: white;
    text-align: center;
}

.villes-hero .hero-badge {
    display: inline-block;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 30px;
    font-size: 0.9rem;
    margin-bottom: 24px;
    backdrop-filter: blur(10px);
}

.villes-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    margin: 0 0 20px 0;
    line-height: 1.1;
}

.villes-hero p {
    font-size: 1.2rem;
    margin: 0;
    opacity: 0.95;
}

/* Section Container */
.section-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 80px 20px;
}

/* Section Badge */
.section-badge {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 24px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.section-badge.blue {
    background: #DBEAFE;
    color: #1E40AF;
}

.section-badge.yellow {
    background: #FEF3C7;
    color: #92400E;
}

.section-badge.green {
    background: #DCFCE7;
    color: #166534;
}

.section-badge.purple {
    background: #F3E8FF;
    color: #6B21A8;
}

/* Section Title */
.section-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1a202c;
    margin: 0 0 16px 0;
    line-height: 1.2;
}

.section-desc {
    font-size: 1rem;
    color: #718096;
    margin: 0 0 50px 0;
    max-width: 700px;
}

/* Carte Interactive */
#map {
    width: 100%;
    height: 550px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    margin-bottom: 80px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

/* Grille Villes */
.villes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 28px;
    margin-bottom: 80px;
}

.ville-card {
    background: white;
    border-radius: 14px;
    padding: 32px;
    border-left: 4px solid #10b981;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    position: relative;
}

.ville-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
}

.ville-card h3 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 12px 0;
}

.ville-coords {
    font-size: 0.85rem;
    color: #a0aec0;
    margin-bottom: 16px;
}

.ville-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    background: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.ville-cta {
    margin-top: 20px;
}

.ville-cta a {
    display: inline-block;
    padding: 12px 24px;
    background: linear-gradient(135deg, #5B5EC7, #8B5CF6);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    transition: opacity 0.2s, transform 0.2s;
}

.ville-cta a:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

/* Zones Réservées */
.zones-reservees {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 28px;
}

.zone-card {
    background: white;
    border-radius: 14px;
    padding: 32px;
    border-left: 4px solid #fbbf24;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    text-align: center;
    transition: all 0.3s ease;
}

.zone-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.zone-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 8px 0;
}

.zone-advisor {
    color: #5B5EC7;
    font-weight: 700;
    font-size: 1.05rem;
    margin: 12px 0;
}

.zone-card p {
    color: #718096;
    font-size: 0.9rem;
    margin: 8px 0 0 0;
}

.zone-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
    margin-top: 16px;
}

/* Levier Timeline Style */
.levier-section {
    padding: 40px;
    background: white;
    border-left: 5px solid #5B5EC7;
    margin-bottom: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.levier-header {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.levier-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #5B5EC7, #8B5CF6);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}

.levier-content h3 {
    font-size: 0.85rem;
    font-weight: 700;
    color: #5B5EC7;
    margin: 0 0 6px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.levier-content h4 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1a202c;
    margin: 0 0 12px 0;
}

.levier-content p {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
    line-height: 1.6;
}

/* CTA Section finale */
.villes-cta {
    background: linear-gradient(135deg, #5B5EC7 0%, #8B5CF6 100%);
    padding: 100px 20px;
    text-align: center;
    color: white;
}

.villes-cta-inner {
    max-width: 900px;
    margin: 0 auto;
}

.villes-cta .hero-badge {
    margin-bottom: 24px;
}

.villes-cta h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 20px 0;
    line-height: 1.1;
}

.villes-cta p {
    font-size: 1.1rem;
    margin: 0 0 40px 0;
    opacity: 0.95;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-btn {
    padding: 16px 36px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    display: inline-block;
}

.cta-btn.primary {
    background: white;
    color: #5B5EC7;
}

.cta-btn.primary:hover {
    opacity: 0.9;
}

.cta-btn.secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.cta-btn.secondary:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .villes-hero h1 {
        font-size: 1.8rem;
    }

    .villes-hero p {
        font-size: 1rem;
    }

    .section-container {
        padding: 50px 15px;
    }

    .section-title {
        font-size: 1.5rem;
    }

    #map {
        height: 400px;
        margin-bottom: 50px;
    }

    .villes-grid,
    .zones-reservees {
        grid-template-columns: 1fr;
    }

    .ville-card,
    .zone-card {
        padding: 24px;
    }

    .villes-cta h2 {
        font-size: 1.8rem;
    }

    .cta-buttons {
        flex-direction: column;
        gap: 12px;
    }

    .cta-btn {
        width: 100%;
    }

    .levier-section {
        padding: 24px;
    }

    .levier-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .levier-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
}
</style>

<!-- HERO SECTION -->
<section class="villes-hero">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="hero-badge">🗺️ Villes disponibles — CARTE</div>
        <h1>Zones pilotes</h1>
        <p>Rejoignez notre réseau et dominez votre marché local</p>
    </div>
</section>

<!-- SECTION CARTE -->
<section style="background: white;">
    <div class="section-container">
        <div class="section-badge blue">🗺️ Explorez</div>
        <h2 class="section-title">Découvrez les zones disponibles</h2>
        <p class="section-desc">
            Cliquez sur la carte pour explorer. Les zones en <strong style="color: #10b981;">vert</strong> sont disponibles, 
            celles en <strong style="color: #fbbf24;">orange</strong> sont réservées à nos partenaires.
        </p>
        
        <div id="map"></div>
    </div>
</section>

<!-- SECTION VILLES DISPONIBLES -->
<section style="background: #f7fafc;">
    <div class="section-container">
        <div class="section-badge green">✓ Disponibles</div>
        <h2 class="section-title">Zones à réserver</h2>
        <p class="section-desc">
            Sélectionnez votre région et candidatez dès maintenant.
        </p>
        
        <div class="villes-grid" id="villesGrid">
            <!-- Généré en JS -->
        </div>
    </div>
</section>

<!-- SECTION ZONES RÉSERVÉES -->
<section style="background: white;">
    <div class="section-container">
        <div class="section-badge yellow">👥 Partenaires</div>
        <h2 class="section-title">Nos conseillers partenaires</h2>
        <p class="section-desc">
            Ils font déjà partie du réseau ÉCOSYSTÈME IMMO+.
        </p>
        
        <div class="zones-reservees" id="zonesReservees">
            <!-- Généré en JS -->
        </div>
    </div>
</section>

<!-- SECTION POURQUOI VILLES PILOTES -->
<section style="background: #f7fafc;">
    <div class="section-container">
        <div class="section-badge purple">💡 Concept</div>
        <h2 class="section-title">Pourquoi des villes pilotes ?</h2>
        <p class="section-desc">
            Une exclusivité par zone pour garantir votre succès.
        </p>

        <div class="levier-section">
            <div class="levier-header">
                <div class="levier-icon">🎯</div>
                <div class="levier-content">
                    <h3>Unicité territoriale</h3>
                    <h4>Une seule licence par ville</h4>
                    <p>Chaque zone est réservée à un seul conseiller. Pas de concurrence interne, une exclusivité garantie pour dominer votre marché local.</p>
                </div>
            </div>
        </div>

        <div class="levier-section">
            <div class="levier-header">
                <div class="levier-icon">🚀</div>
                <div class="levier-content">
                    <h3>Accompagnement complet</h3>
                    <h4>De la capture au mandat signé</h4>
                    <p>Notre écosystème guide chaque prospect jusqu'à la signature. Vous bénéficiez de 43 modules intégrés pour attirer, qualifier et convertir les vendeurs.</p>
                </div>
            </div>
        </div>

        <div class="levier-section">
            <div class="levier-header">
                <div class="levier-icon">⭐</div>
                <div class="levier-content">
                    <h3>Autorité locale</h3>
                    <h4>Devenez le leader immobilier de votre zone</h4>
                    <p>Grâce au contenu local, à la présence Google optimisée et aux réseaux sociaux, vous bâtissez une autorité durable et inattaquable.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINALE -->
<section class="villes-cta">
    <div class="villes-cta-inner">
        <div class="hero-badge">🚀 Places limitées</div>
        <h2>Réservez votre zone maintenant</h2>
        <p>
            4 places restantes sur 10 disponibles. Candidatez et rejoignez nos conseillers partenaires 
            qui dominent déjà leur marché local.
        </p>
        <div class="cta-buttons">
            <a href="/contact?type=beta" class="cta-btn primary">🎯 Candidater à la bêta</a>
            <a href="/contact?type=coaching" class="cta-btn secondary">📞 Demander un coaching</a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>

<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    // Données villes
    const allCities = [
        { name: 'Paris', lat: 48.8566, lng: 2.3522 },
        { name: 'Marseille', lat: 43.2965, lng: 5.3698 },
        { name: 'Lyon', lat: 45.7640, lng: 4.8357 },
        { name: 'Toulouse', lat: 43.6047, lng: 1.4422 },
        { name: 'Nice', lat: 43.7102, lng: 7.2620 },
        { name: 'Strasbourg', lat: 48.5734, lng: 7.7521 },
        { name: 'Montpellier', lat: 43.6108, lng: 3.8767 },
        { name: 'Lille', lat: 50.6292, lng: 3.0573 },
        { name: 'Rennes', lat: 48.1113, lng: -1.6800 },
        { name: 'Reims', lat: 49.2583, lng: 4.0347 },
        { name: 'Havre', lat: 49.4944, lng: 0.1079 },
        { name: 'Saint-Étienne', lat: 45.4398, lng: 4.3910 },
        { name: 'Toulon', lat: 43.1256, lng: 5.9355 },
        { name: 'Grenoble', lat: 45.1885, lng: 5.7245 },
        { name: 'Dijon', lat: 47.3220, lng: 5.0344 },
        { name: 'Angers', lat: 47.4711, lng: -0.5517 },
        { name: 'Villeurbanne', lat: 45.7754, lng: 4.8795 },
        { name: 'Metz', lat: 49.1193, lng: 6.1757 },
        { name: 'Orléans', lat: 47.9029, lng: 1.9039 },
        { name: 'Nanterre', lat: 48.8924, lng: 2.2071 },
    ];

    // Zones réservées
    const takenZones = [
        { name: 'Bordeaux', lat: 44.8378, lng: -0.5792, advisor: 'Eduardo De Sul' },
        { name: 'Nantes', lat: 47.2184, lng: -1.5536, advisor: 'Brice Chupin' },
        { name: 'Aix-en-Provence', lat: 43.5298, lng: 5.4455, advisor: 'Pascal Hamm' },
        { name: 'Nandy', lat: 48.5797, lng: 2.5678, advisor: 'Fatima Rabia' },
        { name: 'Lannion', lat: 48.7321, lng: -3.4528, advisor: 'Stéphanie Hulen' },
    ];

    // Init carte
    const map = L.map('map').setView([46.5, 2.5], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap',
        maxZoom: 19
    }).addTo(map);

    // Marqueurs villes disponibles
    allCities.forEach(city => {
        L.circleMarker([city.lat, city.lng], {
            radius: 8,
            fillColor: '#10b981',
            color: '#fff',
            weight: 2,
            fillOpacity: 0.8
        }).addTo(map).bindPopup(`<strong>${city.name}</strong><br><small>✓ Disponible</small>`);
    });

    // Marqueurs zones réservées
    takenZones.forEach(zone => {
        L.circleMarker([zone.lat, zone.lng], {
            radius: 10,
            fillColor: '#fbbf24',
            color: '#fff',
            weight: 3,
            fillOpacity: 0.9
        }).addTo(map).bindPopup(`<strong>${zone.name}</strong><br><small>${zone.advisor}</small>`);
    });

    // Grille villes disponibles
    const grid = document.getElementById('villesGrid');
    allCities.forEach(city => {
        const card = document.createElement('div');
        card.className = 'ville-card';
        card.innerHTML = `
            <h3>${city.name}</h3>
            <div class="ville-coords">${city.lat.toFixed(4)}° N • ${city.lng.toFixed(4)}° E</div>
            <span class="ville-badge">✓ Disponible</span>
            <div class="ville-cta">
                <a href="/contact?type=beta">Candidater →</a>
            </div>
        `;
        grid.appendChild(card);
    });

    // Zones réservées
    const zonesDiv = document.getElementById('zonesReservees');
    takenZones.forEach(zone => {
        const card = document.createElement('div');
        card.className = 'zone-card';
        card.innerHTML = `
            <h3>${zone.name}</h3>
            <p class="zone-advisor">👤 ${zone.advisor}</p>
            <p>Partenaire ÉCOSYSTÈME IMMO+</p>
            <span class="zone-badge">✓ Réservée</span>
        `;
        zonesDiv.appendChild(card);
    });
</script>