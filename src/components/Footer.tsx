export default function Footer() {
  return (
    <footer className="py-10 px-5 sm:px-6 border-t border-gray-100 bg-white">
      <div className="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div className="font-bold text-gray-900 text-sm">Ecosystème Immo</div>
        <div className="flex items-center gap-6 text-sm text-gray-400">
          <a href="/mentions-legales" className="hover:text-gray-600 transition-colors">
            Mentions légales
          </a>
          <a href="/confidentialite" className="hover:text-gray-600 transition-colors">
            Confidentialité
          </a>
          <a
            href="mailto:contact@ecosystemeimmo.fr"
            className="hover:text-gray-600 transition-colors"
          >
            Contact
          </a>
        </div>
        <p className="text-sm text-gray-400">© 2026 Ecosystème Immo</p>
      </div>
    </footer>
  )
}
