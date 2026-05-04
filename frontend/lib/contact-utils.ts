/** Apenas dígitos (útil para wa.me a partir do telefone do painel). */
export function digitsOnly(s: string): string {
  return s.replace(/\D/g, "")
}

/** Link WhatsApp a partir do campo telefone/WhatsApp configurado no admin. */
export function phoneToWhatsAppHref(phone: string): string | null {
  const d = digitsOnly(phone)
  if (d.length < 10 || d.length > 15) return null
  return `https://wa.me/${d}`
}

/** E-mail público: prioriza rede social, depois bloco de contato. */
export function publicContactEmail(settings: Record<string, string>): string {
  return (
    (settings["social.email"] || settings["contact.email"] || "").trim()
  )
}

export function mailtoHref(email: string): string {
  const e = email.trim()
  return e ? `mailto:${e}` : ""
}
