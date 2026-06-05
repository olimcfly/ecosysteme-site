'use client'
import { useEffect, useState } from 'react'
import { ArrowRight } from 'lucide-react'

interface StickyMobileCTAProps {
  onOpenModal: () => void
}

export default function StickyMobileCTA({ onOpenModal }: StickyMobileCTAProps) {
  const [visible, setVisible] = useState(false)

  useEffect(() => {
    const handler = () => setVisible(window.scrollY > 500)
    window.addEventListener('scroll', handler, { passive: true })
    return () => window.removeEventListener('scroll', handler)
  }, [])

  if (!visible) return null

  return (
    <div className="fixed bottom-0 left-0 right-0 z-40 sm:hidden px-4 pb-4 pt-3 bg-white/95 backdrop-blur border-t border-slate-100 shadow-lg animate-fade-in">
      <button
        onClick={onOpenModal}
        className="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors shadow-md shadow-blue-900/20"
      >
        Vérifier la disponibilité de ma ville
        <ArrowRight size={14} />
      </button>
    </div>
  )
}
