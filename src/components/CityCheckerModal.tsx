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

function normalize(str: string): string {
  return str
    .toLowerCase()
    .normalize("NFD")
    .replace(/[̀-ͯ]/g, "")
    .trim();
}

function isClosed(city: string): boolean {
  const n = normalize(city);
  return CLOSED_CITIES.some((c) => normalize(c) === n);
}

interface Props {
  open: boolean;
  onClose: () => void;
}

export default function CityCheckerModal({ open, onClose }: Props) {
  const [city, setCity] = useState("");
  const [status, setStatus] = useState<"idle" | "taken" | "available">("idle");
  const [email, setEmail] = useState("");
  const [submitted, setSubmitted] = useState(false);
  const inputRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    if (open) {
      setCity("");
      setStatus("idle");
      setEmail("");
      setSubmitted(false);
      setTimeout(() => inputRef.current?.focus(), 100);
    }
  }, [open]);

  useEffect(() => {
    const handleKey = (e: KeyboardEvent) => {
      if (e.key === "Escape") onClose();
    };
    if (open) document.addEventListener("keydown", handleKey);
    return () => document.removeEventListener("keydown", handleKey);
  }, [open, onClose]);

  useEffect(() => {
    if (open) document.body.style.overflow = "hidden";
    else document.body.style.overflow = "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [open]);

  function handleCheck(e: React.FormEvent) {
    e.preventDefault();
    if (!city.trim()) return;
    if (isClosed(city)) {
      setStatus("taken");
    } else {
      setStatus("available");
    }
  }

  function handleWaitlist(e: React.FormEvent) {
    e.preventDefault();
    setSubmitted(true);
  }

  if (!open) return null;

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center p-4"
      aria-modal="true"
      role="dialog"
      aria-label="Vérifier la disponibilité de votre ville"
    >
      <div
        className="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onClick={onClose}
      />

      <div className="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 z-10">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition-colors p-1 rounded-lg hover:bg-slate-100"
          aria-label="Fermer"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth={2}
            stroke="currentColor"
            className="w-5 h-5"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>

        {status === "idle" && (
          <>
            <div className="mb-6">
              <div
                className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium mb-4"
                style={{ background: "#f0f9ff", color: "#0369a1" }}
              >
                <span
                  className="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"
                />
                Vérification en temps réel
              </div>
              <h2 className="text-2xl font-bold text-slate-900 mb-2">
                Votre ville est-elle disponible ?
              </h2>
              <p className="text-slate-500 text-sm">
                Chaque ville n&apos;est attribuée qu&apos;à un seul conseiller.
                Vérifiez maintenant.
              </p>
            </div>

            <form onSubmit={handleCheck} className="space-y-4">
              <div>
                <label
                  htmlFor="city-input"
                  className="block text-sm font-medium text-slate-700 mb-1.5"
                >
                  Votre ville
                </label>
                <input
                  ref={inputRef}
                  id="city-input"
                  type="text"
                  value={city}
                  onChange={(e) => setCity(e.target.value)}
                  placeholder="ex. Lyon, Rennes, Montpellier..."
                  className="w-full px-4 py-3 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base transition"
                  autoComplete="off"
                />
              </div>
              <button
                type="submit"
                disabled={!city.trim()}
                className="w-full py-3 px-6 rounded-xl font-semibold text-white transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                style={{
                  background: city.trim()
                    ? "var(--accent-blue)"
                    : undefined,
                  backgroundColor: !city.trim() ? "#94a3b8" : undefined,
                }}
              >
                Vérifier la disponibilité
              </button>
            </form>

            <p className="text-xs text-slate-400 text-center mt-4">
              5 villes déjà fermées ce mois — Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion
            </p>
          </>
        )}

        {status === "taken" && (
          <div>
            <div className="flex items-center justify-center w-14 h-14 rounded-full bg-red-50 mx-auto mb-4">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth={2}
                stroke="#ef4444"
                className="w-7 h-7"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                />
              </svg>
            </div>
            <h3 className="text-xl font-bold text-slate-900 text-center mb-2">
              {city} est déjà prise
            </h3>
            <p className="text-slate-500 text-sm text-center mb-6">
              Un conseiller a déjà réservé l&apos;exclusivité sur cette ville. Inscrivez-vous
              sur liste d&apos;attente — vous serez notifié en priorité si une place se libère.
            </p>

            {!submitted ? (
              <form onSubmit={handleWaitlist} className="space-y-3">
                <input
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="Votre adresse email"
                  required
                  className="w-full px-4 py-3 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition"
                />
                <button
                  type="submit"
                  className="w-full py-3 px-6 rounded-xl font-semibold text-white"
                  style={{ background: "var(--navy-900)" }}
                >
                  Rejoindre la liste d&apos;attente
                </button>
              </form>
            ) : (
              <div
                className="text-center p-4 rounded-xl"
                style={{ background: "#f0fdf4" }}
              >
                <p className="font-semibold text-green-800">
                  Vous êtes sur liste d&apos;attente.
                </p>
                <p className="text-green-700 text-sm mt-1">
                  Nous vous contacterons dès qu&apos;une place se libère sur {city}.
                </p>
              </div>
            )}

            <button
              onClick={() => setStatus("idle")}
              className="mt-4 text-sm text-slate-400 hover:text-slate-600 transition-colors w-full text-center"
            >
              Vérifier une autre ville
            </button>
          </div>
        )}

        {status === "available" && (
          <div>
            <div className="flex items-center justify-center w-14 h-14 rounded-full bg-green-50 mx-auto mb-4">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth={2.5}
                stroke="#16a34a"
                className="w-7 h-7"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <h3 className="text-xl font-bold text-slate-900 text-center mb-2">
              {city} est disponible
            </h3>
            <p className="text-slate-500 text-sm text-center mb-6">
              Bonne nouvelle — l&apos;exclusivité sur{" "}
              <strong className="text-slate-800">{city}</strong> est encore
              disponible. Réservez-la avant qu&apos;un autre conseiller ne le fasse.
            </p>

            <a
              href={`mailto:contact@ecosystemeimmo.fr?subject=Réservation%20exclusivit%C3%A9%20${encodeURIComponent(city)}`}
              className="block w-full py-3 px-6 rounded-xl font-semibold text-white text-center transition-all hover:opacity-90"
              style={{ background: "var(--accent-blue)" }}
              onClick={onClose}
            >
              Réserver l&apos;exclusivité sur {city}
            </a>

            <p className="text-xs text-slate-400 text-center mt-4">
              Ou appelez-nous directement pour démarrer immédiatement.
            </p>

            <button
              onClick={() => setStatus("idle")}
              className="mt-3 text-sm text-slate-400 hover:text-slate-600 transition-colors w-full text-center"
            >
              Vérifier une autre ville
            </button>
          </div>
        )}
      </div>
    </div>
  );
}
