const PAIN_POINTS = [
  {
    title: 'Invisible sur Google',
    desc: 'Vos concurrents apparaissent sur les recherches locales. Pour les vendeurs qui cherchent un conseiller en ligne dans votre ville, vous n\'existez pas.',
  },
  {
    title: 'Dépendant des portails',
    desc: 'SeLoger, LeBonCoin, Bien\'ici — vous payez pour des leads génériques, froids, partagés avec dix autres agents. Zéro avantage concurrentiel.',
  },
  {
    title: 'Aucun actif digital personnel',
    desc: 'Changez de réseau demain et vous repartez de zéro. Pas de site propre, pas de base de contacts, pas de visibilité construite.',
  },
]

export default function Problem() {
  return (
    <section className="py-20 px-4 sm:px-6 border-t border-[#1A2840]">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Le problème
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-[#EEE8D8] mb-4">
            La réalité du terrain
          </h2>
          <p className="text-[#8090A8] max-w-xl mx-auto text-sm leading-relaxed">
            La plupart des conseillers indépendants font face aux mêmes blocages. Le marché ne manque pas — c&apos;est la visibilité locale qui fait défaut.
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-5">
          {PAIN_POINTS.map((point) => (
            <div
              key={point.title}
              className="bg-[#0D1829] border border-[#1A2840] rounded-lg p-6"
            >
              <span className="inline-block w-2 h-2 rounded-full bg-red-400 mb-5" />
              <h3 className="text-[#EEE8D8] font-semibold text-base mb-3">{point.title}</h3>
              <p className="text-[#8090A8] text-sm leading-relaxed">{point.desc}</p>
            </div>
          ))}
        </div>

        <div className="mt-12 text-center">
          <a
            href="#verifier"
            className="inline-block bg-[#C8A84B] hover:bg-[#D4B56A] text-[#080E1A] font-semibold px-6 py-3 rounded text-sm transition-colors"
          >
            Vérifier si ma ville est encore libre
          </a>
        </div>
      </div>
    </section>
  )
}
