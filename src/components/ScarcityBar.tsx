const CLOSED_CITIES = [
  "Bordeaux",
  "Nantes",
  "Nandy",
  "Aix-en-Provence",
  "Lannion",
];

export default function ScarcityBar() {
  return (
    <div className="bg-ei-card border-y border-ei-border py-3 px-4">
      <div className="max-w-6xl mx-auto flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-sm">
        <span className="text-ei-faint font-medium whitespace-nowrap">
          Villes fermées :
        </span>
        <div className="flex flex-wrap gap-x-4 gap-y-1 justify-center">
          {CLOSED_CITIES.map((city) => (
            <span
              key={city}
              className="text-ei-muted flex items-center gap-1.5 whitespace-nowrap"
            >
              <span className="w-1.5 h-1.5 bg-red-500 rounded-full flex-shrink-0" />
              {city}
            </span>
          ))}
        </div>
        <a
          href="#verifier-ma-ville"
          className="text-ei-gold hover:text-ei-gold-light text-sm font-medium whitespace-nowrap transition-colors"
        >
          Vérifier la mienne →
        </a>
      </div>
    </div>
  );
}
