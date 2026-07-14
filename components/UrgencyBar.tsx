export default function UrgencyBar() {
  return (
    <div className="bg-red-50 border-b border-red-100 py-2.5 fixed top-16 left-0 right-0 z-40">
      <p className="text-center text-sm text-red-700 font-medium px-4">
        <span className="inline-flex items-center gap-2">
          <span className="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0" />
          <span>
            5 villes déjà fermées ce mois — Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
          </span>
        </span>
      </p>
    </div>
  )
}
