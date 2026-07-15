'use client'

import { useState } from 'react'
import CityCheckerModal from '@/components/ui/CityCheckerModal'

export default function FinalCTA() {
  const [isModalOpen, setIsModalOpen] = useState(false)

  return (
    <>
      <section className="py-24 md:py-32 bg-gray-50 border-t border-gray-200">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 text-center">
          <div className="max-w-2xl mx-auto">
            <div className="inline-flex items-center gap-2 bg-navy/5 border border-navy/10 text-navy text-xs font-medium px-3.5 py-1.5 rounded-full mb-8">
              <span className="w-1.5 h-1.5 rounded-full bg-green-500" />
              Vérification gratuite — aucun engagement
            </div>

            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-balance">
              Votre territoire est peut-être encore libre.
            </h2>
            <p className="text-lg text-gray-500 mb-10 leading-relaxed">
              5 villes déjà fermées. D'autres partent régulièrement. Si votre ville est disponible, ne laissez pas un concurrent s'y installer avant vous.
            </p>

            <div className="flex flex-col sm:flex-row items-center justify-center gap-3 mb-10">
              <button
                onClick={() => setIsModalOpen(true)}
                className="btn-primary-lg w-full sm:w-auto"
              >
                Vérifier si ma ville est disponible
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </button>
              <a
                href="mailto:contact@ecosystemeimmo.fr"
                className="btn-secondary w-full sm:w-auto"
              >
                Poser une question à Olivier
              </a>
            </div>

            <div className="flex flex-wrap justify-center gap-6 text-sm text-gray-400">
              <span className="flex items-center gap-1.5">
                <svg className="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
                Déploiement en 7 jours
              </span>
              <span className="flex items-center gap-1.5">
                <svg className="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
                Exclusivité contractuelle
              </span>
              <span className="flex items-center gap-1.5">
                <svg className="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
                Sans frais cachés
              </span>
              <span className="flex items-center gap-1.5">
                <svg className="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
                Support direct avec Olivier
              </span>
            </div>
          </div>
        </div>
      </section>

      <CityCheckerModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </>
  )
}
