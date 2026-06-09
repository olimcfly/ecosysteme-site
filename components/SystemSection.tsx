const components = [
  {
    n: '1',
    title: 'Site professionnel local',
    desc: 'Un site à votre nom, optimisé pour convertir des visiteurs en contacts vendeurs. Mobile-first, rapide, brandé à votre identité.',
    result: 'Votre nom s\'ancre durablement sur Google pour votre secteur.',
  },
  {
    n: '2',
    title: 'SEO local + pages secteurs',
    desc: 'Des pages dédiées à vos communes et quartiers, optimisées pour les requêtes locales à fort potentiel vendeur.',
    result: 'Des positions sur "estimation immobilière [votre ville]" que vos concurrents n\'ont pas encore.',
  },
  {
    n: '3',
    title: 'Google Business Profile',
    desc: 'Fiche Google optimisée, cohérente avec votre site. Indispensable pour apparaître sur Google Maps quand un vendeur cherche près de chez lui.',
    result: 'Présence dans le Local Pack Google — là où se concentrent les clics immobiliers locaux.',
  },
  {
    n: '4',
    title: 'CRM prospects intégré',
    desc: 'Suivi clair de chaque contact vendeur : statut, historique, prochaine action. Tout centralisé, rien de dispersé entre vos outils.',
    result: '0 lead oublié. 0 relance manquée.',
  },
  {
    n: '5',
    title: 'Automatisations et séquences',
    desc: 'Relances email automatiques, rappels, nurturing. Vous restez présent auprès de vos prospects sans y consacrer du temps.',
    result: 'Vos prospects reçoivent le bon message au bon moment — même quand vous êtes en rendez-vous.',
  },
  {
    n: '6',
    title: 'IA de qualification',
    desc: 'Les contacts entrants sont analysés automatiquement selon leur profil et leur niveau de maturité de projet.',
    result: 'Vous traitez les leads chauds en priorité. Fini les heures perdues sur des projets non aboutis.',
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
          {components.map(({ n, title, desc, result }) => (
            <div
              key={n}
              className="bg-white p-7 flex flex-col gap-3 hover:bg-stone-50 transition-colors duration-150"
            >
              <div className="w-9 h-9 rounded-full bg-navy-50 flex items-center justify-center shrink-0">
                <span className="text-navy-700 font-bold text-sm">{n}</span>
              </div>
              <h3 className="font-semibold text-stone-900 text-base">{title}</h3>
              <p className="text-stone-500 text-sm leading-relaxed">{desc}</p>
              <p className="text-navy-700 text-xs font-semibold border-t border-stone-100 pt-3 mt-auto">
                → {result}
              </p>
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
