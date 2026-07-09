'use client';

import { useState } from 'react';

const CLOSED_CITIES = [
  'bordeaux',
  'nantes',
  'nandy',
  'aix-en-provence',
  'aix en provence',
  'lannion',
];

function normalize(str: string) {
  return str
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/-/g, ' ')
    .trim();
}

type Status = 'idle' | 'available' | 'taken';

export default function CityChecker() {
  const [city, setCity] = useState('');
  const [status, setStatus] = useState<Status>('idle');

  const check = () => {
    if (!city.trim()) return;
    const n = normalize(city);
    const taken = CLOSED_CITIES.some((c) => normalize(c) === n);
    setStatus(taken ? 'taken' : 'available');
  };

  const reset = () => {
    setCity('');
    setStatus('idle');
  };

  return (
    <section id="disponibilite" className="py-24 px-4">
      <div className="max-w-2xl mx-auto">
        <div className="rounded-2xl bg-white/[0.03] border border-white/[0.08] p-8 sm:p-12">
          <div className="text-center mb-8">
            <p className="text-blue-400 text-sm font-medium uppercase tracking-wider mb-3">Disponibilité</p>
            <h2 className="text-2xl sm:text-3xl font-bold text-white mb-3">
              Votre ville est-elle encore disponible ?
            </h2>
            <p className="text-slate-400 text-sm leading-relaxed">
              Chaque territoire est attribué en exclusivité à un seul conseiller.
              Une fois fermé, il l'est définitivement.
            </p>
          </div>

          {/* Villes fermées */}
          <div className="mb-8 p-4 rounded-xl bg-red-500/5 border border-red-500/15">
            <p className="text-xs text-slate-500 mb-2 font-medium uppercase tracking-wide">Territoires fermés</p>
            <div className="flex flex-wrap gap-2">
              {['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion'].map((c) => (
                <span key={c} className="px-3 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-medium">
                  {c}
                </span>
              ))}
            </div>
          </div>

          {/* Input */}
          {status === 'idle' && (
            <div className="space-y-3">
              <div className="flex gap-3">
                <input
                  type="text"
                  value={city}
                  onChange={(e) => setCity(e.target.value)}
                  onKeyDown={(e) => e.key === 'Enter' && check()}
                  placeholder="Entrez votre ville..."
                  className="flex-1 px-4 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-600 text-sm focus:outline-none focus:border-blue-500/50 focus:bg-white/7 transition-all"
                />
                <button
                  onClick={check}
                  disabled={!city.trim()}
                  className="px-5 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 disabled:opacity-40 disabled:cursor-not-allowed text-white font-medium text-sm transition-colors whitespace-nowrap"
                >
                  Vérifier
                </button>
              </div>
            </div>
          )}

          {/* Result: available */}
          {status === 'available' && (
            <div className="rounded-xl bg-emerald-500/10 border border-emerald-500/25 p-6 text-center space-y-4">
              <div className="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto">
                <svg className="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <div>
                <p className="text-emerald-300 font-semibold text-lg mb-1">
                  {city} est disponible
                </p>
                <p className="text-slate-400 text-sm">
                  Vous pouvez réserver l'exclusivité de ce territoire dès maintenant.
                </p>
              </div>
              <div className="flex flex-col sm:flex-row gap-3 justify-center">
                <a
                  href="#tarifs"
                  className="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-medium text-sm transition-colors"
                >
                  Voir les offres
                </a>
                <button
                  onClick={reset}
                  className="px-6 py-3 rounded-xl border border-white/10 text-slate-400 hover:text-white text-sm transition-colors"
                >
                  Rechercher une autre ville
                </button>
              </div>
            </div>
          )}

          {/* Result: taken */}
          {status === 'taken' && (
            <div className="rounded-xl bg-red-500/10 border border-red-500/25 p-6 text-center space-y-4">
              <div className="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center mx-auto">
                <svg className="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
              </div>
              <div>
                <p className="text-red-300 font-semibold text-lg mb-1">
                  {city} est fermée
                </p>
                <p className="text-slate-400 text-sm">
                  Ce territoire est déjà attribué à un autre conseiller. Essayez une ville voisine.
                </p>
              </div>
              <button
                onClick={reset}
                className="px-6 py-3 rounded-xl bg-white/5 border border-white/10 hover:border-white/20 text-slate-300 hover:text-white text-sm transition-colors"
              >
                Rechercher une autre ville
              </button>
            </div>
          )}
        </div>
      </div>
    </section>
  );
}
