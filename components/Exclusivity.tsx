import { Lock, CheckCircle } from 'lucide-react'

const CLOSED = ['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion']

const GUARANTEES = [
  'Aucun concurrent actif sur votre secteur digital',
  'Votre ville retirée du catalogue dès activation',
  'Transmissible si vous changez de secteur',
  'Priorité sur les nouvelles fonctionnalités locales',
]

export default function Exclusivity() {
  return (
    <section className="py-20 sm:py-28 bg-navy overflow-hidden">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
          {/* Left: copy */}
          <div>
            <span className="inline-block text-xs font-semibold uppercase tracking-widest text-blue-400 mb-3">
              Exclusivité territoriale
            </span>
            <h2 className="text-3xl sm:text-4xl font-bold text-white leading-tight mb-5">
              1 ville. 1 conseiller.
              <br />
              <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-300">
                Verrouillé à vie.
              </span>
            </h2>
            <p className="text-white/55 text-base leading-relaxed mb-8">
              Contrairement aux outils que tout le monde utilise, Ecosystème Immo vous garantit
              l&apos;exclusivité digitale sur votre territoire. Quand votre ville est activée —
              elle est fermée à tous les autres conseillers. Définitivement.
            </p>

            <ul className="space-y-3 mb-8">
              {GUARANTEES.map((g) => (
                <li key={g} className="flex items-start gap-3">
                  <CheckCircle size={16} className="text-blue-400 flex-shrink-0 mt-0.5" />
                  <span className="text-white/70 text-sm">{g}</span>
                </li>
              ))}
            </ul>
          </div>

          {/* Right: visual — closed cities */}
          <div className="bg-navy-700 rounded-2xl border border-white/8 p-8">
            <div className="flex items-center gap-2 mb-6">
              <Lock size={14} className="text-gold" />
              <span className="text-white/40 text-xs font-medium uppercase tracking-widest">
                Territoires verrouillés
              </span>
            </div>

            <div className="space-y-3">
              {CLOSED.map((city) => (
                <div
                  key={city}
                  className="flex items-center justify-between bg-white/3 rounded-xl px-4 py-3.5 border border-white/5"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-2 h-2 rounded-full bg-red-500" />
                    <span className="text-white/80 text-sm font-medium">{city}</span>
                  </div>
                  <span className="text-red-400/70 text-xs font-medium">Fermé</span>
                </div>
              ))}

              {/* Placeholder to show more could be taken */}
              <div className="flex items-center justify-between bg-white/3 rounded-xl px-4 py-3.5 border border-white/5 border-dashed">
                <div className="flex items-center gap-3">
                  <div className="w-2 h-2 rounded-full bg-green-500" />
                  <span className="text-white/30 text-sm">Votre ville</span>
                </div>
                <span className="text-green-400/60 text-xs font-medium">Disponible</span>
              </div>
            </div>

            <p className="text-white/30 text-xs mt-5 text-center">
              Vérifiez la disponibilité avant qu&apos;un concurrent ne le fasse.
            </p>
          </div>
        </div>
      </div>
    </section>
  )
}
