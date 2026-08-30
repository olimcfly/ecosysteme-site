import CityChecker from './CityChecker'

const CLOSED = ['Bordeaux', 'Nantes', 'Aix-en-Provence', 'Nandy', 'Lannion']

export default function HeroSection() {
  return (
    <section
      id="verifier-ville"
      className="pt-36 pb-16 sm:pt-44 sm:pb-24 bg-white"
    >
      <div className="container-main">
        {/* Badge */}
        <div className="flex justify-center mb-8">
          <span className="tag bg-gold-50 text-gold-700 border border-gold-200">
            Exclusivité territoriale · 1 ville = 1 conseiller · Garanti par contrat
          </span>
        </div>

        {/* Headline */}
        <h1 className="text-center text-[2.4rem] sm:text-5xl lg:text-6xl font-bold text-stone-950 leading-[1.1] tracking-tight mb-6">
          Devenez le conseiller
          <br className="hidden sm:block" />
          <span className="text-navy-600"> référent de votre ville.</span>
        </h1>

        {/* Sous-headline */}
        <p className="text-center text-lg sm:text-xl text-stone-500 max-w-2xl mx-auto mb-4 leading-relaxed">
          Système d&apos;acquisition local complet — site, SEO local, CRM, automatisations, IA.
          Géré pour vous. Réservé à un seul conseiller par territoire.
        </p>

        {/* Ancre ROI */}
        <p className="text-center text-sm text-stone-400 mb-10">
          Un seul mandat supplémentaire couvre plus de 5 ans d&apos;abonnement annuel.
        </p>

        {/* City Checker */}
        <div className="max-w-xl mx-auto mb-8">
          <p className="text-center text-sm font-semibold text-stone-700 mb-3 uppercase tracking-widest">
            Vérifiez si votre ville est disponible
          </p>
          <CityChecker />
        </div>

        {/* FOMO villes fermées */}
        <div className="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-sm text-stone-400">
          <span className="font-medium text-stone-500">Déjà fermé :</span>
          {CLOSED.map((city) => (
            <span key={city} className="flex items-center gap-1.5">
              <span className="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0" />
              <span>{city}</span>
            </span>
          ))}
        </div>

        {/* Stats de réassurance */}
        <div className="mt-12 grid grid-cols-3 gap-4 max-w-lg mx-auto border-t border-stone-100 pt-8">
          {[
            { value: '7 jours', label: 'pour être opérationnel' },
            { value: '5 villes', label: 'déjà actives' },
            { value: '100%', label: 'clé en main' },
          ].map(({ value, label }) => (
            <div key={value} className="text-center">
              <p className="text-lg font-bold text-stone-900">{value}</p>
              <p className="text-xs text-stone-400 mt-0.5 leading-tight">{label}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
