'use client'

import { useState } from 'react'

const FAQS = [
  {
    question: "Comment fonctionne l'exclusivité territoriale ?",
    answer:
      "Dès votre activation, votre ville est verrouillée dans notre système. Aucun autre conseiller ne peut rejoindre Écosystème Immo sur le même secteur géographique. Cette exclusivité est contractuelle et reste active tant que vous êtes client. Si vous souhaitez la rendre permanente, l'option Exclusivité verrouillée (900 € paiement unique) protège votre territoire même en cas de suspension d'abonnement.",
  },
  {
    question: "En combien de temps le système est-il opérationnel ?",
    answer:
      "Le déploiement complet prend 7 jours ouvrés. À la fin de la première semaine : votre site est en ligne, votre Google Business Profile est optimisé, votre CRM est configuré et vos formulaires de capture sont actifs. Vous êtes opérationnel avant même que le SEO commence à produire ses effets.",
  },
  {
    question: "Quand puis-je espérer les premiers résultats SEO ?",
    answer:
      "Les premières pages s'indexent sur Google entre 2 et 4 semaines. Les effets visibles sur le trafic apparaissent généralement entre 4 et 8 semaines. Le SEO local est une construction progressive — plus vous restez longtemps, plus votre position se consolide et devient difficile à déloger.",
  },
  {
    question: "Que se passe-t-il si je ne renouvelle pas mon abonnement ?",
    answer:
      "Votre site reste en ligne pendant 30 jours après l'arrêt du paiement. Pendant cette période, vous pouvez récupérer l'ensemble de vos données (textes, contacts, historique). L'exclusivité territoriale est libérée et peut être attribuée à un autre conseiller. L'option Exclusivité verrouillée (900 €) est la seule façon de protéger votre territoire en dehors de l'abonnement actif.",
  },
  {
    question: "Quelle différence avec un site vitrine classique ?",
    answer:
      "Un site vitrine vous rend visible. Notre système vous génère des prospects qualifiés. La différence : des pages SEO par quartier (indexées sur des requêtes précises), un formulaire de qualification vendeur, des séquences email automatisées sur 90 jours, et un CRM pour ne perdre aucun contact. C'est une infrastructure d'acquisition, pas une carte de visite digitale.",
  },
  {
    question: "Puis-je commencer avec l'Estimateur et évoluer ensuite ?",
    answer:
      "Oui. L'offre Estimateur (27 €/mois + 197 € setup) vous permet de démarrer la capture de prospects vendeurs avec un site estimateur de valeur. Vous pouvez évoluer vers le Système Local à tout moment — le setup de migration est réduit car une partie du travail est déjà faite.",
  },
  {
    question: "Êtes-vous limités à certains réseaux ou statuts ?",
    answer:
      "Non. Écosystème Immo s'adresse à tous les conseillers immobiliers indépendants français, quel que soit votre réseau (IAD, Optimhome, Safti, EffiCity, indépendant pur...). La seule condition : être consacré à un territoire géographique défini.",
  },
]

export default function FAQ() {
  const [openIndex, setOpenIndex] = useState<number | null>(null)

  return (
    <section id="faq" className="py-24 md:py-32 bg-white">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mb-16">
          <p className="text-sm font-semibold text-gold uppercase tracking-wider mb-3">FAQ</p>
          <h2 className="section-title mb-4">Questions fréquentes</h2>
          <p className="text-lg text-gray-500">
            Tout ce que vous devez savoir avant de réserver votre territoire.
          </p>
        </div>

        <div className="max-w-3xl divide-y divide-gray-200">
          {FAQS.map((faq, i) => (
            <div key={i}>
              <button
                onClick={() => setOpenIndex(openIndex === i ? null : i)}
                className="w-full flex items-start justify-between gap-4 py-6 text-left group"
                aria-expanded={openIndex === i}
              >
                <span className="font-semibold text-gray-900 group-hover:text-navy transition-colors text-base">
                  {faq.question}
                </span>
                <span className="flex-shrink-0 mt-0.5">
                  <svg
                    className={`w-5 h-5 text-gray-400 transition-transform duration-200 ${
                      openIndex === i ? 'rotate-180' : ''
                    }`}
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                  </svg>
                </span>
              </button>
              {openIndex === i && (
                <div className="pb-6">
                  <p className="text-gray-500 leading-relaxed text-sm md:text-base">{faq.answer}</p>
                </div>
              )}
            </div>
          ))}
        </div>

        <div className="mt-12 max-w-3xl">
          <p className="text-gray-500 text-sm">
            Vous ne trouvez pas votre réponse ?{' '}
            <a href="mailto:contact@ecosystemeimmo.fr" className="text-navy font-semibold hover:underline">
              Posez votre question directement à Olivier
            </a>{' '}
            — réponse sous 24h.
          </p>
        </div>
      </div>
    </section>
  )
}
