"use client";
import { useState } from "react";
import { CityModal } from "./CityModal";

export function Hero() {
  const [modalOpen, setModalOpen] = useState(false);

  return (
    <>
      <section className="relative min-h-screen bg-[#07090F] flex items-center pt-16 overflow-hidden">
        {/* Subtle radial glow */}
        <div
          className="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] opacity-[0.06] pointer-events-none"
          style={{
            background:
              "radial-gradient(ellipse at center, #C8A84B 0%, transparent 70%)",
          }}
        />

        {/* Dot grid background */}
        <div
          className="absolute inset-0 opacity-[0.03] pointer-events-none"
          style={{
            backgroundImage:
              "radial-gradient(circle, #ffffff 1px, transparent 1px)",
            backgroundSize: "32px 32px",
          }}
        />

        <div className="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
          {/* Kicker badge */}
          <div className="inline-flex items-center gap-2.5 bg-[#C8A84B]/10 border border-[#C8A84B]/20 rounded-full px-4 py-1.5 mb-8">
            <span className="w-1.5 h-1.5 rounded-full bg-[#C8A84B] animate-pulse-slow" />
            <span className="text-[#C8A84B] text-xs font-medium tracking-widest uppercase">
              Exclusivité territoriale — 1 ville, 1 seul conseiller
            </span>
          </div>

          {/* Headline */}
          <h1 className="text-4xl sm:text-5xl lg:text-[3.5rem] font-bold text-white leading-[1.1] mb-6 tracking-tight text-balance">
            Devenez la référence immobilière
            <br />
            <span className="text-[#C8A84B]">de votre ville</span>
          </h1>

          {/* Sub-headline */}
          <p className="text-slate-400 text-lg sm:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            Site SEO local, CRM, automatisations et IA — tout configuré pour
            votre territoire.{" "}
            <span className="text-slate-200 font-medium">
              Exclusivité garantie : une seule ville, un seul conseiller.
            </span>
          </p>

          {/* CTAs */}
          <div className="flex flex-col sm:flex-row items-center justify-center gap-4 mb-14">
            <button
              onClick={() => setModalOpen(true)}
              className="w-full sm:w-auto bg-[#C8A84B] hover:bg-[#B8962E] text-[#07090F] font-bold text-base px-8 py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-[0_8px_30px_rgba(200,168,75,0.25)] flex items-center justify-center gap-2"
            >
              Vérifier si ma ville est disponible
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path
                  d="M3 8h10M9 4l4 4-4 4"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
            </button>
            <a
              href="#comment-ca-marche"
              className="text-slate-400 hover:text-slate-200 text-sm transition-colors flex items-center gap-1"
            >
              Voir comment ça marche
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path
                  d="M7 2v10M3 8l4 4 4-4"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
            </a>
          </div>

          {/* Trust indicators */}
          <div className="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-slate-600">
            <span className="flex items-center gap-1.5">
              <span className="w-1.5 h-1.5 rounded-full bg-red-500" />
              5 villes déjà fermées ce mois
            </span>
            <span className="hidden sm:block text-slate-800">·</span>
            <span>Setup en 5–7 jours ouvrés</span>
            <span className="hidden sm:block text-slate-800">·</span>
            <span>Sans engagement après 3 mois</span>
          </div>
        </div>
      </section>

      <CityModal isOpen={modalOpen} onClose={() => setModalOpen(false)} />
    </>
  );
}
