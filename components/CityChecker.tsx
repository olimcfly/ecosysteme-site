'use client'

import { useState } from 'react'
import { CLOSED_CITIES } from '@/data/cities'

function normalizeCity(city: string): string {
  return city
    .toLowerCase()
    .normalize('NFD')
    .replace(/\p{Mn}/gu, '')
    .replace(/-/g, ' ')
    .trim()
}

export default function CityChecker() {
  const [city, setCity] = useState('')
  const [result, setResult] = useState<'available' | 'taken' | null>(null)
  const [checkedCity, setCheckedCity] = useState('')

  function handleCheck(e: React.FormEvent) {
    e.preventDefault()
    if (!city.trim()) return
    const normalized = normalizeCity(city)
    const isTaken = CLOSED_CITIES.some((c) => normalizeCity(c) === normalized)
    setResult(isTaken ? 'taken' : 'available')
    setCheckedCity(city.trim())
  }

  return (
    <div id="verifier" className="mt-10 max-w-lg mx-auto">
      <form onSubmit={handleCheck} className="flex flex-col sm:flex-row gap-3">
        <input
          type="text"
          value={city}
          onChange={(e) => {
            setCity(e.target.value)
            setResult(null)
          }}
          placeholder="Entrez votre ville..."
          className="flex-1 bg-[#0D1829] border border-[#1A2840] focus:border-[#C8A84B] text-[#EEE8D8] placeholder-[#4A5568] rounded px-4 py-3 text-sm outline-none transition-colors"
          autoComplete="off"
        />
        <button
          type="submit"
          className="bg-[#C8A84B] hover:bg-[#D4B56A] text-[#080E1A] font-semibold px-6 py-3 rounded text-sm transition-colors whitespace-nowrap"
        >
          Vérifier ma ville
        </button>
      </form>

      {result === 'available' && (
        <div className="mt-4 rounded border border-green-800/40 bg-green-950/30 p-4">
          <div className="flex items-center gap-2 mb-2">
            <span className="inline-block w-2 h-2 rounded-full bg-green-400" />
            <span className="text-green-400 font-semibold text-sm">
              {checkedCity} — territoire disponible
            </span>
          </div>
          <p className="text-[#8090A8] text-xs leading-relaxed mb-3">
            Ce territoire n&apos;est pas encore attribué. Il peut être réservé dès maintenant avec exclusivité garantie.
          </p>
          <a
            href={`mailto:contact@ecosystemeimmo.fr?subject=R%C3%A9servation%20territoire%20%E2%80%94%20${encodeURIComponent(checkedCity)}&body=Bonjour%2C%0A%0AJe%20souhaite%20r%C3%A9server%20le%20territoire%20de%20${encodeURIComponent(checkedCity)}.%0A%0ACordialement`}
            className="inline-block bg-green-700 hover:bg-green-600 text-white font-semibold text-sm px-4 py-2 rounded transition-colors"
          >
            Réserver ce territoire
          </a>
        </div>
      )}

      {result === 'taken' && (
        <div className="mt-4 rounded border border-red-900/40 bg-red-950/20 p-4">
          <div className="flex items-center gap-2 mb-2">
            <span className="inline-block w-2 h-2 rounded-full bg-red-400" />
            <span className="text-red-400 font-semibold text-sm">
              {checkedCity} — territoire attribué
            </span>
          </div>
          <p className="text-[#8090A8] text-xs leading-relaxed mb-3">
            Ce territoire est déjà réservé en exclusivité. Essayez une ville voisine ou rejoignez la liste d&apos;attente.
          </p>
          <a
            href={`mailto:contact@ecosystemeimmo.fr?subject=Liste%20attente%20%E2%80%94%20${encodeURIComponent(checkedCity)}&body=Bonjour%2C%0A%0AJe%20souhaite%20rejoindre%20la%20liste%20d'attente%20pour%20${encodeURIComponent(checkedCity)}.%0A%0ACordialement`}
            className="inline-block bg-[#1A2840] hover:bg-[#243550] text-[#EEE8D8] font-semibold text-sm px-4 py-2 rounded transition-colors"
          >
            Rejoindre la liste d&apos;attente
          </a>
        </div>
      )}
    </div>
  )
}
