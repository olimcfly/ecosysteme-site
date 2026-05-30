export default function FinalCTA() {
  return (
    <section className="py-20 px-5 sm:px-6 bg-gray-900">
      <div className="max-w-3xl mx-auto text-center">
        <div className="text-emerald-400 text-xs font-semibold uppercase tracking-widest mb-5">
          Dernière étape
        </div>
        <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4 leading-tight">
          Votre ville est peut-être encore disponible.
        </h2>
        <p className="text-gray-400 text-lg mb-8 max-w-xl mx-auto leading-relaxed">
          Chaque semaine, de nouvelles villes se ferment. Vérifiez maintenant et réservez votre
          territoire avant qu'un concurrent ne le fasse.
        </p>
        <a
          href="#disponibilite"
          className="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-8 py-4 rounded-xl hover:bg-emerald-500 active:bg-emerald-700 transition-colors text-base"
        >
          Vérifier si ma ville est disponible
          <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </a>
        <p className="mt-4 text-gray-600 text-sm">Réponse sous 24h — sans engagement</p>
      </div>
    </section>
  )
}
