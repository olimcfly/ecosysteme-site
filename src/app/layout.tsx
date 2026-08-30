import type { Metadata } from "next";
import { Geist } from "next/font/google";
import "./globals.css";

const geist = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
  display: "swap",
});

export const metadata: Metadata = {
  title: "Ecosystème Immo — Attirez des vendeurs qualifiés dans votre ville",
  description:
    "Système complet d'acquisition locale pour conseillers immobiliers indépendants. SEO local, site optimisé, CRM et automatisations IA — un seul conseiller par territoire.",
  openGraph: {
    title: "Ecosystème Immo — Attirez des vendeurs qualifiés dans votre ville",
    description:
      "Système d'acquisition locale clé en main pour conseillers indépendants. Exclusivité territoriale garantie.",
    url: "https://ecosystemeimmo.fr",
    siteName: "Ecosystème Immo",
    locale: "fr_FR",
    type: "website",
  },
  robots: {
    index: true,
    follow: true,
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="fr" className={`${geist.variable} scroll-smooth`}>
      <body className="min-h-screen antialiased">{children}</body>
    </html>
  );
}
