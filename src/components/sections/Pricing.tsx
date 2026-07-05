interface PricingProps {
  onCTA: () => void;
}

const plans = [
  {
    name: "Estimateur",
    description: "L'outil de qualification seul, pour générer des estimations de biens.",
    price: "27",
    period: "/mois",
    setup: "197€ d'activation",
    highlight: false,
    badge: null,
    features: [
      "Estimateur de bien personnalisé",
      "Page de capture intégrée",
      "Notifications par email",
      "Statistiques basiques",
    ],
    cta: "Démarrer",
    note: null,
  },
  {
    name: "Système Complet",
    description: "Le système d'acquisition locale intégral, pour générer des mandats en continu.",
    price: "97",
    period: "/mois",
    setup: "497€ d'activation · 3 premiers mois prépayés",
    highlight: true,
    badge: "Le plus choisi",
    features: [
      "Site web local optimisé",
      "SEO local structuré",
      "Estimateur de bien intégré",
      "CRM et pipeline vendeurs",
      "Automatisations de relance",
      "IA de qualification des leads",
      "Tableau de bord analytics",
      "Support prioritaire",
    ],
    cta: "Réserver ma ville",
    note: "Option exclusivité verrouillée disponible : +900€ paiement unique",
  },
  {
    name: "Annuel",
    description: "Le système complet sur 12 mois, avec exclusivité territoriale garantie.",
    price: "897",
    period: "/an",
    setup: "Activation offerte · Exclusivité incluse",
    highlight: false,
    badge: "Meilleur rapport valeur",
    features: [
      "Tout le Système Complet",
      "Activation offerte (€0)",
      "Exclusivité territoriale verrouillée",
      "Soit 74,75€/mois effectif",
      "Onboarding dédié",
      "Accès anticipé aux nouvelles fonctions",
    ],
    cta: "Choisir l'annuel",
    note: "Soit une économie de 267€ vs mensuel + 497€ d'activation",
  },
];

export default function Pricing({ onCTA }: PricingProps) {
  return (
    <section
      id="tarifs"
      className="section-padding"
      style={{ background: "var(--surface-alt)" }}
    >
      <div className="container-site">
        <div className="text-center max-w-2xl mx-auto mb-6">
          <p
            className="text-xs font-semibold uppercase tracking-widest mb-4"
            style={{ color: "var(--accent-blue)" }}
          >
            Tarifs
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-5 text-balance">
            Choisissez votre niveau d&apos;engagement
          </h2>
          <p className="text-slate-500 text-lg leading-relaxed">
            Tous les plans incluent l&apos;activation par notre équipe. Pas de
            configuration technique de votre côté.
          </p>
        </div>

        {/* Programme Fondateur — closed FOMO */}
        <div
          className="max-w-2xl mx-auto mb-10 p-4 rounded-xl border flex items-center gap-4"
          style={{
            background: "rgba(217,119,6,0.05)",
            borderColor: "rgba(217,119,6,0.2)",
          }}
        >
          <div
            className="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center"
            style={{ background: "rgba(217,119,6,0.12)" }}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              strokeWidth={2}
              stroke="#d97706"
              className="w-4 h-4"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
              />
            </svg>
          </div>
          <div className="flex-1 min-w-0">
            <div className="flex items-center gap-2 flex-wrap">
              <span className="font-semibold text-sm text-slate-800">
                Programme Fondateur — 47€/mois à vie
              </span>
              <span
                className="text-xs font-bold px-2 py-0.5 rounded-full"
                style={{ background: "#d97706", color: "white" }}
              >
                COMPLET
              </span>
            </div>
            <p className="text-xs text-slate-500 mt-0.5">
              Les premiers conseillers ont verrouillé leur accès à vie à ce tarif. Ce programme est fermé.
            </p>
          </div>
        </div>

        <div className="grid lg:grid-cols-3 gap-6">
          {plans.map((plan) => (
            <div
              key={plan.name}
              className={`relative bg-white rounded-2xl border transition-all ${
                plan.highlight
                  ? "shadow-xl ring-2 scale-[1.02]"
                  : "border-slate-150 hover:shadow-md hover:border-slate-200"
              }`}
              style={
                plan.highlight
                  ? {
                      borderColor: "var(--accent-blue)",
                    }
                  : {}
              }
            >
              {plan.badge && (
                <div
                  className="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full text-xs font-bold text-white whitespace-nowrap"
                  style={{
                    background: plan.highlight
                      ? "var(--accent-blue)"
                      : "var(--accent-amber)",
                  }}
                >
                  {plan.badge}
                </div>
              )}

              <div className="p-7">
                <h3 className="font-bold text-slate-900 text-lg mb-1">
                  {plan.name}
                </h3>
                <p className="text-slate-500 text-sm mb-6 leading-relaxed">
                  {plan.description}
                </p>

                <div className="flex items-baseline gap-1 mb-1">
                  <span className="text-4xl font-bold text-slate-900">
                    {plan.price}€
                  </span>
                  <span className="text-slate-500 text-sm">{plan.period}</span>
                </div>
                <p className="text-xs text-slate-400 mb-7">{plan.setup}</p>

                <button
                  onClick={onCTA}
                  className={`w-full py-3 px-5 rounded-xl font-semibold text-sm transition-all hover:opacity-90 active:scale-95 mb-7 ${
                    plan.highlight ? "text-white" : "text-slate-700 border border-slate-200 hover:border-slate-300"
                  }`}
                  style={
                    plan.highlight ? { background: "var(--accent-blue)" } : {}
                  }
                >
                  {plan.cta}
                </button>

                <ul className="space-y-2.5">
                  {plan.features.map((f) => (
                    <li key={f} className="flex items-start gap-2.5">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={2.5}
                        stroke={plan.highlight ? "var(--accent-blue)" : "#16a34a"}
                        className="w-4 h-4 flex-shrink-0 mt-0.5"
                      >
                        <path
                          strokeLinecap="round"
                          strokeLinejoin="round"
                          d="M4.5 12.75l6 6 9-13.5"
                        />
                      </svg>
                      <span className="text-sm text-slate-600">{f}</span>
                    </li>
                  ))}
                </ul>

                {plan.note && (
                  <p className="text-xs text-slate-400 mt-5 pt-4 border-t border-slate-100 leading-relaxed">
                    {plan.note}
                  </p>
                )}
              </div>
            </div>
          ))}
        </div>

        <p className="text-center text-sm text-slate-400 mt-8">
          Toutes les formules sont sans engagement de durée minimum (hors 3 mois prépayés sur Standard).
          Résiliation à tout moment.
        </p>
      </div>
    </section>
  );
}
