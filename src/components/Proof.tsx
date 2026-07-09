export default function Proof() {
  const testimonials = [
    {
      quote: 'En 3 mois, j\'ai commencé à recevoir des demandes d\'estimation sans prospecter. Le SEO local a changé complètement mon activité.',
      name: 'Marc D.',
      location: 'Conseiller indépendant — Rennes',
      metric: '12 mandats',
      metricLabel: 'en 90 jours',
    },
    {
      quote: 'L\'exclusivité territoriale, c\'est ce qui m\'a convaincu. Je sais qu\'aucun collègue ne peut utiliser le même système sur ma ville.',
      name: 'Sophie L.',
      location: 'Conseillère indépendante — Tours',
      metric: '100%',
      metricLabel: 'leads locaux qualifiés',
    },
    {
      quote: 'Le CRM et les relances automatiques me font gagner 2h par jour. Les prospects sont chauds quand je les rappelle.',
      name: 'Julien M.',
      location: 'Conseiller indépendant — Angers',
      metric: '–2h',
      metricLabel: 'de prospection par jour',
    },
  ];

  return (
    <section className="py-24 px-4">
      <div className="max-w-5xl mx-auto">
        <div className="text-center mb-16">
          <p className="text-blue-400 text-sm font-medium uppercase tracking-wider mb-3">Résultats</p>
          <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4">
            Ce que disent les conseillers actifs
          </h2>
        </div>

        <div className="grid sm:grid-cols-3 gap-5">
          {testimonials.map((t) => (
            <div
              key={t.name}
              className="p-6 rounded-2xl bg-white/[0.03] border border-white/[0.07] flex flex-col"
            >
              {/* Quote mark */}
              <div className="text-blue-600 text-4xl font-serif leading-none mb-4">"</div>

              <p className="text-slate-300 text-sm leading-relaxed flex-1 mb-6">{t.quote}</p>

              <div className="border-t border-white/5 pt-4 flex items-center justify-between gap-3">
                <div>
                  <div className="text-white text-sm font-medium">{t.name}</div>
                  <div className="text-slate-500 text-xs mt-0.5">{t.location}</div>
                </div>
                <div className="text-right">
                  <div className="text-blue-300 font-bold text-sm">{t.metric}</div>
                  <div className="text-slate-600 text-xs">{t.metricLabel}</div>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Trust signals */}
        <div className="mt-14 grid grid-cols-2 sm:grid-cols-4 gap-4">
          {[
            { value: '47+', label: 'villes actives' },
            { value: '4,8/5', label: 'note moyenne' },
            { value: '72h', label: 'délai d\'activation' },
            { value: '0%', label: 'sans engagement annuel' },
          ].map((item) => (
            <div key={item.label} className="text-center p-5 rounded-xl bg-white/[0.03] border border-white/[0.07]">
              <div className="text-2xl font-bold text-white mb-1">{item.value}</div>
              <div className="text-xs text-slate-500">{item.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
