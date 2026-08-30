'use client'

import { useEffect, useState } from 'react'

export default function StickyCTA() {
  const [visible, setVisible] = useState(false)
  const [dismissed, setDismissed] = useState(false)

  useEffect(() => {
    const hero = document.getElementById('verifier-ville')
    const ctaFinal = document.getElementById('cta-final')
    if (!hero) return

    const heroObserver = new IntersectionObserver(
      ([entry]) => setVisible(!entry.isIntersecting),
      { threshold: 0.1 },
    )

    let ctaObserver: IntersectionObserver | null = null
    if (ctaFinal) {
      ctaObserver = new IntersectionObserver(
        ([entry]) => { if (entry.isIntersecting) setVisible(false) },
        { threshold: 0.4 },
      )
      ctaObserver.observe(ctaFinal)
    }

    heroObserver.observe(hero)
    return () => {
      heroObserver.disconnect()
      ctaObserver?.disconnect()
    }
  }, [])

  if (!visible || dismissed) return null

  return (
    <div className="md:hidden fixed bottom-0 left-0 right-0 z-40 p-3 bg-white border-t border-stone-200 shadow-[0_-4px_24px_rgba(0,0,0,0.09)]">
      <div className="flex items-center gap-2">
        <a
          href="#verifier-ville"
          className="flex-1 text-center py-3 bg-navy-600 hover:bg-navy-700 text-white font-semibold rounded-lg text-sm transition-colors leading-none"
        >
          Vérifier si ma ville est libre
        </a>
        <a
          href="tel:+33785611700"
          className="flex-none w-12 h-12 flex items-center justify-center border border-stone-200 rounded-lg text-stone-500 hover:text-navy-700 hover:border-navy-300 transition-colors"
          aria-label="Appeler Olivier"
        >
          <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
          </svg>
        </a>
        <button
          onClick={() => setDismissed(true)}
          className="flex-none w-8 h-8 flex items-center justify-center text-stone-300 hover:text-stone-500 transition-colors"
          aria-label="Fermer"
        >
          <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  )
}
