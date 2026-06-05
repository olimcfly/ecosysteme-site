import { Check, Lock, Star, ArrowRight } from 'lucide-react'

interface Plan {
  id: string
  name: string
  price: string
  period: string
  setup: string | null
  badge?: string
  highlighted: boolean
  features: string[]
  cta: string
  note?: string
}

const PLANS: Plan[] = [
  {
    id: 'estimateur',
    name: 'Estimateur',
    price: '27',
    period: '/ mois',
    setup: '+ 197 € setup (une fois)',
    highlighted: false,
    features: [
      'Estimateur immobilier intégré',
      'Génération de leads propriétaires',
      'Formulaire de contact optimisé',
      'Tableau de bord leads',
      'Support par email',
    ],
    cta: 'Commencer avec l\'estimateur',
    note: 'Sans exclusivité territoriale',
  },
  {
    id: 'mensuel',
    name: 'Mensuel Standard',
    price: '97',
    period: '/ mois',
    setup: '+ 497 € setup + 3 mois prépayés',
    highlighted: false,
    features: [
      'Système complet (site + CRM + automations)',
      'SEO local optimisé',
      'Estimateur en ligne',
      'Qualification IA des prospects',
      'Exclusivité territoriale incluse',
      'Support prioritaire',
    ],
    cta: 'Démarrer en mensuel',
  },
  {
    id: 'annuel',
    name: 'Annuel',
    price: '897',
    period: '/ an',
    setup: 'Setup 497 € offert',
    badge: 'Recommandé',
    highlighted: true,
    features: [
      'Tout le plan Mensuel Standard',
      'Setup 497 € offert (économie immédiate)',
      'Exclusivité territoriale incluse',
      'Rapport mensuel de performance',
      'Accès anticipé aux nouvelles fonctionnalités',
      'Support prioritaire',
    ],
    cta: 'Démarrer en annuel',
    note: 'Revient à 74,75 €/mois',
  },
  {
    id: 'exclusivite',
    name: 'Exclusivité verrouillée',
    price: '900',
    period: 'paiement unique',
    setup: null,
    highlighted: false,
    features: [
      'Verrouillez votre ville à vie',
      'Indépendant du plan souscrit',
      'Transmissible si changement de secteur',
      'Priorité absolue sur votre territoire',
    ],
    cta: 'Verrouiller ma ville',
    note: 'Combinable avec tout plan',
  },
]

interface PricingProps {
  onOpenModal: () => void
}

export default function Pricing({ onOpenModal }: PricingProps) {
  return (
    <section id="tarifs" className="py-20 sm:py-28 bg-slate-50">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mx-auto text-center mb-14">
          <span className="section-label">Tarifs</span>
          <h2 className="section-title mb-4">Choisissez votre niveau d&apos;engagement</h2>
          <p className="section-sub">
            Pas de frais cachés. Setup transparent. Résiliable. L&apos;exclusivité territoriale est incluse dès le plan Mensuel.
          </p>
        </div>

        {/* Founder badge */}
        <div className="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-8 max-w-2xl mx-auto">
          <div className="flex items-start gap-3">
            <Star size={16} className="text-amber-600 flex-shrink-0 mt-0.5" />
            <div>
              <p className="text-amber-900 text-sm font-semibold mb-1">Programme Fondateur — Fermé</p>
              <p className="text-amber-700 text-sm leading-relaxed">
                Nos membres fondateurs ont verrouillé leur ville à <strong>47 €/mois à vie</strong>.
                Ce programme n&apos;est plus ouvert. Rejoignez la liste d&apos;attente prioritaire pour être alerté en premier si une opportunité similaire se présente.
              </p>
              <button
                onClick={onOpenModal}
                className="mt-3 text-amber-700 font-semibold text-xs underline underline-offset-2 hover:text-amber-900 transition-colors"
              >
                Rejoindre la liste d&apos;attente
              </button>
            </div>
          </div>
        </div>

        <div className="grid sm:grid-cols-2 xl:grid-cols-4 gap-5">
          {PLANS.map((plan) => (
            <div
              key={plan.id}
              className={`rounded-2xl flex flex-col relative ${
                plan.highlighted
                  ? 'bg-navy border-2 border-blue-700 shadow-xl shadow-blue-950/20'
                  : 'bg-white border border-slate-200 shadow-sm'
              }`}
            >
              {plan.badge && (
                <div className="absolute -top-3.5 left-1/2 -translate-x-1/2">
                  <span className="bg-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap">
                    {plan.badge}
                  </span>
                </div>
              )}

              <div className="p-6 flex-1">
                <p className={`text-xs font-semibold uppercase tracking-widest mb-3 ${plan.highlighted ? 'text-blue-400' : 'text-slate-400'}`}>
                  {plan.name}
                </p>

                <div className="mb-1">
                  <span className={`text-4xl font-bold ${plan.highlighted ? 'text-white' : 'text-slate-900'}`}>
                    {plan.price} €
                  </span>
                  <span className={`text-sm ml-1 ${plan.highlighted ? 'text-white/50' : 'text-slate-400'}`}>
                    {plan.period}
                  </span>
                </div>

                {plan.setup && (
                  <p className={`text-xs mb-5 ${plan.highlighted ? 'text-white/40' : 'text-slate-400'}`}>
                    {plan.setup}
                  </p>
                )}
                {!plan.setup && <div className="mb-5" />}

                {plan.note && (
                  <p className={`text-xs font-medium mb-4 ${plan.highlighted ? 'text-gold' : 'text-blue-600'}`}>
                    {plan.note}
                  </p>
                )}

                <ul className="space-y-2.5">
                  {plan.features.map((f) => (
                    <li key={f} className="flex items-start gap-2.5">
                      <Check
                        size={14}
                        className={`flex-shrink-0 mt-0.5 ${plan.highlighted ? 'text-blue-400' : 'text-blue-600'}`}
                      />
                      <span className={`text-sm leading-snug ${plan.highlighted ? 'text-white/70' : 'text-slate-600'}`}>
                        {f}
                      </span>
                    </li>
                  ))}
                </ul>
              </div>

              <div className="p-6 pt-0">
                <button
                  onClick={onOpenModal}
                  className={`w-full py-3 px-4 rounded-xl text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-2 ${
                    plan.highlighted
                      ? 'bg-blue-700 hover:bg-blue-600 text-white shadow-lg'
                      : 'bg-slate-900 hover:bg-slate-800 text-white'
                  }`}
                >
                  {plan.cta}
                  <ArrowRight size={14} />
                </button>
              </div>
            </div>
          ))}
        </div>

        <p className="text-center text-slate-400 text-xs mt-8">
          Tous les tarifs sont HT. L&apos;exclusivité verrouillée (900 €) est cumulable avec n&apos;importe quel plan.
        </p>
      </div>
    </section>
  )
}
