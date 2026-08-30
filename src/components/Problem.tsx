const PAIN_POINTS = [
  {
    number: "01",
    title: "Vous payez des leads sans exclusivité",
    body: "Les plateformes vous vendent les mêmes contacts qu'à vos concurrents. Vous êtes en compétition permanente sur votre propre marché local.",
  },
  {
    number: "02",
    title: "Votre présence digitale ne vous différencie pas",
    body: "Un site générique sans ancrage local ne remonte pas sur Google. Les vendeurs de votre ville ne vous trouvent pas — ils trouvent la concurrence.",
  },
  {
    number: "03",
    title: "Vous n'avez pas de machine d'acquisition qui tourne seule",
    body: "Sans automatisation, chaque lead nécessite une action manuelle. Vous perdez des opportunités parce que la réponse n'est pas instantanée.",
  },
];

export function Problem() {
  return (
    <section className="bg-white py-20 sm:py-28">
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section header */}
        <div className="max-w-2xl mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Le problème
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mb-4 text-balance">
            Le conseiller indépendant n'a pas de système.
            <br />
            <span className="text-slate-400">Il a des outils éparpillés.</span>
          </h2>
          <p className="text-slate-500 text-base leading-relaxed">
            Des outils isolés ne créent pas de flux de clients. Seul un système
            intégré, ancré localement, génère une acquisition prévisible.
          </p>
        </div>

        {/* Pain points */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {PAIN_POINTS.map((p) => (
            <div
              key={p.number}
              className="bg-[#F8F7F4] border border-slate-100 rounded-2xl p-6"
            >
              <span className="text-[#C8A84B]/40 font-bold text-4xl leading-none block mb-5">
                {p.number}
              </span>
              <h3 className="text-slate-900 font-semibold text-base mb-2 leading-snug">
                {p.title}
              </h3>
              <p className="text-slate-500 text-sm leading-relaxed">{p.body}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
