import { Lock } from 'lucide-react'

const CLOSED = ['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion']

export default function ProofBar() {
  return (
    <section id="territoires" className="bg-navy-800 border-y border-white/5 py-5">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 text-center">
          <div className="flex items-center gap-2 text-white/40 text-xs font-medium uppercase tracking-widest flex-shrink-0">
            <Lock size={11} className="text-gold" />
            Territoires verrouillés
          </div>
          <div className="flex flex-wrap items-center justify-center gap-2">
            {CLOSED.map((city) => (
              <span
                key={city}
                className="inline-flex items-center gap-1.5 bg-white/5 border border-white/10 rounded-full px-3 py-1 text-xs text-white/60"
              >
                <span className="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0" />
                {city}
              </span>
            ))}
          </div>
          <div className="text-white/40 text-xs flex-shrink-0 font-medium">
            Votre ville est peut-être encore libre.
          </div>
        </div>
      </div>
    </section>
  )
}
