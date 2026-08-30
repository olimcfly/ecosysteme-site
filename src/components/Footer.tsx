export default function Footer() {
  const year = new Date().getFullYear();

  return (
    <footer
      className="py-12 border-t"
      style={{
        background: "var(--navy-950)",
        borderColor: "rgba(255,255,255,0.06)",
      }}
    >
      <div className="container-site">
        <div className="grid sm:grid-cols-3 gap-8 mb-10">
          <div>
            <div className="font-bold text-white text-lg mb-3">
              Ecosystème
              <span style={{ color: "var(--accent-amber)" }}>Immo</span>
            </div>
            <p className="text-slate-500 text-sm leading-relaxed max-w-xs">
              Système d&apos;acquisition locale clé en main pour conseillers
              immobiliers indépendants. Un seul conseiller par ville.
            </p>
          </div>

          <div>
            <h4 className="text-slate-400 text-xs font-semibold uppercase tracking-widest mb-4">
              Navigation
            </h4>
            <ul className="space-y-2">
              {[
                ["Le système", "#systeme"],
                ["Comment ça marche", "#fonctionnement"],
                ["Tarifs", "#tarifs"],
                ["FAQ", "#faq"],
              ].map(([label, href]) => (
                <li key={label}>
                  <a
                    href={href}
                    className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
                  >
                    {label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="text-slate-400 text-xs font-semibold uppercase tracking-widest mb-4">
              Contact
            </h4>
            <ul className="space-y-2">
              <li>
                <a
                  href="mailto:contact@ecosystemeimmo.fr"
                  className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
                >
                  contact@ecosystemeimmo.fr
                </a>
              </li>
              <li>
                <a
                  href="https://ecosystemeimmo.fr"
                  className="text-slate-500 hover:text-slate-300 text-sm transition-colors"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  ecosystemeimmo.fr
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div
          className="pt-6 border-t flex flex-col sm:flex-row items-center justify-between gap-3"
          style={{ borderColor: "rgba(255,255,255,0.06)" }}
        >
          <p className="text-slate-600 text-xs">
            &copy; {year} Ecosystème Immo. Tous droits réservés.
          </p>
          <div className="flex items-center gap-4">
            <a
              href="#"
              className="text-slate-600 hover:text-slate-400 text-xs transition-colors"
            >
              Mentions légales
            </a>
            <a
              href="#"
              className="text-slate-600 hover:text-slate-400 text-xs transition-colors"
            >
              Politique de confidentialité
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
}
