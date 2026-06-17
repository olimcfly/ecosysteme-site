'use client'
import { useState } from 'react'
import { Plus, Minus } from 'lucide-react'

const FAQS = [
  {
    q: 'Et si ma ville est déjà prise ?',
    a: 'Vous pouvez rejoindre la liste d\'attente prioritaire pour votre secteur. Certains conseillers changent de ville ou résilient — vous serez alerté en premier. Vous pouvez aussi choisir une ville adjacente libre.',
  },
  {
    q: 'Pourquoi 897 €/an plutôt qu\'un outil générique à 30 €/mois ?',
    a: 'Un outil générique n\'est pas configuré pour l\'immobilier, n\'inclut pas le SEO local, et ne vous donne aucun avantage concurrentiel sur votre secteur. Ecosystème Immo est préconfiguré, livré prêt à l\'emploi, et réservé à un seul conseiller par ville. La comparaison juste n\'est pas un outil à 30 €/mois — c\'est un assistant marketing + SEO + CRM + automatisation à temps plein. Et contrairement à un salarié, il tourne 24h/24.',
  },
  {
    q: 'Combien de temps avant de voir des résultats ?',
    a: 'Le site et le CRM sont opérationnels sous 10 jours ouvrés. Les premières remontées SEO locales apparaissent entre 4 et 8 semaines selon la concurrence de votre ville. Les leads via l\'estimateur commencent dès l\'activation.',
  },
  {
    q: 'Dois-je gérer le site moi-même ?',
    a: 'Non. Le système est livré prêt à l\'emploi. Vous accédez à un tableau de bord simple pour consulter vos leads et vos performances. Les mises à jour techniques, le SEO et les automatisations sont gérés côté plateforme.',
  },
  {
    q: 'Y a-t-il un engagement minimum ?',
    a: 'Le plan Mensuel nécessite 3 mois prépayés à l\'activation, inclus dans le premier versement de 788 €. L\'annuel est sur 12 mois. L\'exclusivité verrouillée est un paiement unique sans abonnement obligatoire.',
  },
  {
    q: 'Quel type de conseiller peut utiliser ce système ?',
    a: 'Ecosystème Immo est conçu exclusivement pour les conseillers immobiliers indépendants français : agents mandataires, agents indépendants, conseillers en réseaux sans apport de leads centralisé. Si vous avez votre propre portefeuille secteur, vous êtes le profil idéal.',
  },
  {
    q: 'Est-ce que ça fonctionne dans toutes les villes de France ?',
    a: 'Oui, le système est déployable sur toute commune française. La pertinence SEO est optimisée selon la taille et la concurrence locale de votre ville. Plus votre marché est niché, meilleure sera votre visibilité.',
  },
  {
    q: 'Que se passe-t-il si je veux changer de secteur ?',
    a: 'Votre exclusivité territoriale est transmissible. Vous pouvez la transférer sur une autre ville disponible, ou la revendre à un autre conseiller avec notre accord. Contactez-nous pour les modalités.',
  },
]

function FAQItem({ q, a }: { q: string; a: string }) {
  const [open, setOpen] = useState(false)
  return (
    <div className="border-b border-slate-100 last:border-0">
      <button
        onClick={() => setOpen(!open)}
        className="w-full flex items-start justify-between gap-4 py-5 text-left"
      >
        <span className={`text-sm font-medium leading-snug transition-colors ${open ? 'text-blue-700' : 'text-slate-900'}`}>
          {q}
        </span>
        <span className={`flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center border transition-colors mt-0.5 ${open ? 'border-blue-600 bg-blue-50' : 'border-slate-200 bg-white'}`}>
          {open
            ? <Minus size={10} className="text-blue-600" />
            : <Plus size={10} className="text-slate-400" />}
        </span>
      </button>
      {open && (
        <div className="pb-5 pr-9 animate-fade-in">
          <p className="text-slate-500 text-sm leading-relaxed">{a}</p>
        </div>
      )}
    </div>
  )
}

export default function FAQ() {
  return (
    <section className="py-20 sm:py-28 bg-white">
      <div className="max-w-3xl mx-auto px-4 sm:px-6">
        <div className="text-center mb-12">
          <span className="section-label">Questions fréquentes</span>
          <h2 className="section-title">Ce que vous vous demandez sûrement</h2>
        </div>

        <div className="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-2">
          {FAQS.map((item) => (
            <FAQItem key={item.q} q={item.q} a={item.a} />
          ))}
        </div>
      </div>
    </section>
  )
}
