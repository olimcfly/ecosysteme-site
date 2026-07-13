const CLOSED = [
  'Bordeaux',
  'Nantes',
  'Aix-en-Provence',
  'Nandy',
  'Lannion',
]

export default function ProofBar() {
  return (
    <div className="bg-stone-900 text-stone-300 py-2.5 px-4">
      <div className="max-w-5xl mx-auto flex flex-wrap items-center justify-center gap-x-5 gap-y-1 text-xs">
        <span className="font-semibold text-stone-400 uppercase tracking-widest text-[10px]">
          Territoires fermés
        </span>
        <span className="hidden sm:block w-px h-3 bg-stone-700" />
        {CLOSED.map((city) => (
          <span key={city} className="flex items-center gap-1.5">
            <span className="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0" />
            <span className="text-stone-400">{city}</span>
          </span>
        ))}
        <span className="hidden sm:block w-px h-3 bg-stone-700" />
        <a
          href="#verifier-ville"
          className="text-white font-semibold hover:text-stone-200 transition-colors"
        >
          Vérifier la vôtre
        </a>
      </div>
    </div>
  )
}
