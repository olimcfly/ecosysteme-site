'use client'
import { useState, useEffect } from 'react'
import Link from 'next/link'

export default function Navigation() {
  const [scrolled, setScrolled] = useState(false)

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 10)
    window.addEventListener('scroll', handleScroll, { passive: true })
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-200 ${
        scrolled ? 'bg-white/95 backdrop-blur-sm border-b border-zinc-200' : 'bg-transparent'
      }`}
    >
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          <Link href="/" className="flex items-center">
            <span className="text-base font-black tracking-tight text-zinc-950">
              Ecosysteme<span className="text-amber-500">Immo</span>
            </span>
          </Link>
          <div className="flex items-center gap-5">
            <a
              href="#tarifs"
              className="hidden sm:block text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors"
            >
              Tarifs
            </a>
            <a
              href="#verifier"
              className="px-4 py-2 bg-zinc-900 text-white text-sm font-semibold rounded-lg hover:bg-zinc-700 transition-colors"
            >
              Vérifier ma ville
            </a>
          </div>
        </div>
      </div>
    </nav>
  )
}
