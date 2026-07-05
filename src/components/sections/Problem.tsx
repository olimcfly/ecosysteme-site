const pains = [
  {
    title: "Invisible sur Google",
    body: "Les grandes agences accaparent les premières positions locales. Votre présence digitale ne suffit pas à capter les vendeurs en phase de recherche.",
  },
  {
    title: "Le bouche-à-oreille s'épuise",
    body: "Les recommandations existent, mais elles ne suffisent plus à alimenter un flux régulier de mandats. Vous dépendez d'un réseau qui ne croît pas assez vite.",
  },
  {
    title: "Pas de système de génération",
    body: "Sans outil structuré pour attirer, qualifier et suivre les vendeurs, chaque mandat reste une victoire isolée — pas un flux prévisible.",
  },
  {
    title: "Budget incomparable aux réseaux",
    body: "Les franchises dépensent des milliers d'euros en publicité locale. En tant qu'indépendant, vous ne pouvez pas rivaliser sur le même terrain.",
  },
];

export default function Problem() {
  return (
    <section className="section-padding bg-white">
      <div className="container-site">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
          <div className="lg:sticky lg:top-28">
            <p
              className="text-xs font-semibold uppercase tracking-widest mb-4"
              style={{ color: "var(--accent-blue)" }}
            >
              Le constat
            </p>
            <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-6 text-balance">
              Le marché a changé. Les vendeurs ne cherchent plus les
              conseillers comme avant.
            </h2>
            <p className="text-slate-500 text-lg leading-relaxed mb-8">
              En 2025, 78% des propriétaires commencent leur recherche de conseiller
              immobilier en ligne. Si vous n&apos;apparaissez pas dans leur zone,
              vous n&apos;existez pas — quelles que soient votre expertise et vos résultats.
            </p>
            <div
              className="p-5 rounded-xl border-l-4"
              style={{
                borderColor: "var(--accent-amber)",
                background: "rgba(217,119,6,0.06)",
              }}
            >
              <p className="text-slate-700 text-sm font-medium">
                &ldquo;Les meilleurs conseillers indépendants ne manquent pas de compétence.
                Ils manquent de visibilité systématique et de processus d&apos;acquisition.&rdquo;
              </p>
            </div>
          </div>

          <div className="space-y-4">
            {pains.map((p, i) => (
              <div
                key={i}
                className="p-6 rounded-xl border border-slate-100 hover:border-slate-200 hover:shadow-sm transition-all"
              >
                <div className="flex items-start gap-4">
                  <div
                    className="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                    style={{ background: "#fef2f2" }}
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth={2}
                      stroke="#ef4444"
                      className="w-4 h-4"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                      />
                    </svg>
                  </div>
                  <div>
                    <h3 className="font-semibold text-slate-900 mb-1.5">
                      {p.title}
                    </h3>
                    <p className="text-slate-500 text-sm leading-relaxed">
                      {p.body}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
