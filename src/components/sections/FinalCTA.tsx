interface FinalCTAProps {
  onCTA: () => void;
}

export default function FinalCTA({ onCTA }: FinalCTAProps) {
  return (
    <section
      className="section-padding relative overflow-hidden"
      style={{ background: "var(--navy-950)" }}
    >
      <div
        className="absolute inset-0 opacity-5 pointer-events-none"
        style={{
          backgroundImage:
            "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
          backgroundSize: "40px 40px",
        }}
        aria-hidden="true"
      />

      <div className="container-site relative z-10 text-center">
        <div
          className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-8 border"
          style={{
            background: "rgba(245,158,11,0.12)",
            color: "#fbbf24",
            borderColor: "rgba(245,158,11,0.25)",
          }}
        >
          <span className="w-1.5 h-1.5 rounded-full animate-pulse" style={{ background: "#f59e0b" }} />
          Places limitées par zone géographique
        </div>

        <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6 text-balance max-w-3xl mx-auto">
          Vérifiez si votre ville est encore disponible.
        </h2>

        <p className="text-slate-300 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
          L&apos;exclusivité est attribuée à la première demande. Une fois une ville réservée,
          elle ne peut plus être attribuée à un autre conseiller.
        </p>

        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-12">
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
        </div>

        <div
          className="inline-flex items-center gap-3 p-4 rounded-xl border"
          style={{
            background: "rgba(255,255,255,0.04)",
            borderColor: "rgba(255,255,255,0.08)",
          }}
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth={2}
            stroke="#94a3b8"
            className="w-4 h-4 flex-shrink-0"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
            />
          </svg>
          <span className="text-slate-400 text-sm">
            Une question ?{" "}
            <a
              href="mailto:contact@ecosystemeimmo.fr"
              className="text-slate-200 hover:text-white underline underline-offset-2 transition-colors"
            >
              contact@ecosystemeimmo.fr
            </a>
          </span>
        </div>
      </div>
    </section>
  );
}
