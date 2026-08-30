'use client'
import { ArrowRight, Shield } from 'lucide-react'

interface HeroProps {
  onOpenModal: () => void
}

export default function Hero({ onOpenModal }: HeroProps) {
  return (
    <section className="relative bg-navy pt-28 pb-20 sm:pt-36 sm:pb-28 overflow-hidden">
      <div
        aria-hidden
        className="absolute inset-0 bg-gradient-to-br from-blue-950/40 via-navy to-navy pointer-events-none"
      />
      <div
        aria-hidden
        className="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-600/5 rounded-full blur-3xl pointer-events-none"
      />

      <div className="relative max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <div className="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 mb-8">
          <Shield size={12} className="text-gold" />
          <span className="text-white/70 text-xs font-medium tracking-wide uppercase">
            Exclusivité territoriale — 1 ville, 1 conseiller
          </span>
        </div>

        <h1 className="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-[1.1] tracking-tight mb-6">
          Attirez des vendeurs qualifiés
          <br />
          <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-300">
            dans votre ville — sans prospecter.
          </span>
        </h1>

        <p className="text-lg sm:text-xl text-white/60 leading-relaxed max-w-2xl mx-auto mb-10">
          Un système d&apos;acquisition locale clé en main — site SEO, CRM vendeurs, automatisations et IA —
          activé en exclusivité sur votre territoire. Opérationnel sous 10 jours.
        </p>

        <div className="flex flex-col sm:flex-row items-center justify-center gap-3 mb-12">
          <button
            onClick={onOpenModal}
            className="btn-primary w-full sm:w-auto text-base px-8 py-4 rounded-xl shadow-xl shadow-blue-900/30"
          >
            Vérifier si ma ville est disponible
            <ArrowRight size={16} />
          </button>
          <a
            href="#fonctionnalites"
            className="text-white/50 hover:text-white/80 text-sm transition-colors py-2"
          >
            Voir le système complet
          </a>
        </div>

        <div className="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
          <span className="text-white/30 text-xs">5 villes déjà verrouillées</span>
          <span className="text-white/15 hidden sm:inline">·</span>
          <span className="text-white/30 text-xs">Opérationnel sous 10 jours</span>
          <span className="text-white/15 hidden sm:inline">·</span>
          <span className="text-white/30 text-xs">0 gestion technique requise</span>
        </div>
      </div>
    </section>
  )
}
