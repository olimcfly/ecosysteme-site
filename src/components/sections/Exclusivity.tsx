export default function Exclusivity() {
  return (
    <section
      className="section-padding relative overflow-hidden"
      style={{ background: "var(--navy-900)" }}
    >
      {/* Background texture */}
      <div
        className="absolute inset-0 opacity-5 pointer-events-none"
        style={{
          backgroundImage:
            "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
          backgroundSize: "40px 40px",
        }}
        aria-hidden="true"
      />

      <div className="container-site relative z-10">
        <div className="max-w-3xl mx-auto text-center">
          <div
            className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-8 border"
            style={{
              background: "rgba(245,158,11,0.12)",
              color: "#fbbf24",
              borderColor: "rgba(245,158,11,0.25)",
            }}
          >
            Le principe fondamental
          </div>

          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-8 text-balance">
            1 ville.{" "}
            <span style={{ color: "var(--accent-amber-light)" }}>
              1 conseiller.
            </span>{" "}
            C&apos;est la règle.
          </h2>

          <p className="text-slate-300 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            Nous n&apos;attribuons jamais le même territoire à deux conseillers différents.
            Une fois votre ville réservée, vous êtes le seul à bénéficier de ce système
            dans votre zone — vos concurrents ne peuvent pas y accéder.
          </p>

          <div className="grid sm:grid-cols-3 gap-4">
            {[
              {
                title: "Aucun concurrent local",
                body: "Pas de dilution de votre visibilité. Votre territoire vous appartient.",
              },
              {
                title: "Avantage durable",
                body: "Plus tôt vous entrez, plus longtemps vous gardez l'exclusivité.",
              },
              {
                title: "Positionnement ancré",
                body: "Votre autorité locale se renforce avec le temps. L'écart se creuse.",
              },
            ].map((card) => (
              <div
                key={card.title}
                className="p-5 rounded-xl border text-left"
                style={{
                  background: "rgba(255,255,255,0.04)",
                  borderColor: "rgba(255,255,255,0.1)",
                }}
              >
                <div
                  className="w-8 h-8 rounded-lg flex items-center justify-center mb-4"
                  style={{ background: "rgba(37,99,235,0.2)" }}
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth={2}
                    stroke="#60a5fa"
                    className="w-4 h-4"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                    />
                  </svg>
                </div>
                <h3 className="text-white font-semibold mb-2 text-sm">
                  {card.title}
                </h3>
                <p className="text-slate-400 text-sm leading-relaxed">{card.body}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
