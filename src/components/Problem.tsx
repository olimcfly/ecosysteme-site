const problems = [
  {
    title: 'Votre agenda dépend du hasard',
    body: 'Prospection terrain, pige, réseau — votre flux de vendeurs est imprévisible. Vous ne savez pas combien de mandats vous aurez le mois prochain.',
  },
  {
    title: 'Vos concurrents captent les vendeurs avant vous',
    body: 'Les réseaux nationaux et les portails dominent Google. Quand un vendeur cherche un conseiller local, il tombe sur eux, pas sur vous.',
  },
  {
    title: 'Vous gérez des outils — pas un système',
    body: 'CRM isolé, site vitrine générique, relances manuelles. Chaque outil fonctionne en silo. Rien n\'est connecté pour convertir automatiquement.',
  },
]

export default function Problem() {
  return (
    <section className="py-20 px-5 sm:px-6 bg-white">
      <div className="max-w-5xl mx-auto">
        <div className="text-center mb-14">
          <h2 className="text-3xl sm:text-4xl font-bold text-gray-900 mb-4 leading-tight">
            Vous êtes un bon conseiller.<br className="hidden sm:block" />
            Mais votre pipeline de vendeurs est imprévisible.
          </h2>
          <p className="text-gray-500 text-lg max-w-xl mx-auto">
            Ce n'est pas un problème de compétence. C'est un problème de système.
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-5">
          {problems.map((p, i) => (
            <div
              key={i}
              className="border border-gray-200 rounded-2xl p-7 bg-white"
            >
              <div className="w-7 h-7 rounded-lg bg-red-50 border border-red-100 flex items-center justify-center mb-5">
                <div className="w-2.5 h-2.5 bg-red-400 rounded-full" />
              </div>
              <h3 className="font-semibold text-gray-900 text-base mb-3 leading-snug">
                {p.title}
              </h3>
              <p className="text-gray-500 text-sm leading-relaxed">{p.body}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
