const problems = [
  {
    title: "Un site vitrine, pas un système",
    description:
      "Votre site n'est pas conçu pour apparaître quand un vendeur cherche un agent dans votre secteur. Il ne génère pas de leads — il existe juste.",
  },
  {
    title: "Invisible sur votre marché local",
    description:
      "Sans SEO local ciblé, vous cédez vos mandats potentiels à d'autres. La visibilité en ligne ne se crée pas par accident — elle se construit.",
  },
  {
    title: "Aucun système de suivi",
    description:
      "Sans CRM et automatisations, vos prospects partent chez un concurrent faute d'une relance au bon moment. Le timing fait le mandat.",
  },
  {
    title: "Des outils qui ne se parlent pas",
    description:
      "Site, portails, tableurs, réseaux sociaux, messagerie — vous gérez des outils éparpillés sans vision unifiée de votre pipeline.",
  },
]

export default function ProblemSection() {
  return (
    <section className="py-20 md:py-28 px-4 sm:px-6 lg:px-8 bg-white">
      <div className="max-w-6xl mx-auto">
        <div className="max-w-2xl mb-16">
          <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">
            Le diagnostic
          </p>
          <h2 className="text-3xl md:text-4xl font-bold tracking-tight text-zinc-950">
            {"Pourquoi la majorité des conseillers indépendants n'attirent pas de vendeurs qualifiés en ligne"}
          </h2>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
          {problems.map((problem, index) => (
            <div key={index} className="p-6 border border-zinc-200 rounded-xl">
              <div className="text-xs font-bold text-zinc-300 mb-4 font-mono">
                0{index + 1}
              </div>
              <h3 className="text-base font-semibold text-zinc-900 mb-2">{problem.title}</h3>
              <p className="text-sm text-zinc-600 leading-relaxed">{problem.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
