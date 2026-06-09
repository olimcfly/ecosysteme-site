'use client'

import { useState } from 'react'

const CLOSED_CITIES = [
  'bordeaux', 'bordeaux metropole', 'bordeaux-metropole', 'bordeaux métropole',
  'nantes', 'nantes metropole', 'nantes métropole',
  'nandy', 'senart', 'sénart', 'nandy senart', 'nandy sénart',
  'aix', 'aix en provence', 'aix-en-provence',
  'lannion', 'tregor', 'trégor', 'lannion tregor', 'lannion trégor',
]

type CheckState = 'idle' | 'available' | 'taken'
type SubmitState = 'idle' | 'loading' | 'success'

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
  const [checkState, setCheckState] = useState<CheckState>('idle')
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [phone, setPhone] = useState('')
  const [submitState, setSubmitState] = useState<SubmitState>('idle')

  const handleCheck = () => {
    if (!city.trim()) return
    setCheckState(isTaken(city) ? 'taken' : 'available')
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setSubmitState('loading')

    try {
      const res = await fetch('/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          city,
          name,
          email,
          phone,
          type: checkState === 'available' ? 'reservation' : 'waitlist',
        }),
      })
      if (!res.ok) throw new Error('api-error')
    } catch {
      // Fallback mailto si l'API n'est pas encore configurée
      const subject =
        checkState === 'available'
          ? `Réservation ville : ${city}`
          : `Liste d'attente : ${city}`
      const body = [
        `Nom : ${name}`,
        `Email : ${email}`,
        `Téléphone : ${phone || 'non renseigné'}`,
        `Ville : ${city}`,
      ].join('\n')
      window.location.href = `mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`
    }

    setSubmitState('success')
  }

  const inputBase =
    'w-full px-4 py-3 border rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 text-sm'

  if (submitState === 'success') {
    return (
      <div className="mt-4 p-5 bg-stone-50 border border-stone-200 rounded-xl text-center">
        <p className="text-stone-900 font-semibold mb-1">Demande reçue.</p>
        <p className="text-stone-500 text-sm">
          Olivier vous contacte sous 24h ouvrées — par email ou directement par téléphone.
        </p>
      </div>
    )
  }

  return (
    <div className="w-full">
      <div className="flex flex-col sm:flex-row gap-3">
        <input
          type="text"
          value={city}
          onChange={(e) => {
            setCity(e.target.value)
            setCheckState('idle')
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

      {checkState === 'available' && (
        <div className="mt-4 p-5 bg-emerald-50 border border-emerald-200 rounded-xl">
          <p className="text-emerald-900 font-semibold mb-1">
            {city} est disponible.
          </p>
          <p className="text-emerald-700 text-sm mb-4">
            Laissez vos coordonnées pour réserver l&apos;exclusivité. Olivier vous répond sous 24h ouvrées.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <input
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Votre nom complet"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            <input
              required
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Votre email professionnel"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            <input
              type="tel"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              placeholder="Téléphone (pour un rappel rapide)"
              className={`${inputBase} border-emerald-300 focus:ring-emerald-400`}
            />
            <button
              type="submit"
              disabled={submitState === 'loading'}
              className="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-lg transition-colors text-base disabled:opacity-60"
            >
              {submitState === 'loading'
                ? 'Envoi en cours…'
                : `Réserver l'exclusivité sur ${city}`}
            </button>
          </form>
        </div>
      )}

      {checkState === 'taken' && (
        <div className="mt-4 p-5 bg-red-50 border border-red-200 rounded-xl">
          <p className="text-red-900 font-semibold mb-1">
            {city} est déjà prise.
          </p>
          <p className="text-red-700 text-sm mb-4">
            Un conseiller a verrouillé ce territoire. Rejoignez la liste d&apos;attente — vous serez prévenu en priorité si la ville se libère, ou pour les communes limitrophes disponibles.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <input
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Votre nom complet"
              className={`${inputBase} border-red-300 focus:ring-red-400`}
            />
            <input
              required
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Votre email professionnel"
              className={`${inputBase} border-red-300 focus:ring-red-400`}
            />
            <button
              type="submit"
              disabled={submitState === 'loading'}
              className="w-full py-3.5 bg-stone-800 hover:bg-stone-900 text-white font-semibold rounded-lg transition-colors text-base disabled:opacity-60"
            >
              {submitState === 'loading'
                ? 'Envoi en cours…'
                : "Rejoindre la liste d'attente"}
            </button>
          </form>
        </div>
      )}
    </div>
  )
}
