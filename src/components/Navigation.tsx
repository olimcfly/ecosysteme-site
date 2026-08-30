"use client";

import { useState, useEffect } from "react";
import Link from "next/link";

export default function Navigation() {
  const [scrolled, setScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  const links = [
    { label: "Comment ça marche", href: "#comment-ca-marche" },
    { label: "Tarifs", href: "#tarifs" },
    { label: "Réalisations", href: "#realisations" },
    { label: "FAQ", href: "#faq" },
  ];

  return (
    <header
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        scrolled
          ? "bg-ei-bg/95 backdrop-blur-sm border-b border-ei-border"
          : "bg-transparent"
      }`}
    >
      <div className="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        {/* Logo */}
        <a href="/" className="flex items-center gap-2 font-bold text-ei-text text-lg">
          <span className="w-7 h-7 bg-ei-gold rounded-lg flex items-center justify-center text-ei-bg text-sm font-black">
            EI
          </span>
          <span className="hidden sm:block">Ecosystème Immo</span>
        </a>

        {/* Desktop nav */}
        <nav className="hidden md:flex items-center gap-6">
          {links.map((link) => (
            <a
              key={link.href}
              href={link.href}
              className="text-ei-muted hover:text-ei-text text-sm transition-colors"
            >
              {link.label}
            </a>
          ))}
        </nav>

        {/* Desktop CTA */}
        <a
          href="#verifier-ma-ville"
          className="hidden md:inline-flex items-center gap-2 bg-ei-gold hover:bg-ei-gold-light text-ei-bg font-semibold text-sm px-4 py-2.5 rounded-lg transition-colors duration-200"
        >
          Vérifier ma ville
        </a>

        {/* Mobile hamburger */}
        <button
          className="md:hidden p-2 text-ei-muted hover:text-ei-text"
          onClick={() => setMenuOpen(!menuOpen)}
          aria-label="Menu"
        >
          <div className="w-5 flex flex-col gap-1.5">
            <span
              className={`h-0.5 bg-current rounded transition-all duration-200 ${
                menuOpen ? "rotate-45 translate-y-2" : ""
              }`}
            />
            <span
              className={`h-0.5 bg-current rounded transition-all duration-200 ${
                menuOpen ? "opacity-0" : ""
              }`}
            />
            <span
              className={`h-0.5 bg-current rounded transition-all duration-200 ${
                menuOpen ? "-rotate-45 -translate-y-2" : ""
              }`}
            />
          </div>
        </button>
      </div>

      {/* Mobile menu */}
      {menuOpen && (
        <div className="md:hidden bg-ei-card border-b border-ei-border px-4 py-6 flex flex-col gap-4">
          {links.map((link) => (
            <a
              key={link.href}
              href={link.href}
              onClick={() => setMenuOpen(false)}
              className="text-ei-muted hover:text-ei-text text-base py-2 transition-colors"
            >
              {link.label}
            </a>
          ))}
          <a
            href="#verifier-ma-ville"
            onClick={() => setMenuOpen(false)}
            className="mt-2 w-full bg-ei-gold hover:bg-ei-gold-light text-ei-bg font-semibold text-base px-4 py-3 rounded-lg transition-colors text-center"
          >
            Vérifier ma ville
          </a>
        </div>
      )}
    </header>
  );
}
