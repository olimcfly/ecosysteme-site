# ecosystemeimmo.fr

Site vitrine Astro + Tailwind CSS pour Écosystème Immo.

## Stack

- [Astro](https://astro.build) — framework SSG
- [Tailwind CSS](https://tailwindcss.com) — styles utilitaires
- Hébergement recommandé : [Netlify](https://netlify.com) (formulaire Netlify Forms intégré)

## Lancer en local

```bash
npm install
npm run dev
```

## Build de production

```bash
npm run build
npm run preview
```

## Structure

```
src/
├── layouts/
│   └── Layout.astro          # Layout global (scarcity bar + header + footer)
├── components/
│   ├── Header.astro           # Navigation + CTA
│   ├── Hero.astro             # Section hero principale
│   ├── HowItWorks.astro       # 3 étapes du processus
│   ├── Features.astro         # 6 fonctionnalités du système
│   ├── Pricing.astro          # Tarifs (Estimateur / Mensuelle / Annuelle / Exclusivité)
│   ├── Realisations.astro     # Clients avec badges "Territoire complet"
│   ├── FAQ.astro              # 3 objections clés
│   ├── CTAFinal.astro         # Formulaire de vérification (id="verifier")
│   └── Footer.astro           # Pied de page simplifié
└── pages/
    ├── index.astro            # Homepage
    ├── offre.astro            # Page offres détaillée
    ├── realisations.astro     # Page réalisations complète
    └── blog.astro             # Blog (placeholder)
```

## Formulaire de contact

Le formulaire dans `CTAFinal.astro` utilise [Netlify Forms](https://docs.netlify.com/forms/setup/).
Sur un autre hébergeur, remplacer `data-netlify="true"` par une action vers Formspree ou un autre service.

## Pricing actif

| Formule | Prix |
|---------|------|
| Estimateur | 27 €/mois + 197 € setup |
| Mensuelle (recommandée) | 97 €/mois + 497 € setup, 3 mois prépayés |
| Annuelle | 897 €/an, setup offert |
| Exclusivité verrouillée | 900 € paiement unique |

## Territoires fermés

Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
