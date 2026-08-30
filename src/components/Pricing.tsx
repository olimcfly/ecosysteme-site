'use client';

import { useState } from 'react';

const plans = [
  {
    name: 'Estimateur',
    badge: null,
    price: { monthly: 27, setup: 197 },
    period: '/mois',
    description: 'L\'outil d\'estimation IA seul, pour démarrer votre visibilité locale.',
    cta: 'Démarrer',
    ctaHref: '#disponibilite',
    featured: false,
    includes: [
      'Estimateur IA intégré sur votre site existant',
      'Formulaire de qualification vendeur',
      'Notifications leads par email',
      'Tableau de bord prospects',
    ],
    excludes: [
      'Site pro personnalisé',
      'SEO local',
      'CRM complet',
      'Automatisations',
      'Exclusivité territoriale',
    ],
  },
  {
    name: 'Système complet',
    badge: 'Le plus choisi',
    price: { monthly: 97, setup: 497, prepaid: '3 mois prépayés' },
    period: '/mois',
    description: 'Le système d\'acquisition complet. Idéal pour s\'installer durablement sur un territoire.',
    cta: 'Démarrer maintenant',
    ctaHref: '#disponibilite',
    featured: true,
    includes: [
      'Site professionnel local clé en main',
      'SEO local complet (Google + pages secteur)',
      'CRM vendeurs avec pipeline visuel',
      'Automatisations email + SMS',
      'Estimateur IA + qualification',
      'Tableau de bord performance',
      'Exclusivité territoriale incluse',
      'Support dédié',
    ],
    excludes: [],
  },
  {
    name: 'Annuel',
    badge: '2 mois offerts',
    price: { annual: 897, perMonth: '74,75' },
    period: '/an',
    description: 'Tout le système complet avec setup offert et engagement annuel.',
    cta: 'Réserver mon territoire',
    ctaHref: '#disponibilite',
    featured: false,
    includes: [
      'Tout le système complet',
      'Setup offert (économisez 497€)',
      'Exclusivité territoriale incluse',
      'Priorité de support',
      'Accès aux nouvelles fonctionnalités en avant-première',
    ],
    excludes: [],
  },
];

export default function Pricing() {
  const [showExclusivity, setShowExclusivity] = useState(false);

  return (
    <section id="tarifs" className="py-24 px-4 relative">
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-blue-600/6 rounded-full blur-[100px]" />
      </div>

      <div className="max-w-6xl mx-auto relative">
        <div className="text-center mb-16">
          <p className="text-blue-400 text-sm font-medium uppercase tracking-wider mb-3">Tarifs</p>
          <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4">
            Investissez dans votre territoire
          </h2>
          <p className="text-slate-400 max-w-xl mx-auto">
            Un seul mandat signé couvre plusieurs mois. Le système travaille pour vous 24h/24.
          </p>
        </div>

        <div className="grid lg:grid-cols-3 gap-5 items-start">
          {plans.map((plan) => (
            <div
              key={plan.name}
              className={`relative rounded-2xl p-7 border transition-all ${
                plan.featured
                  ? 'bg-blue-600/10 border-blue-500/40 shadow-xl shadow-blue-600/10'
                  : 'bg-white/[0.03] border-white/[0.08] hover:border-white/[0.15]'
              }`}
            >
              {plan.badge && (
                <div className={`absolute -top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-1 rounded-full text-xs font-semibold ${
                  plan.featured
                    ? 'bg-blue-600 text-white'
                    : 'bg-amber-500/20 border border-amber-500/30 text-amber-300'
                }`}>
                  {plan.badge}
                </div>
              )}

              <div className="mb-6">
                <h3 className="text-white font-semibold text-base mb-1">{plan.name}</h3>
                <p className="text-slate-500 text-sm leading-relaxed">{plan.description}</p>
              </div>

              {/* Price */}
              <div className="mb-6">
                {plan.price.monthly !== undefined && (
                  <>
                    <div className="flex items-baseline gap-1">
                      <span className="text-3xl font-bold text-white">{plan.price.monthly}€</span>
                      <span className="text-slate-500 text-sm">{plan.period}</span>
                    </div>
                    {plan.price.setup && (
                      <p className="text-xs text-slate-500 mt-1">+ {plan.price.setup}€ de mise en place</p>
                    )}
                    {plan.price.prepaid && (
                      <p className="text-xs text-amber-400/80 mt-1">{plan.price.prepaid}</p>
                    )}
                  </>
                )}
                {plan.price.annual !== undefined && (
                  <>
                    <div className="flex items-baseline gap-1">
                      <span className="text-3xl font-bold text-white">{plan.price.annual}€</span>
                      <span className="text-slate-500 text-sm">{plan.period}</span>
                    </div>
                    <p className="text-xs text-slate-500 mt-1">soit {plan.price.perMonth}€/mois · setup offert</p>
                  </>
                )}
              </div>

              {/* CTA */}
              <a
                href={plan.ctaHref}
                className={`block w-full text-center py-3 rounded-xl font-medium text-sm transition-all mb-7 ${
                  plan.featured
                    ? 'bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30'
                    : 'bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white'
                }`}
              >
                {plan.cta}
              </a>

              {/* Includes */}
              <ul className="space-y-2.5">
                {plan.includes.map((item) => (
                  <li key={item} className="flex items-start gap-2.5 text-sm text-slate-300">
                    <svg className="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                    </svg>
                    {item}
                  </li>
                ))}
                {plan.excludes.map((item) => (
                  <li key={item} className="flex items-start gap-2.5 text-sm text-slate-600 line-through">
                    <svg className="w-4 h-4 text-slate-700 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {item}
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        {/* Exclusivité verrouillée */}
        <div className="mt-8">
          <button
            onClick={() => setShowExclusivity(!showExclusivity)}
            className="mx-auto flex items-center gap-2 text-slate-500 hover:text-slate-300 text-sm transition-colors"
          >
            <svg
              className={`w-4 h-4 transition-transform ${showExclusivity ? 'rotate-90' : ''}`}
              fill="none" viewBox="0 0 24 24" stroke="currentColor"
            >
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
            Option exclusivité verrouillée
          </button>

          {showExclusivity && (
            <div className="mt-5 max-w-xl mx-auto rounded-2xl bg-amber-500/5 border border-amber-500/20 p-6 text-center">
              <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-300 text-xs font-medium mb-4">
                Paiement unique
              </div>
              <div className="text-3xl font-bold text-white mb-1">900€</div>
              <p className="text-slate-400 text-sm mb-4">
                Verrouillez votre territoire définitivement, sans engagement mensuel.
                Votre exclusivité est garantie tant que vous restez actif sur la plateforme.
              </p>
              <a
                href="#disponibilite"
                className="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-500/20 border border-amber-500/30 text-amber-300 hover:bg-amber-500/30 text-sm font-medium transition-colors"
              >
                Vérifier la disponibilité de ma ville
              </a>
            </div>
          )}
        </div>
      </div>
    </section>
  );
}
