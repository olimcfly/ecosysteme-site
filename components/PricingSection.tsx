'use client'

import { useState } from 'react'

type Plan = {
  id: string
  name: string
  price: number
  unit: string
  setup: number
  setupNote: string
  badge: string | null
  description: string
  features: string[]
  featuresMissing: string[]
  cta: string
  highlighted: boolean
  savings: string | null
}

const MONTHLY_PLANS: Plan[] = [
  {
    id: 'estimateur',
    name: 'Estimateur',
    price: 27,
    unit: '/ mois HT',
    setup: 197,
    setupNote: 'setup unique',
    badge: null,
    description: 'Pour démarrer avec un outil de capture vendeurs et une présence locale de base.',
    features: [
      'Site estimateur immobilier',
      'Formulaire capture vendeurs',
      'Intégration votre domaine',
      '1 ville couverte',
      'Support email',
    ],
    featuresMissing: [
      'SEO local + pages secteurs',
      'CRM prospects',
      'Automatisations',
      'IA de qualification',
      'Exclusivité territoriale',
    ],
    cta: 'Démarrer avec l\'estimateur',
    highlighted: false,
    savings: null,
  },
  {
    id: 'systeme',
    name: 'Système Complet',
    price: 97,
    unit: '/ mois HT',
    setup: 497,
    setupNote: 'setup + 3 mois prépayés au démarrage (788€ total)',
    badge: 'Recommandé',
    description: 'Le système d\'acquisition local intégral pour capter, qualifier et convertir des vendeurs.',
    features: [
      'Site professionnel local brandé',
      'SEO local + pages quartiers et secteurs',
      'Google Business Profile optimisé',
      'CRM prospects intégré',
      'Automatisations et séquences email',
      'IA de qualification des contacts',
      'Exclusivité territoriale garantie',
      'Support prioritaire',
    ],
    featuresMissing: [],
    cta: 'Démarrer le système',
    highlighted: true,
    savings: null,
  },
]

const ANNUAL_PLANS: Plan[] = [
  {
    id: 'estimateur-annuel',
    name: 'Estimateur',
    price: 324,
    unit: '/ an HT',
    setup: 197,
    setupNote: 'setup unique',
    badge: null,
    description: 'Pour démarrer avec un outil de capture vendeurs et une présence locale de base.',
    features: [
      'Site estimateur immobilier',
      'Formulaire capture vendeurs',
      'Intégration votre domaine',
      '1 ville couverte',
      'Support email',
    ],
    featuresMissing: [
      'SEO local + pages secteurs',
      'CRM prospects',
      'Automatisations',
      'IA de qualification',
      'Exclusivité territoriale',
    ],
    cta: 'Démarrer avec l\'estimateur',
    highlighted: false,
    savings: null,
  },
  {
    id: 'systeme-annuel',
    name: 'Système Complet',
    price: 897,
    unit: '/ an HT',
    setup: 0,
    setupNote: 'Setup offert — économisez 497€',
    badge: 'Meilleure valeur',
    description: 'Le système complet avec setup offert, exclusivité territoriale incluse et priorité sur les villes restantes.',
    features: [
      'Site professionnel local brandé',
      'SEO local + pages quartiers et secteurs',
      'Google Business Profile optimisé',
      'CRM prospects intégré',
      'Automatisations et séquences email',
      'IA de qualification des contacts',
      'Exclusivité territoriale garantie',
      'Setup offert (valeur 497€)',
      'Support prioritaire',
    ],
    featuresMissing: [],
    cta: 'Verrouiller mon territoire',
    highlighted: true,
    savings: '764€ économisés la 1ère année',
  },
]

function CheckIcon() {
  return (
    <svg className="w-4 h-4 text-navy-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
      <path strokeLinecap="round" strokeLinejoin="round" d="M4.5 12.75l6 6 9-13.5" />
    </svg>
  )
}

function CrossIcon() {
  return (
    <svg className="w-4 h-4 text-stone-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
      <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
  )
}

export default function PricingSection() {
  const [annual, setAnnual] = useState(false)
  const plans = annual ? ANNUAL_PLANS : MONTHLY_PLANS

  return (
    <section id="tarifs" className="section-pad bg-white">
      <div className="container-main">
        {/* Header */}
        <div className="text-center mb-12">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            Tarifs
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950 mb-3">
            Choisissez votre formule.
          </h2>
          <p className="text-stone-500 text-lg mb-8">
            Pas de frais cachés. Un seul conseiller par ville.
          </p>

          {/* Toggle */}
          <div className="inline-flex items-center gap-4 p-1.5 bg-stone-100 rounded-xl">
            <button
              onClick={() => setAnnual(false)}
              className={`px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 ${
                !annual
                  ? 'bg-white text-stone-900 shadow-sm'
                  : 'text-stone-500 hover:text-stone-700'
              }`}
            >
              Mensuel
            </button>
            <button
              onClick={() => setAnnual(true)}
              className={`px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-2 ${
                annual
                  ? 'bg-white text-stone-900 shadow-sm'
                  : 'text-stone-500 hover:text-stone-700'
              }`}
            >
              Annuel
              <span className="tag bg-gold-50 text-gold-700 border border-gold-200 !py-0.5 !text-[10px]">
                Setup offert
              </span>
            </button>
          </div>
        </div>

        {/* First-payment note for monthly */}
        {!annual && (
          <div className="flex items-start gap-2 bg-stone-50 border border-stone-200 rounded-xl px-5 py-3.5 mb-6 text-sm text-stone-600">
            <svg className="w-4 h-4 text-stone-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <span>
              <strong className="text-stone-800">Plan mensuel — premier versement :</strong> setup 497€ + 3 mois prépayés (3×97€) = <strong className="text-stone-800">788€</strong>, puis 97€/mois à partir du 4e mois.
            </span>
          </div>
        )}

        {/* Plans */}
        <div className="grid sm:grid-cols-2 gap-6 mb-8">
          {plans.map((plan) => (
            <div
              key={plan.id}
              className={`relative rounded-2xl border p-8 flex flex-col ${
                plan.highlighted
                  ? 'border-navy-600 border-2 shadow-lg shadow-navy-100'
                  : 'border-stone-200'
              }`}
            >
              {plan.badge && (
                <div className="absolute -top-3.5 left-1/2 -translate-x-1/2">
                  <span className="tag bg-navy-600 text-white border-0 !py-1.5 !px-4 !text-[11px]">
                    {plan.badge}
                  </span>
                </div>
              )}

              <div className="mb-6">
                <p className="text-xs font-semibold uppercase tracking-widest text-stone-400 mb-3">
                  {plan.name}
                </p>
                <div className="flex items-end gap-1 mb-2">
                  <span className="text-4xl font-bold text-stone-950">
                    {plan.price.toLocaleString('fr-FR')}€
                  </span>
                  <span className="text-stone-400 text-sm mb-1">{plan.unit}</span>
                </div>
                <p className="text-sm text-stone-500">
                  {plan.setup > 0
                    ? `+ ${plan.setup}€ setup — ${plan.setupNote}`
                    : plan.setupNote}
                </p>
                {plan.savings && (
                  <p className="mt-2 text-sm font-semibold text-emerald-600">
                    {plan.savings}
                  </p>
                )}
              </div>

              <p className="text-stone-500 text-sm leading-relaxed mb-6">
                {plan.description}
              </p>

              <ul className="flex flex-col gap-3 mb-8">
                {plan.features.map((f) => (
                  <li key={f} className="flex items-start gap-2.5 text-sm text-stone-700">
                    <CheckIcon />
                    <span>{f}</span>
                  </li>
                ))}
                {plan.featuresMissing.map((f) => (
                  <li key={f} className="flex items-start gap-2.5 text-sm text-stone-300">
                    <CrossIcon />
                    <span>{f}</span>
                  </li>
                ))}
              </ul>

              <div className="mt-auto">
                <a
                  href="#verifier-ville"
                  className={`w-full text-center block py-3.5 px-6 rounded-lg font-semibold transition-all duration-200 text-base ${
                    plan.highlighted
                      ? 'bg-navy-600 hover:bg-navy-700 text-white'
                      : 'border border-stone-300 hover:border-navy-400 text-stone-700 hover:text-navy-700'
                  }`}
                >
                  {plan.cta}
                </a>
                <p className="mt-3 text-center text-xs text-stone-400">
                  Vérification ville gratuite · Sans engagement initial
                </p>
              </div>
            </div>
          ))}
        </div>

        {/* Exclusivité add-on */}
        <div className="border border-gold-200 bg-gold-50 rounded-2xl p-6 sm:p-8 mb-6">
          <div className="flex flex-col sm:flex-row sm:items-center gap-6">
            <div className="flex-1">
              <div className="flex items-center gap-2 mb-2">
                <span className="tag bg-gold-100 text-gold-700 border border-gold-200 !text-[11px]">
                  Option add-on
                </span>
              </div>
              <h3 className="text-lg font-bold text-stone-900 mb-1">
                Exclusivité Verrouillée
              </h3>
              <p className="text-stone-600 text-sm leading-relaxed">
                Verrouillez définitivement votre territoire. Complémentaire à
                n&apos;importe quelle formule. Votre ville devient inaccessible
                pour tout nouveau conseiller, même après résiliation.
              </p>
            </div>
            <div className="sm:text-right shrink-0">
              <p className="text-3xl font-bold text-stone-950 mb-1">900€</p>
              <p className="text-stone-500 text-sm mb-4">paiement unique</p>
              <a href="#verifier-ville" className="btn-outline !border-gold-400 !text-gold-700 hover:!text-gold-800 hover:!border-gold-500 !text-sm !py-3">
                En savoir plus
              </a>
            </div>
          </div>
        </div>

        {/* Programme Fondateur */}
        <div className="border border-stone-200 bg-stone-50 rounded-2xl p-6 sm:p-8">
          <div className="flex flex-col sm:flex-row sm:items-center gap-6">
            <div className="flex-1">
              <div className="flex items-center gap-2 mb-2">
                <span className="tag bg-stone-200 text-stone-600 border border-stone-300 !text-[11px]">
                  Programme fermé
                </span>
              </div>
              <h3 className="text-lg font-bold text-stone-900 mb-1">
                Programme Fondateur
              </h3>
              <p className="text-stone-500 text-sm leading-relaxed">
                Réservé aux premiers conseillers qui ont rejoint Écosystème Immo
                en phase bêta. Le tarif à vie de 47€/mois n&apos;est plus disponible
                à la souscription directe. Une liste d&apos;attente est ouverte pour
                les candidatures exceptionnelles.
              </p>
            </div>
            <div className="sm:text-right shrink-0">
              <p className="text-3xl font-bold text-stone-400 mb-1 line-through">47€</p>
              <p className="text-stone-400 text-sm mb-4">/ mois à vie · Fermé</p>
              <a
                href={`mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent("Candidature Programme Fondateur")}`}
                className="btn-outline !text-sm !py-3"
              >
                Candidater sur liste d&apos;attente
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
