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
  const [submitted, setSubmitted] = useState(false)

  const handleCheck = () => {
    if (!city.trim()) return
    setState(isTaken(city) ? 'taken' : 'available')
  }

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    const subject =
      state === 'available'
        ? `Réservation ville : ${city}`
        : `Liste d'attente : ${city}`
    const body = `Nom : ${name}\nEmail : ${email}\nTéléphone : ${phone || 'non renseigné'}\nVille : ${city}\nStatut : ${state === 'available' ? 'ville disponible' : 'liste d\'attente'}`
    window.location.href = `mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`
    setSubmitted(true)
  }

  const inputBase =
    'w-full px-4 py-3 border rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 text-sm'

  return (
    <div className="w-full">
      {/* Search row */}
      <div className="flex flex-col sm:flex-row gap-3">
        <input
          type="text"
          value={city}
          onChange={(e) => {
            setCity(e.target.value)
            setState('idle')
            setSubmitted(false)
          }}
          onKeyDown={(e) => e.key === 'Enter' && handleCheck()}
          placeholder="Entrez le nom de votre ville…"
          className="flex-1 px-4 py-4 border border-stone-300 rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent text-base"
          aria-label="Nom de votre ville"
        />
        <button
          onClick={handleCheck}
          className="btn-primary !py-4 whitespace-nowrap"
          disabled={!city.trim()}
        >
          Vérifier
        </button>
      </div>

      {/* Result: available */}
      {state === 'available' && !submitted && (
        <div className="mt-4 p-5 bg-emerald-50 border border-emerald-200 rounded-xl">
          <p className="text-emerald-900 font-semibold mb-1">
            {city} est disponible.
          </p>
          <p className="text-emerald-700 text-sm mb-4">
            Laissez vos coordonnées pour réserver votre exclusivité. Réponse sous 24h ouvrées.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <input
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Votre nom"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            <input
              required
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Votre email"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            <input
              type="tel"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              placeholder="Téléphone (facultatif)"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            <button
              type="submit"
              className="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-lg transition-colors text-base"
            >
              Réserver {city}
            </button>
          </form>
        </div>
      )}

      {/* Result: taken */}
      {state === 'taken' && !submitted && (
        <div className="mt-4 p-5 bg-red-50 border border-red-200 rounded-xl">
          <p className="text-red-900 font-semibold mb-1">
            {city} est déjà prise.
          </p>
          <p className="text-red-700 text-sm mb-4">
            Un conseiller a verrouillé ce territoire. Rejoignez la liste d&apos;attente — vous serez prévenu en priorité si la ville se libère.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <input
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Votre nom"
              className={`${inputBase} border-red-300 focus:ring-red-400`}
            />
            <input
              required
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Votre email"
              className={`${inputBase} border-red-300 focus:ring-red-400`}
            />
            <button
              type="submit"
              className="w-full py-3.5 bg-stone-800 hover:bg-stone-900 text-white font-semibold rounded-lg transition-colors text-base"
            >
              Rejoindre la liste d&apos;attente
            </button>
          </form>
        </div>
      )}

      {/* Submitted confirmation */}
      {submitted && (
        <div className="mt-4 p-4 bg-stone-50 border border-stone-200 rounded-xl text-center">
          <p className="text-stone-700 font-medium">
            Message envoyé. Réponse sous 24–48h ouvrées.
          </p>
        </div>
      )}
    </div>
  )
}
