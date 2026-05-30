const stats = [
  { value: '5', label: 'Villes actives' },
  { value: '100%', label: 'Exclusivité garantie' },
  { value: '< 48h', label: 'Mise en ligne' },
  { value: '0', label: 'Compétence technique requise' },
]

export default function ProofStrip() {
  return (
    <section className="border-y border-gray-100 bg-gray-50/70 py-10 px-5 sm:px-6">
      <div className="max-w-5xl mx-auto">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
          {stats.map((stat) => (
            <div key={stat.label} className="text-center">
              <div className="text-2xl md:text-3xl font-bold text-gray-900 mb-1 tabular-nums">
                {stat.value}
              </div>
              <div className="text-xs sm:text-sm text-gray-500">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
