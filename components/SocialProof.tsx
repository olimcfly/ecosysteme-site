const TESTIMONIALS = [
  {
    quote: "En 6 semaines, j'ai eu mes premiers contacts entrants via l'estimateur. Avant, je courais après les mandats. Maintenant ils viennent à moi.",
    name: 'Thomas R.',
    role: 'Agent mandataire indépendant',
    location: 'Loire-Atlantique',
    metric: '+4 mandats',
    metricLabel: 'en 3 mois',
  },
  {
    quote: "L'exclusivité territoriale change vraiment la donne. Je sais qu'aucun concurrent ne peut utiliser le même système sur mon secteur. C'est un avantage concret, pas marketing.",
    name: 'Sophie M.',
    role: 'Conseillère immobilière',
    location: 'Région parisienne',
    metric: '100%',
    metricLabel: 'leads qualifiés',
  },
  {
    quote: "Le setup est rapide. En moins de 2 semaines j'étais en ligne avec un site qui ressemble vraiment à quelque chose de professionnel. Le CRM m'a fait gagner des heures chaque semaine.",
    name: 'Julien D.',
    role: 'Agent indépendant',
    location: 'Occitanie',
    metric: '10 jours',
    metricLabel: 'pour être opérationnel',
  },
]

export default function SocialProof() {
  return (
    <section className="py-20 sm:py-28 bg-slate-50">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mx-auto text-center mb-14">
          <span className="section-label">Ils ont activé leur territoire</span>
          <h2 className="section-title mb-4">Ce que ça change concrètement</h2>
          <p className="section-sub">
            Des conseillers indépendants qui ont choisi de dominer leur marché local plutôt que de subir la concurrence des réseaux.
          </p>
        </div>

        <div className="grid sm:grid-cols-3 gap-6">
          {TESTIMONIALS.map(({ quote, name, role, location, metric, metricLabel }) => (
            <div key={name} className="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 flex flex-col">
              <div className="mb-5">
                <div className="text-3xl font-bold text-slate-900">{metric}</div>
                <div className="text-xs text-slate-400 font-medium">{metricLabel}</div>
              </div>
              <p className="text-slate-600 text-sm leading-relaxed flex-1 mb-6">
                &ldquo;{quote}&rdquo;
              </p>
              <div className="border-t border-slate-100 pt-5">
                <p className="font-semibold text-slate-900 text-sm">{name}</p>
                <p className="text-slate-400 text-xs mt-0.5">{role} · {location}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
