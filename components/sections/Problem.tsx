const PROBLEMS = [
  {
    number: '01',
    title: 'Vous êtes invisible sur Google',
    description:
      "Vos prospects cherchent « estimation maison [votre ville] » ou « conseiller immobilier [votre quartier] ». Si vous n'apparaissez pas dans les 3 premiers résultats, ce mandat ira chez quelqu'un d'autre — et vous ne le saurez jamais.",
  },
  {
    number: '02',
    title: 'Vous dépendez des portails',
    description:
      "SeLoger, LeBonCoin, Logic-Immo captent votre audience locale et la revendent à vos concurrents. Chaque annonce que vous publiez finance leur base de données, pas la vôtre. Vous restez locataire de leur trafic.",
  },
  {
    number: '03',
    title: "Vous n'avez aucun actif digital",
    description:
      "Un site vitrine générique ne convertit pas. Sans pages SEO de quartier, sans système de capture, sans relances automatiques — vous recommencez à zéro chaque mois. Pendant ce temps, un concurrent construit son territoire.",
  },
]

export default function Problem() {
  return (
    <section className="py-24 md:py-32 bg-white">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mb-16">
          <p className="text-sm font-semibold text-gold uppercase tracking-wider mb-3">Le problème</p>
          <h2 className="section-title mb-4">
            Pourquoi les conseillers indépendants restent invisibles
          </h2>
          <p className="text-lg text-gray-500">
            Ce n'est pas un problème de compétence. C'est un problème d'infrastructure digitale.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {PROBLEMS.map((problem) => (
            <div key={problem.number} className="relative">
              <div className="text-6xl font-bold text-gray-100 mb-4 leading-none select-none">
                {problem.number}
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3 -mt-4">
                {problem.title}
              </h3>
              <p className="text-gray-500 text-base leading-relaxed">
                {problem.description}
              </p>
            </div>
          ))}
        </div>

        <div className="mt-16 bg-navy rounded-2xl p-8 md:p-10">
          <p className="text-white text-lg md:text-xl font-semibold leading-relaxed max-w-3xl">
            "Pendant que vous lisez cette page, un conseiller dans une ville proche construit son territoire digital. Dans 6 mois, il sera impossible à déloger de Google."
          </p>
          <p className="text-white/50 text-sm mt-4">
            L'exclusivité territoriale n'attend pas.
          </p>
        </div>
      </div>
    </section>
  )
}
