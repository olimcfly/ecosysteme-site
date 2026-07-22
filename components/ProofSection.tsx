const cases = [
  {
    city: 'Bordeaux Métropole',
    name: 'Eduardo De Sul',
    delivery: '18 jours',
    desc: 'Site local brandé, 6 pages secteurs, estimateur intégré, 3 articles SEO de démarrage, séquence email vendeurs.',
    note: 'Présence propriétaire sur Bordeaux — indépendante de son réseau.',
  },
  {
    city: 'Aix-en-Provence',
    name: 'Pascal Hamm',
    delivery: null,
    desc: 'Site brandé, pages services, estimateur, structure SEO locale.',
    note: 'Fondation digitale posée sur un marché à forte concurrence.',
  },
  {
    city: 'Nandy / Sénart',
    name: 'Fatima Rabia',
    delivery: null,
    desc: 'Site local humanisé, formulaire vendeur, pages secteurs.',
    note: 'Présence propriétaire sur son territoire d\'origine.',
  },
  {
    city: 'Lannion / Trégor',
    name: 'Stéphanie Hulen',
    delivery: null,
    desc: 'Site local, pages géographiques, contenus et formulaires.',
    note: 'Présence digitale ancrée dans l\'identité bretonne de son territoire.',
  },
  {
    city: 'Nantes',
    name: 'Brice Chupin',
    delivery: null,
    desc: 'Positionnement conseiller spécialisé rendu visible localement.',
    note: 'Présence différenciante sur Nantes.',
  },
]

export default function ProofSection() {
  return (
    <section id="realisations" className="section-pad bg-stone-50 border-y border-stone-100">
      <div className="container-main">
        {/* Header */}
        <div className="mb-12">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            Réalisations
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950 mb-3">
            Les territoires déjà installés.
          </h2>
          <p className="text-stone-500 text-lg">
            Cinq systèmes construits pour de vrais conseillers indépendants. Ces territoires sont désormais fermés.
          </p>
        </div>

        {/* Cards grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          {cases.map(({ city, name, delivery, desc, note }) => (
            <div
              key={name}
              className="bg-white border border-stone-200 rounded-xl p-6 flex flex-col gap-3"
            >
              <div className="flex items-start justify-between gap-2">
                <div>
                  <p className="font-semibold text-stone-900 text-base">{city}</p>
                  <p className="text-navy-600 text-sm font-medium">{name}</p>
                </div>
                {delivery && (
                  <span className="shrink-0 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full px-2.5 py-1 mt-0.5">
                    {delivery}
                  </span>
                )}
              </div>
              <p className="text-stone-600 text-sm leading-relaxed">{desc}</p>
              <p className="text-stone-400 text-xs leading-relaxed italic">{note}</p>
              <div className="mt-auto pt-3 border-t border-stone-100">
                <span className="text-xs text-red-500 font-medium flex items-center gap-1.5">
                  <span className="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0" />
                  Territoire complet
                </span>
              </div>
            </div>
          ))}

          {/* CTA card */}
          <div className="bg-navy-700 rounded-xl p-6 flex flex-col gap-4 justify-between">
            <div>
              <p className="text-white font-semibold text-base mb-2">
                Votre territoire est encore disponible ?
              </p>
              <p className="text-navy-300 text-sm leading-relaxed">
                La vérification est gratuite et sans engagement.
                Si votre ville est libre, vous recevez une confirmation sous 24h.
              </p>
            </div>
            <div>
              <a
                href="#verifier-ville"
                className="w-full text-center block py-3 px-4 bg-white text-navy-700 font-semibold rounded-lg hover:bg-stone-50 transition-colors text-sm"
              >
                Vérifier ma ville
              </a>
              <p className="text-center text-navy-400 text-xs mt-2">
                Sans engagement · Réponse sous 24h
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
