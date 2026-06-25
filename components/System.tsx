const FEATURES = [
  {
    label: 'Site immobilier professionnel',
    desc: 'Sur votre propre domaine. Design premium, rapide, optimisé pour la conversion. Pages secteurs et quartiers incluses.',
  },
  {
    label: 'SEO local structuré',
    desc: 'Pages optimisées pour chaque secteur de votre territoire. Google Business Profile configuré et alimenté régulièrement.',
  },
  {
    label: 'Formulaire vendeur + estimation',
    desc: 'Capturez les demandes d\'avis de valeur directement sur votre site, 24h/24. Aucune demande ne passe entre les mailles.',
  },
  {
    label: 'CRM + relances automatisées',
    desc: 'Suivi structuré des prospects, séquences de relances email. Chaque contact reçu est traité — aucun n\'est oublié.',
  },
  {
    label: 'IA de qualification',
    desc: 'Les contacts entrants sont qualifiés automatiquement. Premiers échanges vendeur gérés par IA. Vous intervenez uniquement sur les profils chauds.',
  },
  {
    label: 'Exclusivité territoriale',
    desc: 'Un seul système par ville, garanti contractuellement. Votre territoire vous appartient — aucun concurrent déployé sur le même périmètre.',
  },
]

export default function System() {
  return (
    <section id="systeme" className="py-20 px-4 sm:px-6 border-t border-[#1A2840]">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Ce que vous obtenez
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-[#EEE8D8] mb-4">
            Le système, pas l&apos;outil
          </h2>
          <p className="text-[#8090A8] max-w-2xl mx-auto text-sm leading-relaxed">
            Tout est installé, configuré et activé sur votre territoire. Vous ne combinez pas des outils séparés — vous recevez un système opérationnel clé en main dès le premier mois.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {FEATURES.map((feature) => (
            <div
              key={feature.label}
              className="bg-[#0D1829] border border-[#1A2840] rounded-lg p-6"
            >
              <span className="inline-block w-1.5 h-1.5 rounded-full bg-[#C8A84B] mb-5" />
              <h3 className="text-[#EEE8D8] font-semibold text-sm mb-2">{feature.label}</h3>
              <p className="text-[#8090A8] text-sm leading-relaxed">{feature.desc}</p>
            </div>
          ))}
        </div>

        <div className="mt-10 bg-[#0D1829] border border-[#1A2840] rounded-lg p-6 sm:p-8 text-center">
          <p className="text-[#8090A8] text-sm leading-relaxed max-w-2xl mx-auto">
            <span className="text-[#EEE8D8] font-semibold">Setup complet en moins de 30 jours.</span>{' '}
            Nous configurons l&apos;intégralité du système sur votre territoire. Vous recevez les accès,
            une formation de prise en main, et un suivi mensuel.
          </p>
        </div>
      </div>
    </section>
  )
}
