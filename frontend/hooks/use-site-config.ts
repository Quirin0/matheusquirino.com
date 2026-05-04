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
    "site.logo_image": "/images/1632870446247.jpeg",
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
    "seo.home_title": "",
    "seo.home_description": "",
    "seo.home_keywords": "",
    "seo.google_analytics": "",
    "seo.google_tag_manager": "",
  },
  stacks: [],
}

let cachedConfig: SiteConfig | null = null
let inflight: Promise<SiteConfig> | null = null

function applyThemeFromSettings(c: Record<string, string>) {
  if (typeof document === "undefined") return
  const root = document.documentElement
  if (c["colors.primary"]) root.style.setProperty("--primary", c["colors.primary"])
  if (c["colors.background"]) root.style.setProperty("--background", c["colors.background"])
  if (c["colors.text"]) root.style.setProperty("--foreground", c["colors.text"])
  if (c["colors.surface"]) root.style.setProperty("--card", c["colors.surface"])
  if (c["colors.secondary"]) root.style.setProperty("--secondary", c["colors.secondary"])
  if (c["colors.accent"]) root.style.setProperty("--accent", c["colors.accent"])

  let themeColor = document.querySelector('meta[name="theme-color"]')
  if (!themeColor) {
    themeColor = document.createElement("meta")
    themeColor.setAttribute("name", "theme-color")
    document.head.appendChild(themeColor)
  }
  if (c["colors.primary"]) themeColor.setAttribute("content", c["colors.primary"])
}

function mergeSiteConfig(raw: SiteConfig): SiteConfig {
  return {
    settings: { ...defaultConfig.settings, ...(raw.settings || {}) },
    stacks: Array.isArray(raw.stacks) ? raw.stacks : [],
  }
}

async function loadSiteConfig(apiBase: string): Promise<SiteConfig> {
  if (cachedConfig) return cachedConfig
  if (!inflight) {
    inflight = fetch(`${apiBase}/api/site-config`)
      .then(async (r) => {
        if (!r.ok) throw new Error(String(r.status))
        const raw = (await r.json()) as SiteConfig
        const merged = mergeSiteConfig(raw)
        cachedConfig = merged
        return merged
      })
      .catch(() => mergeSiteConfig({ settings: {}, stacks: [] }))
      .finally(() => {
        inflight = null
      })
  }
  return inflight
}

export function useSiteConfig() {
  const [config, setConfig] = useState<SiteConfig>(() => cachedConfig ?? defaultConfig)

  useEffect(() => {
    const apiBase =
      typeof window !== "undefined"
        ? window.location.origin
        : "http://localhost:8000"

    if (cachedConfig) {
      applyThemeFromSettings(cachedConfig.settings)
      setConfig(cachedConfig)
      return
    }

    loadSiteConfig(apiBase).then((merged) => {
      applyThemeFromSettings(merged.settings)
      setConfig(merged)
    })
  }, [])

  return config
}
