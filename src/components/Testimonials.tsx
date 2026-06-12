const TESTIMONIALS = [
  {
    quote:
      "En 6 semaines, j'ai signé 3 mandats exclusifs venus directement de mon estimateur. Avant, je courais après les leads. Maintenant ils arrivent qualifiés dans mon CRM.",
    name: "Eduardo De Sul",
    role: "Conseiller indépendant",
    location: "Bordeaux Métropole",
    metric: "3 mandats en 6 semaines",
  },
  {
    quote:
      "J'ai failli rater ma ville — un collègue a pris la zone voisine deux jours après moi. L'exclusivité, c'est la vraie valeur. Personne ne peut me concurrencer sur mon territoire.",
    name: "Pascal Hamm",
    role: "Mandataire indépendant",
    location: "Aix-en-Provence",
    metric: "Territoire sécurisé",
  },
  {
    quote:
      "97 € par mois pour un système qui me génère en moyenne 8 à 12 contacts vendeurs qualifiés. Le calcul est vite fait. J'aurais dû m'y mettre bien plus tôt.",
    name: "Brice Chupin",
    role: "Conseiller indépendant",
    location: "Nantes",
    metric: "8-12 leads qualifiés/mois",
  },
];

export default function Testimonials() {
  return (
    <section id="realisations" className="py-24 px-4" style={{ background: "rgba(12, 21, 37, 0.4)" }}>
      <div className="max-w-5xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
            Résultats
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-ei-text mb-3">
            Ce que disent les conseillers actifs
          </h2>
          <p className="text-ei-muted text-base">
            5 villes déjà actives. Bordeaux, Nantes, Aix-en-Provence, Nandy, Lannion.
          </p>
        </div>

        <div className="grid sm:grid-cols-3 gap-5">
          {TESTIMONIALS.map((t) => (
            <div
              key={t.name}
              className="bg-ei-card border border-ei-border rounded-2xl p-7 flex flex-col"
            >
              {/* Metric highlight */}
              <div className="bg-ei-gold/10 border border-ei-gold/20 rounded-lg px-3 py-2 mb-5 inline-block self-start">
                <span className="text-ei-gold text-xs font-semibold">
                  {t.metric}
                </span>
              </div>

              {/* Quote */}
              <p className="text-ei-muted text-sm leading-relaxed flex-1 mb-6">
                &ldquo;{t.quote}&rdquo;
              </p>

              {/* Author */}
              <div className="border-t border-ei-border pt-5">
                <p className="text-ei-text font-semibold text-sm">{t.name}</p>
                <p className="text-ei-faint text-xs mt-0.5">
                  {t.role} · {t.location}
                </p>
              </div>
            </div>
          ))}
        </div>

        {/* CTA */}
        <div className="mt-10 text-center">
          <a
            href="#verifier-ma-ville"
            className="inline-flex items-center gap-2 text-ei-gold hover:text-ei-gold-light text-sm font-medium transition-colors"
          >
            Votre ville est-elle encore disponible ?
            <svg
              className="w-4 h-4"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M17 8l4 4m0 0l-4 4m4-4H3"
              />
            </svg>
          </a>
        </div>
      </div>
    </section>
  );
}
