import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({ subsets: ['latin'], display: 'swap' })

export const metadata: Metadata = {
  title: 'Ecosystème Immo — Le système d\'acquisition local pour conseillers indépendants',
  description: 'Attirez des vendeurs qualifiés dans votre ville. Site SEO local, CRM, automatisations IA et exclusivité territoriale. 1 ville = 1 conseiller.',
  openGraph: {
    title: 'Ecosystème Immo',
    description: 'Attirez des vendeurs qualifiés dans votre ville. 1 ville = 1 conseiller.',
    url: 'https://ecosystemeimmo.fr',
    siteName: 'Ecosystème Immo',
    locale: 'fr_FR',
    type: 'website',
  },
}

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr">
      <body className={`${inter.className} bg-white text-gray-900 antialiased`}>
        {children}
      </body>
    </html>
  )
}
