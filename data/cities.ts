export interface Advisor {
  name: string
  city: string
  territory: string
  initial: string
}

export const CLOSED_CITIES: string[] = [
  'bordeaux',
  'nantes',
  'nandy',
  'aix-en-provence',
  'aix en provence',
  'lannion',
]

export const ADVISORS: Advisor[] = [
  { name: 'Eduardo De Sul', city: 'Bordeaux', territory: 'Bordeaux Métropole', initial: 'E' },
  { name: 'Pascal Hamm', city: 'Aix-en-Provence', territory: 'Aix-en-Provence', initial: 'P' },
  { name: 'Fatima Rabia', city: 'Nandy', territory: 'Nandy / Sénart', initial: 'F' },
  { name: 'Stéphanie Hulen', city: 'Lannion', territory: 'Lannion / Trégor', initial: 'S' },
  { name: 'Brice Chupin', city: 'Nantes', territory: 'Nantes', initial: 'B' },
]
