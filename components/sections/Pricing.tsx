'use client'

import { useState } from 'react'
import CityCheckerModal from '@/components/ui/CityCheckerModal'

const PLANS = [
  {
    id: 'estimateur',
    name: 'Estimateur',
    badge: null,
    price: '27',
    period: '/mois',
    setup: "+ 197 € à l'activation",
    description: "Pour démarrer la capture de prospects vendeurs sans engagement fort.",
    features: [
      "Site estimateur de valeur branded",
      "Formulaire de capture vendeur",
      "Intégration Google Analytics",
      "Hébergement inclus",
      "SSL et maintenance technique",
    ],
    limitations: [
      "Sans SEO de quartier",
      "Sans CRM ni automatisations",
      "Sans Google Business Profile",
    ],
    cta: "Démarrer avec l'Estimateur",
    highlighted: false,
  },
  {
    id: 'systeme',
    name: 'Système Local',
    badge: 'Recommandé',
    price: '97',
    period: '/mois',
    setup: "+ 497 € à l'activation · 3 mois prépayés",
    description: "Le système complet d'acquisition local. Tout inclus, déployé en 7 jours.",
    features: [
      "Site professionnel local",
      "Pages SEO par quartier",
      "Google Business Profile optimisé",
      "Formulaire de capture vendeur",
      "CRM de suivi prospects",
      "Séquences email automatisées (90j)",
      "Reporting mensuel",
      "Exclusivité territoriale incluse",
    ],
    limitations: [],
    cta: "Réserver mon territoire",
    highlighted: true,
  },
  {
    id: 'annuel',
    name: 'Annuel',
    badge: 'Meilleure valeur',
    price: '897',
    period: '/an',
    setup: "Setup offert (économie de 497 €)",
    description: "L'offre complète avec engagement annuel. Votre position SEO se construit dans la durée.",
    features: [
      "Tout inclus dans Système Local",
      "Setup offert (–497 €)",
      "Exclusivité territoriale incluse",
      "Priorité sur les nouvelles villes",
      "Support prioritaire 24h",
    ],
    limitations: [],
    cta: "Choisir l'annuel",
    highlighted: false,
  },
]

function CheckIcon() {
  return (
    <svg className="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
    </svg>
  )
}

function CrossIcon() {
  return (
    <svg className="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
    </svg>
  )
}

export default function Pricing() {
  const [isModalOpen, setIsModalOpen] = useState(false)

  return (
    <>
      <section id="tarifs" className="py-24 md:py-32 bg-gray-50">
        <div className="max-w-6xl mx-auto px-4 sm:px-6">
          <div className="max-w-2xl mb-16">
            <p className="text-sm font-semibold text-gold uppercase tracking-wider mb-3">Tarifs</p>
            <h2 className="section-title mb-4">Simple, transparent, sans surprise.</h2>
            <p className="text-lg text-gray-500">
              {"Trois options selon votre niveau d'engagement. L'exclusivité territoriale est incluse dans le Système Local et l'Annuel."}
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            {PLANS.map((plan) => (
              <div
                key={plan.id}
                className={`relative rounded-2xl ${
                  plan.highlighted
                    ? 'bg-navy text-white ring-2 ring-navy shadow-xl'
                    : 'bg-white border border-gray-200 shadow-sm'
                }`}
              >
                {plan.badge && (
                  <div className="absolute -top-3.5 left-1/2 -translate-x-1/2">
                    <span
                      className={`inline-flex text-xs font-bold px-3 py-1 rounded-full ${
                        plan.highlighted
                          ? 'bg-gold text-white'
                          : 'bg-gray-900 text-white'
                      }`}
                    >
                      {plan.badge}
                    </span>
                  </div>
                )}

                <div className="p-8">
                  <p className={`text-sm font-semibold uppercase tracking-wider mb-1 ${plan.highlighted ? 'text-white/60' : 'text-gray-500'}`}>
                    {plan.name}
                  </p>

                  <div className="flex items-baseline gap-1 mb-1">
                    <span className={`text-4xl font-bold ${plan.highlighted ? 'text-white' : 'text-gray-900'}`}>
                      {plan.price}€
                    </span>
                    <span className={`text-sm ${plan.highlighted ? 'text-white/60' : 'text-gray-400'}`}>
                      {plan.period}
                    </span>
                  </div>

                  <p className={`text-xs mb-3 ${plan.highlighted ? 'text-white/50' : 'text-gray-400'}`}>
                    {plan.setup}
                  </p>

                  <p className={`text-sm leading-relaxed mb-6 ${plan.highlighted ? 'text-white/70' : 'text-gray-500'}`}>
                    {plan.description}
                  </p>

                  <button
                    onClick={() => setIsModalOpen(true)}
                    className={`w-full font-semibold px-6 py-3.5 rounded-lg transition-colors text-sm mb-8 ${
                      plan.highlighted
                        ? 'bg-gold hover:bg-gold-light text-white'
                        : 'bg-navy hover:bg-navy-light text-white'
                    }`}
                  >
                    {plan.cta}
                  </button>

                  <ul className="space-y-3">
                    {plan.features.map((feature) => (
                      <li key={feature} className="flex items-start gap-2.5">
                        <CheckIcon />
                        <span className={`text-sm ${plan.highlighted ? 'text-white/80' : 'text-gray-600'}`}>
                          {feature}
                        </span>
                      </li>
                    ))}
                    {plan.limitations.map((limit) => (
                      <li key={limit} className="flex items-start gap-2.5">
                        <CrossIcon />
                        <span className="text-sm text-gray-400">{limit}</span>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
            ))}
          </div>

          <div className="mt-8 p-6 bg-white border border-gold/30 rounded-xl flex flex-col md:flex-row md:items-center gap-6">
            <div className="flex-1">
              <div className="flex items-center gap-2 mb-1">
                <span className="text-sm font-bold text-gray-900">Option : Exclusivité verrouillée</span>
                <span className="text-xs font-semibold bg-gold/10 text-gold px-2 py-0.5 rounded-full">Add-on</span>
              </div>
              <p className="text-sm text-gray-500">
                {"Verrouillez votre territoire définitivement avec un paiement unique. Votre exclusivité reste active même si vous changez d'offre ou suspendez votre abonnement."}
              </p>
            </div>
            <div className="flex-shrink-0 flex flex-col items-start md:items-end gap-2">
              <span className="text-2xl font-bold text-gray-900">900 €</span>
              <span className="text-xs text-gray-400">paiement unique</span>
            </div>
          </div>

          <p className="text-center text-sm text-gray-400 mt-8">
            Toutes les offres incluent un accompagnement au démarrage et une maintenance technique continue.
            <br />
            {"Des questions ? "}
            <a href="mailto:contact@ecosystemeimmo.fr" className="text-navy font-medium hover:underline">
              Écrivez directement à Olivier
            </a>
            {" ou appelez le "}
            <a href="tel:0785611700" className="text-navy font-medium hover:underline">
              07 85 61 17 00
            </a>
            .
          </p>
        </div>
      </section>

      <CityCheckerModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </>
  )
}
