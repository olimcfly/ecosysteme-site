'use client'

import { useState } from 'react'

export default function Pricing() {
  const [annual, setAnnual] = useState(false)

  return (
    <section id="pricing" className="py-20 px-5 sm:px-6 bg-white">
      <div className="max-w-5xl mx-auto">

        <div className="text-center mb-12">
          <div className="text-emerald-600 text-xs font-semibold uppercase tracking-widest mb-4">
            Tarifs
          </div>
          <h2 className="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
            Un investissement, pas une dépense.
          </h2>
          <p className="text-gray-500 text-lg max-w-xl mx-auto mb-8">
            Un mandat de 4 500€ de commission couvre plusieurs années d'abonnement. La question
            n'est pas le coût — c'est combien vous perdez sans système.
          </p>

          {/* Toggle mensuel / annuel */}
          <div className="inline-flex items-center bg-gray-100 rounded-xl p-1">
            <button
              onClick={() => setAnnual(false)}
              className={`px-5 py-2 rounded-lg text-sm font-medium transition-all ${
                !annual ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'
              }`}
            >
              Mensuel
            </button>
            <button
              onClick={() => setAnnual(true)}
              className={`px-5 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 ${
                annual ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'
              }`}
            >
              Annuel
              <span className="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full">
                -23%
              </span>
            </button>
          </div>
        </div>

        <div className="grid md:grid-cols-3 gap-5 mb-8">

          {/* Plan 1 — Estimateur */}
          <div className="border border-gray-200 rounded-2xl p-7 flex flex-col">
            <div className="mb-6">
              <p className="text-sm font-semibold text-gray-500 mb-2">Estimateur</p>
              <div className="flex items-baseline gap-1">
                <span className="text-4xl font-bold text-gray-900">27€</span>
                <span className="text-gray-400 text-sm">/mois</span>
              </div>
              <p className="text-gray-400 text-xs mt-1.5">+ 197€ de setup</p>
            </div>
            <p className="text-gray-500 text-sm mb-6 leading-relaxed flex-none">
              L'estimateur de bien seul, intégrable à votre site existant. Capte les leads vendeurs
              en entrée.
            </p>
            <ul className="space-y-2.5 mb-8 flex-1">
              {[
                'Estimateur intelligent',
                'Capture de leads vendeurs',
                'Intégrable sur site existant',
                'Sans exclusivité territoriale',
              ].map((item) => (
                <li key={item} className="flex items-center gap-2.5 text-sm text-gray-500">
                  <svg className="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                  {item}
                </li>
              ))}
            </ul>
            <a
              href="#disponibilite"
              className="block text-center border border-gray-300 text-gray-700 font-semibold px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm"
            >
              Vérifier ma ville
            </a>
          </div>

          {/* Plan 2 — Système Complet (highlighted) */}
          <div className="border-2 border-emerald-600 rounded-2xl p-7 flex flex-col relative shadow-lg shadow-emerald-600/10">
            <div className="absolute -top-4 left-1/2 -translate-x-1/2">
              <span className="bg-emerald-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                Recommandé
              </span>
            </div>

            <div className="mb-6">
              <p className="text-sm font-semibold text-emerald-600 mb-2">Système Complet</p>
              {annual ? (
                <>
                  <div className="flex items-baseline gap-1">
                    <span className="text-4xl font-bold text-gray-900">74€</span>
                    <span className="text-gray-400 text-sm">/mois</span>
                  </div>
                  <p className="text-gray-400 text-xs mt-1.5">897€/an — setup offert</p>
                </>
              ) : (
                <>
                  <div className="flex items-baseline gap-1">
                    <span className="text-4xl font-bold text-gray-900">97€</span>
                    <span className="text-gray-400 text-sm">/mois</span>
                  </div>
                  <p className="text-gray-400 text-xs mt-1.5">+ 497€ à l'activation</p>
                </>
              )}
            </div>

            <p className="text-gray-600 text-sm mb-6 leading-relaxed flex-none">
              Le système complet : site SEO local, CRM, automatisations IA.{' '}
              {annual ? 'Exclusivité territoriale incluse.' : 'Exclusivité disponible en option.'}
            </p>

            <ul className="space-y-2.5 mb-8 flex-1">
              {[
                'Site professionnel SEO local',
                'CRM immobilier intégré',
                'Automatisations email & SMS',
                'Personnalisation IA',
                'Tableau de bord analytics',
                annual ? 'Exclusivité territoriale incluse' : 'Onboarding personnalisé',
                annual ? 'Setup offert' : null,
              ]
                .filter(Boolean)
                .map((item) => (
                  <li key={item as string} className="flex items-center gap-2.5 text-sm text-gray-700">
                    <svg className="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                    {item}
                  </li>
                ))}
            </ul>

            <a
              href="#disponibilite"
              className="block text-center bg-emerald-600 text-white font-semibold px-4 py-3.5 rounded-xl hover:bg-emerald-700 transition-colors"
            >
              Vérifier ma ville
            </a>
          </div>

          {/* Plan 3 — Exclusivité Verrouillée */}
          <div className="bg-gray-900 border border-gray-800 rounded-2xl p-7 flex flex-col text-white">
            <div className="mb-6">
              <p className="text-sm font-semibold text-emerald-400 mb-2">Exclusivité Verrouillée</p>
              <div className="flex items-baseline gap-1">
                <span className="text-4xl font-bold text-white">900€</span>
              </div>
              <p className="text-gray-500 text-xs mt-1.5">paiement unique · à vie</p>
            </div>

            <p className="text-gray-400 text-sm mb-6 leading-relaxed flex-none">
              Verrouillez votre ville définitivement, indépendamment de votre abonnement. Votre
              territoire vous appartient à vie.
            </p>

            <ul className="space-y-2.5 mb-8 flex-1">
              {[
                'Exclusivité à vie sur votre ville',
                'Indépendante de l\'abonnement',
                'Priorité si place se libère',
                'Non perdue en cas de suspension',
              ].map((item) => (
                <li key={item} className="flex items-center gap-2.5 text-sm text-gray-300">
                  <svg className="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                  {item}
                </li>
              ))}
            </ul>

            <a
              href="#disponibilite"
              className="block text-center border border-white/20 text-white font-semibold px-4 py-3 rounded-xl hover:bg-white/10 transition-colors text-sm"
            >
              En savoir plus
            </a>
          </div>

        </div>

        {/* Programme fondateur */}
        <div className="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-4">
          <div className="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg className="w-4.5 h-4.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p className="font-semibold text-gray-900 text-sm mb-1">Programme Fondateur — places limitées</p>
            <p className="text-gray-600 text-sm leading-relaxed">
              Les premiers conseillers à rejoindre bénéficient d'un accompagnement onboarding
              prioritaire et d'un tarif verrouillé à vie. Mentionnez{' '}
              <span className="font-medium text-gray-800">« Fondateur »</span> dans votre demande.
            </p>
          </div>
        </div>

        {/* Mention HT */}
        <p className="text-center text-xs text-gray-400 mt-5">
          Tarifs hors taxes. TVA applicable selon votre régime fiscal.
        </p>

      </div>
    </section>
  )
}
