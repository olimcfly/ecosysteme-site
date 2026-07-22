import type { Metadata } from 'next'
import Link from 'next/link'

export const metadata: Metadata = {
  title: 'Politique de confidentialité — Écosystème Immo',
  description: 'Politique de confidentialité et de traitement des données personnelles d\'Écosystème Immo.',
  robots: { index: false, follow: false },
}

export default function ConfidentialitePage() {
  return (
    <div className="min-h-screen bg-white">
      <div className="max-w-2xl mx-auto px-6 py-20">
        <Link href="/" className="text-sm text-navy-600 hover:underline mb-10 block">
          &larr; Retour à l&apos;accueil
        </Link>

        <h1 className="text-3xl font-bold text-stone-950 mb-10">Politique de confidentialité</h1>

        <div className="prose prose-stone prose-sm max-w-none space-y-8">

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Responsable du traitement</h2>
            <p className="text-stone-600 leading-relaxed">
              OCDM Agency — Olivier Colas<br />
              Email : <a href="mailto:contact@ecosystemeimmo.fr" className="text-navy-600 hover:underline">contact@ecosystemeimmo.fr</a><br />
              Téléphone : <a href="tel:+33785611700" className="text-navy-600 hover:underline">07 85 61 17 00</a>
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Données collectées</h2>
            <p className="text-stone-600 leading-relaxed mb-3">
              Lorsque vous utilisez le formulaire de vérification de ville ou les formulaires de contact, nous collectons :
            </p>
            <ul className="text-stone-600 text-sm space-y-1.5 pl-4">
              <li>Votre nom et prénom</li>
              <li>Votre adresse email</li>
              <li>Votre numéro de téléphone (facultatif)</li>
              <li>Le nom de votre ville ou secteur géographique</li>
            </ul>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Finalité du traitement</h2>
            <p className="text-stone-600 leading-relaxed">
              Ces données sont utilisées exclusivement pour :
            </p>
            <ul className="text-stone-600 text-sm space-y-1.5 pl-4 mt-2">
              <li>Vérifier la disponibilité de votre territoire et vous répondre</li>
              <li>Gérer votre inscription sur liste d&apos;attente si votre ville est fermée</li>
              <li>Traiter votre demande de souscription au système</li>
            </ul>
            <p className="text-stone-600 leading-relaxed mt-3">
              Aucune donnée n&apos;est vendue ou transmise à des tiers à des fins commerciales.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Base légale</h2>
            <p className="text-stone-600 leading-relaxed">
              Le traitement est fondé sur votre consentement (démarche volontaire via le formulaire) et sur l&apos;intérêt légitime d&apos;OCDM Agency à répondre aux demandes d&apos;information.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Durée de conservation</h2>
            <p className="text-stone-600 leading-relaxed">
              Vos données sont conservées pendant 3 ans à compter de votre dernière interaction avec nous, ou jusqu&apos;à votre demande de suppression.
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Vos droits</h2>
            <p className="text-stone-600 leading-relaxed mb-3">
              Conformément au RGPD (Règlement Général sur la Protection des Données), vous disposez des droits suivants :
            </p>
            <ul className="text-stone-600 text-sm space-y-1.5 pl-4">
              <li><strong>Accès</strong> : obtenir une copie des données vous concernant</li>
              <li><strong>Rectification</strong> : corriger des données inexactes</li>
              <li><strong>Suppression</strong> : demander l&apos;effacement de vos données</li>
              <li><strong>Opposition</strong> : vous opposer à certains traitements</li>
              <li><strong>Portabilité</strong> : recevoir vos données dans un format structuré</li>
            </ul>
            <p className="text-stone-600 leading-relaxed mt-3">
              Pour exercer ces droits, contactez-nous à{' '}
              <a href="mailto:contact@ecosystemeimmo.fr" className="text-navy-600 hover:underline">
                contact@ecosystemeimmo.fr
              </a>. En cas de litige, vous pouvez saisir la CNIL (www.cnil.fr).
            </p>
          </section>

          <section>
            <h2 className="text-lg font-semibold text-stone-900 mb-3">Sécurité</h2>
            <p className="text-stone-600 leading-relaxed">
              Nous mettons en œuvre les mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, perte ou divulgation.
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
