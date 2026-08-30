import CityChecker from '@/components/CityChecker'

export default function Hero() {
  return (
    <section className="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 pt-24 pb-20 text-center">
      <div className="max-w-4xl mx-auto">
        <div className="inline-flex items-center gap-2 bg-[#C8A84B]/10 border border-[#C8A84B]/20 text-[#C8A84B] text-xs font-medium px-3 py-1.5 rounded-full mb-8">
          <span className="w-1.5 h-1.5 rounded-full bg-[#C8A84B] animate-pulse inline-block" />
          5 villes fermées — nouvelles demandes en cours
        </div>

        <h1 className="text-4xl sm:text-5xl md:text-6xl font-bold text-[#EEE8D8] leading-tight mb-6 tracking-tight">
          Devenez le conseiller référent
          <br />
          <span className="text-[#C8A84B]">de votre ville — avant qu&apos;un autre le fasse.</span>
        </h1>

        <p className="text-lg sm:text-xl text-[#8090A8] max-w-2xl mx-auto leading-relaxed mb-3">
          Système clé en main pour attirer des vendeurs qualifiés dans votre secteur : site SEO local,
          CRM, automatisations et IA — avec exclusivité territoriale contractuelle sur votre ville.
        </p>

        <p className="text-sm text-[#4A5568]">
          Un seul conseiller par ville, garanti contractuellement. Dès qu&apos;un territoire est attribué, il ne se libère plus.
        </p>

        <CityChecker />

        <p className="mt-6 text-xs text-[#4A5568]">
          Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion — déjà attribués
        </p>
      </div>
    </section>
  )
}
