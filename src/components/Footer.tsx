import { CONTACT_EMAIL } from '@/lib/config'

export default function Footer() {
  return (
    <footer className="bg-zinc-950 border-t border-zinc-800/60 py-10 px-4 sm:px-6 lg:px-8">
      <div className="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
          <span className="text-base font-black tracking-tight text-white">
            Ecosysteme<span className="text-amber-500">Immo</span>
          </span>
          <p className="text-xs text-zinc-600 mt-1">
            Système d&apos;acquisition locale pour conseillers indépendants
          </p>
        </div>
        <div className="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
          <a
            href={`mailto:${CONTACT_EMAIL}`}
            className="text-xs text-zinc-500 hover:text-zinc-300 transition-colors"
          >
            {CONTACT_EMAIL}
          </a>
          <a
            href="#tarifs"
            className="text-xs text-zinc-500 hover:text-zinc-300 transition-colors"
          >
            Tarifs
          </a>
          <a href="#" className="text-xs text-zinc-500 hover:text-zinc-300 transition-colors">
            Mentions légales
          </a>
          <a href="#" className="text-xs text-zinc-500 hover:text-zinc-300 transition-colors">
            CGV
          </a>
        </div>
      </div>
      <div className="max-w-6xl mx-auto mt-8 pt-6 border-t border-zinc-800/60">
        <p className="text-xs text-zinc-700 text-center">
          © 2026 EcosystemeImmo — Tous droits réservés
        </p>
      </div>
    </footer>
  )
}
