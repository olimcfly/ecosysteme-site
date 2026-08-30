'use client'

import { useState } from 'react'

const faqs = [
  {
    q: 'Comment fonctionne concrètement l\'exclusivité territoriale ?',
    a: 'L\'exclusivité est inscrite dans votre contrat. Une fois votre ville activée, aucun autre conseiller ne peut souscrire au système sur ce territoire. Votre exclusivité est maintenue tant que votre abonnement est actif. Elle peut être verrouillée définitivement via l\'option à 900€.',
  },
  {
    q: 'Que se passe-t-il si ma ville est déjà prise ?',
    a: 'Vous pouvez rejoindre la liste d\'attente via le formulaire du site. Si la ville se libère (résiliation du conseiller en place), vous serez contacté en priorité. Vous pouvez aussi vérifier les communes limitrophes de votre secteur — plusieurs restent disponibles.',
  },
  {
    q: 'Est-ce que je garde mon site si je résilie mon abonnement ?',
    a: 'Le contenu et la structure de votre site appartiennent à votre abonnement. En cas de résiliation, l\'accès au CRM, aux automatisations et aux mises à jour SEO est suspendu. Votre nom de domaine vous appartient dans tous les cas.',
  },
  {
    q: 'Pourquoi 3 mois prépayés au démarrage pour le plan mensuel ?',
    a: 'La construction du système complet (site, SEO, GBP, CRM, automatisations) représente un investissement initial de temps significatif. Les 3 mois prépayés garantissent que ce travail démarre et s\'ancre correctement avant que les premiers résultats SEO n\'apparaissent.',
  },
  {
    q: 'Combien de temps pour apparaître sur Google local ?',
    a: 'Les premiers résultats SEO locaux visibles apparaissent en général entre 3 et 6 mois selon la concurrence de votre territoire. Sur certaines villes moins concurrentielles, des résultats sont observables dès 6 à 8 semaines. C\'est pourquoi démarrer tôt est un avantage concurrentiel réel.',
  },
  {
    q: 'Qu\'est-ce que l\'IA de qualification incluse ?',
    a: 'Chaque nouveau contact entrant (formulaire, estimation, demande d\'information) est analysé automatiquement pour évaluer son profil et sa maturité de projet. Les leads chauds sont signalés en priorité dans votre CRM. Vous ne perdez plus de temps à relancer des prospects non qualifiés.',
  },
  {
    q: 'Y a-t-il une durée d\'engagement minimale ?',
    a: 'Le plan mensuel requiert 3 mois prépayés au démarrage. Après cette période, vous êtes libre de résilier avec un préavis de 30 jours. Le plan annuel engage sur 12 mois. L\'option exclusivité verrouillée est un paiement unique sans abonnement supplémentaire.',
  },
  {
    q: 'Puis-je voir des exemples concrets de résultats ?',
    a: 'Les 5 premiers conseillers déployés sont visibles dans la section Réalisations. Chaque cas présente le territoire couvert et le système installé. Pour des résultats précis (trafic, leads générés), vous pouvez contacter Olivier directement à contact@ecosystemeimmo.fr.',
  },
]

export default function FAQSection() {
  const [open, setOpen] = useState<number | null>(0)

  return (
    <section id="faq" className="section-pad bg-stone-50 border-t border-stone-100">
      <div className="container-main">
        <div className="max-w-xl mb-12">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            FAQ
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950">
            Questions fréquentes.
          </h2>
        </div>

        <div className="max-w-2xl flex flex-col gap-2">
          {faqs.map(({ q, a }, i) => (
            <div
              key={i}
              className="bg-white border border-stone-200 rounded-xl overflow-hidden"
            >
              <button
                onClick={() => setOpen(open === i ? null : i)}
                className="w-full text-left flex items-start justify-between gap-4 p-6"
                aria-expanded={open === i}
              >
                <span className="text-stone-900 font-semibold text-sm leading-relaxed">
                  {q}
                </span>
                <span
                  className={`shrink-0 w-5 h-5 rounded-full border border-stone-300 flex items-center justify-center transition-transform duration-200 mt-0.5 ${
                    open === i ? 'rotate-45' : ''
                  }`}
                >
                  <svg
                    className="w-2.5 h-2.5 text-stone-500"
                    fill="none"
                    viewBox="0 0 10 10"
                    stroke="currentColor"
                    strokeWidth={2}
                  >
                    <path
                      strokeLinecap="round"
                      d="M5 1v8M1 5h8"
                    />
                  </svg>
                </span>
              </button>
              {open === i && (
                <div className="px-6 pb-6">
                  <p className="text-stone-500 text-sm leading-relaxed border-t border-stone-100 pt-4">
                    {a}
                  </p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
