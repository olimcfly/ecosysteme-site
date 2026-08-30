import { Globe, Database, Zap, Brain, Calculator, Lock } from 'lucide-react'

const FEATURES = [
  {
    icon: Globe,
    title: 'Site SEO local',
    body: 'Vos concurrents en réseau monopolisent Google sur votre secteur. Ce site est architecturé pour vous positionner sur "estimation immobilière + [votre ville]" — et les faire passer derrière vous.',
    highlight: false,
  },
  {
    icon: Database,
    title: 'CRM vendeurs prêt à l\'emploi',
    body: 'Plus de contacts perdus dans votre messagerie. Votre pipeline vendeurs est opérationnel dès J+1 : suivi des mandats, historique des échanges, relances planifiées.',
    highlight: false,
  },
  {
    icon: Zap,
    title: 'Relances automatiques',
    body: 'Un propriétaire vous contacte à 22h ? Il reçoit une réponse immédiate. Vos séquences de relance partent sans action de votre part — configurées pour l\'immobilier.',
    highlight: false,
  },
  {
    icon: Brain,
    title: 'Qualification IA',
    body: 'Ne passez plus de temps avec des curieux. L\'IA trie vos contacts, évalue la motivation réelle de chaque prospect et vous alerte uniquement quand un vendeur est sérieux.',
    highlight: false,
  },
  {
    icon: Calculator,
    title: 'Estimateur en ligne',
    body: 'Des leads propriétaires arrivent pendant que vous êtes en visite. L\'estimateur génère des contacts qualifiés 24h/24 et les pousse directement dans votre CRM.',
    highlight: false,
  },
  {
    icon: Lock,
    title: 'Exclusivité territoriale',
    body: 'Votre ville. Votre système. Aucun autre conseiller ne peut utiliser Ecosystème Immo sur votre secteur. Une fois activé, le territoire est fermé — définitivement.',
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
            Tout ce qu&apos;il faut pour dominer localement — en un seul système.
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
