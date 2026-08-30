const features = [
  {
    title: 'Site professionnel SEO local',
    description:
      'Un site pensé pour le référencement local : pages de quartier, estimateur de bien, blog immobilier. Classé sur Google pour les recherches dans votre ville.',
    items: [
      'Pages optimisées par quartier et secteur',
      'Estimateur de bien pour capter les vendeurs',
      'Blog SEO configuré pour votre territoire',
      'Fiche Google Business optimisée et synchronisée',
    ],
  },
  {
    title: 'CRM immobilier intégré',
    description:
      'Tous vos prospects centralisés. Chaque vendeur entrant est qualifié, catégorisé, relancé selon son niveau de maturité — sans action manuelle de votre part.',
    items: [
      'Scoring automatique des leads entrants',
      'Pipeline de conversion personnalisé',
      'Historique complet de chaque interaction',
      'Rappels et alertes configurables',
    ],
  },
  {
    title: 'Automatisations et IA',
    description:
      'Des séquences email et SMS activées pour chaque étape du parcours vendeur. L\'IA personnalise les messages selon le profil et le timing.',
    items: [
      'Séquences email post-estimation',
      'Relances SMS à intervalles optimisés',
      'Réponse automatique aux demandes entrantes',
      'Nurturing long terme sans maintenance',
    ],
  },
  {
    title: 'Tableau de bord local',
    description:
      'Suivez vos positions SEO, vos leads entrants, vos conversions et votre retour sur investissement. Tout centralisé, mis à jour en temps réel.',
    items: [
      'Analytics de trafic et de conversion',
      'Positions Google par mot-clé local',
      'Volume et qualité des leads par semaine',
      'Rapport mensuel automatique',
    ],
  },
]

export default function Features() {
  return (
    <section className="py-20 px-5 sm:px-6 bg-gray-50">
      <div className="max-w-5xl mx-auto">
        <div className="text-center mb-14">
          <div className="text-emerald-600 text-xs font-semibold uppercase tracking-widest mb-4">
            Ce qui est inclus
          </div>
          <h2 className="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
            Tout ce dont vous avez besoin. Rien de superflu.
          </h2>
          <p className="text-gray-500 text-lg max-w-2xl mx-auto">
            Chaque composant est conçu pour fonctionner ensemble. Vous démarrez avec un système
            complet, pas avec des briques à assembler.
          </p>
        </div>

        <div className="grid md:grid-cols-2 gap-5">
          {features.map((f, i) => (
            <div
              key={i}
              className="bg-white border border-gray-200 rounded-2xl p-7"
            >
              <h3 className="font-bold text-gray-900 text-lg mb-2">{f.title}</h3>
              <p className="text-gray-500 text-sm leading-relaxed mb-5">{f.description}</p>
              <ul className="space-y-2">
                {f.items.map((item, j) => (
                  <li key={j} className="flex items-start gap-2.5 text-sm text-gray-700">
                    <svg
                      className="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                    {item}
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
