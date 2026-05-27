export function Footer() {
  const year = new Date().getFullYear();

  return (
    <footer className="bg-[#07090F] border-t border-[#1C2333]">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
          {/* Logo */}
          <div>
            <span className="text-white font-semibold text-base tracking-tight">
              ecosystème<span className="text-[#C8A84B]">.</span>immo
            </span>
            <p className="text-slate-600 text-xs mt-1 max-w-xs">
              Système d'acquisition locale pour conseillers immobiliers indépendants.
            </p>
          </div>

          {/* Links */}
          <nav className="flex flex-wrap gap-5">
            <a
              href="#comment-ca-marche"
              className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
            >
              Comment ça marche
            </a>
            <a
              href="#tarifs"
              className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
            >
              Tarifs
            </a>
            <a
              href="#faq"
              className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
            >
              FAQ
            </a>
            <a
              href="mailto:contact@ecosystemeimmo.fr"
              className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
            >
              Contact
            </a>
          </nav>
        </div>

        <div className="border-t border-[#1C2333] mt-8 pt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
          <p className="text-slate-600 text-xs">
            © {year} Ecosystème Immo. Tous droits réservés.
          </p>
          <div className="flex gap-4">
            <a
              href="/mentions-legales"
              className="text-slate-600 hover:text-slate-400 text-xs transition-colors"
            >
              Mentions légales
            </a>
            <a
              href="/cgv"
              className="text-slate-600 hover:text-slate-400 text-xs transition-colors"
            >
              CGV
            </a>
            <a
              href="/confidentialite"
              className="text-slate-600 hover:text-slate-400 text-xs transition-colors"
            >
              Confidentialité
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
}
