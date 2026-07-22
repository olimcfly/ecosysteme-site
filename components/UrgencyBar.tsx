export default function UrgencyBar() {
  return (
    <div className="bg-stone-900 py-2.5 fixed top-16 left-0 right-0 z-40">
      <p className="text-center text-[13px] text-stone-300 px-4">
        <span className="inline-flex items-center gap-2 flex-wrap justify-center">
          <span className="flex items-center gap-1.5">
            <span className="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0" />
            <span>Territoires complets : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion</span>
          </span>
          <a
            href="#verifier-ville"
            className="text-white font-semibold underline-offset-2 hover:underline whitespace-nowrap"
          >
            Vérifiez le vôtre &rarr;
          </a>
        </span>
      </p>
    </div>
  )
}
