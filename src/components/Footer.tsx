export default function Footer() {
  return (
    <footer className="border-t border-white/[0.06] px-4 py-12">
      <div className="max-w-6xl mx-auto">
        <div className="grid sm:grid-cols-3 gap-10 mb-10">
          {/* Brand */}
          <div>
            <div className="flex items-center gap-2 mb-3">
              <div className="w-6 h-6 rounded-md bg-blue-600 flex items-center justify-center">
                <span className="text-white font-bold text-xs">E</span>
              </div>
              <span className="font-semibold text-white text-sm">Ecosystème Immo</span>
            </div>
            <p className="text-slate-500 text-xs leading-relaxed max-w-[220px]">
              Le système d'acquisition locale pour conseillers immobiliers indépendants français.
            </p>
          </div>

          {/* Links */}
          <div>
            <p className="text-slate-400 text-xs font-medium uppercase tracking-wider mb-4">Navigation</p>
            <ul className="space-y-2.5">
              {[
                { label: 'Le système', href: '#systeme' },
                { label: 'Tarifs', href: '#tarifs' },
                { label: 'FAQ', href: '#faq' },
                { label: 'Vérifier ma ville', href: '#disponibilite' },
              ].map((link) => (
                <li key={link.label}>
                  <a href={link.href} className="text-slate-500 hover:text-slate-300 text-sm transition-colors">
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <p className="text-slate-400 text-xs font-medium uppercase tracking-wider mb-4">Contact</p>
            <ul className="space-y-2.5">
              <li>
                <a href="mailto:contact@ecosystemeimmo.fr" className="text-slate-500 hover:text-slate-300 text-sm transition-colors">
                  contact@ecosystemeimmo.fr
                </a>
              </li>
              <li>
                <a href="#disponibilite" className="text-slate-500 hover:text-slate-300 text-sm transition-colors">
                  Demander une démo
                </a>
              </li>
            </ul>
          </div>
        </div>

        {/* Bottom bar */}
        <div className="border-t border-white/[0.05] pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p className="text-slate-600 text-xs">
            © {new Date().getFullYear()} Ecosystème Immo — Tous droits réservés
          </p>
          <div className="flex gap-5">
            <a href="#" className="text-slate-600 hover:text-slate-400 text-xs transition-colors">Mentions légales</a>
            <a href="#" className="text-slate-600 hover:text-slate-400 text-xs transition-colors">CGU</a>
            <a href="#" className="text-slate-600 hover:text-slate-400 text-xs transition-colors">Politique de confidentialité</a>
          </div>
        </div>
      </div>
    </footer>
  );
}
