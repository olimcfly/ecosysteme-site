'use client'
import { useState, useEffect, useRef } from 'react'
import { X, Search, Lock, ArrowRight, CheckCircle, User, Mail, Phone } from 'lucide-react'

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

type Status = 'idle' | 'closed' | 'available' | 'form-waitlist' | 'form-reserve' | 'success-waitlist' | 'success-reserve'

interface CityModalProps {
  open: boolean
  onClose: () => void
}

interface LeadForm {
  name: string
  email: string
  phone: string
}

export default function CityModal({ open, onClose }: CityModalProps) {
  const [city, setCity] = useState('')
  const [status, setStatus] = useState<Status>('idle')
  const [form, setForm] = useState<LeadForm>({ name: '', email: '', phone: '' })
  const [submitting, setSubmitting] = useState(false)
  const inputRef = useRef<HTMLInputElement>(null)
  const nameRef = useRef<HTMLInputElement>(null)

  useEffect(() => {
    if (open) {
      setCity('')
      setStatus('idle')
      setForm({ name: '', email: '', phone: '' })
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

  useEffect(() => {
    if (status === 'form-waitlist' || status === 'form-reserve') {
      setTimeout(() => nameRef.current?.focus(), 100)
    }
  }, [status])

  const handleCheck = () => {
    const normalized = normalize(city)
    if (!normalized) return
    const isClosed = CLOSED_CITIES.some((c) => normalize(c) === normalized)
    setStatus(isClosed ? 'closed' : 'available')
  }

  const handleSubmit = (type: 'waitlist' | 'reserve') => {
    if (!form.name.trim() || !form.email.trim()) return
    setSubmitting(true)

    const subject = type === 'reserve'
      ? `Réservation territoire — ${city}`
      : `Liste d'attente — ${city}`

    const body = type === 'reserve'
      ? `Bonjour,\n\nJe souhaite réserver l'exclusivité sur ${city}.\n\nNom : ${form.name}\nEmail : ${form.email}${form.phone ? `\nTéléphone : ${form.phone}` : ''}\n\nMerci de me recontacter rapidement.`
      : `Bonjour,\n\nJe souhaite rejoindre la liste d'attente pour ${city}.\n\nNom : ${form.name}\nEmail : ${form.email}${form.phone ? `\nTéléphone : ${form.phone}` : ''}\n\nMerci de me tenir informé(e) en priorité.`

    window.location.href = `mailto:contact@ecosystemeimmo.fr?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`

    setTimeout(() => {
      setSubmitting(false)
      setStatus(type === 'reserve' ? 'success-reserve' : 'success-waitlist')
    }, 600)
  }

  if (!open) return null

  return (
    <div className="fixed inset-0 z-[100] flex items-end sm:items-center justify-center">
      <div
        className="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onClick={onClose}
      />

      <div className="relative w-full sm:max-w-lg bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl z-10 p-6 sm:p-8 mx-0 sm:mx-4">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors"
          aria-label="Fermer"
        >
          <X size={14} className="text-slate-500" />
        </button>

        {/* ÉTAT : IDLE — recherche de ville */}
        {status === 'idle' && (
          <>
            <div className="mb-6">
              <h2 className="text-xl font-bold text-slate-900 mb-1">Vérifier la disponibilité</h2>
              <p className="text-slate-500 text-sm">Entrez le nom de votre ville pour savoir si elle est encore disponible.</p>
            </div>
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
          </>
        )}

        {/* ÉTAT : FERMÉ */}
        {status === 'closed' && (
          <div className="animate-fade-in">
            <div className="mb-6">
              <h2 className="text-xl font-bold text-slate-900 mb-1">Territoire indisponible</h2>
              <p className="text-slate-500 text-sm">Rejoignez la liste d&apos;attente prioritaire pour être alerté en premier.</p>
            </div>
            <div className="bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
              <div className="flex items-center gap-3">
                <div className="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                  <Lock size={13} className="text-red-500" />
                </div>
                <p className="font-semibold text-red-800 text-sm">
                  {city} est déjà verrouillé
                </p>
              </div>
            </div>
            <button
              onClick={() => setStatus('form-waitlist')}
              className="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors"
            >
              Rejoindre la liste d&apos;attente prioritaire
              <ArrowRight size={14} />
            </button>
            <button
              onClick={() => { setCity(''); setStatus('idle') }}
              className="w-full mt-2 text-slate-400 hover:text-slate-600 text-sm py-2 transition-colors"
            >
              Chercher une autre ville
            </button>
          </div>
        )}

        {/* ÉTAT : DISPONIBLE */}
        {status === 'available' && (
          <div className="animate-fade-in">
            <div className="mb-6">
              <h2 className="text-xl font-bold text-slate-900 mb-1">Territoire disponible</h2>
              <p className="text-slate-500 text-sm">Réservez maintenant — avant qu&apos;un concurrent ne le fasse.</p>
            </div>
            <div className="bg-green-50 border border-green-100 rounded-xl p-4 mb-5">
              <div className="flex items-center gap-3">
                <div className="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                  <CheckCircle size={13} className="text-green-600" />
                </div>
                <p className="font-semibold text-green-800 text-sm">
                  {city} est disponible
                </p>
              </div>
            </div>
            <button
              onClick={() => setStatus('form-reserve')}
              className="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors shadow-lg shadow-blue-900/20"
            >
              Réserver l&apos;exclusivité sur {city}
              <ArrowRight size={14} />
            </button>
            <button
              onClick={() => { setCity(''); setStatus('idle') }}
              className="w-full mt-2 text-slate-400 hover:text-slate-600 text-sm py-2 transition-colors"
            >
              Vérifier une autre ville
            </button>
          </div>
        )}

        {/* ÉTAT : FORMULAIRE LISTE D'ATTENTE */}
        {status === 'form-waitlist' && (
          <div className="animate-fade-in">
            <div className="mb-6">
              <h2 className="text-xl font-bold text-slate-900 mb-1">Liste d&apos;attente — {city}</h2>
              <p className="text-slate-500 text-sm">Vous serez alerté en priorité si ce territoire se libère ou si une ville adjacente devient disponible.</p>
            </div>
            <div className="space-y-3">
              <div className="relative">
                <User size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                <input
                  ref={nameRef}
                  type="text"
                  value={form.name}
                  onChange={(e) => setForm(f => ({ ...f, name: e.target.value }))}
                  placeholder="Votre prénom et nom"
                  className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
                />
              </div>
              <div className="relative">
                <Mail size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                <input
                  type="email"
                  value={form.email}
                  onChange={(e) => setForm(f => ({ ...f, email: e.target.value }))}
                  placeholder="Votre email professionnel"
                  className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
                />
              </div>
              <div className="relative">
                <Phone size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                <input
                  type="tel"
                  value={form.phone}
                  onChange={(e) => setForm(f => ({ ...f, phone: e.target.value }))}
                  placeholder="Téléphone (optionnel)"
                  className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
                />
              </div>
              <button
                onClick={() => handleSubmit('waitlist')}
                disabled={!form.name.trim() || !form.email.trim() || submitting}
                className="w-full bg-slate-900 hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors"
              >
                {submitting ? 'Envoi en cours...' : 'Rejoindre la liste d\'attente'}
                {!submitting && <ArrowRight size={14} />}
              </button>
            </div>
            <button
              onClick={() => setStatus('closed')}
              className="w-full mt-2 text-slate-400 hover:text-slate-600 text-sm py-2 transition-colors"
            >
              Retour
            </button>
          </div>
        )}

        {/* ÉTAT : FORMULAIRE RÉSERVATION */}
        {status === 'form-reserve' && (
          <div className="animate-fade-in">
            <div className="mb-6">
              <h2 className="text-xl font-bold text-slate-900 mb-1">Réserver {city}</h2>
              <p className="text-slate-500 text-sm">Complétez vos coordonnées — nous vous recontactons sous 24h pour activer votre territoire.</p>
            </div>
            <div className="space-y-3">
              <div className="relative">
                <User size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                <input
                  ref={nameRef}
                  type="text"
                  value={form.name}
                  onChange={(e) => setForm(f => ({ ...f, name: e.target.value }))}
                  placeholder="Votre prénom et nom"
                  className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
                />
              </div>
              <div className="relative">
                <Mail size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                <input
                  type="email"
                  value={form.email}
                  onChange={(e) => setForm(f => ({ ...f, email: e.target.value }))}
                  placeholder="Votre email professionnel"
                  className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
                />
              </div>
              <div className="relative">
                <Phone size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                <input
                  type="tel"
                  value={form.phone}
                  onChange={(e) => setForm(f => ({ ...f, phone: e.target.value }))}
                  placeholder="Téléphone (optionnel)"
                  className="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-slate-900 text-sm transition-all"
                />
              </div>
              <button
                onClick={() => handleSubmit('reserve')}
                disabled={!form.name.trim() || !form.email.trim() || submitting}
                className="w-full bg-blue-700 hover:bg-blue-800 disabled:opacity-40 disabled:cursor-not-allowed text-white font-semibold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2 transition-colors shadow-lg shadow-blue-900/20"
              >
                {submitting ? 'Envoi en cours...' : `Réserver l'exclusivité sur ${city}`}
                {!submitting && <ArrowRight size={14} />}
              </button>
              <p className="text-center text-slate-400 text-xs">Réponse sous 24h — sans engagement immédiat</p>
            </div>
            <button
              onClick={() => setStatus('available')}
              className="w-full mt-1 text-slate-400 hover:text-slate-600 text-sm py-2 transition-colors"
            >
              Retour
            </button>
          </div>
        )}

        {/* ÉTAT : SUCCÈS LISTE D'ATTENTE */}
        {status === 'success-waitlist' && (
          <div className="animate-fade-in text-center py-4">
            <div className="w-12 h-12 rounded-full bg-slate-900 flex items-center justify-center mx-auto mb-5">
              <CheckCircle size={22} className="text-white" />
            </div>
            <h2 className="text-xl font-bold text-slate-900 mb-2">Vous êtes sur la liste</h2>
            <p className="text-slate-500 text-sm leading-relaxed mb-6">
              Vous serez alerté en priorité si {city} se libère ou si une ville adjacente devient disponible.
            </p>
            <button
              onClick={onClose}
              className="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 rounded-xl text-sm transition-colors"
            >
              Fermer
            </button>
          </div>
        )}

        {/* ÉTAT : SUCCÈS RÉSERVATION */}
        {status === 'success-reserve' && (
          <div className="animate-fade-in text-center py-4">
            <div className="w-12 h-12 rounded-full bg-blue-700 flex items-center justify-center mx-auto mb-5">
              <CheckCircle size={22} className="text-white" />
            </div>
            <h2 className="text-xl font-bold text-slate-900 mb-2">Demande envoyée</h2>
            <p className="text-slate-500 text-sm leading-relaxed mb-6">
              Nous vous recontactons sous 24h pour activer l&apos;exclusivité sur {city}. Vérifiez votre boîte mail.
            </p>
            <button
              onClick={onClose}
              className="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-xl text-sm transition-colors"
            >
              Fermer
            </button>
          </div>
        )}
      </div>
    </div>
  )
}
