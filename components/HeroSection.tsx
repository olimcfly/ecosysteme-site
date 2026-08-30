import CityChecker from './CityChecker'

const CLOSED = ['Bordeaux', 'Nantes', 'Aix-en-Provence', 'Nandy', 'Lannion']

export default function HeroSection() {
  return (
    <section
      id="verifier-ville"
      className="pt-28 pb-16 sm:pt-36 sm:pb-24 bg-white"
    >
      <div className="container-main">
        {/* Badge */}
        <div className="flex justify-center mb-8">
          <span className="tag bg-gold-50 text-gold-700 border border-gold-200">
            Exclusivité territoriale · 1 ville = 1 conseiller
          </span>
        </div>

        {/* Headline */}
        <h1 className="text-center text-[2.4rem] sm:text-5xl lg:text-6xl font-bold text-stone-950 leading-[1.1] tracking-tight mb-6">
          Attirez des vendeurs qualifiés
          <br className="hidden sm:block" />
          <span className="text-navy-600"> sur votre territoire.</span>
        </h1>

        {/* Sub */}
        <p className="text-center text-lg sm:text-xl text-stone-500 max-w-2xl mx-auto mb-10 leading-relaxed">
          Le système d&apos;acquisition local complet pour conseillers
          indépendants — site, SEO local, CRM, automatisations, IA. Géré pour
          vous. Personne d&apos;autre ne peut l&apos;avoir sur votre secteur.
        </p>

        {/* City checker */}
        <div className="max-w-xl mx-auto mb-8">
          <p className="text-center text-sm text-stone-400 font-medium mb-3 uppercase tracking-widest">
            Vérifiez si votre ville est encore disponible
          </p>
          <CityChecker />
        </div>

        {/* Closed cities FOMO */}
        <div className="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-sm text-stone-400">
          <span className="font-medium text-stone-500">Déjà pris :</span>
          {CLOSED.map((city) => (
            <span key={city} className="flex items-center gap-1.5">
              <span className="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0" />
              <span>{city}</span>
            </span>
          ))}
        </div>
      </div>
    </section>
  )
}
