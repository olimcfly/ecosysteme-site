"use client";
import { useState } from "react";
import { CityModal } from "./CityModal";

const PLANS = [
  {
    id: "essentiel",
    name: "Essentiel",
    description: "L'estimateur seul pour commencer à qualifier",
    price: 27,
    period: "mois",
    setup: 197,
    setupLabel: "Setup unique",
    highlight: false,
    exclusivity: false,
    features: [
      "Estimateur en marque blanche",
      "Formulaire de qualification intégré",
      "Notifications des nouvelles demandes",
      "Tableau de bord basique",
      "Support email",
    ],
    missing: [
      "Site vitrine SEO local",
      "CRM et pipeline de suivi",
      "Automatisations email/SMS",
      "IA de traitement",
      "Exclusivité territoriale",
    ],
    cta: "Démarrer avec l'essentiel",
    note: null,
  },
  {
    id: "standard",
    name: "Standard",
    description: "Le système complet pour dominer votre marché",
    price: 97,
    period: "mois",
    setup: 497,
    setupLabel: "Setup + 3 premiers mois prépayés",
    highlight: true,
    exclusivity: false,
    features: [
      "Site vitrine SEO local (votre ville)",
      "Estimateur intégré",
      "CRM avec pipeline de suivi",
      "Automatisations email et SMS",
      "IA de traitement des demandes",
      "Dashboard de performance",
      "Support prioritaire",
    ],
    missing: [],
    cta: "Vérifier ma ville",
    note: "Premier paiement : 788€ (setup 497€ + 3 mois × 97€), puis 97€/mois. Résiliation libre après 3 mois.",
  },
  {
    id: "annuel",
    name: "Annuel",
    description: "La meilleure valeur — exclusivité incluse",
    price: 897,
    period: "an",
    setup: 0,
    setupLabel: "Setup offert",
    highlight: false,
    exclusivity: true,
    features: [
      "Tout le plan Standard",
      "Setup offert (économie : 497€)",
      "Exclusivité territoriale incluse",
      "Économisez 35% vs mensuel",
      "Accès aux nouvelles fonctionnalités en avant-première",
      "Support dédié",
    ],
    missing: [],
    cta: "Vérifier ma ville",
    note: "Équivalent à 74,75€/mois. Exclusivité garantie contractuellement.",
  },
];

const ADDON = {
  name: "Exclusivité verrouillée",
  description: "Pour les abonnés mensuel : verrouillez votre territoire à vie en un paiement unique.",
  price: 900,
  benefits: [
    "Territoire garanti à vie, indépendamment de l'abonnement",
    "Aucun concurrent possible sur votre ville",
    "Transférable en cas de cession d'activité",
  ],
};

function CheckIcon() {
  return (
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" className="flex-shrink-0">
      <path d="M2 7l3.5 3.5 6.5-7" stroke="#C8A84B" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

function CrossIcon() {
  return (
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" className="flex-shrink-0 opacity-30">
      <path d="M10.5 3.5l-7 7M3.5 3.5l7 7" stroke="#94A3B8" strokeWidth="1.5" strokeLinecap="round" />
    </svg>
  );
}

export function Pricing() {
  const [modalOpen, setModalOpen] = useState(false);

  return (
    <>
      <section id="tarifs" className="bg-[#F8F7F4] py-20 sm:py-28">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="text-center max-w-2xl mx-auto mb-14">
            <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
              Tarifs
            </p>
            <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mb-4">
              Transparent, sans surprise
            </h2>
            <p className="text-slate-500 text-base">
              Choisissez le niveau qui correspond à votre ambition. L'exclusivité est disponible sur tous les plans.
            </p>
          </div>

          {/* Plans grid */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            {PLANS.map((plan) => (
              <div
                key={plan.id}
                className={`relative rounded-2xl p-6 flex flex-col ${
                  plan.highlight
                    ? "bg-[#07090F] border-2 border-[#C8A84B]/40 shadow-xl"
                    : "bg-white border border-slate-200"
                }`}
              >
                {/* Recommended badge */}
                {plan.highlight && (
                  <div className="absolute -top-3.5 left-1/2 -translate-x-1/2">
                    <span className="bg-[#C8A84B] text-[#07090F] text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                      Le plus populaire
                    </span>
                  </div>
                )}

                {/* Exclusivity badge */}
                {plan.exclusivity && (
                  <div className="absolute -top-3.5 left-1/2 -translate-x-1/2">
                    <span className="bg-[#07090F] text-[#C8A84B] border border-[#C8A84B]/30 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                      Exclusivité incluse
                    </span>
                  </div>
                )}

                <div className="mb-5">
                  <h3
                    className={`font-semibold text-lg mb-1 ${
                      plan.highlight ? "text-white" : "text-slate-900"
                    }`}
                  >
                    {plan.name}
                  </h3>
                  <p
                    className={`text-sm ${
                      plan.highlight ? "text-slate-400" : "text-slate-500"
                    }`}
                  >
                    {plan.description}
                  </p>
                </div>

                {/* Price */}
                <div className="mb-5">
                  <div className="flex items-end gap-1">
                    <span
                      className={`font-bold text-4xl leading-none ${
                        plan.highlight ? "text-white" : "text-slate-900"
                      }`}
                    >
                      {plan.price.toLocaleString("fr-FR")}€
                    </span>
                    <span
                      className={`text-sm mb-1 ${
                        plan.highlight ? "text-slate-400" : "text-slate-500"
                      }`}
                    >
                      /{plan.period}
                    </span>
                  </div>
                  {plan.setup > 0 ? (
                    <p
                      className={`text-xs mt-1.5 ${
                        plan.highlight ? "text-slate-500" : "text-slate-400"
                      }`}
                    >
                      + {plan.setup}€ {plan.setupLabel}
                    </p>
                  ) : (
                    <p className="text-xs mt-1.5 text-[#C8A84B]">
                      {plan.setupLabel}
                    </p>
                  )}
                </div>

                {/* Divider */}
                <div
                  className={`border-t mb-5 ${
                    plan.highlight ? "border-[#1C2333]" : "border-slate-100"
                  }`}
                />

                {/* Features */}
                <ul className="space-y-2.5 mb-6 flex-1">
                  {plan.features.map((f) => (
                    <li key={f} className="flex items-center gap-2.5">
                      <CheckIcon />
                      <span
                        className={`text-sm ${
                          plan.highlight ? "text-slate-300" : "text-slate-600"
                        }`}
                      >
                        {f}
                      </span>
                    </li>
                  ))}
                  {plan.missing.map((f) => (
                    <li key={f} className="flex items-center gap-2.5">
                      <CrossIcon />
                      <span className="text-sm text-slate-400 line-through decoration-slate-300">
                        {f}
                      </span>
                    </li>
                  ))}
                </ul>

                {/* CTA */}
                <button
                  onClick={() => setModalOpen(true)}
                  className={`w-full py-3 rounded-xl font-semibold text-sm transition-colors ${
                    plan.highlight
                      ? "bg-[#C8A84B] hover:bg-[#B8962E] text-[#07090F]"
                      : "bg-[#07090F] hover:bg-[#0D1117] text-white"
                  }`}
                >
                  {plan.cta}
                </button>

                {/* Fine print */}
                {plan.note && (
                  <p
                    className={`text-xs mt-3 leading-relaxed ${
                      plan.highlight ? "text-slate-600" : "text-slate-400"
                    }`}
                  >
                    {plan.note}
                  </p>
                )}
              </div>
            ))}
          </div>

          {/* Addon: Exclusivité verrouillée */}
          <div className="bg-[#07090F] border border-[#1C2333] rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center gap-6">
            <div className="flex-1">
              <div className="flex items-center gap-2 mb-1.5">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <rect x="3" y="7" width="10" height="8" rx="2" stroke="#C8A84B" strokeWidth="1.5" />
                  <path d="M5 7V5.5a3 3 0 016 0V7" stroke="#C8A84B" strokeWidth="1.5" strokeLinecap="round" />
                </svg>
                <h3 className="text-white font-semibold text-base">
                  {ADDON.name}
                </h3>
                <span className="bg-[#C8A84B]/10 border border-[#C8A84B]/20 text-[#C8A84B] text-xs font-medium px-2 py-0.5 rounded-full">
                  Option
                </span>
              </div>
              <p className="text-slate-400 text-sm mb-3">{ADDON.description}</p>
              <ul className="flex flex-wrap gap-x-5 gap-y-1">
                {ADDON.benefits.map((b) => (
                  <li key={b} className="flex items-center gap-1.5 text-slate-400 text-xs">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                      <path d="M1.5 5l2.5 2.5 4.5-4.5" stroke="#C8A84B" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                    </svg>
                    {b}
                  </li>
                ))}
              </ul>
            </div>
            <div className="flex flex-col items-start sm:items-end gap-3 flex-shrink-0">
              <div>
                <span className="text-white font-bold text-3xl">
                  {ADDON.price.toLocaleString("fr-FR")}€
                </span>
                <span className="text-slate-500 text-sm ml-1">unique</span>
              </div>
              <button
                onClick={() => setModalOpen(true)}
                className="bg-[#1C2333] hover:bg-[#1E2A3C] text-white font-medium text-sm px-5 py-2.5 rounded-lg transition-colors whitespace-nowrap"
              >
                Ajouter à mon plan
              </button>
            </div>
          </div>

          {/* Programme fondateur note */}
          <div className="mt-6 bg-[#C8A84B]/5 border border-[#C8A84B]/15 rounded-xl p-4 text-center">
            <p className="text-slate-400 text-sm">
              <span className="text-[#C8A84B] font-semibold">Programme Fondateur</span>{" "}
              — Places très limitées, sur sélection.{" "}
              <a
                href="mailto:contact@ecosystemeimmo.fr?subject=Candidature Programme Fondateur"
                className="text-[#C8A84B] hover:underline"
              >
                Soumettre ma candidature
              </a>
            </p>
          </div>
        </div>
      </section>

      <CityModal isOpen={modalOpen} onClose={() => setModalOpen(false)} />
    </>
  );
}
