export default function Hero() {
  return (
    <section className="relative min-h-screen flex items-center grid-bg overflow-hidden pt-16">
      {/* Radial glow background */}
      <div
        aria-hidden="true"
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[700px] rounded-full pointer-events-none"
        style={{
          background:
            "radial-gradient(ellipse at center, rgba(200, 150, 42, 0.07) 0%, transparent 70%)",
        }}
      />
      {/* Bottom fade to next section */}
      <div
        aria-hidden="true"
        className="absolute bottom-0 left-0 right-0 h-32 pointer-events-none"
        style={{
          background: "linear-gradient(to bottom, transparent, #070D1A)",
        }}
      />

      <div className="relative max-w-5xl mx-auto px-4 py-20 text-center">
        {/* Urgency badge */}
        <div className="inline-flex items-center gap-2.5 bg-ei-card border border-ei-border rounded-full px-4 py-2 mb-10 text-sm">
          <span className="w-2 h-2 bg-green-400 rounded-full animate-pulse-slow flex-shrink-0" />
          <span className="text-ei-muted">
            Exclusivité territoriale — 1 ville, 1 seul conseiller
          </span>
        </div>

        {/* Main headline */}
        <h1 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-ei-text leading-[1.05] tracking-tight mb-6">
          Dominez votre marché local.
          <br />
          <span className="gold-text">Avant quelqu'un d'autre.</span>
        </h1>

        {/* Subheadline */}
        <p className="text-lg sm:text-xl text-ei-muted leading-relaxed max-w-2xl mx-auto mb-10">
          Le système clé-en-main pour générer des vendeurs qualifiés dans votre
          ville. Site SEO local, estimateur propriétaire, CRM automatisé, IA
          conversationnelle — configuré en 48h.
        </p>

        {/* CTAs */}
        <div className="flex flex-col sm:flex-row gap-3 justify-center items-center mb-5">
          <a
            href="#verifier-ma-ville"
            className="w-full sm:w-auto bg-ei-gold hover:bg-ei-gold-light text-ei-bg font-bold text-base sm:text-lg px-8 py-4 rounded-xl transition-colors duration-200 inline-flex items-center justify-center gap-2"
          >
            Vérifier si ma ville est disponible
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
          <a
            href="#comment-ca-marche"
            className="w-full sm:w-auto border border-ei-border hover:border-ei-gold/50 text-ei-muted hover:text-ei-text px-8 py-4 rounded-xl transition-colors duration-200 text-base sm:text-lg text-center"
          >
            Voir comment ça fonctionne
          </a>
        </div>

        {/* Trust indicators */}
        <p className="text-ei-faint text-sm">
          Vérification gratuite · Sans engagement · Réponse immédiate
        </p>

        {/* Stats */}
        <div className="mt-16 grid grid-cols-3 gap-6 max-w-md mx-auto">
          {[
            { value: "47+", label: "Conseillers actifs" },
            { value: "5", label: "Villes déjà fermées" },
            { value: "30j", label: "Pour vos premiers leads" },
          ].map((stat) => (
            <div key={stat.label} className="text-center">
              <div className="text-2xl sm:text-3xl font-bold text-ei-gold">
                {stat.value}
              </div>
              <div className="text-xs sm:text-sm text-ei-muted mt-1">
                {stat.label}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
