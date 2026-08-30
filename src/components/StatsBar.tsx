const stats = [
  { value: '5', label: 'Villes actives' },
  { value: '100 %', label: 'Exclusif par territoire' },
  { value: '7 jours', label: 'Délai de déploiement' },
  { value: '0', label: 'Partage de leads' },
]

export default function StatsBar() {
  return (
    <section className="bg-zinc-950 py-10 px-4 sm:px-6 lg:px-8">
      <div className="max-w-5xl mx-auto">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
          {stats.map((stat) => (
            <div key={stat.label} className="text-center">
              <div className="text-2xl md:text-3xl font-black text-white mb-1">{stat.value}</div>
              <div className="text-xs font-medium uppercase tracking-wider text-zinc-500">
                {stat.label}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
