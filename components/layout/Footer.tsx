export default function Footer() {
  return (
    <footer className="bg-gray-900 text-gray-400">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
          <div>
            <div className="font-bold text-lg text-white mb-3">
              Écosystème<span className="text-gold">Immo</span>
            </div>
            <p className="text-sm leading-relaxed">
              Système d'acquisition local pour conseillers immobiliers indépendants. Un seul conseiller par ville.
            </p>
          </div>

          <div>
            <p className="text-sm font-semibold text-white uppercase tracking-wider mb-4">Liens</p>
            <ul className="space-y-2 text-sm">
              <li><a href="#systeme" className="hover:text-white transition-colors">Le système</a></li>
              <li><a href="#realisations" className="hover:text-white transition-colors">Réalisations</a></li>
              <li><a href="#tarifs" className="hover:text-white transition-colors">Tarifs</a></li>
              <li><a href="#faq" className="hover:text-white transition-colors">FAQ</a></li>
            </ul>
          </div>

          <div>
            <p className="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</p>
            <ul className="space-y-2 text-sm">
              <li>
                <span className="text-gray-500">Olivier Colas</span>
              </li>
              <li>
                <a href="tel:0785611700" className="hover:text-white transition-colors">
                  07 85 61 17 00
                </a>
              </li>
              <li>
                <a href="mailto:contact@ecosystemeimmo.fr" className="hover:text-white transition-colors">
                  contact@ecosystemeimmo.fr
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
          <p>© 2024 Écosystème Immo. Tous droits réservés.</p>
          <div className="flex gap-6">
            <a href="/mentions-legales" className="hover:text-white transition-colors">Mentions légales</a>
            <a href="/cgu" className="hover:text-white transition-colors">CGU</a>
            <a href="/confidentialite" className="hover:text-white transition-colors">Données personnelles</a>
          </div>
        </div>
      </div>
    </footer>
  )
}
