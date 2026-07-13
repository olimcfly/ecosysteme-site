'use client'

import { useState } from 'react'

const CLOSED_CITIES = [
  'bordeaux', 'nantes', 'nandy', 'senart', 'sénart',
  'aix', 'aix-en-provence', 'lannion', 'tregor', 'trégor',
]

type State = 'idle' | 'available' | 'taken'

function normalize(s: string): string {
  return s
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9\s-]/g, '')
    .trim()
}

function isTaken(city: string): boolean {
  const n = normalize(city)
  if (!n) return false
  return CLOSED_CITIES.some((c) => {
    const cn = normalize(c)
    return cn === n || n.includes(cn) || cn.includes(n)
  })
}

export default function CityChecker() {
  const [city, setCity] = useState('')
  const [state, setState] = useState<State>('idle')
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [phone, setPhone] = useState('')
  const [loading, setLoading] = useState(false)
  const [submitted, setSubmitted] = useState(false)
  const [error, setError] = useState('')

  const handleCheck = () => {
    if (!city.trim()) return
    setState(isTaken(city) ? 'taken' : 'available')
    setName('')
    setEmail('')
    setPhone('')
    setSubmitted(false)
    setError('')
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    setError('')

    try {
      const res = await fetch('/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ city, name, email, phone, type: state }),
      })

      if (!res.ok) throw new Error()
      setSubmitted(true)
    } catch {
      // Fallback : ouvrir le client email si l'API n'est pas disponible
      const subject =
        state === 'available'
          ? `Réservation territoire : ${city}`
          : `Liste d'attente : ${city}`
      const body = `Nom : ${name}\nEmail : ${email}\nTéléphone : ${phone || 'non renseigné'}\nVille : ${city}`
      window.open(
        `mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`,
      )
      setSubmitted(true)
    } finally {
      setLoading(false)
    }
  }

  const inputBase =
    'w-full px-4 py-3 border rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 text-sm transition-colors'

  if (submitted) {
    return (
      <div className="mt-0 p-5 bg-stone-50 border border-stone-200 rounded-xl text-center">
        <p className="text-stone-900 font-semibold mb-1">Demande reçue.</p>
        <p className="text-stone-500 text-sm">
          Olivier vous contacte sous 24h ouvrées au sujet de{' '}
          <strong className="text-stone-700">{city}</strong>.
        </p>
      </div>
    )
  }

  return (
    <div className="w-full">
      {/* Input row */}
      <div className="flex flex-col sm:flex-row gap-3">
        <input
          type="text"
          value={city}
          onChange={(e) => {
            setCity(e.target.value)
            setState('idle')
            setError('')
          }}
          onKeyDown={(e) => e.key === 'Enter' && handleCheck()}
          placeholder="Votre ville (ex : Lyon, Rennes…)"
          className="flex-1 px-4 py-4 border border-stone-300 rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent text-base transition-colors"
          aria-label="Nom de votre ville"
        />
        <button
          onClick={handleCheck}
          className="btn-primary !py-4 whitespace-nowrap"
          disabled={!city.trim()}
        >
          Vérifier ma ville
        </button>
      </div>

      {/* Available */}
      {state === 'available' && (
        <div className="mt-4 p-5 bg-emerald-50 border border-emerald-200 rounded-xl">
          <div className="flex items-center gap-2 mb-1">
            <span className="w-2 h-2 rounded-full bg-emerald-500 shrink-0" />
            <p className="text-emerald-900 font-semibold">
              {city} est disponible.
            </p>
          </div>
          <p className="text-emerald-700 text-sm mb-4 pl-4">
            Réservez votre exclusivité maintenant. Réponse sous 24h ouvrées, sans engagement immédiat.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <div className="flex flex-col sm:flex-row gap-3">
              <input
                required
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder="Votre nom"
                className={`${inputBase} border-emerald-300 focus:ring-emerald-400 sm:flex-1`}
              />
              <input
                required
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Votre email"
                className={`${inputBase} border-emerald-300 focus:ring-emerald-400 sm:flex-1`}
              />
            </div>
            <input
              type="tel"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              placeholder="Téléphone (facultatif — pour un rappel rapide)"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            {error && <p className="text-red-600 text-xs">{error}</p>}
            <button
              type="submit"
              disabled={loading}
              className="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 disabled:opacity-60 text-white font-semibold rounded-lg transition-colors text-base"
            >
              {loading ? 'Envoi en cours…' : `Réserver l'exclusivité sur ${city}`}
            </button>
          </form>
        </div>
      )}

      {/* Taken */}
      {state === 'taken' && (
        <div className="mt-4 p-5 bg-red-50 border border-red-200 rounded-xl">
          <div className="flex items-center gap-2 mb-1">
            <span className="w-2 h-2 rounded-full bg-red-500 shrink-0" />
            <p className="text-red-900 font-semibold">{city} est déjà prise.</p>
          </div>
          <p className="text-red-700 text-sm mb-4 pl-4">
            Un conseiller a verrouillé ce territoire. Inscrivez-vous en liste
            prioritaire — vous serez alerté en premier si la ville se libère.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <div className="flex flex-col sm:flex-row gap-3">
              <input
                required
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder="Votre nom"
                className={`${inputBase} border-red-300 focus:ring-red-400 sm:flex-1`}
              />
              <input
                required
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Votre email"
                className={`${inputBase} border-red-300 focus:ring-red-400 sm:flex-1`}
              />
            </div>
            {error && <p className="text-red-600 text-xs">{error}</p>}
            <button
              type="submit"
              disabled={loading}
              className="w-full py-3.5 bg-stone-800 hover:bg-stone-900 disabled:opacity-60 text-white font-semibold rounded-lg transition-colors text-base"
            >
              {loading ? 'Envoi en cours…' : 'Rejoindre la liste prioritaire'}
            </button>
          </form>
        </div>
      )}
    </div>
  )
}
