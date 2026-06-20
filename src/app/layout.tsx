import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({ subsets: ['latin'], variable: '--font-inter' })

export const metadata: Metadata = {
  title: 'EcosystemeImmo — Système d\'acquisition locale pour conseillers immobiliers indépendants',
  description:
    'Le premier système clé en main qui attire des vendeurs qualifiés dans votre secteur. Site SEO local, CRM, automatisations IA. Une ville. Un seul conseiller.',
  keywords:
    'conseiller immobilier indépendant, génération leads immobilier, SEO local immobilier, CRM immobilier, exclusivité territoriale',
}

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr" className={inter.variable}>
      <body>{children}</body>
    </html>
  )
}
