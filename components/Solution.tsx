import { Globe, Database, Zap, Brain, Calculator, Lock } from 'lucide-react'

const FEATURES = [
  {
    icon: Globe,
    title: 'Site vitrine SEO local',
    body: 'Conçu pour apparaître sur "estimation immobilière + [votre ville]". Architecture technique, balises locales, pages de quartier.',
    highlight: false,
  },
  {
    icon: Database,
    title: 'CRM pré-configuré',
    body: 'Pipeline vendeurs, suivi des mandats, historique des contacts. Tout ce qu\'un conseiller indépendant a besoin, sans se former des semaines.',
    highlight: false,
  },
  {
    icon: Zap,
    title: 'Automatisations email & relances',
    body: 'Vos prospects reçoivent le bon message au bon moment — sans que vous y pensiez. Séquences pré-configurées pour l\'immobilier.',
    highlight: false,
  },
  {
    icon: Brain,
    title: 'Qualification par IA',
    body: 'Filtrez les curieux des vendeurs réellement motivés. L\'IA qualifie, priorise et vous prévient quand un prospect est chaud.',
    highlight: false,
  },
  {
    icon: Calculator,
    title: 'Estimateur en ligne',
    body: 'Générez des leads propriétaires 24h/24. L\'estimateur capte des contacts qualifiés pendant que vous êtes en visite.',
    highlight: false,
  },
  {
    icon: Lock,
    title: 'Exclusivité territoriale',
    body: 'Votre ville. Votre système. Aucun autre conseiller ne peut utiliser Ecosystème Immo sur votre secteur. À vie.',
    highlight: true,
  },
]

export default function Solution() {
  return (
    <section id="fonctionnalites" className="py-20 sm:py-28 bg-white">
      <div className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="max-w-2xl mx-auto text-center mb-14">
          <span className="section-label">Le système</span>
          <h2 className="section-title mb-4">
            Un seul système. Tout ce qu&apos;il faut pour dominer localement.
          </h2>
          <p className="section-sub">
            Pas un outil parmi d&apos;autres. Un écosystème complet, préconfiguré pour l&apos;immobilier, activé sur votre territoire.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          {FEATURES.map(({ icon: Icon, title, body, highlight }) => (
            <div
              key={title}
              className={`rounded-2xl p-7 border transition-shadow duration-200 ${
                highlight
                  ? 'bg-navy border-blue-800 shadow-lg shadow-blue-950/20'
                  : 'bg-white border-slate-100 shadow-sm hover:shadow-md'
              }`}
            >
              <div
                className={`w-10 h-10 rounded-xl flex items-center justify-center mb-5 ${
                  highlight ? 'bg-blue-500/10' : 'bg-blue-50'
                }`}
              >
                <Icon size={18} className={highlight ? 'text-blue-400' : 'text-blue-600'} />
              </div>
              <h3
                className={`font-semibold text-base mb-2 ${
                  highlight ? 'text-white' : 'text-slate-900'
                }`}
              >
                {title}
              </h3>
              <p className={`text-sm leading-relaxed ${highlight ? 'text-white/60' : 'text-slate-500'}`}>
                {body}
              </p>
              {highlight && (
                <div className="mt-4 inline-flex items-center gap-1.5 text-xs text-gold font-medium">
                  <Lock size={10} />
                  Différenciateur clé
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
