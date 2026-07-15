'use client'

import { useState } from 'react'
import CityCheckerModal from '@/components/ui/CityCheckerModal'

const CLOSED = [
  'Bordeaux',
  'Nantes',
  'Nandy',
  'Aix-en-Provence',
  'Lannion',
]

export default function Exclusivity() {
  const [isModalOpen, setIsModalOpen] = useState(false)

  return (
    <>
      <section className="py-24 md:py-32 bg-navy">
        <div className="max-w-6xl mx-auto px-4 sm:px-6">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
              <p className="text-sm font-semibold text-gold uppercase tracking-wider mb-4">
                Exclusivité territoriale
              </p>
              <h2 className="text-3xl md:text-4xl font-bold text-white leading-tight mb-6">
                Un seul conseiller par ville.{' '}
                <br className="hidden md:block" />
                C'est la règle, pas l'exception.
              </h2>
              <p className="text-white/60 text-lg leading-relaxed mb-8">
                L'exclusivité territoriale n'est pas un argument commercial. C'est un engagement contractuel. Dès votre activation, votre secteur est fermé à tout autre conseiller sur la plateforme.
              </p>
              <ul className="space-y-4 mb-10">
                {[
                  'Exclusivité contractuelle — protégée par votre accord',
                  'Aucun concurrent sur Écosystème Immo dans votre ville',
                  'Territoire libéré seulement à votre demande',
                  'Option de verrouillage permanent disponible',
                ].map((item) => (
                  <li key={item} className="flex items-start gap-3">
                    <svg className="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                    <span className="text-white/80 text-sm">{item}</span>
                  </li>
                ))}
              </ul>
              <button
                onClick={() => setIsModalOpen(true)}
                className="btn-primary-lg bg-gold hover:bg-gold-light text-white rounded-lg"
              >
                Vérifier si ma ville est disponible
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </button>
            </div>

            <div>
              <div className="bg-white/5 border border-white/10 rounded-2xl p-8">
                <p className="text-sm font-semibold text-white/50 uppercase tracking-wider mb-6">
                  Villes actuellement fermées
                </p>
                <ul className="space-y-3 mb-8">
                  {CLOSED.map((city) => (
                    <li key={city} className="flex items-center justify-between py-3 border-b border-white/10 last:border-0">
                      <div className="flex items-center gap-3">
                        <svg className="w-4 h-4 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                          <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                        </svg>
                        <span className="text-white font-medium">{city}</span>
                      </div>
                      <span className="text-xs font-semibold text-red-400 bg-red-400/10 px-2.5 py-1 rounded-full">
                        Fermé
                      </span>
                    </li>
                  ))}
                </ul>

                <div className="bg-green-400/10 border border-green-400/20 rounded-xl p-4">
                  <div className="flex items-center gap-2 mb-2">
                    <span className="w-2 h-2 rounded-full bg-green-400 animate-pulse" />
                    <p className="text-green-400 text-sm font-semibold">Votre ville est peut-être encore libre</p>
                  </div>
                  <p className="text-white/50 text-xs leading-relaxed">
                    Des milliers de villes françaises restent disponibles. Vérifiez maintenant avant qu'un autre conseiller prenne votre territoire.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <CityCheckerModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </>
  )
}
