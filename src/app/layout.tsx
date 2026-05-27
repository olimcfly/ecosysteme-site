import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";

const inter = Inter({
  subsets: ["latin"],
  variable: "--font-inter",
  display: "swap",
});

export const metadata: Metadata = {
  title: "Ecosystème Immo — Attirez des vendeurs qualifiés dans votre ville",
  description:
    "Système d'acquisition locale pour conseillers immobiliers indépendants. Site SEO local, CRM, automatisations et IA — avec exclusivité territoriale garantie. 1 ville, 1 seul conseiller.",
  keywords: [
    "conseiller immobilier indépendant",
    "leads immobilier",
    "SEO local immobilier",
    "CRM immobilier",
    "exclusivité territoriale",
    "acquisition vendeurs",
  ],
  openGraph: {
    title: "Ecosystème Immo — Devenez la référence immobilière de votre ville",
    description:
      "Système d'acquisition locale complet avec exclusivité territoriale. Site SEO, CRM, automatisations, IA — 1 ville, 1 seul conseiller.",
    type: "website",
    locale: "fr_FR",
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="fr" className={inter.variable}>
      <body>{children}</body>
    </html>
  );
}
