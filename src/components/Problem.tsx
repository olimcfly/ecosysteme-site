export default function Problem() {
  const problems = [
    {
      title: 'Invisible localement',
      description: 'Vos prospects cherchent "estimation immobilière [votre ville]" sur Google. Ils tombent sur la concurrence ou les portails.',
    },
    {
      title: 'Pas de suivi systématique',
      description: 'Un prospect qui ne répond pas le premier jour est perdu. Sans relance automatisée, vous perdez 70% de vos leads.',
    },
    {
      title: 'Site générique, zéro confiance',
      description: 'Une page réseau sans identité locale ne convertit pas. Les vendeurs ont besoin de voir un expert de leur quartier.',
    },
    {
      title: 'Concurrence interne',
      description: 'Dans votre propre réseau, trois autres conseillers couvrent la même zone. Personne ne gagne vraiment.',
    },
  ];

  return (
    <section className="py-24 px-4">
      <div className="max-w-5xl mx-auto">
        {/* Section header */}
        <div className="text-center mb-16">
          <p className="text-blue-400 text-sm font-medium uppercase tracking-wider mb-3">Le diagnostic</p>
          <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4">
            Pourquoi la plupart des conseillers<br className="hidden sm:block" /> n'obtiennent pas de mandats qualifiés
          </h2>
          <p className="text-slate-400 max-w-xl mx-auto">
            Ce n'est pas une question de compétences. C'est un problème de système.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 gap-4">
          {problems.map((p, i) => (
            <div
              key={i}
              className="group p-6 rounded-2xl bg-white/[0.03] border border-white/[0.07] hover:border-white/[0.12] transition-all"
            >
              <div className="flex items-start gap-4">
                <div className="flex-shrink-0 w-8 h-8 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center justify-center mt-0.5">
                  <svg className="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </div>
                <div>
                  <h3 className="font-semibold text-white mb-1.5">{p.title}</h3>
                  <p className="text-sm text-slate-400 leading-relaxed">{p.description}</p>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Transition */}
        <div className="mt-16 text-center">
          <div className="inline-block px-5 py-3 rounded-xl bg-blue-600/10 border border-blue-500/20">
            <p className="text-blue-300 text-sm font-medium">
              Ecosystème Immo résout chacun de ces problèmes — sur votre territoire, en exclusivité.
            </p>
          </div>
        </div>
      </div>
    </section>
  );
}
