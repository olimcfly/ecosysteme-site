'use client'

import { useState } from 'react'

const faqs = [
  {
    q: 'Comment fonctionne l\'exclusivité territoriale ?',
    a: 'Dès votre inscription, votre ville est fermée à tout autre conseiller dans le système. Aucun concurrent ne peut accéder au même système d\'acquisition dans votre zone. Si vous choisissez l\'option exclusivité verrouillée (900€ unique), elle reste acquise même si vous suspendez votre abonnement.',
  },
  {
    q: 'Que se passe-t-il si ma ville est déjà prise ?',
    a: 'Si votre ville est occupée, vous pouvez vous inscrire sur liste d\'attente. Vous serez alerté en priorité si le conseiller actuel résilie. Vous pouvez aussi vérifier des villes limitrophes encore disponibles.',
  },
  {
    q: 'Ai-je besoin de compétences techniques ?',
    a: 'Non. L\'onboarding inclut la configuration complète : site mis en ligne, CRM configuré, automatisations activées. Vous recevez un système opérationnel, pas un outil à monter.',
  },
  {
    q: 'Combien de temps avant de voir des résultats ?',
    a: 'Les automatisations CRM et l\'estimateur génèrent des leads dès la mise en ligne. Le SEO local monte en puissance sur 30 à 90 jours selon la concurrence dans votre ville. Certains conseillers reçoivent leurs premières demandes qualifiées dans la première semaine.',
  },
  {
    q: 'Quelle est la durée d\'engagement ?',
    a: 'La formule mensuelle est sans engagement après la période initiale. La formule annuelle est réglée en une fois avec le setup offert. L\'exclusivité verrouillée est un paiement unique définitif.',
  },
  {
    q: 'Quelle est la différence avec un site vitrine classique ?',
    a: 'Un site vitrine vous donne une présence en ligne. Ecosystème Immo vous donne un système d\'acquisition : le site capte des vendeurs, le CRM les qualifie, les automatisations les convertissent — le tout centré sur votre territoire exclusif.',
  },
  {
    q: 'Est-ce compatible avec mon réseau ou mon statut d\'agent ?',
    a: 'Oui. Le système est conçu pour les conseillers indépendants, qu\'ils soient sous mandat d\'un réseau ou à leur compte. Il complète votre outil réseau sans le remplacer.',
  },
]

export default function FAQ() {
  const [open, setOpen] = useState<number | null>(null)

  return (
    <section id="faq" className="py-20 px-5 sm:px-6 bg-gray-50">
      <div className="max-w-3xl mx-auto">
        <div className="text-center mb-12">
          <h2 className="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
            Questions fréquentes
          </h2>
          <p className="text-gray-500 text-lg">
            Tout ce que vous devez savoir avant de démarrer.
          </p>
        </div>

        <div className="space-y-2.5">
          {faqs.map((faq, i) => (
            <div
              key={i}
              className="bg-white border border-gray-200 rounded-xl overflow-hidden"
            >
              <button
                onClick={() => setOpen(open === i ? null : i)}
                className="w-full flex items-center justify-between px-6 py-5 text-left group"
                aria-expanded={open === i}
              >
                <span className="font-semibold text-gray-900 text-sm sm:text-base pr-4 leading-snug">
                  {faq.q}
                </span>
                <svg
                  className={`w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-200 ${
                    open === i ? 'rotate-180' : ''
                  }`}
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              {open === i && (
                <div className="px-6 pb-5">
                  <p className="text-gray-500 text-sm leading-relaxed">{faq.a}</p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
