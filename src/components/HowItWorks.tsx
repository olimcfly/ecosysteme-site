const steps = [
  {
    number: '01',
    title: 'Vérifiez la disponibilité de votre ville',
    description:
      'Entrez votre ville dans le vérificateur. Si elle est libre, vous pouvez la réserver immédiatement. Une fois attribuée à un autre conseiller, elle est fermée définitivement.',
  },
  {
    number: '02',
    title: 'Choisissez votre formule',
    description:
      "Estimateur seul, mensuel, annuel, ou exclusivité verrouillée. Chaque formule inclut l'onboarding complet et la configuration de l'ensemble du système.",
  },
  {
    number: '03',
    title: 'Déploiement en 7 jours ouvrés',
    description:
      'Votre site, votre SEO de secteur, votre CRM — tout est actif en une semaine. Vous commencez à recevoir des leads qualifiés dès le lancement.',
  },
]

export default function HowItWorks() {
  return (
    <section className="py-20 md:py-28 px-4 sm:px-6 lg:px-8 bg-white">
      <div className="max-w-3xl mx-auto">
        <div className="text-center mb-16">
          <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">
            Le processus
          </p>
          <h2 className="text-3xl md:text-4xl font-bold tracking-tight text-zinc-950">
            Opérationnel en 7 jours
          </h2>
        </div>

        <div className="space-y-10">
          {steps.map((step, index) => (
            <div key={index} className="flex gap-6 md:gap-8">
              <div className="flex flex-col items-center flex-shrink-0">
                <div className="w-11 h-11 bg-zinc-950 text-white rounded-xl flex items-center justify-center text-xs font-black font-mono">
                  {step.number}
                </div>
                {index < steps.length - 1 && (
                  <div className="mt-3 w-px flex-1 bg-zinc-200 min-h-[2rem]" />
                )}
              </div>
              <div className="pt-1 pb-4">
                <h3 className="text-base font-semibold text-zinc-900 mb-2">{step.title}</h3>
                <p className="text-sm text-zinc-600 leading-relaxed">{step.description}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
