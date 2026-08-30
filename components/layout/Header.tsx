'use client'

import { useState, useEffect } from 'react'
import CityCheckerModal from '@/components/ui/CityCheckerModal'

const NAV_LINKS = [
  { label: "Le système", href: "#systeme" },
  { label: "Réalisations", href: "#realisations" },
  { label: "Tarifs", href: "#tarifs" },
  { label: "FAQ", href: "#faq" },
]

export default function Header() {
  const [isScrolled, setIsScrolled] = useState(false)
  const [isMobileOpen, setIsMobileOpen] = useState(false)
  const [isModalOpen, setIsModalOpen] = useState(false)

  useEffect(() => {
    const onScroll = () => setIsScrolled(window.scrollY > 20)
    window.addEventListener('scroll', onScroll, { passive: true })
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  return (
    <>
      <header
        className={`fixed top-0 left-0 right-0 z-40 transition-all duration-200 ${
          isScrolled ? 'bg-white/95 backdrop-blur-sm shadow-sm' : 'bg-transparent'
        }`}
      >
        <div className="max-w-6xl mx-auto px-4 sm:px-6">
          <div className="flex items-center justify-between h-16 md:h-18">
            <a href="/" className="flex items-center gap-2">
              <span className="font-bold text-lg text-navy">
                Écosystème<span className="text-gold">Immo</span>
              </span>
            </a>

            <nav className="hidden md:flex items-center gap-8">
              {NAV_LINKS.map((link) => (
                <a
                  key={link.href}
                  href={link.href}
                  className={`text-sm font-medium transition-colors ${
                    isScrolled ? 'text-gray-600 hover:text-navy' : 'text-white/80 hover:text-white'
                  }`}
                >
                  {link.label}
                </a>
              ))}
            </nav>

            <div className="flex items-center gap-3">
              <button
                onClick={() => setIsModalOpen(true)}
                className="hidden md:inline-flex btn-primary text-sm py-2.5 px-5"
              >
                Vérifier ma ville
              </button>

              <button
                onClick={() => setIsMobileOpen(!isMobileOpen)}
                className={`md:hidden p-2 rounded-lg ${
                  isScrolled ? 'text-gray-600' : 'text-white'
                }`}
                aria-label="Menu"
              >
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  {isMobileOpen ? (
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  ) : (
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                  )}
                </svg>
              </button>
            </div>
          </div>
        </div>

        {isMobileOpen && (
          <div className="md:hidden bg-white border-t border-gray-100 shadow-lg">
            <div className="max-w-6xl mx-auto px-4 py-4 flex flex-col gap-3">
              {NAV_LINKS.map((link) => (
                <a
                  key={link.href}
                  href={link.href}
                  onClick={() => setIsMobileOpen(false)}
                  className="text-gray-700 font-medium py-2 text-base"
                >
                  {link.label}
                </a>
              ))}
              <button
                onClick={() => {
                  setIsMobileOpen(false)
                  setIsModalOpen(true)
                }}
                className="btn-primary mt-2 w-full"
              >
                Vérifier si ma ville est disponible
              </button>
            </div>
          </div>
        )}
      </header>

      <CityCheckerModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </>
  )
}
