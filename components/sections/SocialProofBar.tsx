const STATS = [
  { value: '5', label: 'conseillers actifs' },
  { value: '5', label: 'villes fermées' },
  { value: '7 jours', label: 'pour être opérationnel' },
  { value: '1', label: 'seul conseiller par ville' },
]

export default function SocialProofBar() {
  return (
    <section id="preuves" className="bg-gray-50 border-y border-gray-200">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4">
          {STATS.map((stat, i) => (
            <div key={i} className="text-center">
              <div className="text-2xl md:text-3xl font-bold text-navy">{stat.value}</div>
              <div className="text-sm text-gray-500 mt-1">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
