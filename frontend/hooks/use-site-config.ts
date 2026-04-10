"use client"

import { useEffect, useState } from "react"

export interface SiteConfig {
  settings: Record<string, string>
  stacks: Array<{
    name: string
    slug: string
    icon_url: string | null
    category: string
    color: string
  }>
}

const defaultConfig: SiteConfig = {
  settings: {
    "site.logo_text": "<MatheusQuirino />",
    "site.hero_name": "Hello World_",
    "site.hero_title": "Desenvolvedor\nFullstack Junior",
    "site.hero_description":
      "Apaixonado por criar soluções web modernas e eficientes. Especializado em PHP, Laravel, React e tecnologias que transformam ideias em realidade digital.",
    "contact.email": "",
    "contact.phone": "",
    "contact.location": "",
    "social.github": "https://github.com",
    "social.linkedin": "https://linkedin.com",
    "social.email": "",
    "colors.primary": "#6366f1",
    "colors.secondary": "#1e1b4b",
    "colors.accent": "#a5b4fc",
    "colors.background": "#09090b",
    "colors.surface": "#18181b",
    "colors.text": "#fafafa",
  },
  stacks: [],
}

let cachedConfig: SiteConfig | null = null

export function useSiteConfig() {
  const [config, setConfig] = useState<SiteConfig>(cachedConfig ?? defaultConfig)

  useEffect(() => {
    if (cachedConfig) return

    const apiBase =
      typeof window !== "undefined"
        ? window.location.origin
        : "http://localhost:8000"

    fetch(`${apiBase}/api/site-config`)
      .then((r) => r.json())
      .then((data: SiteConfig) => {
        cachedConfig = data
        setConfig(data)

        // Aplicar cores como CSS variables
        const colors = data.settings
        const root = document.documentElement
        if (colors["colors.primary"])    root.style.setProperty("--color-primary-raw",    colors["colors.primary"])
        if (colors["colors.background"]) root.style.setProperty("--background-raw",        colors["colors.background"])
        if (colors["colors.surface"])    root.style.setProperty("--surface-raw",           colors["colors.surface"])
        if (colors["colors.text"])       root.style.setProperty("--text-raw",              colors["colors.text"])
      })
      .catch(() => {
        // fallback silencioso – usa defaults
      })
  }, [])

  return config
}
