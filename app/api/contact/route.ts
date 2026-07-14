import { NextRequest, NextResponse } from 'next/server'

type ContactPayload = {
  city: string
  type: 'available' | 'waiting'
  name: string
  email: string
  phone?: string
}

export async function POST(req: NextRequest) {
  let body: ContactPayload
  try {
    body = await req.json()
  } catch {
    return NextResponse.json({ error: 'Invalid JSON' }, { status: 400 })
  }

  const { city, type, name, email, phone } = body

  if (!city?.trim() || !name?.trim() || !email?.trim()) {
    return NextResponse.json({ error: 'Champs obligatoires manquants.' }, { status: 422 })
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(email)) {
    return NextResponse.json({ error: 'Adresse email invalide.' }, { status: 422 })
  }

  const payload = {
    city: city.trim(),
    type,
    name: name.trim(),
    email: email.trim().toLowerCase(),
    phone: phone?.trim() || null,
    source: 'ecosystemeimmo.fr',
    submitted_at: new Date().toISOString(),
  }

  // Webhook externe (Make, n8n, Zapier, etc.)
  const webhookUrl = process.env.CONTACT_WEBHOOK_URL
  if (webhookUrl) {
    try {
      const res = await fetch(webhookUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
        signal: AbortSignal.timeout(8000),
      })
      if (!res.ok) {
        console.error('[contact] Webhook error:', res.status, await res.text())
      }
    } catch (err) {
      console.error('[contact] Webhook fetch failed:', err)
    }
  }

  // Log serveur comme filet de sécurité
  console.log('[LEAD]', JSON.stringify(payload))

  return NextResponse.json({ ok: true })
}
