const FEATURES = [
  {
    title: "Site web SEO local",
    description:
      "Votre site optimisé pour apparaître en premier sur Google dans votre ville. Vos prospects vous trouvent au bon moment, au bon endroit, avant vos concurrents.",
    icon: (
      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9" />
      </svg>
    ),
  },
  {
    title: "Estimateur propriétaire",
    description:
      "Capturez les vendeurs au moment précis où ils cherchent à estimer leur bien. Le levier le plus efficace pour générer des leads vendeurs qualifiés sans budget publicitaire.",
    icon: (
      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
      </svg>
    ),
  },
  {
    title: "CRM + automatisations",
    description:
      "Qualifiez, segmentez et relancez vos prospects automatiquement via email et SMS. Tout fonctionne sans action manuelle de votre part.",
    icon: (
      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
      </svg>
    ),
  },
  {
    title: "IA conversationnelle",
    description:
      "Un assistant intelligent répond à vos prospects 24h/24, 7j/7. Il qualifie, oriente et chauffe vos leads avant même votre premier contact.",
    icon: (
      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
      </svg>
    ),
  },
  {
    title: "Exclusivité territoriale",
    description:
      "Votre ville vous appartient. Aucun autre conseiller ne peut activer le système dans votre zone. Vos leads sont 100% vôtres — aujourd'hui et demain.",
    icon: (
      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
      </svg>
    ),
  },
];

export default function SystemSection() {
  return (
    <section id="systeme" className="py-24 px-4" style={{ background: "rgba(12, 21, 37, 0.4)" }}>
      <div className="max-w-5xl mx-auto">
        {/* Header */}
        <div className="text-center mb-16">
          <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
            La solution
          </p>
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-bold text-ei-text leading-tight mb-5">
            Ce n'est pas un outil de plus.
            <br />
            <span className="gold-text">C'est un système complet.</span>
          </h2>
          <p className="text-ei-muted text-lg max-w-2xl mx-auto leading-relaxed">
            Chaque composant est conçu pour travailler ensemble. Le résultat : un
            pipeline de leads vendeurs qualifiés, entièrement automatisé, 100%
            local.
          </p>
        </div>

        {/* Features grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {FEATURES.map((feature, i) => (
            <div
              key={i}
              className={`bg-ei-card border border-ei-border rounded-2xl p-7 ${
                i === 4 ? "sm:col-span-2 lg:col-span-1" : ""
              }`}
            >
              <div className="w-10 h-10 bg-ei-gold/10 border border-ei-gold/20 rounded-xl flex items-center justify-center mb-5 text-ei-gold">
                {feature.icon}
              </div>
              <h3 className="text-ei-text font-semibold text-base mb-2.5">
                {feature.title}
              </h3>
              <p className="text-ei-muted text-sm leading-relaxed">
                {feature.description}
              </p>
            </div>
          ))}
        </div>

        {/* Differentiator callout */}
        <div className="mt-10 bg-ei-gold/5 border border-ei-gold/20 rounded-2xl p-8 text-center">
          <p className="text-ei-gold font-semibold text-base mb-2">
            La différence fondamentale
          </p>
          <p className="text-ei-muted text-sm leading-relaxed max-w-2xl mx-auto">
            Nos concurrents vendent des outils. Nous installons un système
            d'acquisition locale qui tourne automatiquement — et que personne
            d'autre dans votre ville ne peut utiliser.
          </p>
        </div>
      </div>
    </section>
  );
}
