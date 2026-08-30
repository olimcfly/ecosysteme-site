const ADVISORS = [
  {
    name: 'Eduardo De Sul',
    territory: 'Bordeaux Métropole',
    city: 'Bordeaux',
  },
  {
    name: 'Pascal Hamm',
    territory: 'Aix-en-Provence',
    city: 'Aix-en-Provence',
  },
  {
    name: 'Fatima Rabia',
    territory: 'Nandy / Sénart',
    city: 'Nandy',
  },
  {
    name: 'Stéphanie Hulen',
    territory: 'Lannion / Trégor',
    city: 'Lannion',
  },
  {
    name: 'Brice Chupin',
    territory: 'Nantes',
    city: 'Nantes',
  },
]

function getInitials(name: string) {
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
}

export default function Proof() {
  return (
    <section id="realisations" className="py-24 md:py-32 bg-white">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
          <div className="max-w-xl">
            <p className="text-sm font-semibold text-gold uppercase tracking-wider mb-3">
              Déployé et actif
            </p>
            <h2 className="section-title mb-4">
              5 conseillers. 5 territoires. Tous opérationnels.
            </h2>
            <p className="text-lg text-gray-500">
              Ces cinq conseillers ont déjà verrouillé leur ville. Leurs territoires sont fermés définitivement aux nouvelles demandes.
            </p>
          </div>
          <div className="flex-shrink-0">
            <div className="inline-flex items-center gap-2 text-sm font-medium text-gray-500 border border-gray-200 rounded-full px-4 py-2">
              <span className="w-2 h-2 rounded-full bg-red-500" />
              Aucun de ces territoires n'est accessible
            </div>
          </div>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {ADVISORS.map((advisor) => (
            <div
              key={advisor.name}
              className="relative card flex items-start gap-4"
            >
              <div className="flex-shrink-0 w-12 h-12 rounded-xl bg-navy flex items-center justify-center">
                <span className="text-white text-sm font-bold">{getInitials(advisor.name)}</span>
              </div>
              <div className="min-w-0">
                <p className="font-semibold text-gray-900">{advisor.name}</p>
                <p className="text-gray-500 text-sm mt-0.5">{advisor.territory}</p>
                <span className="badge-closed mt-3">
                  <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                  </svg>
                  Territoire fermé
                </span>
              </div>
            </div>
          ))}

          <div className="card border-dashed border-2 border-gray-200 bg-gray-50 flex flex-col items-center justify-center text-center py-8 gap-3">
            <div className="w-12 h-12 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center">
              <span className="text-2xl font-bold text-gray-300">?</span>
            </div>
            <div>
              <p className="font-semibold text-gray-700">Votre ville</p>
              <p className="text-gray-400 text-sm mt-1">Disponible si personne ne l'a encore pris</p>
            </div>
          </div>
        </div>

        <div className="mt-8 text-center">
          <p className="text-sm text-gray-500 mb-1">
            Le Programme Fondateur (47€/mois à vie) est désormais complet.{' '}
            <span className="font-medium text-gray-700">
              Ces 5 conseillers en bénéficient encore aujourd'hui.
            </span>
          </p>
          <p className="text-xs text-gray-400">Les nouvelles entrées se font aux tarifs standards.</p>
        </div>
      </div>
    </section>
  )
}
