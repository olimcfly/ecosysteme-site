'use client'

import { useState, useEffect, useRef } from 'react'

const CLOSED_CITIES = [
  'bordeaux',
  'nantes',
  'nandy',
  'aix-en-provence',
  'aix en provence',
  'lannion',
]

function normalizeCity(city: string): string {
  return city
    .toLowerCase()
    .trim()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
}

function checkCity(city: string): 'closed' | 'available' | null {
  if (!city.trim()) return null
  const normalized = normalizeCity(city)
  const isClosed = CLOSED_CITIES.some((c) => normalized.includes(normalizeCity(c)))
  return isClosed ? 'closed' : 'available'
}

interface Props {
  isOpen: boolean
  onClose: () => void
}

export default function CityCheckerModal({ isOpen, onClose }: Props) {
  const [city, setCity] = useState('')
  const [result, setResult] = useState<'closed' | 'available' | null>(null)
  const inputRef = useRef<HTMLInputElement>(null)

  useEffect(() => {
    if (isOpen) {
      setTimeout(() => inputRef.current?.focus(), 50)
      document.body.style.overflow = 'hidden'
    } else {
      document.body.style.overflow = ''
      setCity('')
      setResult(null)
    }
    return () => {
      document.body.style.overflow = ''
    }
  }, [isOpen])

  useEffect(() => {
    const handleKey = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose()
    }
    if (isOpen) document.addEventListener('keydown', handleKey)
    return () => document.removeEventListener('keydown', handleKey)
  }, [isOpen, onClose])

  const handleCheck = () => {
    setResult(checkCity(city))
  }

  const handleKeyDown = (e: React.KeyboardEvent) => {
    if (e.key === 'Enter') handleCheck()
  }

  const mailtoAvailable = `mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent(`Réservation territoire — ${city}`)}`
  const mailtoAlternatives = `mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent('Disponibilité territoire proche')}`

  if (!isOpen) return null

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center p-4"
      role="dialog"
      aria-modal="true"
      aria-label="Vérifier la disponibilité de ma ville"
    >
      <div
        className="absolute inset-0 bg-navy/70 backdrop-blur-sm"
        onClick={onClose}
      />
      <div className="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
          aria-label="Fermer"
        >
          <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <h2 className="text-2xl font-bold text-gray-900 mb-2">
          Votre ville est-elle disponible ?
        </h2>
        <p className="text-gray-500 text-sm mb-6">
          Entrez le nom de votre ville pour vérifier si le territoire est encore libre.
        </p>

        <div className="flex gap-2 mb-4">
          <input
            ref={inputRef}
            type="text"
            value={city}
            onChange={(e) => {
              setCity(e.target.value)
              setResult(null)
            }}
            onKeyDown={handleKeyDown}
            placeholder="Ex : Lyon, Rennes, Toulouse..."
            className="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
          />
          <button
            onClick={handleCheck}
            disabled={!city.trim()}
            className="btn-primary disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap"
          >
            Vérifier
          </button>
        </div>

        {result === 'closed' && (
          <div className="rounded-xl bg-red-50 border border-red-200 p-5 mt-4">
            <div className="flex items-start gap-3">
              <span className="text-red-500 mt-0.5 flex-shrink-0">
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z" />
                </svg>
              </span>
              <div>
                <p className="font-semibold text-red-700 text-sm">Territoire fermé</p>
                <p className="text-red-600 text-sm mt-1">
                  {"Cette ville est déjà attribuée à un conseiller. D'autres territoires proches de chez vous sont peut-être disponibles."}
                </p>
                <a
                  href={mailtoAlternatives}
                  className="inline-block mt-3 text-sm font-semibold text-navy underline"
                >
                  Contacter Olivier pour explorer les alternatives
                </a>
              </div>
            </div>
          </div>
        )}

        {result === 'available' && (
          <div className="rounded-xl bg-green-50 border border-green-200 p-5 mt-4">
            <div className="flex items-start gap-3">
              <span className="text-green-500 mt-0.5 flex-shrink-0">
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
              </span>
              <div>
                <p className="font-semibold text-green-700 text-sm">Votre ville est disponible</p>
                <p className="text-green-600 text-sm mt-1">
                  <strong className="capitalize">{city}</strong>{" n'est pas encore attribuée. Réservez votre territoire avant qu'un autre conseiller le fasse."}
                </p>
                <a
                  href={mailtoAvailable}
                  className="inline-flex items-center gap-2 mt-3 btn-primary text-sm py-2.5 px-4"
                >
                  Réserver mon territoire maintenant
                  <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        )}

        <p className="text-xs text-gray-400 text-center mt-6">
          Ou appelez directement :{' '}
          <a href="tel:0785611700" className="font-medium text-gray-600 hover:text-navy">
            07 85 61 17 00
          </a>
        </p>
      </div>
    </div>
  )
}
