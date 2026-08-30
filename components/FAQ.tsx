'use client'

import { useState } from 'react'

const QUESTIONS = [
  {
    q: "L'exclusivité territoriale est-elle vraiment garantie ?",
    a: "Oui, contractuellement. Dès que votre ville est attribuée, Écosystème Immo s'engage à ne déployer aucun autre conseiller dans votre périmètre. C'est inscrit dans le contrat — pas une promesse commerciale.",
  },
  {
    q: "Combien de temps avant les premiers résultats ?",
    a: "Le système est opérationnel en moins de 30 jours. Les premiers contacts via formulaire d'estimation arrivent dès le premier mois. La visibilité SEO locale monte progressivement entre 60 et 90 jours selon la concurrence sur votre ville.",
  },
  {
    q: "Que se passe-t-il si je résilie ?",
    a: "Votre abonnement s'arrête et le système est mis en pause sur votre territoire. La ville peut alors être proposée à un autre conseiller — sauf si vous avez souscrit à l'option Exclusivité verrouillée (900 € paiement unique), qui garantit le verrou contractuel même après résiliation.",
  },
  {
    q: "Est-ce compatible avec mon réseau mandataire actuel ?",
    a: "Oui. Le système est conçu pour les conseillers indépendants et mandataires. Il s'appuie sur votre propre domaine et votre propre marque — indépendant de votre réseau. Il complète votre dispositif existant sans conflit.",
  },
  {
    q: "Dois-je gérer la technique moi-même ?",
    a: "Non. Tout est configuré par nos soins : site, SEO, CRM, automatisations. Vous recevez les accès, une formation de prise en main, et un suivi mensuel. Votre rôle est de traiter les leads entrants — pas de gérer la technique.",
  },
]

export default function FAQ() {
  const [open, setOpen] = useState<number | null>(null)

  return (
    <section className="py-20 px-4 sm:px-6 border-t border-[#1A2840]">
      <div className="max-w-3xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Questions fréquentes
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-[#EEE8D8] mb-4">
            Avant de réserver votre ville
          </h2>
        </div>

        <div className="space-y-2">
          {QUESTIONS.map((item, i) => (
            <div
              key={i}
              className="bg-[#0D1829] border border-[#1A2840] rounded-lg overflow-hidden"
            >
              <button
                onClick={() => setOpen(open === i ? null : i)}
                className="w-full flex items-center justify-between gap-4 px-6 py-5 text-left"
                aria-expanded={open === i}
              >
                <span className="text-[#EEE8D8] font-medium text-sm leading-snug">{item.q}</span>
                <span
                  className={`flex-shrink-0 text-[#C8A84B] text-base font-light transition-transform duration-200 ${
                    open === i ? 'rotate-45' : ''
                  }`}
                >
                  +
                </span>
              </button>
              {open === i && (
                <div className="px-6 pb-5">
                  <p className="text-[#8090A8] text-sm leading-relaxed">{item.a}</p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
