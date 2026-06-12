"use client";

import { useState, FormEvent } from "react";

const CLOSED_CITIES = [
  "bordeaux",
  "nantes",
  "nandy",
  "aix-en-provence",
  "lannion",
];

function normalizeCity(city: string): string {
  return city
    .toLowerCase()
    .normalize("NFD")
    .replace(/[̀-ͯ]/g, "")
    .trim();
}

type Status = "idle" | "available" | "closed";

export default function CityChecker() {
  const [city, setCity] = useState("");
  const [status, setStatus] = useState<Status>("idle");

  const checkCity = (e: FormEvent) => {
    e.preventDefault();
    if (!city.trim()) return;
    const normalized = normalizeCity(city);
    const isClosed = CLOSED_CITIES.some((c) => normalizeCity(c) === normalized);
    setStatus(isClosed ? "closed" : "available");
  };

  const reset = () => {
    setCity("");
    setStatus("idle");
  };

  return (
    <section
      id="verifier-ma-ville"
      className="py-24 px-4"
      style={{ background: "rgba(12, 21, 37, 0.5)" }}
    >
      <div className="max-w-2xl mx-auto text-center">
        <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
          Disponibilité
        </p>
        <h2 className="text-3xl sm:text-4xl font-bold text-ei-text mb-4">
          Votre territoire est-il encore libre ?
        </h2>
        <p className="text-ei-muted text-base mb-10 leading-relaxed">
          Vérification gratuite et immédiate. Un seul conseiller par ville.
        </p>

        {status === "idle" && (
          <form onSubmit={checkCity} className="flex flex-col sm:flex-row gap-3">
            <input
              type="text"
              value={city}
              onChange={(e) => setCity(e.target.value)}
              placeholder="Entrez votre ville..."
              className="flex-1 bg-ei-card border border-ei-border hover:border-ei-border-light focus:border-ei-gold rounded-xl px-5 py-4 text-ei-text placeholder:text-ei-faint text-base outline-none transition-colors"
              autoComplete="off"
              spellCheck={false}
            />
            <button
              type="submit"
              disabled={!city.trim()}
              className="bg-ei-gold hover:bg-ei-gold-light disabled:opacity-40 disabled:cursor-not-allowed text-ei-bg font-bold px-7 py-4 rounded-xl transition-colors duration-200 whitespace-nowrap text-base"
            >
              Vérifier
            </button>
          </form>
        )}

        {status === "available" && (
          <div className="bg-green-500/5 border border-green-500/30 rounded-2xl p-8">
            <div className="flex items-center justify-center gap-2 mb-4">
              <span className="w-3 h-3 bg-green-400 rounded-full animate-pulse-slow" />
              <span className="text-green-400 font-semibold text-lg">
                {city} est disponible
              </span>
            </div>
            <p className="text-ei-muted text-sm mb-7 leading-relaxed">
              Votre ville n'est pas encore prise. Vous pouvez activer votre
              système et verrouiller votre territoire avant qu'un concurrent ne
              le fasse.
            </p>
            <div className="flex flex-col sm:flex-row gap-3 justify-center">
              <a
                href={`mailto:contact@ecosystemeimmo.fr?subject=Activation ${city}&body=Bonjour, je souhaite activer le système pour la ville de ${city}.`}
                className="bg-ei-gold hover:bg-ei-gold-light text-ei-bg font-bold px-7 py-3.5 rounded-xl transition-colors text-sm inline-block"
              >
                Activer pour {city}
              </a>
              <button
                onClick={reset}
                className="border border-ei-border hover:border-ei-border-light text-ei-muted hover:text-ei-text px-7 py-3.5 rounded-xl transition-colors text-sm"
              >
                Tester une autre ville
              </button>
            </div>
          </div>
        )}

        {status === "closed" && (
          <div className="bg-red-500/5 border border-red-500/30 rounded-2xl p-8">
            <div className="flex items-center justify-center gap-2 mb-4">
              <span className="w-3 h-3 bg-red-500 rounded-full" />
              <span className="text-red-400 font-semibold text-lg">
                {city} est déjà prise
              </span>
            </div>
            <p className="text-ei-muted text-sm mb-7 leading-relaxed">
              Un conseiller a déjà activé le système sur ce territoire. Mais des
              villes proches sont peut-être encore disponibles — contactez-nous
              pour explorer les zones adjacentes.
            </p>
            <div className="flex flex-col sm:flex-row gap-3 justify-center">
              <a
                href={`mailto:contact@ecosystemeimmo.fr?subject=Liste d'attente ${city}&body=Bonjour, je souhaite être sur liste d'attente pour ${city} ou connaître les zones adjacentes disponibles.`}
                className="bg-ei-card border border-ei-border hover:border-ei-gold/50 text-ei-text font-semibold px-7 py-3.5 rounded-xl transition-colors text-sm inline-block"
              >
                Me mettre en liste d'attente
              </a>
              <button
                onClick={reset}
                className="border border-ei-border hover:border-ei-border-light text-ei-muted hover:text-ei-text px-7 py-3.5 rounded-xl transition-colors text-sm"
              >
                Tester une autre ville
              </button>
            </div>
          </div>
        )}

        {/* Contact alternative */}
        <p className="mt-8 text-ei-faint text-xs">
          Vous avez des questions ?{" "}
          <a
            href="mailto:contact@ecosystemeimmo.fr"
            className="text-ei-muted hover:text-ei-text transition-colors"
          >
            contact@ecosystemeimmo.fr
          </a>{" "}
          ou{" "}
          <a
            href="tel:+33785611700"
            className="text-ei-muted hover:text-ei-text transition-colors"
          >
            07 85 61 17 00
          </a>
        </p>
      </div>
    </section>
  );
}
