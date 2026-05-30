const pillars = [
  {
    label: 'Site professionnel SEO local',
    desc: 'Optimisé pour votre ville et vos quartiers. Capte les vendeurs sur Google avant vos concurrents.',
  },
  {
    label: 'CRM intégré et qualifié',
    desc: 'Tous vos prospects centralisés, scorés, relancés automatiquement selon leur niveau de maturité.',
  },
  {
    label: 'Automatisations IA',
    desc: 'Emails, SMS, séquences de nurturing — personnalisés par l\'IA, déclenchés sans intervention.',
  },
  {
    label: 'Exclusivité territoriale',
    desc: 'Votre ville est fermée à tout autre conseiller dans le système. Aucun concurrent sur votre zone.',
  },
]

export default function Solution() {
  return (
    <section id="solution" className="py-20 px-5 sm:px-6 bg-gray-900 text-white">
      <div className="max-w-5xl mx-auto">
        <div className="grid md:grid-cols-2 gap-12 lg:gap-16 items-center">

          {/* Left */}
          <div>
            <div className="text-emerald-400 text-xs font-semibold uppercase tracking-widest mb-5">
              La solution
            </div>
            <h2 className="text-3xl sm:text-4xl font-bold mb-5 leading-tight">
              Pas un outil de plus.<br />Un système d'acquisition local.
            </h2>
            <p className="text-gray-400 text-base sm:text-lg leading-relaxed mb-8">
              Ecosystème Immo connecte votre site, votre SEO, votre CRM et vos automatisations en
              un seul système — conçu pour attirer des vendeurs dans{' '}
              <span className="text-white font-medium">votre ville</span>, pas dans celle de
              votre voisin.
            </p>
            <a
              href="#disponibilite"
              className="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-6 py-3.5 rounded-xl hover:bg-emerald-500 transition-colors text-sm"
            >
              Vérifier si ma ville est disponible
              <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </a>
          </div>

          {/* Right */}
          <div className="space-y-3">
            {pillars.map((item, i) => (
              <div
                key={i}
                className="flex items-start gap-4 p-4 bg-white/5 rounded-xl border border-white/8"
              >
                <div className="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <div>
                  <p className="font-semibold text-white text-sm">{item.label}</p>
                  <p className="text-gray-400 text-sm mt-0.5 leading-relaxed">{item.desc}</p>
                </div>
              </div>
            ))}
          </div>

        </div>
      </div>
    </section>
  )
}
