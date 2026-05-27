"use client";
import { useState } from "react";
import { CityModal } from "./CityModal";

export function FinalCTA() {
  const [modalOpen, setModalOpen] = useState(false);

  return (
    <>
      <section className="bg-[#07090F] py-20 sm:py-28">
        <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          {/* Urgency signal */}
          <div className="inline-flex items-center gap-2 bg-red-950/40 border border-red-900/30 rounded-full px-4 py-1.5 mb-8">
            <span className="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse" />
            <span className="text-red-400 text-xs font-medium">
              5 villes fermées · Places limitées par secteur
            </span>
          </div>

          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6 text-balance">
            Votre ville est peut-être
            <br />
            <span className="text-[#C8A84B]">encore disponible.</span>
          </h2>

          <p className="text-slate-400 text-lg mb-10 leading-relaxed max-w-xl mx-auto">
            Vérifiez en 30 secondes. Si elle est libre, vous pouvez réserver
            votre exclusivité aujourd'hui. Demain, ce sera peut-être trop tard.
          </p>

          <button
            onClick={() => setModalOpen(true)}
            className="inline-flex items-center gap-3 bg-[#C8A84B] hover:bg-[#B8962E] text-[#07090F] font-bold text-base px-10 py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-[0_8px_30px_rgba(200,168,75,0.3)] mb-6"
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

          <div className="flex flex-wrap items-center justify-center gap-5 text-slate-600 text-xs">
            <span className="flex items-center gap-1.5">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M2 6l3 3 5-5" stroke="#C8A84B" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
              </svg>
              Vérification gratuite
            </span>
            <span className="flex items-center gap-1.5">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M2 6l3 3 5-5" stroke="#C8A84B" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
              </svg>
              Sans engagement immédiat
            </span>
            <span className="flex items-center gap-1.5">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M2 6l3 3 5-5" stroke="#C8A84B" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
              </svg>
              Setup en 5–7 jours
            </span>
          </div>
        </div>
      </section>

      <CityModal isOpen={modalOpen} onClose={() => setModalOpen(false)} />
    </>
  );
}
