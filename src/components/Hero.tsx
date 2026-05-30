'use client'

import { useState } from 'react'

const CLOSED_CITIES = [
  'bordeaux',
  'nantes',
  'nandy',
  'aix en provence',
  'aix-en-provence',
  'lannion',
]

function normalize(str: string): string {
  return str
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/[-']/g, ' ')
    .trim()
}

function isCityClosed(city: string): boolean {
  const n = normalize(city)
  return CLOSED_CITIES.some((c) => normalize(c) === n || normalize(c).includes(n) || n.includes(normalize(c)))
}

type Status = 'idle' | 'available' | 'taken' | 'submitted'

export default function Hero() {
  const [city, setCity] = useState('')
  const [email, setEmail] = useState('')
  const [status, setStatus] = useState<Status>('idle')
  const [checkedCity, setCheckedCity] = useState('')

  function handleCheck(e: React.FormEvent) {
    e.preventDefault()
    if (!city.trim()) return
    setCheckedCity(city.trim())
    setStatus(isCityClosed(city) ? 'taken' : 'available')
  }

  function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setStatus('submitted')
  }

  function reset() {
    setCity('')
    setEmail('')
    setStatus('idle')
    setCheckedCity('')
  }

  return (
    <section
      id="disponibilite"
      className="relative pt-28 pb-24 px-5 sm:px-6 bg-white overflow-hidden"
    >
      {/* Background texture */}
      <div
        aria-hidden
        className="absolute inset-0 bg-[radial-gradient(ellipse_at_60%_0%,_#d1fae5_0%,_transparent_60%)] opacity-40 pointer-events-none"
      />

      <div className="relative max-w-3xl mx-auto text-center">
        {/* Eyebrow */}
        <div className="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-600 text-xs font-medium px-4 py-2 rounded-full mb-8 shadow-sm">
          <span className="w-2 h-2 bg-emerald-500 rounded-full flex-shrink-0" />
          Réservé aux conseillers indépendants — 1 ville = 1 conseiller
        </div>

        {/* Headline */}
        <h1 className="text-4xl sm:text-5xl md:text-[3.75rem] font-bold tracking-tight text-gray-900 leading-[1.1] mb-6">
          Attirez des vendeurs qualifiés<br className="hidden sm:block" /> dans votre ville.{' '}
          <span className="text-emerald-600">Automatiquement.</span>
        </h1>

        {/* Subhead */}
        <p className="text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
          Un système d'acquisition local complet — site SEO, CRM, automatisations IA — configuré
          pour votre territoire, avec l'exclusivité de votre ville.
        </p>

        {/* City checker widget */}
        <div className="max-w-lg mx-auto">
          {status === 'idle' && (
            <form onSubmit={handleCheck} className="flex flex-col sm:flex-row gap-3">
              <input
                type="text"
                value={city}
                onChange={(e) => setCity(e.target.value)}
                placeholder="Votre ville..."
                className="flex-1 px-4 py-3.5 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-base min-h-[52px]"
                required
                autoComplete="off"
              />
              <button
                type="submit"
                className="bg-emerald-600 text-white font-semibold px-6 py-3.5 rounded-xl hover:bg-emerald-700 active:bg-emerald-800 transition-colors whitespace-nowrap text-base min-h-[52px]"
              >
                Vérifier ma ville
              </button>
            </form>
          )}

          {status === 'available' && (
            <div className="bg-emerald-50 border border-emerald-200 rounded-2xl p-6 text-left">
              <div className="flex items-start gap-3 mb-5">
                <div className="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg className="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <div>
                  <p className="font-bold text-gray-900 text-lg leading-tight">
                    {checkedCity} est disponible.
                  </p>
                  <p className="text-gray-500 text-sm mt-1">
                    Réservez maintenant avant qu'un concurrent prenne ce territoire.
                  </p>
                </div>
              </div>
              <form onSubmit={handleSubmit} className="flex flex-col sm:flex-row gap-3">
                <input
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="Votre email professionnel"
                  className="flex-1 px-4 py-3 border border-emerald-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white min-h-[48px]"
                  required
                />
                <button
                  type="submit"
                  className="bg-emerald-600 text-white font-semibold px-5 py-3 rounded-xl hover:bg-emerald-700 transition-colors text-sm whitespace-nowrap min-h-[48px]"
                >
                  Réserver ma ville
                </button>
              </form>
              <button onClick={reset} className="mt-3 text-xs text-gray-400 hover:text-gray-600 underline">
                Vérifier une autre ville
              </button>
            </div>
          )}

          {status === 'taken' && (
            <div className="bg-white border border-gray-200 rounded-2xl p-6 text-left shadow-sm">
              <div className="flex items-start gap-3 mb-5">
                <div className="w-10 h-10 bg-red-50 border border-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg className="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </div>
                <div>
                  <p className="font-bold text-gray-900 text-lg leading-tight">
                    {checkedCity} est déjà prise.
                  </p>
                  <p className="text-gray-500 text-sm mt-1">
                    Un conseiller est actif sur ce territoire. Inscrivez-vous pour être alerté si
                    une place se libère — ou vérifiez une ville proche.
                  </p>
                </div>
              </div>
              <form onSubmit={handleSubmit} className="flex flex-col sm:flex-row gap-3">
                <input
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="Votre email pour être alerté"
                  className="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm bg-white min-h-[48px]"
                  required
                />
                <button
                  type="submit"
                  className="bg-gray-900 text-white font-semibold px-5 py-3 rounded-xl hover:bg-gray-800 transition-colors text-sm whitespace-nowrap min-h-[48px]"
                >
                  M'alerter
                </button>
              </form>
              <button onClick={reset} className="mt-3 text-xs text-gray-400 hover:text-gray-600 underline">
                Vérifier une autre ville
              </button>
            </div>
          )}

          {status === 'submitted' && (
            <div className="bg-white border border-gray-200 rounded-2xl p-8 text-center shadow-sm">
              <div className="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p className="font-bold text-gray-900 text-lg mb-1">Demande reçue.</p>
              <p className="text-gray-500 text-sm">
                Vous serez contacté sous 24h pour{' '}
                <strong className="text-gray-700">{checkedCity}</strong>.
              </p>
            </div>
          )}
        </div>

        {/* Closed cities strip */}
        <p className="mt-6 text-sm text-gray-400">
          Déjà fermé :{' '}
          <span className="text-gray-500">
            Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion
          </span>
        </p>
      </div>
    </section>
  )
}
