"use client"

import { MessageCircle } from "lucide-react"
import { useSiteConfig } from "@/hooks/use-site-config"
import { phoneToWhatsAppHref } from "@/lib/contact-utils"

export function WhatsAppButton() {
  const { settings } = useSiteConfig()
  const phone = (settings["contact.phone"] || "").trim()
  const href = phoneToWhatsAppHref(phone)

  if (!href) return null

  return (
    <a
      href={href}
      target="_blank"
      rel="noopener noreferrer"
      className="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20BD5A] text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 group"
      aria-label="Contato via WhatsApp"
    >
      <MessageCircle className="h-6 w-6 transition-transform duration-300 group-hover:scale-110" />
      <span className="sr-only">Abrir WhatsApp</span>
    </a>
  )
}
