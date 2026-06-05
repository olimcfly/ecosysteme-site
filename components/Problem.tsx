import { EyeOff, Users, Clock } from 'lucide-react'

const PROBLEMS = [
  {
    icon: EyeOff,
    title: 'Invisible localement',
    body: 'Vos concurrents en réseau dominent Google sur votre secteur. Quand un propriétaire cherche un conseiller dans votre ville, votre nom n\'apparaît pas.',
  },
  {
    icon: Users,
    title: 'Dépendant du réseau',
    body: 'Vos mandats viennent de vos contacts et du bouche-à-oreille. C\'est fragile, cyclique, et ça ne scale pas — même quand vous êtes excellent.',
  },
  {
    icon: Clock,
    title: 'Trop peu de temps pour le digital',
    body: 'Entre les visites, les compromis et vos clients, le marketing passe à la trappe. Et sans système, vous recommencez à zéro chaque mois.',
  },
]

export default function Problem() {
  return (
    <section className="py-20 sm:py-28 bg-slate-50">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mx-auto text-center mb-14">
          <span className="section-label">Le problème</span>
          <h2 className="section-title mb-4">
            Ce que personne ne règle pour les indépendants
          </h2>
          <p className="section-sub">
            Les outils génériques ne comprennent pas votre marché. Résultat : vous êtes excellent terrain, mais invisible en ligne.
          </p>
        </div>

        <div className="grid sm:grid-cols-3 gap-6">
          {PROBLEMS.map(({ icon: Icon, title, body }) => (
            <div key={title} className="bg-white rounded-2xl border border-slate-100 shadow-sm p-7">
              <div className="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-5">
                <Icon size={18} className="text-red-500" />
              </div>
              <h3 className="font-semibold text-slate-900 text-base mb-2">{title}</h3>
              <p className="text-slate-500 text-sm leading-relaxed">{body}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
