'use client'

import { useState } from 'react'

const CLOSED_CITIES = [
  'bordeaux', 'nantes', 'nandy', 'senart', 'sénart',
  'aix', 'aix-en-provence', 'lannion', 'tregor', 'trégor',
]

type Step = 'idle' | 'available' | 'taken' | 'submitting' | 'done'

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
  const [step, setStep] = useState<Step>('idle')
  const [taken, setTaken] = useState(false)
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [phone, setPhone] = useState('')
  const [error, setError] = useState<string | null>(null)

  const handleCheck = () => {
    if (!city.trim()) return
    const cityTaken = isTaken(city)
    setTaken(cityTaken)
    setError(null)
    setStep(cityTaken ? 'taken' : 'available')
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setError(null)
    setStep('submitting')
    try {
      const res = await fetch('/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          city: city.trim(),
          type: taken ? 'waiting' : 'available',
          name: name.trim(),
          email: email.trim(),
          phone: phone.trim() || undefined,
        }),
      })
      if (!res.ok) {
        const data = await res.json().catch(() => ({}))
        throw new Error((data as { error?: string }).error || 'Erreur serveur')
      }
      setStep('done')
    } catch (err: unknown) {
      const message =
        err instanceof Error
          ? err.message
          : 'Une erreur est survenue. Appelez directement le 07 85 61 17 00.'
      setError(message)
      setStep(taken ? 'taken' : 'available')
    }
  }

  const inputCls = (color: 'green' | 'red') =>
    `w-full px-4 py-3 border rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 text-sm ${
      color === 'green'
        ? 'border-emerald-300 focus:ring-emerald-400'
        : 'border-red-300 focus:ring-red-400'
    }`

  const isSubmitting = step === 'submitting'

  return (
    <div className="w-full">
      {/* Ligne de saisie */}
      <div className="flex flex-col sm:flex-row gap-3">
        <input
          type="text"
          value={city}
          onChange={(e) => {
            setCity(e.target.value)
            if (step !== 'idle' && step !== 'done') setStep('idle')
            setError(null)
          }}
          onKeyDown={(e) => e.key === 'Enter' && handleCheck()}
          placeholder="Entrez le nom de votre ville…"
          className="flex-1 px-4 py-4 border border-stone-300 rounded-lg text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent text-base"
          aria-label="Nom de votre ville"
          disabled={isSubmitting}
        />
        <button
          onClick={handleCheck}
          className="btn-primary !py-4 whitespace-nowrap"
          disabled={!city.trim() || isSubmitting}
        >
          Vérifier
        </button>
      </div>

      {/* Erreur */}
      {error && (
        <p className="mt-3 text-sm text-red-600 text-center">{error}</p>
      )}

      {/* Ville disponible */}
      {(step === 'available' || (isSubmitting && !taken)) && (
        <div className="mt-4 p-5 bg-emerald-50 border border-emerald-200 rounded-xl">
          <p className="text-emerald-900 font-semibold mb-1">
            {city} est disponible.
          </p>
          <p className="text-emerald-700 text-sm mb-4">
            Laissez vos coordonnées pour réserver votre exclusivité. Réponse d&apos;Olivier sous 24h ouvrées.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <input
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Votre nom"
              className={inputCls('green')}
              disabled={isSubmitting}
            />
            <input
              required
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Votre email professionnel"
              className={inputCls('green')}
              disabled={isSubmitting}
            />
            <input
              type="tel"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              placeholder="Téléphone (recommandé — réponse plus rapide)"
              className={inputCls('green')}
              disabled={isSubmitting}
            />
            <button
              type="submit"
              className="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-lg transition-colors text-base disabled:opacity-60"
              disabled={isSubmitting}
            >
              {isSubmitting ? 'Envoi en cours…' : `Réserver l'exclusivité sur ${city}`}
            </button>
          </form>
        </div>
      )}

      {/* Ville prise */}
      {(step === 'taken' || (isSubmitting && taken)) && (
        <div className="mt-4 p-5 bg-red-50 border border-red-200 rounded-xl">
          <p className="text-red-900 font-semibold mb-1">
            {city} est déjà prise.
          </p>
          <p className="text-red-700 text-sm mb-4">
            Un conseiller a verrouillé ce territoire. Inscrivez-vous sur liste d&apos;attente — vous serez prévenu en priorité si la ville se libère.
          </p>
          <form onSubmit={handleSubmit} className="flex flex-col gap-3">
            <input
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Votre nom"
              className={inputCls('red')}
              disabled={isSubmitting}
            />
            <input
              required
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Votre email"
              className={inputCls('red')}
              disabled={isSubmitting}
            />
            <button
              type="submit"
              className="w-full py-3.5 bg-stone-800 hover:bg-stone-900 text-white font-semibold rounded-lg transition-colors text-base disabled:opacity-60"
              disabled={isSubmitting}
            >
              {isSubmitting ? 'Envoi en cours…' : "Rejoindre la liste d'attente"}
            </button>
          </form>
        </div>
      )}

      {/* Confirmation */}
      {step === 'done' && (
        <div className="mt-4 p-5 bg-stone-50 border border-stone-200 rounded-xl text-center">
          <p className="text-stone-800 font-semibold mb-1">Demande envoyée.</p>
          <p className="text-stone-500 text-sm">
            Réponse d&apos;Olivier sous 24h ouvrées — vérifiez vos spams si besoin.
          </p>
          <p className="text-stone-400 text-sm mt-2">
            Ou appelez directement :{' '}
            <a href="tel:+33785611700" className="text-navy-600 font-medium hover:underline">
              07 85 61 17 00
            </a>
          </p>
        </div>
      )}
    </div>
  )
}
