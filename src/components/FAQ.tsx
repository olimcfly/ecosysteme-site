"use client";

import { useState } from "react";

const FAQS = [
  {
    question:
      "Ma ville est disponible mais je ne suis pas encore prêt. Puis-je la réserver ?",
    answer:
      "La disponibilité n'est pas réservable sans activation. Si vous souhaitez sécuriser votre territoire immédiatement, l'option Exclusivité Verrouillée (900 € paiement unique) vous permet de verrouiller votre ville indépendamment de votre formule d'abonnement.",
  },
  {
    question: "Combien de temps avant mes premiers leads ?",
    answer:
      "La plupart de nos conseillers reçoivent leurs premiers contacts qualifiés dans les 30 jours suivant l'activation. Le délai dépend du volume de recherches dans votre ville et de la compétitivité de votre marché local.",
  },
  {
    question: "Comment fonctionne l'exclusivité territoriale ?",
    answer:
      "L'exclusivité garantit qu'aucun autre conseiller ne peut activer le système Ecosystème Immo dans votre ville. Vos leads sont 100% vôtres. Elle est incluse dans l'offre Annuelle, ou disponible séparément en paiement unique à 900 €.",
  },
  {
    question: "Je ne suis pas technique. Est-ce que je peux gérer ça seul ?",
    answer:
      "Notre équipe configure tout : site, CRM, automatisations, estimateur. Vous recevez un accès à votre tableau de bord et une session d'onboarding. Aucune compétence technique requise — vous gérez vos leads, pas la technique.",
  },
  {
    question: "Quelle est la différence entre l'offre mensuelle et annuelle ?",
    answer:
      "Les fonctionnalités sont identiques. L'offre Annuelle inclut le setup offert (économie de 497 €), l'exclusivité territoriale garantie et le support prioritaire. C'est l'option la plus rentable si vous avez une vision long terme sur votre territoire.",
  },
  {
    question: "Que se passe-t-il si je quitte le système ?",
    answer:
      "Votre abonnement peut être résilié avec un préavis de 30 jours. En cas de résiliation, votre exclusivité territoriale est libérée et la ville peut être ouverte à un autre conseiller. L'option Exclusivité Verrouillée est définitive et vous appartient même sans abonnement actif.",
  },
  {
    question: "Comment fonctionne l'estimateur ?",
    answer:
      "C'est un outil d'estimation de bien intégré à votre site. Un vendeur qui cherche à connaître la valeur de son bien le complète en 2 minutes. Vous recevez immédiatement une notification avec ses coordonnées, les détails du bien et un score de qualification.",
  },
];

export default function FAQ() {
  const [open, setOpen] = useState<number | null>(null);

  return (
    <section id="faq" className="py-24 px-4">
      <div className="max-w-3xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-ei-gold text-xs font-semibold uppercase tracking-widest mb-4">
            Questions fréquentes
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-ei-text">
            Tout ce que vous voulez savoir
          </h2>
        </div>

        <div className="space-y-2">
          {FAQS.map((faq, i) => (
            <div
              key={i}
              className="bg-ei-card border border-ei-border rounded-xl overflow-hidden"
            >
              <button
                onClick={() => setOpen(open === i ? null : i)}
                className="w-full flex items-center justify-between gap-4 px-6 py-5 text-left hover:bg-ei-elevated/50 transition-colors"
                aria-expanded={open === i}
              >
                <span className="text-ei-text font-medium text-sm sm:text-base leading-snug">
                  {faq.question}
                </span>
                <span
                  className={`flex-shrink-0 w-5 h-5 text-ei-muted transition-transform duration-200 ${
                    open === i ? "rotate-45" : ""
                  }`}
                >
                  <svg
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    className="w-5 h-5"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={1.5}
                      d="M12 4v16m8-8H4"
                    />
                  </svg>
                </span>
              </button>

              {open === i && (
                <div className="px-6 pb-5">
                  <p className="text-ei-muted text-sm leading-relaxed border-t border-ei-border pt-4">
                    {faq.answer}
                  </p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
