'use client';

import { useState, useEffect } from 'react';

export default function Nav() {
  const [scrolled, setScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40);
    window.addEventListener('scroll', onScroll);
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        scrolled
          ? 'bg-[#06070d]/95 backdrop-blur-md border-b border-white/5 shadow-lg shadow-black/30'
          : 'bg-transparent'
      }`}
    >
      <div className="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
        <a href="#" className="flex items-center gap-2">
          <div className="w-7 h-7 rounded-md bg-blue-600 flex items-center justify-center">
            <span className="text-white font-bold text-sm">E</span>
          </div>
          <span className="font-semibold text-white tracking-tight">Ecosystème Immo</span>
        </a>

        {/* Desktop nav */}
        <div className="hidden md:flex items-center gap-8">
          <a href="#systeme" className="text-sm text-slate-400 hover:text-white transition-colors">Le système</a>
          <a href="#tarifs" className="text-sm text-slate-400 hover:text-white transition-colors">Tarifs</a>
          <a href="#faq" className="text-sm text-slate-400 hover:text-white transition-colors">FAQ</a>
          <a
            href="#disponibilite"
            className="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium transition-colors"
          >
            Vérifier ma ville
          </a>
        </div>

        {/* Mobile hamburger */}
        <button
          className="md:hidden p-2 text-slate-400 hover:text-white"
          onClick={() => setMenuOpen(!menuOpen)}
          aria-label="Menu"
        >
          {menuOpen ? (
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          ) : (
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          )}
        </button>
      </div>

      {/* Mobile menu */}
      {menuOpen && (
        <div className="md:hidden bg-[#06070d]/98 backdrop-blur-md border-t border-white/5 px-4 py-6 flex flex-col gap-5">
          <a href="#systeme" className="text-slate-300" onClick={() => setMenuOpen(false)}>Le système</a>
          <a href="#tarifs" className="text-slate-300" onClick={() => setMenuOpen(false)}>Tarifs</a>
          <a href="#faq" className="text-slate-300" onClick={() => setMenuOpen(false)}>FAQ</a>
          <a
            href="#disponibilite"
            className="w-full text-center px-4 py-3 rounded-lg bg-blue-600 text-white font-medium"
            onClick={() => setMenuOpen(false)}
          >
            Vérifier ma ville
          </a>
        </div>
      )}
    </nav>
  );
}
