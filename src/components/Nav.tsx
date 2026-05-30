'use client'

import { useState, useEffect } from 'react'

export default function Nav() {
  const [scrolled, setScrolled] = useState(false)
  const [menuOpen, setMenuOpen] = useState(false)

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 20)
    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-200 ${
        scrolled
          ? 'bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm'
          : 'bg-transparent'
      }`}
    >
      <div className="max-w-6xl mx-auto px-5 sm:px-6">
        <div className="flex items-center justify-between h-16">
          <a href="#" className="font-bold text-base tracking-tight text-gray-900">
            Ecosystème Immo
          </a>

          <div className="hidden md:flex items-center gap-7 text-sm text-gray-500">
            <a href="#solution" className="hover:text-gray-900 transition-colors">
              Le système
            </a>
            <a href="#pricing" className="hover:text-gray-900 transition-colors">
              Tarifs
            </a>
            <a href="#faq" className="hover:text-gray-900 transition-colors">
              FAQ
            </a>
          </div>

          <div className="flex items-center gap-3">
            <a
              href="#disponibilite"
              className="bg-emerald-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors"
            >
              Vérifier ma ville
            </a>
            <button
              onClick={() => setMenuOpen(!menuOpen)}
              className="md:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors"
              aria-label="Menu"
            >
              <svg className="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {menuOpen ? (
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                ) : (
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                )}
              </svg>
            </button>
          </div>
        </div>
      </div>

      {menuOpen && (
        <div className="md:hidden bg-white border-t border-gray-100 px-5 py-4 space-y-1">
          <a
            href="#solution"
            onClick={() => setMenuOpen(false)}
            className="block py-2.5 text-sm text-gray-600 hover:text-gray-900"
          >
            Le système
          </a>
          <a
            href="#pricing"
            onClick={() => setMenuOpen(false)}
            className="block py-2.5 text-sm text-gray-600 hover:text-gray-900"
          >
            Tarifs
          </a>
          <a
            href="#faq"
            onClick={() => setMenuOpen(false)}
            className="block py-2.5 text-sm text-gray-600 hover:text-gray-900"
          >
            FAQ
          </a>
        </div>
      )}
    </nav>
  )
}
