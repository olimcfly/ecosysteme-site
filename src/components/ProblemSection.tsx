const PROBLEMS = [
  {
    title: "Des leads partagés entre 10 concurrents",
    description:
      "Vous payez pour des contacts que SeLoger, LeBonCoin ou votre réseau revendent à 5, 10 ou 15 conseillers simultanément. Le prospect est déjà sollicité avant même de vous répondre.",
  },
  {
    title: "Aucune visibilité locale sur Google",
    description:
      "Un vendeur qui tape « estimer ma maison à [votre ville] » ne vous trouve pas. Sans SEO local, vous êtes invisible exactement là où l'intention d'acheter ou de vendre se manifeste.",
  },
  {
    title: "100% dépendant des plateformes",
    description:
      "Chaque hausse tarifaire, changement d'algorithme ou nouveau concurrent impacte directement votre activité. Vous ne contrôlez rien. Vous ne possédez rien.",
  },
];

export default function ProblemSection() {
  return (
    <section className="py-24 px-4">
      <div className="max-w-5xl mx-auto">
        {/* Section label */}
        <div className="text-center mb-16">
          <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
            Le problème
          </p>
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-bold text-ei-text leading-tight">
            Les portails ne travaillent pas pour vous.
            <br />
            <span className="text-ei-muted">Ils travaillent contre vous.</span>
          </h2>
        </div>

        {/* Problem cards */}
        <div className="grid sm:grid-cols-3 gap-5">
          {PROBLEMS.map((problem, i) => (
            <div
              key={i}
              className="bg-ei-card border border-ei-border rounded-2xl p-7"
            >
              <div className="w-10 h-10 bg-red-500/10 border border-red-500/20 rounded-xl flex items-center justify-center mb-6">
                <span className="w-2.5 h-2.5 bg-red-500 rounded-full" />
              </div>
              <h3 className="text-ei-text font-semibold text-base mb-3">
                {problem.title}
              </h3>
              <p className="text-ei-muted text-sm leading-relaxed">
                {problem.description}
              </p>
            </div>
          ))}
        </div>

        {/* Bridge */}
        <div className="mt-14 text-center">
          <p className="text-ei-muted text-lg max-w-2xl mx-auto leading-relaxed">
            Des efforts constants, une prospection épuisante, une rentabilité
            instable.{" "}
            <span className="text-ei-text font-medium">
              Il existe une alternative.
            </span>
          </p>
        </div>
      </div>
    </section>
  );
}
