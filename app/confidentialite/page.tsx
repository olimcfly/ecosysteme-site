import Link from 'next/link'
import type { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'Politique de confidentialité — Écosystème Immo',
  robots: { index: false, follow: false },
}

export default function Confidentialite() {
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

        <h1 className="text-3xl font-bold text-stone-950 mb-10">Politique de confidentialité</h1>

        <div className="prose prose-stone max-w-none text-stone-600 space-y-8">
          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Données collectées</h2>
            <p>
              Lorsque vous remplissez un formulaire sur ecosystemeimmo.fr, nous collectons :
              votre nom, adresse email, et éventuellement votre numéro de téléphone et votre ville.
              Ces informations sont utilisées uniquement pour traiter votre demande.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Finalité du traitement</h2>
            <p>
              Les données collectées sont utilisées pour :
            </p>
            <ul className="list-disc pl-5 space-y-1 mt-2">
              <li>Vous recontacter suite à une demande de disponibilité de ville</li>
              <li>Vous inscrire sur liste d&apos;attente pour un territoire</li>
              <li>Répondre à vos questions commerciales</li>
            </ul>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Conservation des données</h2>
            <p>
              Vos données sont conservées pour une durée maximale de 3 ans à compter de votre dernière interaction avec nous.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Vos droits</h2>
            <p>
              Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :
              accès, rectification, suppression, portabilité et opposition au traitement de vos données.
              Pour exercer ces droits, contactez-nous à :{' '}
              <a href="mailto:contact@ecosystemeimmo.fr" className="text-navy-600 hover:underline">
                contact@ecosystemeimmo.fr
              </a>
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Responsable de traitement</h2>
            <p>
              OCDM Agency — Olivier Colas<br />
              contact@ecosystemeimmo.fr
            </p>
          </section>
        </div>
      </div>
    </main>
  )
}
