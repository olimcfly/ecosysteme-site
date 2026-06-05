import { ArrowRight, Shield } from 'lucide-react'

interface FinalCTAProps {
  onOpenModal: () => void
}

export default function FinalCTA({ onOpenModal }: FinalCTAProps) {
  return (
    <section className="py-20 sm:py-28 bg-navy relative overflow-hidden">
      <div
        aria-hidden
        className="absolute inset-0 bg-gradient-to-br from-blue-950/50 via-transparent to-transparent pointer-events-none"
      />
      <div
        aria-hidden
        className="absolute bottom-0 right-0 w-[500px] h-[300px] bg-blue-600/5 rounded-full blur-3xl pointer-events-none"
      />

      <div className="relative max-w-2xl mx-auto px-4 sm:px-6 text-center">
        <div className="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 mb-7">
          <Shield size={11} className="text-gold" />
          <span className="text-white/60 text-xs font-medium">Exclusivité territoriale garantie</span>
        </div>

        <h2 className="text-3xl sm:text-4xl font-bold text-white leading-tight mb-4">
          Votre ville est peut-être encore disponible.
        </h2>
        <p className="text-white/50 text-base leading-relaxed mb-10">
          Vérifiez maintenant — avant qu&apos;un autre conseiller de votre secteur ne le fasse.
          Une ville activée est fermée définitivement.
        </p>

        <button
          onClick={onOpenModal}
          className="btn-primary text-base px-8 py-4 rounded-xl shadow-xl shadow-blue-900/40 mb-6"
        >
          Vérifier la disponibilité de ma ville
          <ArrowRight size={16} />
        </button>

        <p className="text-white/25 text-xs">
          Vérification gratuite et sans engagement.
        </p>
      </div>
    </section>
  )
}
