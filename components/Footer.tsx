export default function Footer() {
  const year = new Date().getFullYear()

  return (
    <footer className="bg-navy border-t border-white/5 py-10">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div>
            <span className="text-white font-semibold text-sm tracking-tight">
              Ecosystème<span className="text-blue-400">Immo</span>
            </span>
            <p className="text-white/30 text-xs mt-1">Système d&apos;acquisition locale pour conseillers indépendants</p>
          </div>

          <div className="flex items-center gap-6">
            <a href="#" className="text-white/30 hover:text-white/60 text-xs transition-colors">Mentions légales</a>
            <a href="#" className="text-white/30 hover:text-white/60 text-xs transition-colors">CGV</a>
            <a href="mailto:contact@ecosystemeimmo.fr" className="text-white/30 hover:text-white/60 text-xs transition-colors">
              Contact
            </a>
          </div>
        </div>

        <div className="border-t border-white/5 mt-6 pt-6 text-center">
          <p className="text-white/20 text-xs">&copy; {year} Ecosystème Immo. Tous droits réservés.</p>
        </div>
      </div>
    </footer>
  )
}
