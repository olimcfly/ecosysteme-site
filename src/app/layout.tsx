import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";

const inter = Inter({
  subsets: ["latin"],
  variable: "--font-inter",
  display: "swap",
});

export const metadata: Metadata = {
  title: "Ecosystème Immo — Système d'acquisition locale pour conseillers indépendants",
  description:
    "Générez des vendeurs qualifiés dans votre ville avec un système clé-en-main : site SEO local, estimateur propriétaire, CRM automatisé, IA conversationnelle. Exclusivité territoriale garantie — 1 ville, 1 seul conseiller.",
  keywords:
    "conseiller immobilier indépendant, leads vendeurs immobilier, SEO local immobilier, mandataire immobilier, exclusivité territoriale immobilier",
  openGraph: {
    title: "Ecosystème Immo — Dominez votre marché local",
    description:
      "Le système clé-en-main pour générer des vendeurs qualifiés. Exclusivité territoriale garantie — 1 ville, 1 seul conseiller.",
    type: "website",
    locale: "fr_FR",
    siteName: "Ecosystème Immo",
  },
  robots: {
    index: true,
    follow: true,
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="fr" className={inter.variable}>
      <body className="font-sans bg-ei-bg text-ei-text antialiased">
        {children}
      </body>
    </html>
  );
}
