const steps = [
  {
    number: "01",
    title: "Vous réservez votre ville",
    body: "Vérifiez la disponibilité de votre territoire, choisissez votre formule et sécurisez votre exclusivité. L'accès est limité à un seul conseiller par ville.",
    detail: "Disponibilité vérifiée en temps réel",
  },
  {
    number: "02",
    title: "Votre système est activé",
    body: "En 7 jours, votre site est en ligne, votre SEO local configuré, votre CRM prêt. Tout est paramétré selon votre zone géographique et votre positionnement.",
    detail: "Activation en 7 jours ouvrés",
  },
  {
    number: "03",
    title: "Les vendeurs vous trouvent",
    body: "Votre système travaille en continu. Les vendeurs locaux vous trouvent sur Google, remplissent votre estimateur, et entrent automatiquement dans votre pipeline de qualification.",
    detail: "Flux de leads passif et continu",
  },
];

export default function HowItWorks() {
  return (
    <section id="fonctionnement" className="section-padding bg-white">
      <div className="container-site">
        <div className="text-center max-w-2xl mx-auto mb-14">
          <p
            className="text-xs font-semibold uppercase tracking-widest mb-4"
            style={{ color: "var(--accent-blue)" }}
          >
            Comment ça marche
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-5 text-balance">
            Opérationnel en 7 jours. Sans vous occuper du technique.
          </h2>
        </div>

        <div className="relative">
          {/* Connector line — desktop only */}
          <div
            className="hidden lg:block absolute top-16 left-[16.66%] right-[16.66%] h-px"
            style={{ background: "var(--border)" }}
            aria-hidden="true"
          />

          <div className="grid lg:grid-cols-3 gap-8">
            {steps.map((step, i) => (
              <div key={i} className="relative text-center lg:text-left">
                <div className="flex flex-col lg:flex-row items-center lg:items-start gap-5">
                  <div
                    className="flex-shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center relative z-10"
                    style={{
                      background: "var(--navy-900)",
                      border: "4px solid white",
                      boxShadow: "0 0 0 1px var(--border)",
                    }}
                  >
                    <span className="text-white font-bold text-lg leading-none">
                      {step.number}
                    </span>
                  </div>
                  <div className="flex-1">
                    <div
                      className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium mb-3"
                      style={{
                        background: "var(--surface-alt)",
                        color: "var(--text-muted)",
                      }}
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={2}
                        stroke="currentColor"
                        className="w-3 h-3"
                        style={{ color: "var(--accent-blue)" }}
                      >
                        <path
                          strokeLinecap="round"
                          strokeLinejoin="round"
                          d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      {step.detail}
                    </div>
                    <h3 className="text-xl font-bold text-slate-900 mb-3">
                      {step.title}
                    </h3>
                    <p className="text-slate-500 leading-relaxed text-sm">
                      {step.body}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div
          className="mt-14 grid sm:grid-cols-3 gap-5 p-6 rounded-2xl"
          style={{ background: "var(--surface-alt)" }}
        >
          {[
            { label: "Délai d'activation", value: "7 jours" },
            { label: "Configuration technique", value: "Entièrement gérée" },
            { label: "Suivi et optimisation", value: "Inclus" },
          ].map((item) => (
            <div key={item.label} className="text-center">
              <div className="text-2xl font-bold text-slate-900 mb-1">
                {item.value}
              </div>
              <div className="text-sm text-slate-500">{item.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
