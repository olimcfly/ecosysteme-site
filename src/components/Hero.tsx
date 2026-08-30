import CityChecker from './CityChecker'

export default function Hero() {
  return (
    <section className="pt-28 pb-20 md:pt-36 md:pb-28 px-4 sm:px-6 lg:px-8">
      <div className="max-w-4xl mx-auto text-center">
        <div className="inline-flex items-center gap-2 px-3 py-1.5 border border-zinc-200 rounded-full text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-8">
          Système exclusif — Disponibilité limitée par territoire
        </div>

        <h1 className="text-4xl sm:text-5xl md:text-[3.5rem] font-black tracking-tight text-zinc-950 leading-[1.1] mb-6">
          Attirez des vendeurs qualifiés
          <br className="hidden sm:block" /> dans votre secteur.{' '}
          <span className="text-amber-500">En exclusivité.</span>
        </h1>

        <p className="text-lg md:text-xl text-zinc-600 leading-relaxed max-w-2xl mx-auto mb-10">
          EcosystemeImmo est le premier système d&apos;acquisition locale conçu pour les conseillers
          immobiliers indépendants — site SEO, CRM, automatisations IA. Tout inclus.{' '}
          <strong className="text-zinc-900 font-semibold">Une ville. Un seul conseiller.</strong>
        </p>

        <div id="verifier" className="flex flex-col items-center gap-5">
          <CityChecker />

          <p className="text-xs text-zinc-400 flex items-center gap-2">
            <span className="inline-block w-1.5 h-1.5 bg-red-400 rounded-full flex-shrink-0" />
            Bordeaux · Nantes · Aix-en-Provence · Lannion · Nandy — déjà fermées
          </p>
        </div>
      </div>
    </section>
  )
}
