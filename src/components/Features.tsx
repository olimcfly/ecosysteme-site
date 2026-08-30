const FEATURES = [
  {
    icon: (
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <path d="M3 4h14v2H3V4zm0 5h14v2H3V9zm0 5h8v2H3v-2z" fill="currentColor" />
        <circle cx="16" cy="15" r="3" fill="currentColor" opacity=".4" />
      </svg>
    ),
    title: "Site vitrine SEO local",
    body: "Pages optimisées pour votre ville, indexées par Google. Votre URL, votre marque, vos mots-clés locaux — personne d'autre ne peut occuper cet espace.",
  },
  {
    icon: (
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <rect x="2" y="4" width="16" height="12" rx="2" stroke="currentColor" strokeWidth="1.5" />
        <path d="M6 8h8M6 11h5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
      </svg>
    ),
    title: "Estimateur intégré",
    body: "Formulaire de qualification intelligent. Les vendeurs obtiennent une estimation, vous obtenez leurs coordonnées qualifiées — avec leur projet et leur timing.",
  },
  {
    icon: (
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <circle cx="7" cy="6" r="3" stroke="currentColor" strokeWidth="1.5" />
        <circle cx="13" cy="6" r="3" stroke="currentColor" strokeWidth="1.5" />
        <path d="M1 18c0-3.314 2.686-6 6-6h6c3.314 0 6 2.686 6 6" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
      </svg>
    ),
    title: "CRM de suivi intelligent",
    body: "Pipeline de contacts avec historique complet, statut de qualification, rappels automatiques. Ne laissez plus aucun prospect passer entre les mailles.",
  },
  {
    icon: (
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <path d="M10 2l2 5h5l-4 3 1.5 5L10 12l-4.5 3L7 10 3 7h5L10 2z" stroke="currentColor" strokeWidth="1.5" strokeLinejoin="round" />
      </svg>
    ),
    title: "Automatisations email et SMS",
    body: "Séquences de nurturing déclenchées automatiquement. Relance à J+1, J+7, J+30. Le système travaille même quand vous êtes sur le terrain.",
  },
  {
    icon: (
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <path d="M10 2C5.582 2 2 5.582 2 10s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8z" stroke="currentColor" strokeWidth="1.5" />
        <path d="M7 10l2 2 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
      </svg>
    ),
    title: "IA de traitement des demandes",
    body: "Qualification automatique à l'entrée. L'IA catégorise chaque demande, répond en moins de 2 minutes, et vous alerte sur les opportunités chaudes.",
  },
  {
    icon: (
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <path d="M3 14l4-4 3 3 4-5 3 4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
        <rect x="2" y="3" width="16" height="14" rx="2" stroke="currentColor" strokeWidth="1.5" />
      </svg>
    ),
    title: "Dashboard de performance",
    body: "Visites, leads, taux de conversion, mandats générés. Vous mesurez ce que le système produit — en temps réel, en chiffres, sans interprétation.",
  },
];

export function Features() {
  return (
    <section className="bg-white py-20 sm:py-28">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="max-w-2xl mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Ce qui est inclus
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mb-4 text-balance">
            Pas un outil. Un système complet.
          </h2>
          <p className="text-slate-500 text-base leading-relaxed">
            Chaque composant est conçu pour fonctionner ensemble. Résultat : une
            acquisition locale qui s'auto-entretient, sans dépendance aux
            plateformes de leads.
          </p>
        </div>

        {/* Feature grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {FEATURES.map((f) => (
            <div
              key={f.title}
              className="bg-[#F8F7F4] border border-slate-100 hover:border-slate-200 rounded-2xl p-6 transition-colors group"
            >
              <div className="w-10 h-10 rounded-xl bg-[#07090F] flex items-center justify-center mb-4 text-[#C8A84B]">
                {f.icon}
              </div>
              <h3 className="text-slate-900 font-semibold text-base mb-2">
                {f.title}
              </h3>
              <p className="text-slate-500 text-sm leading-relaxed">{f.body}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
