import { ADVISORS } from '@/data/cities'

export default function Proof() {
  return (
    <section id="preuves" className="py-20 px-4 sm:px-6 border-t border-[#1A2840]">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-14">
          <p className="text-[#C8A84B] text-xs font-semibold uppercase tracking-widest mb-3">
            Déjà déployé
          </p>
          <h2 className="text-3xl sm:text-4xl font-bold text-[#EEE8D8] mb-4">
            Premiers conseillers accompagnés
          </h2>
          <p className="text-[#8090A8] max-w-xl mx-auto text-sm leading-relaxed">
            Ces territoires sont attribués. Les conseillers ci-dessous ont réservé leur ville en exclusivité.
            Chaque territoire listé est définitivement fermé.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          {ADVISORS.map((advisor) => (
            <div
              key={advisor.name}
              className="bg-[#0D1829] border border-[#1A2840] rounded-lg p-5 flex items-start gap-4"
            >
              <div className="w-10 h-10 rounded-full bg-[#1A2840] flex items-center justify-center flex-shrink-0">
                <span className="text-[#C8A84B] font-bold text-sm">{advisor.initial}</span>
              </div>
              <div>
                <p className="text-[#EEE8D8] font-semibold text-sm">{advisor.name}</p>
                <p className="text-[#C8A84B] text-xs mb-1.5">{advisor.territory}</p>
                <div className="flex items-center gap-1.5">
                  <span className="inline-block w-1.5 h-1.5 rounded-full bg-green-400" />
                  <span className="text-[#4A5568] text-xs">Territoire actif</span>
                </div>
              </div>
            </div>
          ))}

          <div className="bg-[#080E1A] border border-dashed border-[#1A2840] rounded-lg p-5 flex items-start gap-4">
            <div className="w-10 h-10 rounded-full bg-[#0D1829] flex items-center justify-center flex-shrink-0">
              <span className="text-[#4A5568] text-lg leading-none">+</span>
            </div>
            <div className="pt-1">
              <p className="text-[#4A5568] font-semibold text-sm">Votre ville</p>
              <p className="text-[#4A5568] text-xs mt-0.5">En attente d&apos;attribution</p>
            </div>
          </div>
        </div>

        <div className="mt-8 text-center">
          <a
            href="#verifier"
            className="inline-block bg-[#C8A84B] hover:bg-[#D4B56A] text-[#080E1A] font-semibold px-6 py-3 rounded text-sm transition-colors"
          >
            Vérifier si ma ville est disponible
          </a>
        </div>
      </div>
    </section>
  )
}
