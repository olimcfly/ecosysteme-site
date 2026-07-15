'use client'

import { useState } from 'react'
import CityCheckerModal from '@/components/ui/CityCheckerModal'

const CLOSED_CITIES = ['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion']

export default function Hero() {
  const [isModalOpen, setIsModalOpen] = useState(false)

  return (
    <>
      <section className="relative bg-navy min-h-screen flex items-center overflow-hidden">
        <div
          className="absolute inset-0 opacity-30"
          style={{
            backgroundImage: `radial-gradient(ellipse 80% 60% at 70% 50%, #1E3A5F 0%, transparent 70%)`,
          }}
        />

        <div className="relative max-w-6xl mx-auto px-4 sm:px-6 py-32 md:py-40 w-full">
          <div className="max-w-3xl">
            <div className="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white/90 text-xs font-medium px-3.5 py-1.5 rounded-full mb-8">
              <span className="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse" />
              5 villes déjà fermées — Places limitées par secteur
            </div>

            <h1 className="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight text-balance mb-6">
              Devenez la référence immobilière de votre ville,{' '}
              <span className="text-gold">avant quelqu'un d'autre.</span>
            </h1>

            <p className="text-lg md:text-xl text-white/70 leading-relaxed mb-10 max-w-2xl">
              Un système d'acquisition local complet déployé en 7 jours : site professionnel, SEO de quartier, Google Business Profile, CRM et automatisations.{' '}
              <strong className="text-white/90 font-semibold">Un seul conseiller par ville.</strong>
            </p>

            <div className="flex flex-col sm:flex-row gap-3 mb-12">
              <button
                onClick={() => setIsModalOpen(true)}
                className="btn-primary-lg bg-gold hover:bg-gold-light text-white rounded-lg"
              >
                Vérifier si ma ville est disponible
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </button>
              <a
                href="#tarifs"
                className="inline-flex items-center justify-center gap-2 border border-white/30 text-white font-semibold px-8 py-4 text-lg rounded-lg hover:bg-white/10 transition-colors duration-150"
              >
                Voir les offres
              </a>
            </div>

            <div className="flex flex-wrap gap-2">
              {CLOSED_CITIES.map((city) => (
                <span key={city} className="badge-closed">
                  <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                  </svg>
                  {city} — Fermé
                </span>
              ))}
              <span className="inline-flex items-center text-xs text-white/50 pl-1">
                · Votre ville est peut-être libre
              </span>
            </div>
          </div>
        </div>

        <div className="absolute bottom-8 left-1/2 -translate-x-1/2 hidden md:block">
          <a href="#preuves" aria-label="Défiler vers le bas">
            <svg className="w-6 h-6 text-white/30 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M19 9l-7 7-7-7" />
            </svg>
          </a>
        </div>
      </section>

      <CityCheckerModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </>
  )
}
