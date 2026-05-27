const STEPS = [
  {
    step: "01",
    title: "Vérifiez votre ville",
    duration: "2 minutes",
    body: "Saisissez votre ville dans le vérificateur. Si elle est disponible, vous réservez votre exclusivité territoriale. Si elle est fermée, vous rejoignez la liste de priorité.",
    detail: "Disponibilité vérifiée en temps réel",
  },
  {
    step: "02",
    title: "Votre système est configuré",
    duration: "5–7 jours ouvrés",
    body: "Nous configurons l'ensemble du système pour votre territoire : site SEO local, CRM paramétré, automatisations email et SMS, IA de traitement des demandes entrantes.",
    detail: "Aucune compétence technique requise",
  },
  {
    step: "03",
    title: "Les vendeurs vous trouvent",
    duration: "Dès le premier mois",
    body: "Google indexe votre ville, vos pages locales remontent sur les requêtes de vendeurs. Les demandes entrent dans le CRM. Le système les traite, les qualifie, vous alerte.",
    detail: "Machine d'acquisition active 24h/24",
  },
];

export function HowItWorks() {
  return (
    <section id="comment-ca-marche" className="bg-[#F8F7F4] py-20 sm:py-28">
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="max-w-2xl mb-16">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Comment ça marche
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mb-4 text-balance">
            De zéro à une machine d'acquisition locale
            <br />
            <span className="text-slate-400">en moins de 7 jours.</span>
          </h2>
        </div>

        {/* Steps */}
        <div className="relative">
          {/* Vertical line — desktop */}
          <div className="hidden md:block absolute left-[2.75rem] top-8 bottom-8 w-px bg-[#1C2333]" />

          <div className="space-y-8">
            {STEPS.map((s, i) => (
              <div key={s.step} className="flex gap-6 md:gap-8">
                {/* Step number circle */}
                <div className="flex-shrink-0 w-[5.5rem] flex flex-col items-center">
                  <div className="w-14 h-14 rounded-full bg-[#07090F] border border-[#1C2333] flex items-center justify-center">
                    <span className="text-[#C8A84B] font-bold text-sm">{s.step}</span>
                  </div>
                  {i < STEPS.length - 1 && (
                    <div className="flex-1 w-px bg-[#1C2333] mt-3 md:hidden" />
                  )}
                </div>

                {/* Content */}
                <div className="flex-1 pb-2">
                  <div className="flex flex-wrap items-center gap-2 mb-2">
                    <h3 className="text-slate-900 font-semibold text-lg leading-snug">
                      {s.title}
                    </h3>
                    <span className="bg-slate-100 text-slate-500 text-xs font-medium px-2.5 py-0.5 rounded-full">
                      {s.duration}
                    </span>
                  </div>
                  <p className="text-slate-500 text-sm leading-relaxed mb-3 max-w-xl">
                    {s.body}
                  </p>
                  <span className="inline-flex items-center gap-1.5 text-[#C8A84B] text-xs font-medium">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                      <path
                        d="M2 6l3 3 5-5"
                        stroke="currentColor"
                        strokeWidth="1.5"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                      />
                    </svg>
                    {s.detail}
                  </span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
