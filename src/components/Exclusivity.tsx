const takenCities = [
  { name: 'Bordeaux', code: 'BDX' },
  { name: 'Nantes', code: 'NTS' },
  { name: 'Nandy', code: 'NDY' },
  { name: 'Aix-en-Provence', code: 'AIX' },
  { name: 'Lannion', code: 'LAN' },
]

const points = [
  {
    title: 'Votre SEO local vous appartient',
    body: 'Votre site est optimisé pour votre ville et vos quartiers. Les vendeurs qui cherchent un conseiller localement vous trouvent vous — pas un concurrent utilisant le même système.',
  },
  {
    title: 'Un avantage qui se creuse dans le temps',
    body: 'Plus votre présence locale est ancienne, plus elle est forte. Chaque mois renforce votre position sur Google et creuse l\'écart avec les nouveaux entrants.',
  },
  {
    title: 'Réservez avant qu\'un concurrent ne le fasse',
    body: 'Les villes sont attribuées dans l\'ordre des demandes. Une fois votre ville prise par un autre conseiller, elle est définitivement fermée pour vous.',
  },
]

export default function Exclusivity() {
  return (
    <section className="py-20 px-5 sm:px-6 bg-white">
      <div className="max-w-5xl mx-auto">
        <div className="text-center mb-14">
          <div className="text-emerald-600 text-xs font-semibold uppercase tracking-widest mb-4">
            Exclusivité territoriale
          </div>
          <h2 className="text-3xl sm:text-4xl font-bold text-gray-900 mb-4 leading-tight">
            1 ville. 1 conseiller. 0 concurrent dans le système.
          </h2>
          <p className="text-gray-500 text-lg max-w-2xl mx-auto">
            Quand vous rejoignez Ecosystème Immo, votre territoire vous est réservé. Aucun autre
            conseiller ne peut accéder au même système dans votre zone.
          </p>
        </div>

        <div className="grid md:grid-cols-2 gap-10 items-start">

          {/* Left */}
          <div className="space-y-7">
            {points.map((p, i) => (
              <div key={i} className="flex gap-4">
                <div className="w-1 flex-shrink-0 bg-emerald-500 rounded-full self-stretch min-h-[3rem]" />
                <div>
                  <h3 className="font-semibold text-gray-900 text-base mb-1.5">{p.title}</h3>
                  <p className="text-gray-500 text-sm leading-relaxed">{p.body}</p>
                </div>
              </div>
            ))}

            <a
              href="#disponibilite"
              className="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-5 py-3 rounded-xl hover:bg-emerald-700 transition-colors text-sm mt-2"
            >
              Vérifier si ma ville est disponible
              <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </a>
          </div>

          {/* Right */}
          <div className="bg-gray-50 border border-gray-200 rounded-2xl p-6">
            <p className="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">
              Villes actuellement fermées
            </p>
            <div className="space-y-2.5">
              {takenCities.map((city) => (
                <div
                  key={city.name}
                  className="flex items-center justify-between py-3 px-4 bg-white border border-gray-200 rounded-xl"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 bg-red-50 border border-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <span className="text-[10px] font-bold text-red-500 tracking-wide">
                        {city.code}
                      </span>
                    </div>
                    <span className="font-medium text-gray-900 text-sm">{city.name}</span>
                  </div>
                  <span className="text-[11px] bg-red-50 text-red-600 border border-red-100 px-2.5 py-1 rounded-full font-semibold">
                    Fermé
                  </span>
                </div>
              ))}
            </div>
            <div className="mt-5 pt-4 border-t border-gray-200 text-center">
              <p className="text-xs text-gray-400">
                Votre ville est peut-être encore disponible.
              </p>
              <a
                href="#disponibilite"
                className="inline-block mt-2 text-xs text-emerald-600 font-medium hover:underline"
              >
                Vérifier maintenant
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>
  )
}
