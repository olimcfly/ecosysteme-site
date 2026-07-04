import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({
  subsets: ['latin'],
  variable: '--font-inter',
  display: 'swap',
})

export const metadata: Metadata = {
  title: 'Écosystème Immo — Système d\'acquisition locale | 1 ville = 1 conseiller',
  description:
    'Système complet pour conseillers immobiliers indépendants : site SEO local, CRM, automatisations et IA. Exclusivité territoriale garantie — un seul conseiller par ville.',
  openGraph: {
    title: 'Écosystème Immo — Système d\'acquisition locale',
    description:
      'Attirer des vendeurs qualifiés sur votre ville. Site SEO + CRM + IA. Exclusivité territoriale.',
    locale: 'fr_FR',
    type: 'website',
  },
}

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr" className={inter.variable}>
      <body className="font-sans">{children}</body>
    </html>
  )
}
