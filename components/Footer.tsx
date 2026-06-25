import Link from 'next/link'
import CityChecker from '@/components/CityChecker'

export default function Footer() {
  return (
    <footer className="border-t border-[#1A2840]">
      {/* Final CTA block */}
      <div className="py-20 px-4 sm:px-6 text-center">
        <div className="max-w-2xl mx-auto">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-4">
            Avant que ce soit trop tard
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-[#EEE8D8] mb-4">
            Votre ville est encore libre ?
          </h2>
          <p className="text-[#8090A8] text-sm leading-relaxed mb-2">
            Les territoires se ferment au fil des inscriptions. Vérifiez la disponibilité maintenant.
          </p>
          <CityChecker />
        </div>
      </div>

      {/* Footer bottom */}
      <div className="border-t border-[#1A2840] py-10 px-4 sm:px-6">
        <div className="max-w-6xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
          <div>
            <p className="text-[#C8A84B] font-bold text-base mb-1">Écosystème Immo</p>
            <p className="text-[#4A5568] text-sm">
              Système d&apos;acquisition locale pour conseillers indépendants
            </p>
          </div>

          <nav className="flex flex-col sm:flex-row gap-4 sm:gap-8">
            <Link href="#systeme" className="text-[#8090A8] hover:text-[#EEE8D8] text-sm transition-colors">
              Le système
            </Link>
            <Link href="#offres" className="text-[#8090A8] hover:text-[#EEE8D8] text-sm transition-colors">
              Offres
            </Link>
            <Link href="#preuves" className="text-[#8090A8] hover:text-[#EEE8D8] text-sm transition-colors">
              Territoires
            </Link>
          </nav>

          <div className="text-sm">
            <p className="text-[#EEE8D8] font-medium mb-1">Olivier Colas</p>
            <a
              href="tel:+33785611700"
              className="block text-[#8090A8] hover:text-[#EEE8D8] transition-colors mb-0.5"
            >
              07 85 61 17 00
            </a>
            <a
              href="mailto:contact@ecosystemeimmo.fr"
              className="block text-[#8090A8] hover:text-[#EEE8D8] transition-colors"
            >
              contact@ecosystemeimmo.fr
            </a>
          </div>
        </div>

        <div className="max-w-6xl mx-auto mt-8 pt-6 border-t border-[#1A2840]">
          <p className="text-[#4A5568] text-xs text-center">
            &copy; 2026 Écosystème Immo. Tous droits réservés.
          </p>
        </div>
      </div>
    </footer>
  )
}
