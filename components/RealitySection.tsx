const pains = [
  {
    number: '01',
    title: 'Invisible sur Google local',
    desc: 'Quand un vendeur tape "estimation immobilière [votre ville]", votre nom n\'apparaît pas. Ce sont vos concurrents — ou des plateformes qui vous revendent vos propres leads — qui captent la demande.',
  },
  {
    number: '02',
    title: 'Zéro actif digital à votre nom',
    desc: 'Vous n\'avez pas de site à votre nom, pas d\'historique SEO, pas de base email. Si vous changez de réseau demain, vous repartez de zéro. Votre présence numérique appartient à votre enseigne, pas à vous.',
  },
  {
    number: '03',
    title: 'Dépendant des portails toute votre carrière',
    desc: 'SeLoger, LeBonCoin, PAP vous louent une visibilité temporaire et coûteuse. Vous ne construisez rien qui vous appartient. Le coût par lead augmente chaque année, sans jamais baisser.',
  },
]

export default function RealitySection() {
  return (
    <section className="section-pad bg-stone-50 border-y border-stone-100">
      <div className="container-main">
        {/* Header */}
        <div className="max-w-2xl mb-14">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            La réalité du terrain
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950 mb-5">
            Le marché immobilier est ultra-local.
            <br />
            <span className="text-stone-500 font-normal">
              Votre acquisition ne l&apos;est pas encore.
            </span>
          </h2>
          <p className="text-stone-500 text-lg leading-relaxed">
            Pendant que vous achetez des leads génériques sur les portails, un
            concurrent prépare silencieusement sa domination digitale sur votre
            secteur. Le SEO local prend 12 à 18 mois. Ceux qui démarrent
            maintenant auront une avance difficile à rattraper.
          </p>
        </div>

        {/* Pain points */}
        <div className="grid sm:grid-cols-3 gap-8">
          {pains.map(({ number, title, desc }) => (
            <div key={number} className="flex flex-col gap-4">
              <span className="text-[11px] font-bold text-stone-300 tracking-widest">
                {number}
              </span>
              <h3 className="text-base font-semibold text-stone-900">{title}</h3>
              <p className="text-stone-500 text-sm leading-relaxed">{desc}</p>
            </div>
          ))}
        </div>

        {/* Bridge vers la solution */}
        <div className="mt-14 pt-8 border-t border-stone-200">
          <div className="flex flex-col sm:flex-row sm:items-center gap-5">
            <div className="flex-1">
              <p className="text-stone-900 font-semibold text-lg leading-snug">
                Il existe une alternative aux portails.
              </p>
              <p className="text-stone-500 text-base mt-1 leading-relaxed">
                Un système qui vous appartient, ancré sur votre territoire, qui génère des contacts vendeurs en continu — sans dépendance à une plateforme tierce.
              </p>
            </div>
            <a
              href="#systeme"
              className="shrink-0 inline-flex items-center gap-2 text-navy-700 font-semibold text-sm hover:text-navy-900 transition-colors border border-navy-200 hover:border-navy-400 px-5 py-3 rounded-lg"
            >
              Voir le système
              <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>
  )
}
