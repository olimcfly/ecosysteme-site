"use client";

import { useState } from "react";

const faqs = [
  {
    q: "C'est quoi exactement le système Ecosystème Immo ?",
    a: "C'est un ensemble de composants activés ensemble : un site web local optimisé pour votre secteur géographique, un référencement local structuré (SEO, fiche Google, données structurées), un outil estimateur intégré qui capte les contacts vendeurs, un CRM avec automatisations de suivi, et une couche IA qui qualifie les leads avant que vous les voyiez. Tout est configuré pour vous — vous n'avez rien à paramétrer.",
  },
  {
    q: "Que se passe-t-il si ma ville est déjà prise ?",
    a: "Si votre ville est déjà attribuée, vous pouvez vous inscrire sur liste d'attente. Vous serez contacté en priorité si une place se libère. Vous pouvez également vérifier les villes voisines — l'exclusivité est définie par commune.",
  },
  {
    q: "En combien de temps le système est-il opérationnel ?",
    a: "7 jours ouvrés après votre activation. Notre équipe s'occupe de tout : création du site, configuration du SEO local, paramétrage du CRM et des automatisations, intégration de l'estimateur. Vous recevez un accès complet et un onboarding pour prendre en main votre tableau de bord.",
  },
  {
    q: "Est-ce que je dois m'occuper du SEO ou du site moi-même ?",
    a: "Non. Le SEO local, les mises à jour techniques, les optimisations sont gérés par notre équipe dans le cadre de votre abonnement. Vous pouvez nous transmettre vos actualités, annonces ou contenus — nous nous occupons de la publication et de l'optimisation.",
  },
  {
    q: "Quelle est la différence entre le plan mensuel et l'annuel ?",
    a: "Le plan mensuel (97€/mois + 497€ d'activation) démarre avec un engagement de 3 mois prépayés. L'annuel (897€/an) offre l'activation gratuite, l'exclusivité territoriale verrouillée dès le départ, et revient à 74,75€/mois effectif. Sur 12 mois, l'annuel représente une économie significative.",
  },
  {
    q: "Qu'est-ce que l'option exclusivité verrouillée à 900€ ?",
    a: "C'est un paiement unique qui verrouille définitivement votre exclusivité territoriale, même si vous interrompez votre abonnement et le reprenez plus tard. Sur le plan annuel, cette exclusivité est déjà incluse. Sur le plan mensuel Standard, c'est une option complémentaire.",
  },
  {
    q: "Puis-je résilier à tout moment ?",
    a: "Oui, sur le plan mensuel après la période de 3 mois prépayés. Sur le plan annuel, l'abonnement est engagé sur 12 mois. Aucun frais de résiliation au-delà de ces périodes.",
  },
  {
    q: "Le système fonctionne-t-il pour toutes les villes françaises ?",
    a: "Oui, pour toutes les communes françaises dès lors que la population est suffisante pour générer un flux de leads pertinent. Pour les communes de moins de 5 000 habitants, nous recommandons un territoire élargi. Vérifiez la disponibilité de votre ville — c'est gratuit et instantané.",
  },
];

export default function FAQ() {
  const [openIndex, setOpenIndex] = useState<number | null>(null);

  return (
    <section
      id="faq"
      className="section-padding"
      style={{ background: "var(--surface-alt)" }}
    >
      <div className="container-site">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <p
            className="text-xs font-semibold uppercase tracking-widest mb-4"
            style={{ color: "var(--accent-blue)" }}
          >
            Questions fréquentes
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 text-balance">
            Tout ce que vous devez savoir
          </h2>
        </div>

        <div className="max-w-2xl mx-auto divide-y divide-slate-200">
          {faqs.map((item, i) => {
            const isOpen = openIndex === i;
            return (
              <div key={i} className="py-1">
                <button
                  className="w-full text-left py-5 flex items-start justify-between gap-4 group"
                  onClick={() => setOpenIndex(isOpen ? null : i)}
                  aria-expanded={isOpen}
                >
                  <span
                    className={`font-medium text-sm sm:text-base transition-colors ${
                      isOpen ? "text-blue-600" : "text-slate-900 group-hover:text-blue-600"
                    }`}
                  >
                    {item.q}
                  </span>
                  <span
                    className={`flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center transition-all ${
                      isOpen ? "rotate-45" : ""
                    }`}
                    style={{
                      background: isOpen
                        ? "var(--accent-blue)"
                        : "var(--surface-alt)",
                      border: "1px solid",
                      borderColor: isOpen ? "var(--accent-blue)" : "var(--border)",
                    }}
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth={2.5}
                      stroke={isOpen ? "white" : "#64748b"}
                      className="w-3 h-3"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                      />
                    </svg>
                  </span>
                </button>
                {isOpen && (
                  <div className="pb-5">
                    <p className="text-slate-500 text-sm leading-relaxed">{item.a}</p>
                  </div>
                )}
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
