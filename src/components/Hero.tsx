'use client';

export default function Hero() {
  return (
    <section className="relative min-h-screen flex flex-col items-center justify-center px-4 pt-20 pb-16 overflow-hidden">
      {/* Background gradient */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[600px] bg-blue-600/10 rounded-full blur-[120px]" />
        <div className="absolute top-1/3 left-1/4 w-[400px] h-[400px] bg-blue-900/8 rounded-full blur-[80px]" />
        <div
          className="absolute inset-0 opacity-[0.015]"
          style={{
            backgroundImage: `linear-gradient(rgba(255,255,255,.3) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.3) 1px, transparent 1px)`,
            backgroundSize: '60px 60px',
          }}
        />
      </div>

      <div className="relative max-w-4xl mx-auto text-center">
        {/* Badge */}
        <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-300 text-xs font-medium mb-8">
          <span className="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse" />
          Exclusivité territoriale — 1 ville, 1 seul conseiller
        </div>

        {/* H1 */}
        <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1] tracking-tight mb-6">
          Attirez des vendeurs qualifiés{' '}
          <span className="text-blue-400">dans votre ville.</span>
          <br />
          En exclusivité.
        </h1>

        <p className="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
          Le premier système d'acquisition locale conçu pour les conseillers immobiliers indépendants français.
          Site pro, SEO local, CRM, automatisations et IA — activé sur votre territoire exclusif.
        </p>

        {/* CTAs */}
        <div className="flex flex-col sm:flex-row gap-3 justify-center items-center mb-14">
          <a
            href="#disponibilite"
            className="w-full sm:w-auto px-7 py-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold text-base transition-all shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 hover:-translate-y-0.5"
          >
            Vérifier si ma ville est disponible
          </a>
          <a
            href="#systeme"
            className="w-full sm:w-auto px-7 py-4 rounded-xl border border-white/10 hover:border-white/20 text-slate-300 hover:text-white font-medium text-base transition-all bg-white/3 hover:bg-white/5"
          >
            Voir le système
          </a>
        </div>

        {/* Stats bar */}
        <div className="grid grid-cols-3 gap-4 sm:gap-8 max-w-xl mx-auto">
          {[
            { value: '47', label: 'villes actives' },
            { value: '100%', label: 'exclusivité garantie' },
            { value: '72h', label: 'mise en ligne' },
          ].map((stat) => (
            <div key={stat.label} className="text-center">
              <div className="text-2xl sm:text-3xl font-bold text-white mb-0.5">{stat.value}</div>
              <div className="text-xs sm:text-sm text-slate-500">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>

      {/* Scroll indicator */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 text-slate-600">
        <span className="text-xs">Découvrir</span>
        <svg className="w-4 h-4 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </section>
  );
}
