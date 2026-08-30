'use client'
import { useState } from 'react'

const faqs = [
  {
    q: "Qu'est-ce qui différencie EcosystemeImmo d'un simple site vitrine ?",
    a: "Un site vitrine est une page de présentation. EcosystemeImmo est un système d'acquisition : il est structuré pour apparaître en recherche locale, capture les leads avec un estimateur intégré, les qualifie avec l'IA et les suit dans un CRM avec des automatisations de relance. L'objectif n'est pas d'exister en ligne — c'est d'attirer des mandats.",
  },
  {
    q: "L'exclusivité territoriale, comment ça fonctionne exactement ?",
    a: "Votre ville vous est attribuée contractuellement. Nous ne pouvons pas vendre le même territoire à un autre conseiller tant que vous êtes actif. Plans Annuel et Exclusivité Verrouillée : exclusivité incluse. Plan Standard : exclusivité disponible en option.",
  },
  {
    q: 'Combien de temps pour être opérationnel ?',
    a: "7 jours ouvrés après signature et règlement. Votre site est en ligne, votre SEO est configuré, votre CRM est prêt. Vous pouvez recevoir vos premiers leads dans la semaine suivant le lancement.",
  },
  {
    q: 'Est-ce que ça fonctionne pour les petites villes ou les zones rurales ?',
    a: "Mieux. Les petites villes ont souvent moins de concurrence SEO locale. C'est là où l'exclusivité territoriale a le plus de valeur : vous devenez rapidement la référence locale sans bataille de visibilité.",
  },
  {
    q: "Y a-t-il un engagement minimum ?",
    a: "Plan Standard : 3 premiers mois prépayés à l'activation, puis mensuel sans engagement. Plan Annuel : 12 mois. Exclusivité Verrouillée : paiement unique, sans abonnement ni durée minimale.",
  },
  {
    q: "Je travaille déjà avec une agence SEO. Pourquoi changer ?",
    a: "Une agence SEO généraliste optimise votre site de façon générique. EcosystemeImmo construit un système intégré ciblé sur votre secteur géographique, avec un CRM et des automatisations qui transforment ce trafic en leads qualifiés. Ce sont deux niveaux d'intervention différents.",
  },
  {
    q: "Que se passe-t-il si je veux arrêter ?",
    a: "À l'issue de votre période d'engagement, vous pouvez arrêter à tout moment avec un préavis de 30 jours. Votre contenu, vos leads et vos données vous appartiennent — nous vous les fournissons dans un export complet.",
  },
  {
    q: "Comment fonctionne le programme Fondateur ?",
    a: "Le programme Fondateur à 47 €/mois à vie était ouvert aux premiers membres lors du lancement bêta. Il est maintenant complet. Vous pouvez rejoindre la liste d'attente prioritaire pour être notifié en cas d'ouverture future.",
  },
]

export default function FAQSection() {
  const [open, setOpen] = useState<number | null>(null)

  return (
    <section className="py-20 md:py-28 px-4 sm:px-6 lg:px-8 bg-white">
      <div className="max-w-3xl mx-auto">
        <div className="text-center mb-16">
          <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">
            Questions fréquentes
          </p>
          <h2 className="text-3xl md:text-4xl font-bold tracking-tight text-zinc-950">
            Ce que vous voulez savoir
          </h2>
        </div>

        <div className="space-y-2">
          {faqs.map((faq, index) => (
            <div key={index} className="border border-zinc-200 rounded-xl overflow-hidden">
              <button
                className="w-full text-left px-6 py-4 flex items-center justify-between gap-4 hover:bg-zinc-50 transition-colors"
                onClick={() => setOpen(open === index ? null : index)}
                aria-expanded={open === index}
              >
                <span className="text-sm font-semibold text-zinc-900">{faq.q}</span>
                <svg
                  className={`w-4 h-4 flex-shrink-0 text-zinc-400 transition-transform duration-200 ${
                    open === index ? 'rotate-180' : ''
                  }`}
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  strokeWidth={2}
                >
                  <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              {open === index && (
                <div className="px-6 pb-5 border-t border-zinc-100">
                  <p className="text-sm text-zinc-600 leading-relaxed pt-4">{faq.a}</p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
