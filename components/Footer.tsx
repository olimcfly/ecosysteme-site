export default function Footer() {
  const year = new Date().getFullYear()

  return (
    <footer className="bg-navy-800 text-navy-300">
      <div className="container-main py-14">
        <div className="grid sm:grid-cols-3 gap-10 pb-10 border-b border-navy-700">
          {/* Brand */}
          <div className="sm:col-span-1">
            <p className="text-white font-bold text-base mb-2">Écosystème Immo</p>
            <p className="text-navy-400 text-sm leading-relaxed max-w-xs">
              Système d&apos;acquisition local pour conseillers immobiliers indépendants. 1 ville = 1 conseiller.
            </p>
          </div>

          {/* Nav */}
          <div>
            <p className="text-navy-200 font-semibold text-xs uppercase tracking-widest mb-4">
              Navigation
            </p>
            <ul className="flex flex-col gap-2.5">
              {[
                { href: '#systeme', label: 'Le système' },
                { href: '#tarifs', label: 'Tarifs' },
                { href: '#realisations', label: 'Réalisations' },
                { href: '#faq', label: 'FAQ' },
              ].map(({ href, label }) => (
                <li key={href}>
                  <a
                    href={href}
                    className="text-navy-400 hover:text-white text-sm transition-colors duration-150"
                  >
                    {label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <p className="text-navy-200 font-semibold text-xs uppercase tracking-widest mb-4">
              Contact
            </p>
            <ul className="flex flex-col gap-2.5">
              <li>
                <a
                  href="tel:+33785611700"
                  className="text-navy-400 hover:text-white text-sm transition-colors duration-150"
                >
                  07 85 61 17 00
                </a>
              </li>
              <li>
                <a
                  href="mailto:contact@ecosystemeimmo.fr"
                  className="text-navy-400 hover:text-white text-sm transition-colors duration-150"
                >
                  contact@ecosystemeimmo.fr
                </a>
              </li>
              <li>
                <a
                  href="#verifier-ville"
                  className="text-white font-medium text-sm hover:text-navy-200 transition-colors duration-150"
                >
                  Vérifier si ma ville est disponible
                </a>
              </li>
            </ul>
          </div>
        </div>

        {/* Bottom */}
        <div className="pt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs text-navy-500">
          <p>
            © {year} Écosystème Immo — OCDM Agency. Tous droits réservés.
          </p>
          <div className="flex gap-5">
            <a href="/mentions-legales" className="hover:text-navy-300 transition-colors">
              Mentions légales
            </a>
            <a href="/confidentialite" className="hover:text-navy-300 transition-colors">
              Confidentialité
            </a>
          </div>
        </div>
      </div>
    </footer>
  )
}
