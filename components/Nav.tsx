'use client'
import { useState } from 'react'
import { Menu, X } from 'lucide-react'

interface NavProps {
  onOpenModal: () => void
}

export default function Nav({ onOpenModal }: NavProps) {
  const [mobileOpen, setMobileOpen] = useState(false)

  const links = [
    { label: 'Fonctionnalités', href: '#fonctionnalites' },
    { label: 'Tarifs', href: '#tarifs' },
    { label: 'Territoires fermés', href: '#territoires' },
  ]

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-navy/95 backdrop-blur-md border-b border-white/5">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="flex items-center justify-between h-16">
          <a href="#" className="flex-shrink-0">
            <span className="text-white font-semibold text-base tracking-tight">
              Ecosystème<span className="text-blue-400">Immo</span>
            </span>
          </a>

          <div className="hidden md:flex items-center gap-8">
            {links.map((l) => (
              <a
                key={l.href}
                href={l.href}
                className="text-white/60 hover:text-white text-sm transition-colors duration-150"
              >
                {l.label}
              </a>
            ))}
          </div>

          <div className="hidden md:block">
            <button
              onClick={onOpenModal}
              className="bg-blue-700 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors duration-150"
            >
              Vérifier ma ville
            </button>
          </div>

          <button
            onClick={() => setMobileOpen(!mobileOpen)}
            className="md:hidden text-white/80 hover:text-white p-1.5 transition-colors"
            aria-label="Menu"
          >
            {mobileOpen ? <X size={20} /> : <Menu size={20} />}
          </button>
        </div>
      </div>

      {mobileOpen && (
        <div className="md:hidden bg-navy border-t border-white/10 px-4 pb-5">
          <div className="flex flex-col gap-1 pt-3">
            {links.map((l) => (
              <a
                key={l.href}
                href={l.href}
                onClick={() => setMobileOpen(false)}
                className="text-white/70 text-sm py-2.5 border-b border-white/5 last:border-0"
              >
                {l.label}
              </a>
            ))}
            <button
              onClick={() => { setMobileOpen(false); onOpenModal() }}
              className="mt-3 bg-blue-700 text-white text-sm font-semibold px-4 py-3.5 rounded-xl w-full"
            >
              Vérifier la disponibilité de ma ville
            </button>
          </div>
        </div>
      )}
    </nav>
  )
}
