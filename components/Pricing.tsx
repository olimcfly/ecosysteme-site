const PLANS = [
  {
    name: 'Estimateur',
    price: '27',
    period: '/mois',
    setup: '+ 197 € de mise en place',
    commitment: null,
    desc: 'Pour intégrer un outil d\'estimation professionnel sur votre site actuel.',
    features: [
      'Outil d\'estimation vendeur intégré',
      'Formulaire d\'avis de valeur',
      'Page de capture dédiée',
      'Notifications contact instantanées',
    ],
    cta: 'Demander un accès',
    ctaStyle: 'secondary',
    highlight: false,
    badge: null,
  },
  {
    name: 'Standard',
    price: '97',
    period: '/mois',
    setup: '+ 497 € de mise en place · 3 mois prépayés',
    commitment: null,
    desc: 'Le système complet pour dominer votre ville et attirer des vendeurs qualifiés.',
    features: [
      'Site immobilier sur votre domaine',
      'Pages secteurs optimisées SEO',
      'Google Business Profile',
      'Formulaire vendeur + estimation',
      'CRM + relances automatisées',
      'Exclusivité territoriale',
    ],
    cta: 'Réserver mon territoire',
    ctaStyle: 'primary',
    highlight: true,
    badge: 'RECOMMANDÉ',
  },
  {
    name: 'Annuel',
    price: '897',
    period: '/an',
    setup: 'Setup offert · Exclusivité incluse',
    commitment: null,
    desc: 'Meilleure valeur. Économisez 267 € par rapport à l\'abonnement mensuel.',
    features: [
      'Tout le plan Standard inclus',
      'Frais de mise en place offerts',
      'Exclusivité territoriale garantie',
      'Priorité sur les nouvelles fonctionnalités IA',
    ],
    cta: 'Réserver mon territoire',
    ctaStyle: 'secondary',
    highlight: false,
    badge: 'MEILLEURE VALEUR',
  },
]

export default function Pricing() {
  return (
    <section id="offres" className="py-20 px-4 sm:px-6 border-t border-[#1A2840]">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Investissement
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-[#EEE8D8] mb-4">
            Réservez votre territoire
          </h2>
          <p className="text-[#8090A8] max-w-xl mx-auto text-sm leading-relaxed">
            Toutes les offres incluent l&apos;exclusivité territoriale. Un seul conseiller par ville — le premier qui réserve verrouille l&apos;accès.
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-6 mb-8">
          {PLANS.map((plan) => (
            <div
              key={plan.name}
              className={`rounded-lg p-6 flex flex-col ${
                plan.highlight
                  ? 'bg-[#C8A84B]/5 border-2 border-[#C8A84B]/40'
                  : 'bg-[#0D1829] border border-[#1A2840]'
              }`}
            >
              {plan.badge && (
                <span
                  className={`self-start text-xs font-bold px-2 py-0.5 rounded mb-4 ${
                    plan.highlight
                      ? 'bg-[#C8A84B] text-[#080E1A]'
                      : 'bg-[#1A2840] text-[#C8A84B]'
                  }`}
                >
                  {plan.badge}
                </span>
              )}

              <p className="text-[#EEE8D8] font-bold text-lg mb-2">{plan.name}</p>

              <div className="flex items-baseline gap-1 mb-1">
                <span className="text-4xl font-bold text-[#EEE8D8]">{plan.price} €</span>
                <span className="text-[#8090A8] text-sm">{plan.period}</span>
              </div>
              <p className="text-[#4A5568] text-xs mb-5">{plan.setup}</p>

              <p className="text-[#8090A8] text-sm leading-relaxed mb-6">{plan.desc}</p>

              <ul className="space-y-2.5 mb-8 flex-1">
                {plan.features.map((feature) => (
                  <li key={feature} className="flex items-start gap-2.5 text-sm">
                    <span className="text-[#C8A84B] mt-0.5 flex-shrink-0">—</span>
                    <span className="text-[#8090A8]">{feature}</span>
                  </li>
                ))}
              </ul>

              <a
                href={`mailto:contact@ecosystemeimmo.fr?subject=${plan.name} — Demande de démarrage`}
                className={`w-full text-center font-semibold text-sm px-4 py-3 rounded transition-colors ${
                  plan.ctaStyle === 'primary'
                    ? 'bg-[#C8A84B] hover:bg-[#D4B56A] text-[#080E1A]'
                    : 'bg-[#1A2840] hover:bg-[#243550] text-[#EEE8D8]'
                }`}
              >
                {plan.cta}
              </a>
            </div>
          ))}
        </div>

        <p className="text-center text-[#4A5568] text-xs mb-8">
          Les territoires disponibles se réduisent à chaque nouvelle inscription.
        </p>

        {/* Programme Fondateur */}
        <div className="bg-[#0D1829] border border-[#1A2840] rounded-lg p-6 mb-4">
          <div className="flex flex-col sm:flex-row sm:items-center gap-4">
            <div className="flex-1">
              <div className="flex flex-wrap items-center gap-2 mb-2">
                <span className="bg-[#C8A84B]/10 text-[#C8A84B] text-xs font-bold px-2 py-0.5 rounded border border-[#C8A84B]/20">
                  PROGRAMME FONDATEUR
                </span>
                <span className="bg-red-950/40 text-red-400 text-xs font-medium px-2 py-0.5 rounded border border-red-900/40">
                  COMPLET
                </span>
              </div>
              <p className="text-[#EEE8D8] font-semibold mb-1">47 €/mois à vie</p>
              <p className="text-[#8090A8] text-sm leading-relaxed">
                Ce tarif préférentiel a été accordé aux 10 premiers conseillers ayant rejoint le programme avant son ouverture officielle.
                Le programme fondateur est désormais complet. Une liste d&apos;attente reste ouverte.
              </p>
            </div>
            <a
              href="mailto:contact@ecosystemeimmo.fr?subject=Liste attente Programme Fondateur"
              className="flex-shrink-0 text-center border border-[#1A2840] hover:border-[#243550] text-[#8090A8] hover:text-[#EEE8D8] text-sm font-medium px-4 py-2.5 rounded transition-colors"
            >
              Liste d&apos;attente
            </a>
          </div>
        </div>

        {/* Exclusivité verrouillée add-on */}
        <div className="bg-[#0D1829] border border-[#1A2840] rounded-lg p-6">
          <div className="flex flex-col sm:flex-row sm:items-center gap-4">
            <div className="flex-1">
              <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-wide mb-2">
                Option add-on — garantie post-résiliation
              </p>
              <p className="text-[#EEE8D8] font-semibold mb-1">
                Exclusivité verrouillée — 900 € paiement unique
              </p>
              <p className="text-[#8090A8] text-sm leading-relaxed">
                L&apos;exclusivité est incluse dans tous les plans actifs. Cette option la rend permanente :
                votre territoire reste verrouillé contractuellement même après résiliation de l&apos;abonnement.
              </p>
            </div>
            <a
              href="mailto:contact@ecosystemeimmo.fr?subject=Exclusivité verrouillée"
              className="flex-shrink-0 text-center border border-[#C8A84B]/30 hover:border-[#C8A84B]/60 text-[#C8A84B] text-sm font-medium px-4 py-2.5 rounded transition-colors"
            >
              En savoir plus
            </a>
          </div>
        </div>
      </div>
    </section>
  )
}
