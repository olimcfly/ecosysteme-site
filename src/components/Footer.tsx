const CURRENT_YEAR = 2026;

export default function Footer() {
  return (
    <footer className="border-t border-ei-border bg-ei-bg">
      <div className="max-w-6xl mx-auto px-4 py-12">
        <div className="grid sm:grid-cols-3 gap-10 mb-10">
          {/* Brand */}
          <div>
            <div className="flex items-center gap-2 font-bold text-ei-text text-lg mb-3">
              <span className="w-7 h-7 bg-ei-gold rounded-lg flex items-center justify-center text-ei-bg text-sm font-black">
                EI
              </span>
              Ecosystème Immo
            </div>
            <p className="text-ei-faint text-sm leading-relaxed">
              Le système d'acquisition locale pour conseillers immobiliers
              indépendants. Exclusivité territoriale garantie.
            </p>
          </div>

          {/* Liens */}
          <div>
            <p className="text-ei-text text-sm font-semibold mb-4">
              Navigation
            </p>
            <ul className="space-y-2.5">
              {[
                { label: "Comment ça marche", href: "#comment-ca-marche" },
                { label: "Le système", href: "#systeme" },
                { label: "Tarifs", href: "#tarifs" },
                { label: "Réalisations", href: "#realisations" },
                { label: "FAQ", href: "#faq" },
              ].map((link) => (
                <li key={link.href}>
                  <a
                    href={link.href}
                    className="text-ei-faint hover:text-ei-muted text-sm transition-colors"
                  >
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <p className="text-ei-text text-sm font-semibold mb-4">Contact</p>
            <ul className="space-y-2.5">
              <li>
                <a
                  href="mailto:contact@ecosystemeimmo.fr"
                  className="text-ei-faint hover:text-ei-muted text-sm transition-colors"
                >
                  contact@ecosystemeimmo.fr
                </a>
              </li>
              <li>
                <a
                  href="tel:+33785611700"
                  className="text-ei-faint hover:text-ei-muted text-sm transition-colors"
                >
                  07 85 61 17 00
                </a>
              </li>
            </ul>
            <a
              href="#verifier-ma-ville"
              className="mt-6 inline-flex bg-ei-gold hover:bg-ei-gold-light text-ei-bg font-semibold text-sm px-4 py-2.5 rounded-lg transition-colors"
            >
              Vérifier ma ville
            </a>
          </div>
        </div>

        {/* Bottom bar */}
        <div className="border-t border-ei-border pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-ei-faint">
          <p>© {CURRENT_YEAR} Ecosystème Immo — OCDM Agency · Tous droits réservés</p>
          <div className="flex gap-5">
            <a href="/mentions-legales" className="hover:text-ei-muted transition-colors">
              Mentions légales
            </a>
            <a href="/cgu" className="hover:text-ei-muted transition-colors">
              CGU
            </a>
            <a href="/confidentialite" className="hover:text-ei-muted transition-colors">
              Confidentialité
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
}
