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

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr" className={inter.variable}>
      <body>{children}</body>
    </html>
  )
}
