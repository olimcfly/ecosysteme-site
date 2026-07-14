const steps = [
  {
    n: '01',
    title: 'Vérifiez votre ville',
    desc: 'Saisissez votre ville dans le formulaire. Si elle est disponible, vous réservez l\'exclusivité en 2 minutes.',
    detail: 'Gratuit · Sans engagement',
  },
  {
    n: '02',
    title: 'Votre système est activé',
    desc: 'Olivier construit votre site, configure votre SEO local, votre CRM et vos automatisations. Vous ne gérez rien.',
    detail: 'Délai moyen : 7 jours ouvrés',
  },
  {
    n: '03',
    title: 'Les vendeurs vous trouvent',
    desc: 'Votre présence locale attire des propriétaires qui cherchent un conseiller sur votre territoire. Vos leads arrivent directement dans votre CRM.',
    detail: 'Premiers résultats : 4 à 8 semaines',
  },
]

export default function HowItWorksSection() {
  return (
    <section id="fonctionnement" className="section-pad bg-white border-t border-stone-100">
      <div className="container-main">
        <div className="max-w-xl mb-14">
          <p className="text-xs font-semibold uppercase tracking-widest text-navy-500 mb-4">
            Comment ça marche
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-stone-950 mb-5">
            Opérationnel en 7 jours.
            <br />
            <span className="text-stone-500 font-normal">
              Sans vous occuper du technique.
            </span>
          </h2>
          <p className="text-stone-500 text-lg leading-relaxed">
            Pas une formation à suivre, pas un outil à configurer. Un système complet installé et géré à votre place.
          </p>
        </div>

        <div className="grid sm:grid-cols-3 gap-8 lg:gap-12">
          {steps.map(({ n, title, desc, detail }) => (
            <div key={n} className="relative flex flex-col gap-4">
              <div className="flex items-center gap-4">
                <span className="w-10 h-10 rounded-full bg-navy-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                  {n}
                </span>
                <h3 className="font-semibold text-stone-900 text-base">{title}</h3>
              </div>
              <p className="text-stone-500 text-sm leading-relaxed">{desc}</p>
              <span className="text-xs font-semibold text-navy-500 uppercase tracking-wide">
                {detail}
              </span>
            </div>
          ))}
        </div>

        <div className="mt-12 text-center">
          <a href="#verifier-ville" className="btn-primary">
            Vérifier si ma ville est disponible
          </a>
        </div>
      </div>
    </section>
  )
}
