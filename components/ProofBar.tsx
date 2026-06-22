import { Lock, ArrowRight } from 'lucide-react'

const CLOSED = ['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion']

interface ProofBarProps {
  onOpenModal: () => void
}

export default function ProofBar({ onOpenModal }: ProofBarProps) {
  return (
    <section id="territoires" className="bg-navy-800 border-y border-white/5 py-4">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="flex flex-col sm:flex-row items-center justify-between gap-3">
          <div className="flex flex-wrap items-center justify-center sm:justify-start gap-2 sm:gap-4">
            <div className="flex items-center gap-2 text-white/40 text-xs font-medium uppercase tracking-widest flex-shrink-0">
              <Lock size={11} className="text-gold" />
              Verrouillés
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
          </div>
          <button
            onClick={onOpenModal}
            className="flex items-center gap-1.5 text-white/50 hover:text-white/80 text-xs font-medium transition-colors flex-shrink-0 group"
          >
            Votre ville est peut-être libre
            <ArrowRight size={11} className="group-hover:translate-x-0.5 transition-transform" />
          </button>
        </div>
      </div>
    </section>
  )
}
