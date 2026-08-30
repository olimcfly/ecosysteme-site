"use client";
import { useState } from "react";

const FAQS = [
  {
    q: "Qu'est-ce que l'exclusivité territoriale exactement ?",
    a: "Une seule personne peut activer le système Ecosystème Immo pour une ville donnée. Quand vous réservez votre territoire, aucun autre conseiller ne peut utiliser le système pour cette même ville — jamais. Ce droit est garanti contractuellement à vie.",
  },
  {
    q: "Combien de temps faut-il pour être opérationnel ?",
    a: "Entre 5 et 7 jours ouvrés après la signature et le paiement du setup. Vous n'avez rien à configurer : notre équipe s'occupe de tout — site, CRM, automatisations, IA. Vous recevez les accès une fois tout en place.",
  },
  {
    q: "Que comprend exactement le setup ?",
    a: "Configuration complète du site vitrine avec vos coordonnées et votre charte, paramétrage du CRM avec votre pipeline personnalisé, création des séquences d'automatisation email et SMS, connexion de l'estimateur, mise en ligne sur votre domaine, et session de formation de 2h pour prise en main.",
  },
  {
    q: "Y a-t-il un engagement de durée ?",
    a: "Le plan mensuel Standard inclut 3 premiers mois prépayés (inclus dans le setup), puis vous êtes libre de résilier à tout moment. Le plan annuel engage sur 12 mois mais offre un setup offert et une économie de 35%. L'option Exclusivité verrouillée est un paiement unique sans abonnement supplémentaire.",
  },
  {
    q: "Le SEO local, ça prend combien de temps à fonctionner ?",
    a: "Les premières indexations Google apparaissent généralement dans les 4 à 8 semaines. Le positionnement sur les requêtes cibles (\"vendre maison [votre ville]\", \"estimation immobilière [votre ville]\") se consolide sur 3 à 6 mois. Les automatisations et l'IA génèrent des résultats dès le premier lead entrant.",
  },
  {
    q: "Et si ma ville est petite (moins de 20 000 habitants) ?",
    a: "Le système fonctionne dès 8 000 habitants. Sur une petite ville, l'exclusivité est d'autant plus précieuse : vous n'avez pas de concurrent sur votre territoire, et Google vous positionnera plus vite faute de compétition locale. Plusieurs de nos villes actives font moins de 15 000 habitants.",
  },
  {
    q: "Puis-je utiliser le système pour plusieurs villes ?",
    a: "Oui, mais chaque ville nécessite un abonnement séparé. Chaque territoire est une entité indépendante, avec son propre site, son propre CRM, ses propres automatisations. Nous proposons des conditions préférentielles à partir de 2 territoires — contactez-nous.",
  },
  {
    q: "Que se passe-t-il si je résilie ? Est-ce que je perds mon exclusivité ?",
    a: "En cas de résiliation d'un abonnement mensuel sans l'option Exclusivité verrouillée, votre territoire redevient disponible après 30 jours. Si vous avez souscrit l'option Exclusivité verrouillée (900€ unique) ou si vous êtes en plan Annuel, votre territoire reste bloqué.",
  },
];

export function FAQ() {
  const [open, setOpen] = useState<number | null>(null);

  return (
    <section id="faq" className="bg-white py-20 sm:py-28">
      <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            FAQ
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mb-4">
            Questions fréquentes
          </h2>
          <p className="text-slate-500 text-base">
            Ce que vous devez savoir avant de démarrer.
          </p>
        </div>

        {/* Accordion */}
        <div className="space-y-2">
          {FAQS.map((item, i) => (
            <div
              key={i}
              className={`border rounded-xl overflow-hidden transition-colors ${
                open === i
                  ? "border-[#C8A84B]/30 bg-[#F8F7F4]"
                  : "border-slate-200 bg-white hover:border-slate-300"
              }`}
            >
              <button
                onClick={() => setOpen(open === i ? null : i)}
                className="w-full flex items-center justify-between gap-4 px-5 py-4 text-left"
              >
                <span className="text-slate-900 font-medium text-sm leading-snug">
                  {item.q}
                </span>
                <div
                  className={`flex-shrink-0 w-5 h-5 rounded-full border flex items-center justify-center transition-all ${
                    open === i
                      ? "border-[#C8A84B] bg-[#C8A84B]/10 rotate-180"
                      : "border-slate-300"
                  }`}
                >
                  <svg
                    width="10"
                    height="10"
                    viewBox="0 0 10 10"
                    fill="none"
                    className={open === i ? "text-[#C8A84B]" : "text-slate-400"}
                  >
                    <path
                      d="M2 3.5L5 6.5L8 3.5"
                      stroke="currentColor"
                      strokeWidth="1.5"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                    />
                  </svg>
                </div>
              </button>

              {open === i && (
                <div className="px-5 pb-4">
                  <p className="text-slate-600 text-sm leading-relaxed">{item.a}</p>
                </div>
              )}
            </div>
          ))}
        </div>

        {/* Contact fallback */}
        <p className="text-center text-slate-500 text-sm mt-8">
          Une autre question ?{" "}
          <a
            href="mailto:contact@ecosystemeimmo.fr"
            className="text-[#C8A84B] hover:underline"
          >
            Écrivez-nous directement
          </a>
        </p>
      </div>
    </section>
  );
}
