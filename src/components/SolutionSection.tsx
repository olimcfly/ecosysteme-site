const pillars = [
  {
    icon: (
      <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
        />
      </svg>
    ),
    title: "Site local de référence",
    description:
      "Un site structuré et optimisé pour votre ville, conçu pour convertir un visiteur en prospect. Vous devenez la première réponse locale quand un vendeur cherche un professionnel.",
  },
  {
    icon: (
      <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
        />
      </svg>
    ),
    title: "SEO de secteur",
    description:
      "Stratégie de contenu et optimisation technique centrées sur votre territoire. Vous apparaissez quand un vendeur tape le nom de votre ville suivi de \"agent immobilier\".",
  },
  {
    icon: (
      <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"
        />
      </svg>
    ),
    title: "CRM + automatisations",
    description:
      "Pipeline de leads intégré, relances automatisées, suivi de chaque prospect. Vous ne perdez plus de contacts faute d'un suivi au bon moment.",
  },
  {
    icon: (
      <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"
        />
      </svg>
    ),
    title: "IA de qualification",
    description:
      "Filtrez les contacts non-pertinents avant qu'ils n'occupent votre temps. Seuls les prospects qualifiés arrivent dans votre CRM, prêts à être traités.",
  },
]

export default function SolutionSection() {
  return (
    <section className="py-20 md:py-28 px-4 sm:px-6 lg:px-8 bg-zinc-50">
      <div className="max-w-6xl mx-auto">
        <div className="text-center max-w-2xl mx-auto mb-16">
          <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">
            La différence
          </p>
          <h2 className="text-3xl md:text-4xl font-bold tracking-tight text-zinc-950 mb-4">
            Un système complet. Pas un outil de plus.
          </h2>
          <p className="text-base text-zinc-600 leading-relaxed">
            EcosystemeImmo regroupe tout ce dont un conseiller indépendant a besoin pour dominer son
            marché local — dans une seule offre, sans coordination entre prestataires.
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
          {pillars.map((pillar, index) => (
            <div key={index} className="p-6 bg-white border border-zinc-200 rounded-xl">
              <div className="w-10 h-10 bg-zinc-100 rounded-lg flex items-center justify-center mb-4 text-zinc-700">
                {pillar.icon}
              </div>
              <h3 className="text-base font-semibold text-zinc-900 mb-2">{pillar.title}</h3>
              <p className="text-sm text-zinc-600 leading-relaxed">{pillar.description}</p>
            </div>
          ))}
        </div>

        <div className="mt-10 p-6 md:p-8 bg-zinc-950 rounded-2xl text-center">
          <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-3">
            Le principe fondateur
          </p>
          <p className="text-xl md:text-2xl font-bold text-white">
            {"1 ville — 1 seul conseiller — 1 système d'acquisition exclusif"}
          </p>
        </div>
      </div>
    </section>
  )
}
