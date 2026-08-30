const COMPONENTS = [
  {
    title: 'Site professionnel local',
    description:
      "Conçu pour convertir les visiteurs en prospects vendeurs. Mobile-first, rapide, référençable. Votre présence digitale permanente — active 24h/24.",
  },
  {
    title: 'Pages SEO par quartier',
    description:
      "Chaque quartier de votre ville devient une page indexée sur Google. Vous capturez les recherches locales précises là où vos concurrents sont absents.",
  },
  {
    title: 'Google Business Profile',
    description:
      "Votre fiche Google optimisée, maintenue et auditée chaque mois. Positionnement prioritaire sur les recherches de proximité.",
  },
  {
    title: 'Formulaire de capture vendeur',
    description:
      "Un tunnel de qualification intégré qui identifie les vendeurs motivés, recueille leurs informations et les qualifie avant le premier contact téléphonique.",
  },
  {
    title: 'CRM de suivi prospects',
    description:
      "Tableau de bord simple pour suivre chaque prospect : stade de maturité, date de dernier contact, probabilité de mandat. Rien ne tombe à l'oubli.",
  },
  {
    title: 'Séquences email automatisées',
    description:
      "Relances programmées sur 90 jours pour convertir les prospects froids en mandats. Le système travaille même quand vous êtes en rendez-vous.",
  },
]

export default function System() {
  return (
    <section id="systeme" className="py-24 md:py-32 bg-gray-50">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mb-16">
          <p className="text-sm font-semibold text-gold uppercase tracking-wider mb-3">La solution</p>
          <h2 className="section-title mb-4">Un système, pas un outil.</h2>
          <p className="text-lg text-gray-500">
            {"Écosystème Immo n'est pas un logiciel. C'est une infrastructure digitale locale déployée pour vous, fonctionnelle dès la première semaine. Vous vous concentrez sur les mandats — le système gère la visibilité."}
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {COMPONENTS.map((item, i) => (
            <div key={i} className="card hover:border-gray-300 transition-colors">
              <div className="w-8 h-8 rounded-lg bg-navy/10 flex items-center justify-center mb-4">
                <span className="text-xs font-bold text-navy">{String(i + 1).padStart(2, '0')}</span>
              </div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">{item.title}</h3>
              <p className="text-gray-500 text-sm leading-relaxed">{item.description}</p>
            </div>
          ))}
        </div>

        <div className="mt-10 flex flex-col sm:flex-row items-start sm:items-center gap-6 p-6 bg-white border border-gray-200 rounded-xl">
          <div className="flex-shrink-0">
            <div className="w-12 h-12 rounded-full bg-gold/10 flex items-center justify-center">
              <svg className="w-6 h-6 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
          </div>
          <div>
            <p className="font-semibold text-gray-900">Exclusivité territoriale contractuelle</p>
            <p className="text-gray-500 text-sm mt-1">
              {"Dès votre activation, votre ville est verrouillée. Aucun autre conseiller ne peut rejoindre Écosystème Immo sur le même secteur géographique. Votre investissement est protégé par contrat."}
            </p>
          </div>
        </div>
      </div>
    </section>
  )
}
