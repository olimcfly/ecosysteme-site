'use client'
import { useState, useEffect, useRef } from 'react'
import { X, Search, Lock, ArrowRight, CheckCircle } from 'lucide-react'

const CLOSED_CITIES = [
  'bordeaux',
  'nantes',
  'nandy',
  'aix-en-provence',
  'aix en provence',
  'lannion',
]

function normalize(s: string): string {
  return s
    .toLowerCase()
    .trim()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9\s-]/g, '')
}

type Status = 'idle' | 'closed' | 'available'

interface CityModalProps {
  open: boolean
  onClose: () => void
}

export default function CityModal({ open, onClose }: CityModalProps) {
  const [city, setCity] = useState('')
  const [status, setStatus] = useState<Status>('idle')
  const inputRef = useRef<HTMLInputElement>(null)

  useEffect(() => {
    if (open) {
      setCity('')
      setStatus('idle')
      setTimeout(() => inputRef.current?.focus(), 100)
      document.body.style.overflow = 'hidden'
    } else {
      document.body.style.overflow = ''
    }
    return () => { document.body.style.overflow = '' }
  }, [open])

  useEffect(() => {
    const handler = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose()
    }
    window.addEventListener('keydown', handler)
    return () => window.removeEventListener('keydown', handler)
  }, [onClose])

  const handleCheck = () => {
    const normalized = normalize(city)
    if (!normalized) return
    const isClosed = CLOSED_CITIES.some((c) => normalize(c) === normalized)
    setStatus(isClosed ? 'closed' : 'available')
  }

  if (!open) return null

  return (
    <div className="fixed inset-0 z-[100] flex items-end sm:items-center justify-center">
      {/* Backdrop */}
      <div
        className="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onClick={onClose}
      />

      {/* Modal */}
      <div className="relative w-full sm:max-w-lg bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl z-10 p-6 sm:p-8 mx-0 sm:mx-4">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors"
          aria-label="Fermer"
        >
          <X size={14} className="text-slate-500" />
        </button>

        <div className="mb-6">
          <h2 className="text-xl font-bold text-slate-900 mb-1">Vérifier la disponibilité</h2>
          <p className="text-slate-500 text-sm">Entrez le nom de votre ville pour savoir si elle est encore disponible.</p>
        </div>

        {status === 'idle' && (
          <div className="space-y-3">
            <div className="relative">
              <Search size={16} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
              <input
                ref={inputRef}
                type="text"
                value={city}
                onChange={(e) => setCity(e.target.value)}
                onKeyDown={(e) => e.key === 'Enter' && handleCheck()}
                placeholder="Ex : Lyon, Toulouse, Rennes..."
                className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
              />
            </div>
            <button
              onClick={handleCheck}
              disabled={!city.trim()}
              className="w-full bg-blue-700 hover:bg-blue-800 disabled:opacity-40 disabled:cursor-not-allowed text-white font-semibold py-3.5 rounded-xl transition-colors text-sm flex items-center justify-center gap-2"
            >
              Vérifier ma ville
              <ArrowRight size={14} />
            </button>
          </div>
        )}

        {status === 'closed' && (
          <div className="animate-fade-in">
            <div className="bg-red-50 border border-red-100 rounded-xl p-5 mb-5">
              <div className="flex items-start gap-3">
                <div className="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                  <Lock size={14} className="text-red-500" />
                </div>
                <div>
                  <p className="font-semibold text-red-800 text-sm mb-1">
                    {city} est déjà verrouillé
                  </p>
                  <p className="text-red-600 text-sm leading-relaxed">
                    Un conseiller a déjà activé l&apos;exclusivité sur ce territoire.
                    Rejoignez la liste d&apos;attente — vous serez alerté en priorité si une ville voisine se libère.
                  </p>
                </div>
              </div>
            </div>
            <a
              href={`mailto:contact@ecosystemeimmo.fr?subject=Liste%20d%27attente%20—%20${encodeURIComponent(city)}`}
              className="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors"
            >
              Rejoindre la liste d&apos;attente prioritaire
              <ArrowRight size={14} />
            </a>
            <button
              onClick={() => { setCity(''); setStatus('idle') }}
              className="w-full mt-2 text-slate-400 hover:text-slate-600 text-sm py-2 transition-colors"
            >
              Chercher une autre ville
            </button>
          </div>
        )}

        {status === 'available' && (
          <div className="animate-fade-in">
            <div className="bg-green-50 border border-green-100 rounded-xl p-5 mb-5">
              <div className="flex items-start gap-3">
                <div className="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                  <CheckCircle size={14} className="text-green-600" />
                </div>
                <div>
                  <p className="font-semibold text-green-800 text-sm mb-1">
                    {city} est disponible
                  </p>
                  <p className="text-green-700 text-sm leading-relaxed">
                    Bonne nouvelle — votre territoire est libre. Activez l&apos;exclusivité maintenant
                    avant qu&apos;un concurrent ne le fasse.
                  </p>
                </div>
              </div>
            </div>
            <a
              href={'mailto:contact@ecosystemeimmo.fr?subject=Réservation territoire — ' + encodeURIComponent(city)}
              className="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors shadow-lg shadow-blue-900/20"
            >
              Réserver l&apos;exclusivité sur {city}
              <ArrowRight size={14} />
            </a>
            <button
              onClick={() => { setCity(''); setStatus('idle') }}
              className="w-full mt-2 text-slate-400 hover:text-slate-600 text-sm py-2 transition-colors"
            >
              Vérifier une autre ville
            </button>
          </div>
        )}
      </div>
    </div>
  )
}
