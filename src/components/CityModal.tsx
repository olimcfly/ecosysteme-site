"use client";
import { useState, useEffect, useRef } from "react";

const CLOSED_CITIES = [
  "bordeaux",
  "nantes",
  "nandy",
  "aix-en-provence",
  "aix en provence",
  "lannion",
];

function normalize(str: string) {
  return str
    .toLowerCase()
    .normalize("NFD")
    .replace(/[̀-ͯ]/g, "")
    .trim();
}

function isClosed(city: string): boolean {
  const n = normalize(city);
  return CLOSED_CITIES.some((c) => normalize(c) === n || normalize(c).includes(n));
}

interface CityModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export function CityModal({ isOpen, onClose }: CityModalProps) {
  const [city, setCity] = useState("");
  const [status, setStatus] = useState<"idle" | "closed" | "available">("idle");
  const inputRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    if (isOpen) {
      setCity("");
      setStatus("idle");
      setTimeout(() => inputRef.current?.focus(), 100);
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
    return () => {
      document.body.style.overflow = "";
    };
  }, [isOpen]);

  useEffect(() => {
    const handleKey = (e: KeyboardEvent) => {
      if (e.key === "Escape") onClose();
    };
    window.addEventListener("keydown", handleKey);
    return () => window.removeEventListener("keydown", handleKey);
  }, [onClose]);

  const handleChange = (value: string) => {
    setCity(value);
    if (value.length < 2) {
      setStatus("idle");
      return;
    }
    setStatus(isClosed(value) ? "closed" : "available");
  };

  if (!isOpen) return null;

  return (
    <div
      className="fixed inset-0 z-[100] flex items-center justify-center p-4"
      onClick={(e) => e.target === e.currentTarget && onClose()}
    >
      {/* Backdrop */}
      <div className="absolute inset-0 bg-[#07090F]/85 backdrop-blur-sm" />

      {/* Modal */}
      <div className="relative w-full max-w-md bg-[#0D1117] border border-[#1C2333] rounded-2xl shadow-2xl p-8">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-slate-500 hover:text-white transition-colors p-1"
          aria-label="Fermer"
        >
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
          </svg>
        </button>

        <h2 className="text-white font-semibold text-xl mb-1">
          Vérifiez votre ville
        </h2>
        <p className="text-slate-400 text-sm mb-6">
          Saisissez votre ville pour voir si l'exclusivité est encore disponible.
        </p>

        <div className="relative mb-4">
          <div className="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" className="text-slate-500">
              <path d="M8 1.5C5.515 1.5 3.5 3.515 3.5 6c0 3.75 4.5 8.5 4.5 8.5S12.5 9.75 12.5 6c0-2.485-2.015-4.5-4.5-4.5zm0 6.125a1.625 1.625 0 110-3.25 1.625 1.625 0 010 3.25z" fill="currentColor" />
            </svg>
          </div>
          <input
            ref={inputRef}
            type="text"
            value={city}
            onChange={(e) => handleChange(e.target.value)}
            placeholder="Ex : Lyon, Rennes, Montpellier..."
            className="w-full bg-[#07090F] border border-[#1C2333] text-white placeholder-slate-600 rounded-xl pl-10 pr-4 py-3.5 text-base focus:outline-none focus:border-[#C8A84B]/60 focus:ring-1 focus:ring-[#C8A84B]/30 transition-all"
          />
        </div>

        {/* Status: idle */}
        {status === "idle" && (
          <div className="bg-[#07090F] border border-[#1C2333] rounded-xl p-4 text-slate-500 text-sm text-center">
            Entrez une ville pour vérifier sa disponibilité
          </div>
        )}

        {/* Status: closed */}
        {status === "closed" && (
          <div className="bg-red-950/40 border border-red-900/50 rounded-xl p-4">
            <div className="flex items-start gap-3">
              <div className="w-8 h-8 rounded-full bg-red-900/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                  <path d="M11 3L3 11M3 3l8 8" stroke="#EF4444" strokeWidth="1.5" strokeLinecap="round" />
                </svg>
              </div>
              <div>
                <p className="text-red-400 font-semibold text-sm mb-0.5">Ville fermée</p>
                <p className="text-slate-400 text-xs leading-relaxed">
                  Cette ville est déjà attribuée à un conseiller. Rejoignez la liste d'attente — vous serez alerté en priorité si une place se libère.
                </p>
              </div>
            </div>
            <a
              href="mailto:contact@ecosystemeimmo.fr?subject=Liste d'attente — %city%"
              className="mt-4 w-full flex items-center justify-center gap-2 bg-[#1C2333] hover:bg-[#1E2A3C] text-white text-sm font-medium py-3 rounded-lg transition-colors"
            >
              Rejoindre la liste d'attente
            </a>
          </div>
        )}

        {/* Status: available */}
        {status === "available" && city.length > 2 && (
          <div className="bg-emerald-950/40 border border-emerald-900/50 rounded-xl p-4">
            <div className="flex items-start gap-3">
              <div className="w-8 h-8 rounded-full bg-emerald-900/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                  <path d="M2.5 7l3.5 3.5 5.5-6" stroke="#10B981" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                </svg>
              </div>
              <div>
                <p className="text-emerald-400 font-semibold text-sm mb-0.5">
                  {city} — disponible
                </p>
                <p className="text-slate-400 text-xs leading-relaxed">
                  Votre ville est libre. Réservez votre exclusivité maintenant avant qu'un autre conseiller ne la prenne.
                </p>
              </div>
            </div>
            <a
              href={`https://cal.com/ecosystemeimmo?city=${encodeURIComponent(city)}`}
              target="_blank"
              rel="noopener noreferrer"
              className="mt-4 w-full flex items-center justify-center gap-2 bg-[#C8A84B] hover:bg-[#B8962E] text-[#07090F] text-sm font-bold py-3 rounded-lg transition-colors"
            >
              Réserver {city} maintenant
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M2.5 7h9M8 3.5L11.5 7 8 10.5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
              </svg>
            </a>
          </div>
        )}

        <p className="mt-4 text-slate-600 text-xs text-center">
          Exclusivité garantie — 1 ville, 1 seul conseiller
        </p>
      </div>
    </div>
  );
}
