'use client'

import { useState, useEffect } from 'react'
import Link from 'next/link'

export default function Nav() {
  const [scrolled, setScrolled] = useState(false)
  const [mobileOpen, setMobileOpen] = useState(false)

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 20)
    window.addEventListener('scroll', handleScroll, { passive: true })
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  const close = () => setMobileOpen(false)

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        scrolled
          ? 'bg-white/95 backdrop-blur-sm shadow-[0_1px_0_0_#e7e5e4]'
          : 'bg-white'
      }`}
    >
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link href="/" className="flex flex-col leading-none" onClick={close}>
            <span className="text-navy-700 font-bold text-[15px] tracking-tight">
              Écosystème Immo
            </span>
            <span className="text-stone-400 text-[11px] font-medium mt-0.5">
              Système d&apos;acquisition local
            </span>
          </Link>

          {/* Desktop links */}
          <div className="hidden md:flex items-center gap-7">
            {[
              { href: '#systeme', label: 'Le système' },
              { href: '#tarifs', label: 'Tarifs' },
              { href: '#realisations', label: 'Réalisations' },
              { href: '#faq', label: 'FAQ' },
            ].map(({ href, label }) => (
              <a
                key={href}
                href={href}
                className="text-stone-600 hover:text-navy-700 text-sm font-medium transition-colors duration-150"
              >
                {label}
              </a>
            ))}
          </div>

          {/* CTA + burger */}
          <div className="flex items-center gap-3">
            <a
              href="#verifier-ville"
              className="hidden sm:inline-flex btn-primary !py-2.5 !px-4 !text-sm"
            >
              Vérifier ma ville
            </a>

            <button
              onClick={() => setMobileOpen(!mobileOpen)}
              className="md:hidden flex flex-col justify-center gap-[5px] w-8 h-8 p-1"
              aria-label="Menu"
              aria-expanded={mobileOpen}
            >
              <span
                className={`block w-full h-0.5 bg-stone-700 transition-transform duration-200 origin-center ${
                  mobileOpen ? 'rotate-45 translate-y-[7px]' : ''
                }`}
              />
              <span
                className={`block w-full h-0.5 bg-stone-700 transition-opacity duration-200 ${
                  mobileOpen ? 'opacity-0' : ''
                }`}
              />
              <span
                className={`block w-full h-0.5 bg-stone-700 transition-transform duration-200 origin-center ${
                  mobileOpen ? '-rotate-45 -translate-y-[7px]' : ''
                }`}
              />
            </button>
          </div>
        </div>

        {/* Mobile menu */}
        {mobileOpen && (
          <div className="md:hidden border-t border-stone-100 py-5">
            <div className="flex flex-col gap-5">
              {[
                { href: '#systeme', label: 'Le système' },
                { href: '#tarifs', label: 'Tarifs' },
                { href: '#realisations', label: 'Réalisations' },
                { href: '#faq', label: 'FAQ' },
              ].map(({ href, label }) => (
                <a
                  key={href}
                  href={href}
                  onClick={close}
                  className="text-stone-700 font-medium text-base"
                >
                  {label}
                </a>
              ))}
              <a
                href="#verifier-ville"
                onClick={close}
                className="btn-primary !justify-center mt-1"
              >
                Vérifier si ma ville est disponible
              </a>
            </div>
          </div>
        )}
      </div>
    </nav>
  )
}
