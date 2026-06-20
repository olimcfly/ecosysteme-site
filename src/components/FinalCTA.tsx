import CityChecker from './CityChecker'

export default function FinalCTA() {
  return (
    <section id="contact" className="py-20 md:py-28 px-4 sm:px-6 lg:px-8 bg-zinc-950">
      <div className="max-w-2xl mx-auto text-center">
        <p className="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-6">
          Disponibilité
        </p>
        <h2 className="text-3xl md:text-4xl font-bold tracking-tight text-white mb-5">
          Votre ville est peut-être encore disponible.
        </h2>
        <p className="text-base text-zinc-400 leading-relaxed mb-10">
          Les exclusivités territoriales se réservent dans l&apos;ordre des demandes. Une fois votre
          ville attribuée à un conseiller, elle est fermée définitivement pour les autres.
        </p>
        <div className="flex justify-center">
          <CityChecker dark={true} />
        </div>
        <p className="mt-8 text-xs text-zinc-600">
          Bordeaux · Nantes · Aix-en-Provence · Lannion · Nandy — déjà fermées
        </p>
      </div>
    </section>
  )
}
