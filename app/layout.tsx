import type { Metadata } from 'next'
import './globals.css'

export const metadata: Metadata = {
  title: 'Ecosystème Immo — Le système d\'acquisition locale pour conseillers indépendants',
  description: 'Attirez des vendeurs qualifiés dans votre ville grâce à un système complet : site SEO local, CRM, automatisations et IA. Exclusivité territoriale garantie — une ville, un conseiller.',
  keywords: 'conseiller immobilier indépendant, SEO local immobilier, système acquisition immobilier, CRM immobilier, leads vendeurs immobilier',
  openGraph: {
    title: 'Ecosystème Immo — Devenez la référence immobilière de votre ville',
    description: 'Le système d\'acquisition locale tout-en-un pour conseillers immobiliers indépendants. Exclusivité territoriale. Site + SEO + CRM + IA.',
    type: 'website',
    locale: 'fr_FR',
  },
  robots: {
    index: true,
    follow: true,
  },
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="fr">
      <body>{children}</body>
    </html>
  )
}
