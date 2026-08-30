export default function FinalCTA() {
  return (
    <section className="py-24 px-4">
      <div className="max-w-3xl mx-auto">
        <div className="relative rounded-3xl overflow-hidden border border-blue-500/20 bg-gradient-to-br from-blue-600/15 to-blue-900/10 p-10 sm:p-16 text-center">
          {/* Background glow */}
          <div className="absolute inset-0 pointer-events-none">
            <div className="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent" />
            <div className="absolute -top-20 left-1/2 -translate-x-1/2 w-[400px] h-[300px] bg-blue-600/15 rounded-full blur-[80px]" />
          </div>

          <div className="relative">
            <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-300 text-xs font-medium mb-7">
              <span className="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse" />
              Places limitées par ville
            </div>

            <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4 leading-tight">
              Votre ville est peut-être<br /> encore disponible.
            </h2>
            <p className="text-slate-400 max-w-lg mx-auto mb-10 leading-relaxed">
              Chaque territoire ne peut être attribué qu'une seule fois.
              Une fois votre ville fermée, aucune exception n'est possible.
            </p>

            <div className="flex flex-col sm:flex-row gap-3 justify-center">
              <a
                href="#disponibilite"
                className="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold text-base transition-all shadow-xl shadow-blue-600/30 hover:-translate-y-0.5 hover:shadow-blue-600/40"
              >
                Vérifier si ma ville est disponible
              </a>
              <a
                href="mailto:contact@ecosystemeimmo.fr"
                className="px-8 py-4 rounded-xl border border-white/10 hover:border-white/20 text-slate-300 hover:text-white text-base transition-all bg-white/3 hover:bg-white/5"
              >
                Demander une démo
              </a>
            </div>

            <p className="text-slate-600 text-xs mt-6">
              Sans engagement — Résultat en 72h — Exclusivité garantie
            </p>
          </div>
        </div>
      </div>
    </section>
  );
}
