import { CONTACT_URL, WAITLIST_URL } from '@/lib/config'

const plans = [
  {
    name: "Estimateur",
    price: "27",
    period: "/mois",
    setup: "+ 197 € setup unique",
    highlight: false,
    badge: null as string | null,
    description: "Pour tester la génération de leads avec un estimateur immobilier local.",
    features: [
      "Estimateur de valeur immobilière",
      "Page de présentation conseiller",
      "Formulaire de capture de leads",
      "Rapport mensuel de performance",
    ],
    missing: [
      "SEO de secteur",
      "CRM et automatisations",
      "IA de qualification",
      "Exclusivité territoriale",
    ],
    cta: "Démarrer avec l'estimateur",
  },
  {
    name: "Standard",
    price: "97",
    period: "/mois",
    setup: "+ 497 € setup + 3 mois prépayés",
    highlight: false,
    badge: null as string | null,
    description: "Le système complet pour développer votre acquisition locale.",
    features: [
      "Site local de référence complet",
      "SEO de secteur (contenu + technique)",
      "CRM intégré + pipeline leads",
      "Automatisations de relance",
      "IA de qualification des contacts",
      "Tableau de bord de performance",
    ],
    missing: ["Exclusivité territoriale (option payante)"],
    cta: "Choisir le plan Standard",
  },
  {
    name: "Annuel",
    price: "897",
    period: "/an",
    setup: "Setup offert · Exclusivité incluse",
    highlight: true,
    badge: "Meilleure valeur" as string | null,
    description:
      "Tout le système Standard avec l'exclusivité territoriale garantie et le setup offert.",
    features: [
      "Tout du plan Standard inclus",
      "Exclusivité territoriale garantie",
      "Setup offert (économie de 497 €)",
      "Support prioritaire",
      "Bilan stratégique trimestriel",
    ],
    missing: [] as string[],
    cta: "Choisir le plan Annuel",
  },
  {
    name: "Exclusivité Verrouillée",
    price: "900",
    period: "paiement unique",
    setup: "Sans abonnement mensuel",
    highlight: false,
    badge: null as string | null,
    description:
      "Verrouillez votre territoire définitivement. Accès aux outils essentiels, sans engagement.",
    features: [
      "Exclusivité territoriale permanente",
      "Page locale de présentation",
      "Estimateur de valeur immobilière",
      "Formulaire de capture",
      "Aucun abonnement requis",
    ],
    missing: ["SEO continu", "CRM avancé", "Automatisations", "IA de qualification"],
    cta: "Verrouiller ma ville",
  },
]

function Check({ highlight }: { highlight: boolean }) {
  return (
    <svg
      className={`w-4 h-4 mt-0.5 flex-shrink-0 ${highlight ? "text-amber-400" : "text-zinc-900"}`}
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      strokeWidth={2.5}
    >
      <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
    </svg>
  )
}

function Cross() {
  return (
    <svg
      className="w-4 h-4 mt-0.5 flex-shrink-0 text-zinc-300"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      strokeWidth={2}
    >
      <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
  )
}

export default function PricingSection() {
  return (
    <section id="tarifs" className="py-20 md:py-28 px-4 sm:px-6 lg:px-8 bg-zinc-50">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-12">
          <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">
            Tarifs
          </p>
          <h2 className="text-3xl md:text-4xl font-bold tracking-tight text-zinc-950 mb-4">
            Des formules adaptées à chaque étape
          </h2>
          <p className="text-base text-zinc-600 max-w-xl mx-auto">
            {"Chaque formule inclut l'onboarding complet. Vous êtes opérationnel en 7 jours ouvrés."}
          </p>
        </div>

        {/* Programme Fondateur — Fermé */}
        <div className="mb-8 p-4 sm:p-5 border border-zinc-200 rounded-xl bg-white flex flex-col sm:flex-row sm:items-center gap-4 sm:justify-between opacity-60 select-none">
          <div>
            <div className="flex items-center gap-2 mb-1">
              <span className="text-sm font-semibold text-zinc-900">Programme Fondateur</span>
              <span className="px-2 py-0.5 text-xs font-bold bg-zinc-900 text-white rounded">
                COMPLET
              </span>
            </div>
            <p className="text-xs text-zinc-500">
              47 €/mois à vie — Réservé aux membres fondateurs. Programme maintenant fermé.
            </p>
          </div>
          <a
            href={WAITLIST_URL}
            className="flex-shrink-0 px-4 py-2 border border-zinc-300 text-zinc-600 text-xs font-semibold rounded-lg hover:bg-zinc-50 transition-colors"
          >
            {"Liste d'attente"}
          </a>
        </div>

        {/* Plans */}
        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
          {plans.map((plan) => (
            <div
              key={plan.name}
              className={`relative flex flex-col p-6 rounded-xl border ${
                plan.highlight
                  ? "border-zinc-900 bg-zinc-950"
                  : "border-zinc-200 bg-white"
              }`}
            >
              {plan.badge && (
                <div className="absolute -top-3 left-1/2 -translate-x-1/2 whitespace-nowrap">
                  <span className="px-3 py-1 text-xs font-bold bg-amber-500 text-white rounded-full">
                    {plan.badge}
                  </span>
                </div>
              )}

              <div className="mb-5">
                <p
                  className={`text-xs font-semibold uppercase tracking-widest mb-3 ${
                    plan.highlight ? "text-zinc-400" : "text-zinc-500"
                  }`}
                >
                  {plan.name}
                </p>
                <div className="flex items-end gap-1 mb-1">
                  <span
                    className={`text-3xl font-black ${
                      plan.highlight ? "text-white" : "text-zinc-950"
                    }`}
                  >
                    {plan.price} €
                  </span>
                  <span
                    className={`text-sm mb-1 ${
                      plan.highlight ? "text-zinc-400" : "text-zinc-500"
                    }`}
                  >
                    {plan.period}
                  </span>
                </div>
                <p
                  className={`text-xs leading-relaxed ${
                    plan.highlight ? "text-zinc-400" : "text-zinc-500"
                  }`}
                >
                  {plan.setup}
                </p>
              </div>

              <p
                className={`text-sm mb-5 leading-relaxed ${
                  plan.highlight ? "text-zinc-300" : "text-zinc-600"
                }`}
              >
                {plan.description}
              </p>

              <ul className="space-y-2.5 mb-6 flex-1">
                {plan.features.map((feature, i) => (
                  <li key={i} className="flex items-start gap-2 text-sm">
                    <Check highlight={plan.highlight} />
                    <span className={plan.highlight ? "text-zinc-200" : "text-zinc-700"}>
                      {feature}
                    </span>
                  </li>
                ))}
                {plan.missing.map((feature, i) => (
                  <li key={i} className="flex items-start gap-2 text-sm opacity-40">
                    <Cross />
                    <span className="text-zinc-400">{feature}</span>
                  </li>
                ))}
              </ul>

              <a
                href={CONTACT_URL}
                className={`block text-center px-4 py-3 text-sm font-semibold rounded-xl transition-colors ${
                  plan.highlight
                    ? "bg-amber-500 text-white hover:bg-amber-400"
                    : "bg-zinc-900 text-white hover:bg-zinc-700"
                }`}
              >
                {plan.cta}
              </a>
            </div>
          ))}
        </div>

        <p className="text-center text-xs text-zinc-400 mt-8 leading-relaxed">
          {"Tous les tarifs sont HT. L'exclusivité territoriale est garantie par contrat dans les plans Annuel et Exclusivité Verrouillée."}
        </p>
      </div>
    </section>
  )
}
