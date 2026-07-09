'use client';

import { useState } from 'react';

const faqs = [
  {
    q: 'Comment l\'exclusivité territoriale fonctionne-t-elle concrètement ?',
    a: 'Dès que vous activez votre accès, votre ville est verrouillée dans notre système. Aucun autre conseiller ne peut utiliser Ecosystème Immo sur ce même territoire. Ce verrouillage est contractuel et définitif tant que vous êtes actif sur la plateforme.',
  },
  {
    q: 'Combien de temps avant que le système soit en ligne ?',
    a: 'En général, votre site et vos outils sont opérationnels sous 72h après validation de votre inscription. Vous recevez un accès à votre tableau de bord immédiatement.',
  },
  {
    q: 'Je ne suis pas technique. Est-ce que je peux utiliser le système ?',
    a: 'Le système est pensé pour des conseillers, pas des développeurs. Vous n\'avez rien à installer ni à configurer vous-même. Notre équipe s\'occupe de tout le setup technique. Vous recevez les leads directement dans votre tableau de bord.',
  },
  {
    q: 'Quelle est la différence avec un site classique de mon réseau ?',
    a: 'Les sites réseau sont génériques, identiques pour tous les conseillers, sans SEO local et sans CRM intégré. Ecosystème Immo est personnalisé à votre ville, optimisé pour les recherches locales des vendeurs, et connecté à un système de suivi automatisé.',
  },
  {
    q: 'Est-ce que ça fonctionne avec mon réseau actuel ?',
    a: 'Oui. Ecosystème Immo est compatible avec tous les réseaux de conseillers indépendants (Optimhome, IAD, Capifrance, Safti, etc.). Le système complète votre activité sans remplacer vos outils réseau.',
  },
  {
    q: 'Que se passe-t-il si je veux arrêter ?',
    a: 'Sur le plan mensuel, vous pouvez arrêter à tout moment, avec un préavis d\'un mois. Votre territoire redevient alors disponible pour un autre conseiller. Sur le plan annuel, l\'engagement est d\'un an. L\'option exclusivité verrouillée (900€) est un paiement unique sans abonnement.',
  },
  {
    q: 'Y a-t-il une période d\'essai ?',
    a: 'Nous ne proposons pas d\'essai gratuit pour préserver la valeur de l\'exclusivité territoriale. En revanche, vous pouvez réserver un appel de découverte pour voir le système en démonstration avant de vous engager.',
  },
];

export default function FAQ() {
  const [open, setOpen] = useState<number | null>(null);

  return (
    <section id="faq" className="py-24 px-4">
      <div className="max-w-2xl mx-auto">
        <div className="text-center mb-12">
          <p className="text-blue-400 text-sm font-medium uppercase tracking-wider mb-3">FAQ</p>
          <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4">
            Questions fréquentes
          </h2>
        </div>

        <div className="space-y-2">
          {faqs.map((faq, i) => (
            <div
              key={i}
              className={`rounded-xl border transition-all ${
                open === i
                  ? 'bg-white/[0.05] border-white/[0.12]'
                  : 'bg-white/[0.02] border-white/[0.06] hover:border-white/[0.10]'
              }`}
            >
              <button
                onClick={() => setOpen(open === i ? null : i)}
                className="w-full text-left px-5 py-4 flex items-center justify-between gap-4"
              >
                <span className="text-white text-sm font-medium leading-snug">{faq.q}</span>
                <svg
                  className={`w-4 h-4 text-slate-500 flex-shrink-0 transition-transform ${open === i ? 'rotate-45' : ''}`}
                  fill="none" viewBox="0 0 24 24" stroke="currentColor"
                >
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                </svg>
              </button>
              {open === i && (
                <div className="px-5 pb-5">
                  <p className="text-slate-400 text-sm leading-relaxed">{faq.a}</p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
