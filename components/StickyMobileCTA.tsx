'use client'

import { useEffect, useState } from 'react'

export default function StickyMobileCTA() {
  const [visible, setVisible] = useState(false)
  const [hidden, setHidden] = useState(false)

  useEffect(() => {
    const onScroll = () => {
      const heroEl = document.getElementById('verifier-ville')
      if (!heroEl) return
      const { bottom } = heroEl.getBoundingClientRect()
      // Apparaît dès que le hero sort du viewport
      setVisible(bottom < 0)
    }

    // Se cache quand l'user atteint la section CTA finale (répétition du form)
    const observer = new IntersectionObserver(
      ([entry]) => setHidden(entry.isIntersecting),
      { threshold: 0.1 }
    )
    const ctaFinal = document.querySelector('section.bg-navy-700')
    if (ctaFinal) observer.observe(ctaFinal)

    window.addEventListener('scroll', onScroll, { passive: true })
    return () => {
      window.removeEventListener('scroll', onScroll)
      observer.disconnect()
    }
  }, [])

  if (!visible || hidden) return null

  return (
    <div className="fixed bottom-0 left-0 right-0 z-50 md:hidden bg-white border-t border-stone-200 px-4 py-3 shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
      <div className="flex items-center gap-3">
        <div className="flex-1 min-w-0">
          <p className="text-stone-900 font-semibold text-sm truncate">
            Votre ville est peut-être disponible.
          </p>
          <p className="text-stone-400 text-xs">Vérification gratuite · Réponse sous 24h</p>
        </div>
        <a
          href="#verifier-ville"
          className="btn-primary !py-2.5 !px-4 !text-sm shrink-0"
        >
          Vérifier
        </a>
      </div>
    </div>
  )
}
