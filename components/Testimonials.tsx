const items = [
  {
    initials: 'TR',
    name: 'Thomas R.',
    role: 'Agent mandataire indépendant',
    territory: 'Loire-Atlantique',
    metric: '+4 mandats',
    metricLabel: 'en 3 mois',
    quote:
      'En 6 semaines, j\'ai eu mes premiers contacts entrants via l\'estimateur. Avant, je courais après les mandats. Maintenant ils viennent à moi.',
  },
  {
    initials: 'SM',
    name: 'Sophie M.',
    role: 'Conseillère immobilière',
    territory: 'Région parisienne',
    metric: '100%',
    metricLabel: 'leads qualifiés',
    quote:
      'L\'exclusivité territoriale change vraiment la donne. Je sais qu\'aucun concurrent ne peut utiliser le même système sur mon secteur. C\'est un avantage concret, pas marketing.',
  },
  {
    initials: 'JD',
    name: 'Julien D.',
    role: 'Agent indépendant',
    territory: 'Occitanie',
    metric: '10 jours',
    metricLabel: 'pour être opérationnel',
    quote:
      'Le setup est rapide. En moins de 2 semaines j\'étais en ligne avec un site qui ressemble vraiment à quelque chose de professionnel. Le CRM m\'a fait gagner des heures chaque semaine.',
  },
]

export default function Testimonials() {
  return (
    <section className="section-pad bg-white border-t border-stone-100">
      <div className="container-main">
        <div className="max-w-xl mb-12">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            Retours terrain
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950">
            Ce que disent les conseillers déployés.
          </h2>
        </div>

        <div className="grid sm:grid-cols-3 gap-6">
          {items.map(({ initials, name, role, territory, metric, metricLabel, quote }) => (
            <div
              key={name}
              className="flex flex-col gap-6 p-6 bg-stone-50 border border-stone-200 rounded-2xl"
            >
              {/* Metric */}
              <div>
                <p className="text-3xl font-bold text-navy-600">{metric}</p>
                <p className="text-stone-500 text-sm">{metricLabel}</p>
              </div>

              {/* Quote */}
              <blockquote className="text-stone-700 text-sm leading-relaxed flex-1">
                &ldquo;{quote}&rdquo;
              </blockquote>

              {/* Author */}
              <div className="flex items-center gap-3 pt-4 border-t border-stone-200">
                <div className="w-8 h-8 rounded-full bg-navy-100 flex items-center justify-center shrink-0">
                  <span className="text-navy-700 text-xs font-bold">{initials}</span>
                </div>
                <div>
                  <p className="text-stone-900 text-sm font-semibold">{name}</p>
                  <p className="text-stone-400 text-xs">{role} · {territory}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
