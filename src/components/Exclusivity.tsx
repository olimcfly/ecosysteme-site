"use client";
import { useState } from "react";
import { CityModal } from "./CityModal";

export function Exclusivity() {
  const [modalOpen, setModalOpen] = useState(false);

  return (
    <>
      <section className="bg-[#07090F] py-20 sm:py-28 overflow-hidden">
        <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {/* Left: text */}
            <div>
              <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-4">
                Le différenciateur clé
              </p>
              <h2 className="text-3xl sm:text-4xl font-bold text-white leading-tight mb-6 text-balance">
                Votre ville.
                <br />
                Votre territoire.
                <br />
                <span className="text-[#C8A84B]">Votre monopole local.</span>
              </h2>
              <p className="text-slate-400 text-base leading-relaxed mb-6">
                L'exclusivité territoriale n'est pas un bonus — c'est le fondement du
                système. Une seule personne peut utiliser Ecosystème Immo pour une ville donnée.
                Quand vous prenez votre territoire, il est verrouillé à votre nom.
              </p>

              <ul className="space-y-3 mb-8">
                {[
                  "Aucun concurrent ne peut utiliser le système sur votre ville",
                  "Votre positionnement SEO local vous appartient",
                  "Les vendeurs de votre ville ne voient que vous",
                  "Territoire garanti contractuellement à vie",
                ].map((item) => (
                  <li key={item} className="flex items-start gap-3">
                    <div className="w-5 h-5 rounded-full bg-[#C8A84B]/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                      <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path
                          d="M1.5 5l2.5 2.5 4.5-4.5"
                          stroke="#C8A84B"
                          strokeWidth="1.5"
                          strokeLinecap="round"
                          strokeLinejoin="round"
                        />
                      </svg>
                    </div>
                    <span className="text-slate-300 text-sm">{item}</span>
                  </li>
                ))}
              </ul>

              <button
                onClick={() => setModalOpen(true)}
                className="bg-[#C8A84B] hover:bg-[#B8962E] text-[#07090F] font-bold text-sm px-6 py-3.5 rounded-xl transition-colors"
              >
                Vérifier si ma ville est disponible
              </button>
            </div>

            {/* Right: visual */}
            <div className="flex justify-center lg:justify-end">
              <div className="relative w-full max-w-sm">
                {/* Territory card */}
                <div className="bg-[#0D1117] border border-[#1C2333] rounded-2xl p-6">
                  <div className="flex items-center gap-3 mb-5">
                    <div className="w-10 h-10 rounded-xl bg-[#C8A84B]/10 border border-[#C8A84B]/20 flex items-center justify-center">
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path
                          d="M9 1.5C6.105 1.5 3.75 3.855 3.75 6.75c0 4.5 5.25 9.75 5.25 9.75S14.25 11.25 14.25 6.75C14.25 3.855 11.895 1.5 9 1.5zm0 7.125a2.25 2.25 0 110-4.5 2.25 2.25 0 010 4.5z"
                          fill="#C8A84B"
                        />
                      </svg>
                    </div>
                    <div>
                      <div className="text-white font-semibold text-sm">Territoire réservé</div>
                      <div className="text-slate-500 text-xs">Verrouillé à votre nom</div>
                    </div>
                    <div className="ml-auto">
                      <span className="bg-emerald-950/50 border border-emerald-900/50 text-emerald-400 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Actif
                      </span>
                    </div>
                  </div>

                  {/* Fictitious example */}
                  <div className="bg-[#07090F] rounded-xl p-4 mb-4">
                    <div className="text-slate-500 text-xs mb-1 uppercase tracking-wider">Ville</div>
                    <div className="text-white font-semibold text-lg">Lyon 3e</div>
                    <div className="text-slate-500 text-xs mt-2">Conseiller : Votre nom</div>
                  </div>

                  <div className="grid grid-cols-2 gap-3">
                    <div className="bg-[#07090F] rounded-xl p-3">
                      <div className="text-slate-500 text-xs mb-1">Concurrents sur ce secteur</div>
                      <div className="text-white font-bold text-xl">0</div>
                    </div>
                    <div className="bg-[#07090F] rounded-xl p-3">
                      <div className="text-slate-500 text-xs mb-1">Exclusivité</div>
                      <div className="text-[#C8A84B] font-bold text-sm">À vie</div>
                    </div>
                  </div>

                  <div className="mt-4 bg-[#C8A84B]/5 border border-[#C8A84B]/15 rounded-xl p-3">
                    <p className="text-[#C8A84B] text-xs leading-relaxed">
                      Ce territoire est protégé. Aucun autre conseiller ne peut activer le système pour cette ville.
                    </p>
                  </div>
                </div>

                {/* Floating badge */}
                <div className="absolute -top-3 -right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                  5 villes fermées
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <CityModal isOpen={modalOpen} onClose={() => setModalOpen(false)} />
    </>
  );
}
