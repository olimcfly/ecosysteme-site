const PLANS = [
  {
    name: "Estimateur seul",
    price: "27",
    period: "/mois",
    setup: "+ 197 € de setup",
    description:
      "Pour commencer à capturer des leads vendeurs sans infrastructure complète.",
    features: [
      "Estimateur propriétaire intégré",
      "Formulaire de capture qualifié",
      "Notifications email instantanées",
      "Tableau de bord leads",
    ],
    cta: "Vérifier ma ville",
    href: "#verifier-ma-ville",
    highlighted: false,
    badge: null,
  },
  {
    name: "Standard",
    price: "97",
    period: "/mois",
    setup: "+ 497 € de setup · 3 mois prépayés",
    description:
      "Le système complet pour dominer votre marché local et générer des leads en continu.",
    features: [
      "Tout l'offre Estimateur +",
      "Site web SEO local complet",
      "Pages secteurs et quartiers",
      "CRM + automatisations email/SMS",
      "IA conversationnelle 24h/24",
      "Reporting mensuel",
    ],
    cta: "Vérifier ma ville",
    href: "#verifier-ma-ville",
    highlighted: true,
    badge: "Le plus populaire",
  },
  {
    name: "Annuel",
    price: "897",
    period: "/an",
    setup: "Setup offert · Exclusivité territoriale incluse",
    description:
      "L'investissement annuel le plus rentable. Exclusivité garantie, setup offert.",
    features: [
      "Tout l'offre Standard +",
      "Setup offert (économisez 497 €)",
      "Exclusivité territoriale garantie",
      "Support prioritaire",
      "Accès aux futures fonctionnalités",
      "1 appel stratégie/trimestre",
    ],
    cta: "Vérifier ma ville",
    href: "#verifier-ma-ville",
    highlighted: false,
    badge: "Meilleure valeur",
  },
];

export default function Pricing() {
  return (
    <section id="tarifs" className="py-24 px-4">
      <div className="max-w-5xl mx-auto">
        {/* Header */}
        <div className="text-center mb-16">
          <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
            Tarifs
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-ei-text mb-4">
            Choisissez votre niveau d'engagement
          </h2>
          <p className="text-ei-muted text-base max-w-lg mx-auto">
            Un seul conseiller par ville. Vérifiez la disponibilité avant de
            choisir votre formule.
          </p>
        </div>

        {/* Pricing cards */}
        <div className="grid sm:grid-cols-3 gap-5">
          {PLANS.map((plan) => (
            <div
              key={plan.name}
              className={`relative rounded-2xl p-7 flex flex-col ${
                plan.highlighted
                  ? "bg-ei-card border-2 border-ei-gold/60 shadow-[0_0_40px_rgba(200,150,42,0.12)]"
                  : "bg-ei-card border border-ei-border"
              }`}
            >
              {/* Badge */}
              {plan.badge && (
                <div
                  className={`absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full text-xs font-semibold whitespace-nowrap ${
                    plan.highlighted
                      ? "bg-ei-gold text-ei-bg"
                      : "bg-ei-elevated border border-ei-border text-ei-gold"
                  }`}
                >
                  {plan.badge}
                </div>
              )}

              {/* Plan name */}
              <p
                className={`text-sm font-semibold mb-4 ${
                  plan.highlighted ? "text-ei-gold" : "text-ei-muted"
                }`}
              >
                {plan.name}
              </p>

              {/* Price */}
              <div className="mb-1">
                <span className="text-4xl font-bold text-ei-text">
                  {plan.price} €
                </span>
                <span className="text-ei-muted text-sm ml-1">{plan.period}</span>
              </div>
              <p className="text-ei-faint text-xs mb-4">{plan.setup}</p>

              <p className="text-ei-muted text-sm mb-7 leading-relaxed">
                {plan.description}
              </p>

              {/* Features */}
              <ul className="space-y-3 flex-1 mb-8">
                {plan.features.map((feature) => (
                  <li key={feature} className="flex items-start gap-2.5 text-sm">
                    <svg
                      className="w-4 h-4 text-ei-gold flex-shrink-0 mt-0.5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                    <span
                      className={
                        feature.endsWith("+")
                          ? "text-ei-muted font-medium"
                          : "text-ei-muted"
                      }
                    >
                      {feature}
                    </span>
                  </li>
                ))}
              </ul>

              {/* CTA */}
              <a
                href={plan.href}
                className={`w-full py-3 rounded-xl font-semibold text-sm text-center transition-colors duration-200 ${
                  plan.highlighted
                    ? "bg-ei-gold hover:bg-ei-gold-light text-ei-bg"
                    : "border border-ei-border hover:border-ei-gold/50 text-ei-muted hover:text-ei-text"
                }`}
              >
                {plan.cta}
              </a>
            </div>
          ))}
        </div>

        {/* Exclusivity lock add-on */}
        <div className="mt-6 bg-ei-card border border-ei-border-light rounded-2xl p-6 sm:p-7 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
          <div className="flex items-start gap-4">
            <div className="w-10 h-10 bg-ei-gold/10 border border-ei-gold/20 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg
                className="w-5 h-5 text-ei-gold"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={1.5}
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                />
              </svg>
            </div>
            <div>
              <p className="text-ei-text font-semibold mb-1">
                Exclusivité verrouillée — 900 € paiement unique
              </p>
              <p className="text-ei-muted text-sm leading-relaxed">
                Verrouillez votre territoire à vie, quelle que soit votre
                formule. Votre ville ne peut jamais être prise par un autre
                conseiller. Transférable en cas de cession d'activité.
              </p>
            </div>
          </div>
          <a
            href="#verifier-ma-ville"
            className="flex-shrink-0 border border-ei-gold/40 hover:border-ei-gold text-ei-gold hover:text-ei-gold-light px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap"
          >
            Sécuriser ma ville →
          </a>
        </div>

        {/* Founder program */}
        <div className="mt-4 bg-ei-elevated border border-ei-border rounded-xl px-6 py-4 flex items-center gap-3">
          <span className="w-2 h-2 bg-ei-faint rounded-full flex-shrink-0" />
          <p className="text-ei-faint text-sm">
            <span className="text-ei-muted font-medium">Programme Fondateur (47 €/mois à vie)</span>
            {" "}— Places épuisées. Les inscrits fondateurs bénéficient de conditions tarifaires permanentes.
          </p>
        </div>
      </div>
    </section>
  );
}
