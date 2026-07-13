import Link from 'next/link'
import type { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'Mentions légales — Écosystème Immo',
  robots: { index: false, follow: false },
}

export default function MentionsLegales() {
  return (
    <main className="min-h-screen bg-white">
      <div className="max-w-3xl mx-auto px-4 py-20 sm:py-28">
        <Link
          href="/"
          className="text-sm text-stone-500 hover:text-navy-600 transition-colors mb-10 inline-flex items-center gap-1.5"
        >
          <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
          Retour à l&apos;accueil
        </Link>

        <h1 className="text-3xl font-bold text-stone-950 mb-10">Mentions légales</h1>

        <div className="prose prose-stone max-w-none text-stone-600 space-y-8">
          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Éditeur du site</h2>
            <p>
              Le site <strong>ecosystemeimmo.fr</strong> est édité par :<br />
              <strong>OCDM Agency</strong><br />
              Représentant légal : Olivier Colas<br />
              Email : contact@ecosystemeimmo.fr<br />
              Téléphone : 07 85 61 17 00
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Hébergement</h2>
            <p>
              Ce site est hébergé par Vercel Inc., 340 Pine Street, Suite 701, San Francisco, CA 94104, États-Unis.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Propriété intellectuelle</h2>
            <p>
              L&apos;ensemble des contenus présents sur ce site (textes, images, graphismes, logo) sont protégés par le droit d&apos;auteur et restent la propriété exclusive d&apos;OCDM Agency. Toute reproduction, même partielle, est interdite sans autorisation préalable.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Données personnelles</h2>
            <p>
              Les données collectées via les formulaires de ce site (nom, email, téléphone) sont utilisées exclusivement pour répondre à vos demandes et ne sont jamais cédées à des tiers.
              Conformément au RGPD, vous disposez d&apos;un droit d&apos;accès, de rectification et de suppression de vos données en contactant : contact@ecosystemeimmo.fr
            </p>
          </section>
        </div>
      </div>
    </main>
  )
}
