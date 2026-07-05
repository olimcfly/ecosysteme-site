const testimonials = [
  {
    quote:
      "J'avais un site, une fiche Google, et pourtant mes mandats venaient toujours du réseau. Depuis l'activation, j'ai reçu 4 demandes d'estimation en 3 semaines — toutes des contacts locaux que je n'aurais jamais touchés autrement.",
    author: "Sophie M.",
    role: "Conseillère indépendante",
    location: "Loire-Atlantique",
  },
  {
    quote:
      "Ce qui m'a convaincu, c'est l'exclusivité. Je ne voulais pas investir dans un système que mes concurrents pourraient utiliser également. Ici, c'est clairement mon territoire.",
    author: "Karim B.",
    role: "Agent indépendant",
    location: "Haute-Garonne",
  },
  {
    quote:
      "Le système est vraiment clé en main. En 7 jours j'étais en ligne, sans avoir géré une seule ligne de code ni paramètre SEO. Mes premiers leads qualifiés sont arrivés dès la deuxième semaine.",
    author: "Marie-Laure D.",
    role: "Conseillère en transactions",
    location: "Isère",
  },
];

export default function Testimonials() {
  return (
    <section className="section-padding bg-white">
      <div className="container-site">
        <div className="text-center max-w-2xl mx-auto mb-14">
          <p
            className="text-xs font-semibold uppercase tracking-widest mb-4"
            style={{ color: "var(--accent-blue)" }}
          >
            Témoignages
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-4 text-balance">
            Ce que disent les conseillers actifs
          </h2>
        </div>

        <div className="grid md:grid-cols-3 gap-6">
          {testimonials.map((t, i) => (
            <figure
              key={i}
              className="flex flex-col p-6 rounded-2xl border border-slate-100 hover:shadow-md transition-all"
              style={{ background: "var(--surface-alt)" }}
            >
              <div className="flex gap-1 mb-5">
                {Array.from({ length: 5 }).map((_, j) => (
                  <svg
                    key={j}
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="#f59e0b"
                    className="w-4 h-4"
                  >
                    <path
                      fillRule="evenodd"
                      d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                      clipRule="evenodd"
                    />
                  </svg>
                ))}
              </div>
              <blockquote className="text-slate-700 text-sm leading-relaxed flex-1 mb-5">
                &ldquo;{t.quote}&rdquo;
              </blockquote>
              <figcaption className="flex items-center gap-3 pt-4 border-t border-slate-200">
                <div
                  className="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold text-white"
                  style={{ background: "var(--navy-900)" }}
                >
                  {t.author.charAt(0)}
                </div>
                <div>
                  <div className="font-semibold text-slate-900 text-sm">
                    {t.author}
                  </div>
                  <div className="text-xs text-slate-400">
                    {t.role} · {t.location}
                  </div>
                </div>
              </figcaption>
            </figure>
          ))}
        </div>
      </div>
    </section>
  );
}
