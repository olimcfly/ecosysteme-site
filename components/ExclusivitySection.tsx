const closedCities = [
  { city: 'Bordeaux Métropole', advisor: 'Eduardo De Sul' },
  { city: 'Nantes', advisor: 'Brice Chupin' },
  { city: 'Aix-en-Provence', advisor: 'Pascal Hamm' },
  { city: 'Nandy / Sénart', advisor: 'Fatima Rabia' },
  { city: 'Lannion / Trégor', advisor: 'Stéphanie Hulen' },
]

export default function ExclusivitySection() {
  return (
    <section className="section-pad bg-navy-600">
      <div className="container-main">
        <div className="grid lg:grid-cols-2 gap-14 items-center">
          {/* Left: copy */}
          <div>
            <p className="text-xs font-semibold uppercase tracking-widest text-navy-200 mb-4">
              Exclusivité territoriale
            </p>
            <h2 className="text-3xl sm:text-4xl font-bold text-white mb-6 leading-tight">
              1 ville.{' '}
              <span className="text-gold-300">1 conseiller.</span>
              <br />
              Garanti par contrat.
            </h2>
            <p className="text-navy-200 text-lg leading-relaxed mb-8">
              L&apos;exclusivité territoriale est inscrite dans votre contrat.
              Une fois votre ville activée, aucun autre conseiller ne peut
              accéder au système sur votre secteur tant que vous êtes actif.
            </p>
            <a href="#verifier-ville" className="btn-primary bg-white text-navy-700 hover:bg-stone-50 !text-navy-800">
              Vérifier si ma ville est disponible
            </a>
          </div>

          {/* Right: closed cities */}
          <div>
            <p className="text-xs font-semibold uppercase tracking-widest text-navy-300 mb-5">
              Villes déjà fermées
            </p>
            <div className="flex flex-col gap-3">
              {closedCities.map(({ city, advisor }) => (
                <div
                  key={city}
                  className="flex items-center justify-between p-4 bg-navy-700 rounded-xl border border-navy-500"
                >
                  <div>
                    <p className="text-white font-semibold text-sm">{city}</p>
                    <p className="text-navy-300 text-xs mt-0.5">{advisor}</p>
                  </div>
                  <span className="flex items-center gap-1.5 text-red-400 text-xs font-semibold">
                    <span className="w-1.5 h-1.5 rounded-full bg-red-400" />
                    Fermé
                  </span>
                </div>
              ))}
              <div className="flex items-center justify-between p-4 bg-navy-700/50 rounded-xl border border-dashed border-navy-500">
                <p className="text-navy-300 text-sm">Votre ville…</p>
                <span className="flex items-center gap-1.5 text-emerald-400 text-xs font-semibold">
                  <span className="w-1.5 h-1.5 rounded-full bg-emerald-400" />
                  Peut-être disponible
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
