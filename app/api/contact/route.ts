import { NextRequest, NextResponse } from 'next/server'

export async function POST(req: NextRequest) {
  try {
    const body = await req.json()
    const { city, name, email, phone, type } = body

    if (!city || !name || !email) {
      return NextResponse.json({ error: 'Champs requis manquants.' }, { status: 400 })
    }

    const subject =
      type === 'available'
        ? `Réservation territoire : ${city}`
        : `Liste d'attente : ${city}`

    const text = [
      `Nom : ${name}`,
      `Email : ${email}`,
      `Téléphone : ${phone || 'non renseigné'}`,
      `Ville : ${city}`,
      `Type : ${type === 'available' ? 'Disponible — réservation' : 'Prise — liste d\'attente'}`,
    ].join('\n')

    // Resend integration — activer en ajoutant RESEND_API_KEY dans .env
    if (process.env.RESEND_API_KEY) {
      const res = await fetch('https://api.resend.com/emails', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${process.env.RESEND_API_KEY}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          from: 'Écosystème Immo <noreply@ecosystemeimmo.fr>',
          to: 'contact@ecosystemeimmo.fr',
          reply_to: email,
          subject,
          text,
        }),
      })
      if (!res.ok) {
        console.error('Resend error:', await res.text())
      }
    } else {
      // Fallback log — connexion à configurer
      console.log('[contact]', { subject, text })
    }

    return NextResponse.json({ ok: true })
  } catch (err) {
    console.error('[contact] error', err)
    return NextResponse.json({ error: 'Erreur serveur.' }, { status: 500 })
  }
}
