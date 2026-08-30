import { NextRequest, NextResponse } from 'next/server'

export async function POST(req: NextRequest) {
  try {
    const data = await req.json()
    const { city, name, email, phone, type } = data

    if (!city || !name || !email) {
      return NextResponse.json({ error: 'Champs requis manquants' }, { status: 400 })
    }

    // Pour activer l'envoi email, décommentez et configurez votre provider.
    //
    // Option Resend (recommandé — gratuit jusqu'à 3 000 emails/mois, resend.com) :
    //   const res = await fetch('https://api.resend.com/emails', {
    //     method: 'POST',
    //     headers: {
    //       Authorization: `Bearer ${process.env.RESEND_API_KEY}`,
    //       'Content-Type': 'application/json',
    //     },
    //     body: JSON.stringify({
    //       from: 'noreply@ecosystemeimmo.fr',
    //       to: 'contact@ecosystemeimmo.fr',
    //       subject: type === 'reservation'
    //         ? `[Réservation] ${city} — ${name}`
    //         : `[Liste attente] ${city} — ${name}`,
    //       text: [
    //         `Type : ${type === 'reservation' ? 'Réservation ville disponible' : "Liste d'attente ville prise"}`,
    //         `Ville : ${city}`,
    //         `Nom : ${name}`,
    //         `Email : ${email}`,
    //         `Téléphone : ${phone || 'non renseigné'}`,
    //       ].join('\n'),
    //     }),
    //   })
    //   if (!res.ok) throw new Error('Resend error')

    console.log('[Nouvelle demande Écosystème Immo]', {
      type,
      city,
      name,
      email,
      phone: phone || 'non renseigné',
    })

    return NextResponse.json({ ok: true })
  } catch {
    return NextResponse.json({ error: 'Erreur serveur' }, { status: 500 })
  }
}
