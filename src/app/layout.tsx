import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import "./globals.css";

const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
});

export const metadata: Metadata = {
  title: "Ecosystème Immo — Système d'acquisition locale pour conseillers indépendants",
  description: "Attirez des vendeurs qualifiés dans votre ville en exclusivité. Site professionnel, SEO local, CRM, automatisations et IA — tout en un.",
  keywords: "conseiller immobilier indépendant, acquisition mandats, SEO immobilier local, CRM immobilier",
  openGraph: {
    title: "Ecosystème Immo — Système d'acquisition locale",
    description: "1 ville. 1 conseiller. Un système complet pour attirer des vendeurs qualifiés.",
    type: "website",
    locale: "fr_FR",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html
      lang="fr"
      className={`${geistSans.variable} ${geistMono.variable} h-full antialiased`}
    >
      <body className="min-h-full flex flex-col">{children}</body>
    </html>
  );
}
