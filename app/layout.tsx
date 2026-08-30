import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'
import Header from '@/components/layout/Header'
import Footer from '@/components/layout/Footer'

const inter = Inter({
  subsets: ['latin'],
  display: 'swap',
  variable: '--font-inter',
})

export const metadata: Metadata = {
  title: "Écosystème Immo — Système d'acquisition local pour conseillers immobiliers",
  description:
    "Devenez la référence immobilière de votre ville. Site, SEO local, Google Business, CRM et automatisations. Un seul conseiller par ville. Vérifiez si votre territoire est disponible.",
  keywords:
    'conseiller immobilier indépendant, site immobilier local, SEO immobilier, mandats exclusifs, acquisition locale',
  openGraph: {
    title: "Écosystème Immo — Devenez la référence de votre ville",
    description:
      "Un système d'acquisition local complet déployé en 7 jours. Exclusivité territoriale garantie. Un seul conseiller par ville.",
    type: 'website',
    locale: 'fr_FR',
  },
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="fr" className={inter.variable}>
      <body className="bg-white text-gray-900 antialiased">
        <Header />
        <main>{children}</main>
        <Footer />
      </body>
    </html>
  )
}
