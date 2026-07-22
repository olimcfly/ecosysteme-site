import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({
  subsets: ['latin'],
  variable: '--font-inter',
  display: 'swap',
})

export const metadata: Metadata = {
  title: 'Écosystème Immo — Système d\'acquisition local pour conseillers immobiliers',
  description: 'Attirez des vendeurs qualifiés sur votre territoire. Site, SEO local, CRM, automatisations, IA. Exclusivité garantie par ville. 1 conseiller = 1 ville.',
  openGraph: {
    title: 'Écosystème Immo — Devenez le conseiller référent de votre ville',
    description: 'Le système d\'acquisition local complet pour conseillers immobiliers indépendants. 1 ville = 1 conseiller, garanti par contrat.',
    type: 'website',
    locale: 'fr_FR',
    url: 'https://ecosystemeimmo.fr',
    siteName: 'Écosystème Immo',
  },
  twitter: {
    card: 'summary_large_image',
    title: 'Écosystème Immo — Système d\'acquisition local',
    description: 'Attirez des vendeurs qualifiés sur votre territoire. Exclusivité 1 ville = 1 conseiller.',
  },
  robots: {
    index: true,
    follow: true,
  },
  alternates: {
    canonical: 'https://ecosystemeimmo.fr',
  },
}

const schemaOrg = {
  '@context': 'https://schema.org',
  '@graph': [
    {
      '@type': 'Organization',
      '@id': 'https://ecosystemeimmo.fr/#organization',
      name: 'Écosystème Immo',
      url: 'https://ecosystemeimmo.fr',
      telephone: '+33785611700',
      email: 'contact@ecosystemeimmo.fr',
      description: 'Système d\'acquisition local pour conseillers immobiliers indépendants. Exclusivité territoriale : 1 ville = 1 conseiller.',
      founder: {
        '@type': 'Person',
        name: 'Olivier Colas',
      },
      areaServed: {
        '@type': 'Country',
        name: 'France',
      },
      offers: {
        '@type': 'Offer',
        name: 'Système d\'acquisition local immobilier',
        priceSpecification: [
          {
            '@type': 'PriceSpecification',
            name: 'Formule Mensuelle',
            price: '97',
            priceCurrency: 'EUR',
            unitText: 'month',
          },
          {
            '@type': 'PriceSpecification',
            name: 'Formule Annuelle',
            price: '897',
            priceCurrency: 'EUR',
            unitText: 'year',
          },
        ],
      },
    },
    {
      '@type': 'WebSite',
      '@id': 'https://ecosystemeimmo.fr/#website',
      url: 'https://ecosystemeimmo.fr',
      name: 'Écosystème Immo',
      publisher: { '@id': 'https://ecosystemeimmo.fr/#organization' },
      inLanguage: 'fr-FR',
    },
  ],
}

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr" className={inter.variable}>
      <head>
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(schemaOrg) }}
        />
      </head>
      <body>{children}</body>
    </html>
  )
}
