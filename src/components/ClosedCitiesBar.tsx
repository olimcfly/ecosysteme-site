const CLOSED = [
  "Bordeaux",
  "Nantes",
  "Aix-en-Provence",
  "Nandy",
  "Lannion",
];

export function ClosedCitiesBar() {
  return (
    <div className="bg-[#0D1117] border-y border-[#1C2333]">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
        <div className="flex flex-wrap items-center gap-3 justify-center sm:justify-between">
          <span className="text-slate-500 text-xs font-medium uppercase tracking-wider whitespace-nowrap">
            Villes fermées
          </span>
          <div className="flex flex-wrap items-center gap-2">
            {CLOSED.map((city) => (
              <span
                key={city}
                className="flex items-center gap-1.5 bg-red-950/30 border border-red-900/30 text-red-400 text-xs font-medium px-3 py-1 rounded-full"
              >
                <span className="w-1.5 h-1.5 rounded-full bg-red-500/70" />
                {city}
              </span>
            ))}
          </div>
          <span className="text-slate-500 text-xs whitespace-nowrap hidden sm:block">
            Places limitées
          </span>
        </div>
      </div>
    </div>
  );
}
