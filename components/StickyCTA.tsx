'use client'

import { useEffect, useRef, useState } from 'react'

const PHONE = '07 85 61 17 00'
const PHONE_HREF = 'tel:+33785611700'

export default function StickyCTA() {
  const [visible, setVisible] = useState(false)
  const [dismissed, setDismissed] = useState(false)
  const heroRef = useRef<Element | null>(null)
  const ctaRef = useRef<Element | null>(null)

  useEffect(() => {
    heroRef.current = document.getElementById('verifier-ville')
    ctaRef.current = document.getElementById('cta-final')

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.target === heroRef.current) {
            setVisible(!entry.isIntersecting)
          }
          if (entry.target === ctaRef.current) {
            setVisible(!entry.isIntersecting)
          }
        })
      },
      { threshold: 0.1 },
    )

    if (heroRef.current) observer.observe(heroRef.current)
    if (ctaRef.current) observer.observe(ctaRef.current)

    return () => observer.disconnect()
  }, [])

  if (!visible || dismissed) return null

  return (
    <div className="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-stone-200 shadow-[0_-4px_24px_rgba(0,0,0,0.08)] px-4 py-3 flex items-center gap-3">
      <a
        href={PHONE_HREF}
        className="flex items-center justify-center w-12 h-12 rounded-xl border border-stone-200 text-stone-700 hover:border-navy-300 hover:text-navy-700 transition-colors shrink-0"
        aria-label={`Appeler Olivier — ${PHONE}`}
      >
        <PhoneIcon />
      </a>
      <a
        href="#verifier-ville"
        className="flex-1 text-center py-3.5 bg-navy-600 hover:bg-navy-700 text-white font-semibold rounded-xl text-sm transition-colors"
        onClick={() => setDismissed(true)}
      >
        Vérifier si ma ville est disponible
      </a>
      <button
        onClick={() => setDismissed(true)}
        className="w-8 h-8 flex items-center justify-center text-stone-400 hover:text-stone-600 transition-colors shrink-0"
        aria-label="Fermer"
      >
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path d="M1 1l12 12M13 1L1 13" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
        </svg>
      </button>
    </div>
  )
}

function PhoneIcon() {
  return (
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden>
      <path
        d="M16.5 12.675v2.1c.001.195-.04.388-.122.564a1.43 1.43 0 0 1-.35.474 1.453 1.453 0 0 1-.514.287 1.474 1.474 0 0 1-.589.048C12.584 15.9 10.354 15.12 8.4 13.8a14.01 14.01 0 0 1-3-3 14.076 14.076 0 0 1-3.3-5.376 1.47 1.47 0 0 1 .048-.594 1.451 1.451 0 0 1 .285-.516 1.43 1.43 0 0 1 .471-.353C3.122 1.88 3.316 1.84 3.513 1.84h2.1c.35-.003.69.118.96.34.27.222.454.532.519.874.097.558.255 1.104.472 1.626a1.45 1.45 0 0 1-.331 1.536L6.3 7.158a11.536 11.536 0 0 0 3 3l.942-.942a1.452 1.452 0 0 1 1.536-.33c.522.216 1.068.374 1.626.47.348.066.661.254.885.53.223.276.342.62.336.974l-.126-.185Z"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
    </svg>
  )
}
