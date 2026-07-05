const pillars = [
  {
    icon: (
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        strokeWidth={1.5}
        stroke="currentColor"
        className="w-6 h-6"
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"
        />
      </svg>
    ),
    title: "Site web local optimisé",
    body: "Un site professionnel conçu pour votre zone, avec les bons signaux locaux dès le départ. Crédibilité immédiate, expérience premium sur mobile.",
    tag: "Présence immédiate",
  },
  {
    icon: (
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        strokeWidth={1.5}
        stroke="currentColor"
        className="w-6 h-6"
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
        />
      </svg>
    ),
    title: "SEO local structuré",
    body: "Positionnement sur les requêtes vendeurs de votre secteur. Fiche Google, données structurées, contenu optimisé — pour être trouvé avant vos concurrents.",
    tag: "Visibilité durable",
  },
  {
    icon: (
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        strokeWidth={1.5}
        stroke="currentColor"
        className="w-6 h-6"
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"
        />
      </svg>
    ),
    title: "CRM + automatisations",
    body: "Chaque contact est qualifié, suivi et relancé automatiquement. Vous vous concentrez sur les mandats — le système s'occupe du reste.",
    tag: "Suivi automatisé",
  },
  {
    icon: (
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        strokeWidth={1.5}
        stroke="currentColor"
        className="w-6 h-6"
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"
        />
      </svg>
    ),
    title: "IA de qualification",
    body: "Les leads sont analysés et scorés avant que vous les voyiez. Seulement des contacts à fort potentiel — fini le temps perdu sur les non-projets.",
    tag: "Leads qualifiés",
  },
];

export default function Solution() {
  return (
    <section
      id="systeme"
      className="section-padding"
      style={{ background: "var(--surface-alt)" }}
    >
      <div className="container-site">
        <div className="text-center max-w-2xl mx-auto mb-14">
          <p
            className="text-xs font-semibold uppercase tracking-widest mb-4"
            style={{ color: "var(--accent-blue)" }}
          >
            Le système
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-5 text-balance">
            Votre système d&apos;acquisition locale, clé en main
          </h2>
          <p className="text-slate-500 text-lg leading-relaxed">
            Pas un outil à configurer. Un système complet activé en 7 jours,
            pensé pour générer des mandats de façon prévisible dans votre territoire.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 gap-5">
          {pillars.map((p, i) => (
            <div
              key={i}
              className="bg-white rounded-2xl p-7 border border-slate-100 hover:border-blue-100 hover:shadow-md transition-all group"
            >
              <div className="flex items-start gap-5">
                <div
                  className="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors"
                  style={{
                    background: "rgba(37,99,235,0.08)",
                    color: "var(--accent-blue)",
                  }}
                >
                  {p.icon}
                </div>
                <div className="flex-1 min-w-0">
                  <div className="flex items-center gap-2 mb-2 flex-wrap">
                    <h3 className="font-semibold text-slate-900">{p.title}</h3>
                    <span
                      className="text-xs font-medium px-2 py-0.5 rounded-full"
                      style={{
                        background: "rgba(37,99,235,0.08)",
                        color: "var(--accent-blue)",
                      }}
                    >
                      {p.tag}
                    </span>
                  </div>
                  <p className="text-slate-500 text-sm leading-relaxed">{p.body}</p>
                </div>
              </div>
            </div>
          ))}
        </div>

        <div
          className="mt-10 p-6 rounded-2xl border text-center"
          style={{
            background: "rgba(37,99,235,0.04)",
            borderColor: "rgba(37,99,235,0.15)",
          }}
        >
          <p className="text-slate-700 font-medium">
            Tout est géré pour vous — technique, contenu, SEO, automatisations.
            <span className="text-slate-500 font-normal">
              {" "}Votre seul travail : répondre aux vendeurs qualifiés qui vous contactent.
            </span>
          </p>
        </div>
      </div>
    </section>
  );
}
