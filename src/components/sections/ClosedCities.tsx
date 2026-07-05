interface ClosedCitiesProps {
  onCTA: () => void;
}

const closedCities = [
  { name: "Bordeaux", region: "Gironde (33)" },
  { name: "Nantes", region: "Loire-Atlantique (44)" },
  { name: "Nandy", region: "Seine-et-Marne (77)" },
  { name: "Aix-en-Provence", region: "Bouches-du-Rhône (13)" },
  { name: "Lannion", region: "Côtes-d'Armor (22)" },
];

export default function ClosedCities({ onCTA }: ClosedCitiesProps) {
  return (
    <section className="section-padding bg-white">
      <div className="container-site">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
          <div>
            <p
              className="text-xs font-semibold uppercase tracking-widest mb-4"
              style={{ color: "#ef4444" }}
            >
              Villes fermées
            </p>
            <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-5 text-balance">
              Ces territoires sont déjà occupés.
            </h2>
            <p className="text-slate-500 text-lg leading-relaxed mb-8">
              Un conseiller a déjà réservé l&apos;exclusivité sur ces villes.
              Les vendeurs locaux ne peuvent contacter qu&apos;eux via le système.
              Vérifiez votre ville avant qu&apos;il soit trop tard.
            </p>

            <button
              onClick={onCTA}
              className="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl font-semibold text-white transition-all hover:opacity-90 active:scale-95"
              style={{ background: "var(--accent-blue)" }}
            >
              Vérifier si ma ville est disponible
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth={2}
                stroke="currentColor"
                className="w-4 h-4"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                />
              </svg>
            </button>
          </div>

          <div className="space-y-3">
            {closedCities.map((city) => (
              <div
                key={city.name}
                className="flex items-center justify-between p-4 rounded-xl border"
                style={{
                  borderColor: "rgba(239,68,68,0.15)",
                  background: "rgba(239,68,68,0.02)",
                }}
              >
                <div className="flex items-center gap-3">
                  <div
                    className="w-2.5 h-2.5 rounded-full flex-shrink-0"
                    style={{ background: "#ef4444" }}
                  />
                  <div>
                    <div className="font-semibold text-slate-900 text-sm">
                      {city.name}
                    </div>
                    <div className="text-xs" style={{ color: "var(--text-muted)" }}>
                      {city.region}
                    </div>
                  </div>
                </div>
                <span
                  className="text-xs font-semibold px-2.5 py-1 rounded-full"
                  style={{
                    background: "rgba(239,68,68,0.08)",
                    color: "#ef4444",
                  }}
                >
                  Fermé
                </span>
              </div>
            ))}

            <div
              className="flex items-center justify-between p-4 rounded-xl border mt-2"
              style={{
                borderColor: "rgba(37,99,235,0.2)",
                background: "rgba(37,99,235,0.03)",
              }}
            >
              <div className="flex items-center gap-3">
                <div
                  className="w-2.5 h-2.5 rounded-full flex-shrink-0 animate-pulse"
                  style={{ background: "var(--accent-blue)" }}
                />
                <span className="font-medium text-slate-700 text-sm">
                  Votre ville ?
                </span>
              </div>
              <button
                onClick={onCTA}
                className="text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors"
                style={{
                  background: "var(--accent-blue)",
                  color: "white",
                }}
              >
                Vérifier
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
