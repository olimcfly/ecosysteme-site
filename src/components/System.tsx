export default function System() {
  const modules = [
    {
      number: '01',
      title: 'Site professionnel local',
      description: 'Un site optimisé à votre nom, votre ville, vos spécificités. Construit pour convertir un visiteur en prospect vendeur.',
      details: ['Design premium mobile-first', 'Formulaire estimation intégré', 'Contenu local personnalisé', 'Vitesse de chargement optimisée'],
    },
    {
      number: '02',
      title: 'SEO local dominant',
      description: 'Apparaître sur "estimation immobilière [votre ville]" et toutes les requêtes locales des vendeurs de votre territoire.',
      details: ['Fiches Google Business optimisée', 'Pages de quartier et secteur', 'Schema markup immobilier', 'Backlinks locaux ciblés'],
    },
    {
      number: '03',
      title: 'CRM vendeurs qualifiés',
      description: 'Suivez chaque prospect depuis le premier contact jusqu\'au mandat signé, sans rien laisser tomber.',
      details: ['Pipeline vendeurs visuel', 'Scoring automatique des leads', 'Historique complet', 'Notes et rappels intégrés'],
    },
    {
      number: '04',
      title: 'Automatisations & relances',
      description: 'Vos relances partent automatiquement. Votre présence est permanente, même quand vous êtes en visite.',
      details: ['Email automatiques post-estimation', 'SMS de relance configurables', 'Séquences de nurturing', 'Alertes en temps réel'],
    },
    {
      number: '05',
      title: 'IA d\'estimation et qualification',
      description: 'Un outil d\'estimation intelligent qui qualifie vos prospects et vous alerte sur les contacts à fort potentiel.',
      details: ['Estimateur IA sur votre site', 'Qualification automatique', 'Rapport vendeur personnalisé', 'Connexion aux données du marché local'],
    },
    {
      number: '06',
      title: 'Exclusivité territoriale',
      description: 'Votre ville vous appartient. Aucun autre conseiller Ecosystème ne peut opérer sur votre territoire.',
      details: ['1 ville = 1 seul conseiller', 'Verrouillage permanent disponible', 'Territoire défini contractuellement', 'Avantage concurrentiel durable'],
    },
  ];

  return (
    <section id="systeme" className="py-24 px-4 relative">
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute bottom-0 right-0 w-[600px] h-[600px] bg-blue-900/8 rounded-full blur-[100px]" />
      </div>

      <div className="max-w-6xl mx-auto relative">
        <div className="text-center mb-16">
          <p className="text-blue-400 text-sm font-medium uppercase tracking-wider mb-3">Le système complet</p>
          <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4">
            Tout ce dont vous avez besoin<br className="hidden sm:block" /> pour dominer votre marché local
          </h2>
          <p className="text-slate-400 max-w-xl mx-auto">
            Six modules intégrés. Une seule plateforme. Zéro friction technique.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {modules.map((m) => (
            <div
              key={m.number}
              className="group p-6 rounded-2xl bg-white/[0.03] border border-white/[0.07] hover:border-blue-500/30 hover:bg-white/[0.05] transition-all duration-300"
            >
              <div className="text-blue-600 text-xs font-bold font-mono mb-4">{m.number}</div>
              <h3 className="text-white font-semibold text-base mb-2 leading-snug">{m.title}</h3>
              <p className="text-slate-400 text-sm leading-relaxed mb-5">{m.description}</p>
              <ul className="space-y-1.5">
                {m.details.map((d, i) => (
                  <li key={i} className="flex items-center gap-2 text-xs text-slate-500">
                    <svg className="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                    </svg>
                    {d}
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        {/* CTA intermédiaire */}
        <div className="mt-16 text-center">
          <a
            href="#disponibilite"
            className="inline-flex items-center gap-2 px-7 py-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold transition-all shadow-lg shadow-blue-600/25 hover:-translate-y-0.5"
          >
            Vérifier si ma ville est disponible
            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </div>
    </section>
  );
}
