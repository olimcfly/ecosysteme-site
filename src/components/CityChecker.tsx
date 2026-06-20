'use client'
import { useState } from 'react'
import { CLOSED_CITIES, CONTACT_URL, WAITLIST_URL } from '@/lib/config'

function normalize(str: string): string {
  return str
    .toLowerCase()
    .normalize("NFD")
    .replace(/\p{M}/gu, "")
    .replace(/[\s\-]+/g, " ")
    .trim()
}

type Status = 'idle' | 'available' | 'closed'

export default function CityChecker({ dark = false }: { dark?: boolean }) {
  const [input, setInput] = useState('')
  const [city, setCity] = useState('')
  const [status, setStatus] = useState<Status>('idle')

  function handleCheck() {
    const trimmed = input.trim()
    if (!trimmed) return
    const norm = normalize(trimmed)
    const isClosed = CLOSED_CITIES.some((c) => normalize(c) === norm)
    setCity(trimmed)
    setStatus(isClosed ? 'closed' : 'available')
  }

  return (
    <div className="w-full max-w-lg">
      <div className="flex flex-col sm:flex-row gap-3">
        <input
          type="text"
          value={input}
          onChange={(e) => setInput(e.target.value)}
          onKeyDown={(e) => e.key === 'Enter' && handleCheck()}
          placeholder="Entrez votre ville..."
          className="flex-1 px-4 py-3.5 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-xl outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent placeholder-zinc-400"
        />
        <button
          onClick={handleCheck}
          className={`px-5 py-3.5 text-sm font-semibold rounded-xl transition-colors whitespace-nowrap ${
            dark
              ? 'bg-amber-500 text-white hover:bg-amber-400'
              : 'bg-zinc-900 text-white hover:bg-zinc-700'
          }`}
        >
          Vérifier la disponibilité
        </button>
      </div>

      {status === 'available' && (
        <div className="mt-4 p-4 border border-green-200 bg-green-50 rounded-xl">
          <div className="flex items-start gap-3">
            <div className="mt-0.5 flex-shrink-0 w-5 h-5 bg-green-600 rounded-full flex items-center justify-center">
              <svg
                className="w-3 h-3 text-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={3}
              >
                <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div className="flex-1">
              <p className="text-sm font-semibold text-green-900">{city} est disponible.</p>
              <p className="text-xs text-green-700 mt-0.5 leading-relaxed">
                {"Réservez l'exclusivité avant qu'un concurrent ne le fasse."}
              </p>
              <a
                href={CONTACT_URL}
                className="mt-3 inline-flex items-center gap-1.5 px-4 py-2 bg-zinc-900 text-white text-xs font-semibold rounded-lg hover:bg-zinc-700 transition-colors"
              >
                {"Réserver l'exclusivité maintenant"}
                <svg
                  className="w-3.5 h-3.5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  strokeWidth={2}
                >
                  <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      )}

      {status === 'closed' && (
        <div className="mt-4 p-4 border border-zinc-200 bg-white rounded-xl">
          <div className="flex items-start gap-3">
            <div className="mt-0.5 flex-shrink-0">
              <svg
                className="w-5 h-5 text-zinc-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={2}
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                />
              </svg>
            </div>
            <div className="flex-1">
              <p className="text-sm font-semibold text-zinc-900">{city} est fermée.</p>
              <p className="text-xs text-zinc-600 mt-0.5 leading-relaxed">
                {"Cette ville est déjà réservée. Rejoignez la liste d'attente prioritaire pour être notifié si elle se libère."}
              </p>
              <a
                href={WAITLIST_URL}
                className="mt-3 inline-flex items-center gap-1.5 px-4 py-2 border border-zinc-300 text-zinc-900 text-xs font-semibold rounded-lg hover:bg-zinc-50 transition-colors"
              >
                {"Rejoindre la liste d'attente"}
                <svg
                  className="w-3.5 h-3.5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  strokeWidth={2}
                >
                  <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}
