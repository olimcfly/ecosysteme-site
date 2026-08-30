"use client";
import { useState, useEffect } from "react";
import { CityModal } from "./CityModal";

export function Navigation() {
  const [scrolled, setScrolled] = useState(false);
  const [modalOpen, setModalOpen] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 30);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <>
      <nav
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
          scrolled
            ? "bg-[#07090F]/95 backdrop-blur-md border-b border-[#1C2333]"
            : "bg-transparent"
        }`}
      >
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16">
            {/* Logo */}
            <a href="/" className="flex-shrink-0">
              <span className="text-white font-semibold text-base tracking-tight">
                ecosystème
                <span className="text-[#C8A84B]">.</span>
                immo
              </span>
            </a>

            {/* Nav links — desktop */}
            <div className="hidden md:flex items-center gap-7">
              <a
                href="#comment-ca-marche"
                className="text-slate-400 hover:text-white text-sm transition-colors"
              >
                Comment ça marche
              </a>
              <a
                href="#tarifs"
                className="text-slate-400 hover:text-white text-sm transition-colors"
              >
                Tarifs
              </a>
              <a
                href="#faq"
                className="text-slate-400 hover:text-white text-sm transition-colors"
              >
                FAQ
              </a>
            </div>

            {/* CTA */}
            <button
              onClick={() => setModalOpen(true)}
              className="bg-[#C8A84B] hover:bg-[#B8962E] text-[#07090F] font-semibold text-sm px-4 py-2.5 rounded-lg transition-colors whitespace-nowrap"
            >
              Vérifier ma ville
            </button>
          </div>
        </div>
      </nav>

      <CityModal isOpen={modalOpen} onClose={() => setModalOpen(false)} />
    </>
  );
}
