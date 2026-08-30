const STEPS = [
  {
    number: "01",
    title: "Vérifiez votre ville",
    description:
      "Entrez votre ville. Si elle est disponible, vous pouvez activer le système immédiatement. Si elle est déjà prise, nous vous proposons les zones adjacentes.",
    duration: "30 secondes",
  },
  {
    number: "02",
    title: "Activation de votre système",
    description:
      "Notre équipe configure votre site SEO, votre estimateur, votre CRM et vos automatisations. Vous recevez un accès à votre tableau de bord et une session d'onboarding.",
    duration: "48 heures",
  },
  {
    number: "03",
    title: "Vos premiers leads locaux",
    description:
      "Votre système est en ligne. Les vendeurs vous trouvent sur Google, complètent l'estimateur, et arrivent qualifiés directement dans votre CRM.",
    duration: "Sous 30 jours",
  },
];

export default function HowItWorks() {
  return (
    <section id="comment-ca-marche" className="py-24 px-4">
      <div className="max-w-4xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
            Le processus
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-ei-text">
            Opérationnel en 48 heures.
          </h2>
        </div>

        <div className="space-y-4">
          {STEPS.map((step, i) => (
            <div
              key={i}
              className="flex gap-5 sm:gap-7 bg-ei-card border border-ei-border rounded-2xl p-6 sm:p-8"
            >
              <div className="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-ei-gold/10 border border-ei-gold/20 flex items-center justify-center">
                <span className="text-ei-gold font-bold text-base sm:text-lg">
                  {step.number}
                </span>
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex flex-wrap items-center gap-2 sm:gap-3 mb-2">
                  <h3 className="text-ei-text font-semibold text-base sm:text-lg">
                    {step.title}
                  </h3>
                  <span className="bg-ei-gold/10 text-ei-gold text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap">
                    {step.duration}
                  </span>
                </div>
                <p className="text-ei-muted text-sm leading-relaxed">
                  {step.description}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
