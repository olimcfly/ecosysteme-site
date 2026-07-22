import type { Metadata } from 'next'
import Link from 'next/link'

export const metadata: Metadata = {
  title: 'Mentions légales — Écosystème Immo',
  description: 'Mentions légales du site ecosystemeimmo.fr — Écosystème Immo, OCDM Agency.',
  robots: { index: false, follow: false },
}

export default function MentionsLegalesPage() {
  return (
    <div className="min-h-screen bg-white">
      <div className="max-w-2xl mx-auto px-6 py-20">
        <Link href="/" className="text-sm text-navy-600 hover:underline mb-10 block">
          &larr; Retour à l&apos;accueil
        </Link>

        <h1 className="text-3xl font-bold text-stone-950 mb-10">Mentions légales</h1>

        <div className="prose prose-stone prose-sm max-w-none space-y-8">

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Éditeur du site</h2>
            <p className="text-stone-600 leading-relaxed">
              <strong>OCDM Agency</strong><br />
              Représentant légal : Olivier Colas<br />
              Adresse : France<br />
              Téléphone : <a href="tel:+33785611700" className="text-navy-600 hover:underline">07 85 61 17 00</a><br />
              Email : <a href="mailto:contact@ecosystemeimmo.fr" className="text-navy-600 hover:underline">contact@ecosystemeimmo.fr</a>
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Hébergement</h2>
            <p className="text-stone-600 leading-relaxed">
              Ce site est hébergé par Vercel Inc., 340 Pine Street, Suite 701, San Francisco, CA 94104, USA.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Propriété intellectuelle</h2>
            <p className="text-stone-600 leading-relaxed">
              L&apos;ensemble des contenus présents sur ce site (textes, images, structure, logotypes) est la propriété exclusive d&apos;OCDM Agency et est protégé par les lois relatives à la propriété intellectuelle. Toute reproduction, totale ou partielle, est interdite sans autorisation préalable.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Responsabilité</h2>
            <p className="text-stone-600 leading-relaxed">
              OCDM Agency s&apos;efforce d&apos;assurer l&apos;exactitude des informations diffusées sur ce site. Toutefois, les informations présentées sont susceptibles d&apos;évoluer sans préavis et ne sauraient engager la responsabilité de l&apos;éditeur.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Données personnelles</h2>
            <p className="text-stone-600 leading-relaxed">
              Les données collectées via les formulaires de ce site sont utilisées uniquement dans le cadre du traitement de vos demandes. Conformément au RGPD et à la loi Informatique et Libertés, vous disposez d&apos;un droit d&apos;accès, de rectification et de suppression de vos données.{' '}
              <Link href="/confidentialite" className="text-navy-600 hover:underline">
                Politique de confidentialité
              </Link>
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Cookies</h2>
            <p className="text-stone-600 leading-relaxed">
              Ce site peut utiliser des cookies techniques nécessaires à son bon fonctionnement. Aucun cookie publicitaire ou de traçage tiers n&apos;est déposé sans votre consentement.
            </p>
          </section>

          <p className="text-stone-400 text-xs pt-6 border-t border-stone-100">
            Dernière mise à jour : juillet 2026
          </p>
        </div>
      </div>
    </div>
  )
}
