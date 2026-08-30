const components = [
  {
    n: '1',
    title: 'Site professionnel local',
    desc: 'Un site à votre nom, optimisé pour convertir des visiteurs en contacts vendeurs. Mobile-first, rapide, brandé à votre identité.',
  },
  {
    n: '2',
    title: 'SEO local + pages secteurs',
    desc: 'Des pages dédiées à vos communes et quartiers, optimisées pour apparaître sur les requêtes locales à fort potentiel vendeur.',
  },
  {
    n: '3',
    title: 'Google Business Profile',
    desc: 'Fiche Google optimisée, cohérente avec votre site. Indispensable pour apparaître sur Google Maps quand un vendeur cherche dans votre secteur.',
  },
  {
    n: '4',
    title: 'CRM prospects intégré',
    desc: 'Suivi clair de chaque contact vendeur : statut, historique, prochaine action. Tout centralisé, rien de dispersé entre vos outils.',
  },
  {
    n: '5',
    title: 'Automatisations et séquences',
    desc: 'Relances email automatiques, rappels, nurturing. Vous restez présent auprès de vos prospects sans y penser.',
  },
  {
    n: '6',
    title: 'IA de qualification',
    desc: 'Les contacts entrants sont qualifiés automatiquement selon leur profil et leur niveau de maturité. Vous traitez les leads chauds en priorité.',
  },
]

export default function SystemSection() {
  return (
    <section id="systeme" className="section-pad bg-white">
      <div className="container-main">
        {/* Header */}
        <div className="max-w-xl mb-14">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            Le système
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950 mb-5">
            Un système d&apos;acquisition.
            <br />
            <span className="text-stone-500 font-normal">
              Pas un outil de plus.
            </span>
          </h2>
          <p className="text-stone-500 text-lg leading-relaxed">
            Six composants connectés pour vous amener des vendeurs qualifiés —
            sans que vous gériez la technique, le contenu ou les relances.
          </p>
        </div>

        {/* Grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-stone-100 border border-stone-100 rounded-2xl overflow-hidden">
          {components.map(({ n, title, desc }) => (
            <div
              key={n}
              className="bg-white p-7 flex flex-col gap-4 hover:bg-stone-50 transition-colors duration-150"
            >
              <div className="w-9 h-9 rounded-full bg-navy-50 flex items-center justify-center shrink-0">
                <span className="text-navy-700 font-bold text-sm">{n}</span>
              </div>
              <h3 className="font-semibold text-stone-900 text-base">{title}</h3>
              <p className="text-stone-500 text-sm leading-relaxed">{desc}</p>
            </div>
          ))}
        </div>

        {/* Bottom note */}
        <p className="mt-8 text-center text-sm text-stone-400">
          Tout est installé et géré pour vous. Votre seul travail : rencontrer vos prospects.
        </p>
      </div>
    </section>
  )
}
