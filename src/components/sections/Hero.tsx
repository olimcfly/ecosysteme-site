interface HeroProps {
  onCTA: () => void;
}

export default function Hero({ onCTA }: HeroProps) {
  return (
    <section
      className="relative min-h-screen flex flex-col"
      style={{ background: "var(--navy-900)" }}
    >
      {/* Urgency bar */}
      <div
        className="relative z-10 py-2.5 px-4 text-center text-sm font-medium"
        style={{ background: "var(--accent-amber)", color: "#451a03" }}
      >
        <span className="font-semibold">5 villes déjà fermées ce mois</span>
        {" — "}
        Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
      </div>

      {/* Hero content */}
      <div className="flex-1 flex items-center pt-16">
        <div className="container-site py-20 lg:py-28">
          <div className="max-w-3xl">
            <div
              className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-8 border"
              style={{
                background: "rgba(37,99,235,0.15)",
                color: "#93c5fd",
                borderColor: "rgba(37,99,235,0.3)",
              }}
            >
              <span className="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse" />
              Exclusivité territoriale — 1 ville, 1 conseiller
            </div>

            <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 text-balance leading-tight">
              Attirez des vendeurs qualifiés dans votre ville.
              <span
                className="block mt-1"
                style={{ color: "var(--accent-amber-light)" }}
              >
                Avant que ce soit trop tard.
              </span>
            </h1>

            <p className="text-lg sm:text-xl text-slate-300 mb-10 max-w-2xl leading-relaxed">
              Ecosystème Immo vous donne un système complet d&apos;acquisition locale —
              site optimisé, SEO local, CRM et automatisations IA. Réservé à un seul
              conseiller par territoire.
            </p>

            <div className="flex flex-col sm:flex-row gap-4 mb-12">
              <button
                onClick={onCTA}
                className="group inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl text-base font-semibold text-white transition-all hover:opacity-90 active:scale-95 shadow-lg"
                style={{ background: "var(--accent-blue)" }}
              >
                Vérifier la disponibilité de ma ville
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  strokeWidth={2.5}
                  stroke="currentColor"
                  className="w-4 h-4 group-hover:translate-x-0.5 transition-transform"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                  />
                </svg>
              </button>

              <a
                href="#tarifs"
                className="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-base font-semibold transition-colors border"
                style={{
                  color: "var(--accent-amber-light)",
                  borderColor: "rgba(245,158,11,0.3)",
                  background: "rgba(245,158,11,0.07)",
                }}
              >
                Voir les tarifs
              </a>
            </div>

            <div className="flex flex-col sm:flex-row gap-6 sm:gap-10">
              {[
                { value: "7 jours", label: "pour être opérationnel" },
                { value: "1 seul", label: "conseiller par ville" },
                { value: "100%", label: "clé en main" },
              ].map((stat) => (
                <div key={stat.label} className="flex items-center gap-3">
                  <div
                    className="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                    style={{ background: "rgba(37,99,235,0.15)" }}
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth={2}
                      stroke="#60a5fa"
                      className="w-4.5 h-4.5"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <div>
                    <div className="text-white font-bold text-sm">{stat.value}</div>
                    <div className="text-slate-400 text-xs">{stat.label}</div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Bottom fade */}
      <div
        className="absolute bottom-0 left-0 right-0 h-32 pointer-events-none"
        style={{
          background: "linear-gradient(to bottom, transparent, rgba(12,27,58,0.5))",
        }}
      />
    </section>
  );
}
