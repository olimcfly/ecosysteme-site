const cases = [
  {
    city: 'Bordeaux Métropole',
    name: 'Eduardo De Sul',
    desc: 'Site local, pages secteurs, estimateur, blog SEO et capture de leads vendeurs sur la métropole bordelaise.',
  },
  {
    city: 'Aix-en-Provence',
    name: 'Pascal Hamm',
    desc: 'Site brandé, structure de pages, estimation, secteurs et base de contenu immobilier local.',
  },
  {
    city: 'Nandy / Sénart',
    name: 'Fatima Rabia',
    desc: 'Site local, formulaire vendeur, pages secteurs et présence digitale centrée sur son territoire.',
  },
  {
    city: 'Lannion / Trégor',
    name: 'Stéphanie Hulen',
    desc: 'Site local, ressources, contenus et base digitale pour renforcer la visibilité en Bretagne.',
  },
  {
    city: 'Nantes',
    name: 'Brice Chupin',
    desc: 'Présence digitale locale autour de son positionnement de conseiller spécialisé.',
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
            Déjà actif dans 5 villes.
          </h2>
          <p className="text-stone-500 text-lg">
            Des systèmes construits pour de vrais conseillers indépendants. Pas une démonstration.
          </p>
        </div>

        {/* Cards grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          {cases.map(({ city, name, desc }) => (
            <div
              key={name}
              className="bg-white border border-stone-200 rounded-xl p-6 flex flex-col gap-3"
            >
              <div>
                <p className="font-semibold text-stone-900 text-base">{city}</p>
                <p className="text-navy-600 text-sm font-medium">{name}</p>
              </div>
              <p className="text-stone-500 text-sm leading-relaxed">{desc}</p>
              <div className="mt-auto pt-3 border-t border-stone-100">
                <span className="text-xs text-stone-400 font-medium flex items-center gap-1.5">
                  <span className="w-1.5 h-1.5 rounded-full bg-red-400" />
                  Ville fermée
                </span>
              </div>
            </div>
          ))}

          {/* CTA card */}
          <div className="bg-navy-600 rounded-xl p-6 flex flex-col gap-4 justify-between">
            <div>
              <p className="text-white font-semibold text-base mb-2">
                Votre ville ?
              </p>
              <p className="text-navy-200 text-sm leading-relaxed">
                Il reste des territoires disponibles. Vérifiez le vôtre maintenant.
              </p>
            </div>
            <a
              href="#verifier-ville"
              className="btn-primary bg-white text-navy-700 hover:bg-stone-50 !text-sm !py-3"
            >
              Vérifier ma ville
            </a>
          </div>
        </div>
      </div>
    </section>
  )
}
