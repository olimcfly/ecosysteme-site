import Link from 'next/link'

export default function Nav() {
  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-[#080E1A]/95 backdrop-blur-sm border-b border-[#1A2840]">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
        <Link href="/" className="text-[#C8A84B] font-bold text-base tracking-tight flex-shrink-0">
          Écosystème Immo
        </Link>

        <div className="hidden md:flex items-center gap-8">
          <Link
            href="#systeme"
            className="text-[#8090A8] hover:text-[#EEE8D8] text-sm transition-colors"
          >
            Le système
          </Link>
          <Link
            href="#offres"
            className="text-[#8090A8] hover:text-[#EEE8D8] text-sm transition-colors"
          >
            Offres
          </Link>
          <Link
            href="#preuves"
            className="text-[#8090A8] hover:text-[#EEE8D8] text-sm transition-colors"
          >
            Territoires déployés
          </Link>
        </div>

        <Link
          href="#verifier"
          className="flex-shrink-0 bg-[#C8A84B] hover:bg-[#D4B56A] text-[#080E1A] font-semibold text-sm px-4 py-2 rounded transition-colors"
        >
          Vérifier ma ville
        </Link>
      </div>
    </nav>
  )
}
