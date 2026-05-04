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
    "resume.personal_statement":
      "Atuo com desenvolvimento de software desde 2018, participando da criação e manutenção de aplicações web que recebem centenas de acessos diariamente. Possuo experiência em ambientes colaborativos, desenvolvimento fullstack e backend, com foco em código limpo, performance e boas práticas.",
    "resume.cv_file": "/cv/curriculo.pdf",
    "resume.differentials": JSON.stringify([
      { text: "Construção de projetos completos (frontend + backend + deploy)" },
      { text: "Integração com APIs externas e automações (ex: pagamentos, scraping, IA)" },
      { text: "Noções de infraestrutura (VPS, Docker, CI/CD)" },
    ]),
    "resume.experiences": JSON.stringify([
      {
        role: "Programador Fullstack Júnior",
        company: "Virtua Brasil",
        type: "Presencial",
        period: "Outubro 2020 – Janeiro 2021",
        color: "#a78bfa",
        tags: "HTML, CSS, PHP, JavaScript, MySQL",
        highlights: [
          { text: "Atuei em conjunto com uma equipe de desenvolvedores no desenvolvimento de websites e sistemas web, utilizando HTML, CSS, PHP, JavaScript e MySQL." },
          { text: "Desenvolvi sistemas administrativos voltados ao gerenciamento e manipulação de dados em banco de dados." },
          { text: "Criei soluções de design responsivo, garantindo melhor experiência do usuário (UX) em diferentes dispositivos." },
        ],
      },
      {
        role: "Programador Backend Júnior",
        company: "Uappi",
        type: "Remoto",
        period: "Março 2022 – Junho 2024",
        color: "#61DAFB",
        tags: "Docker, Laravel, React, Angular, Git, CI/CD, Scrum",
        highlights: [
          { text: "Atuei no desenvolvimento e manutenção de sites de grandes empresas, como Growth Supplements, Daikin, Desinchá, Leveros, entre outras." },
          { text: "Trabalhei com tecnologias e frameworks modernos, incluindo Docker, Laravel, React, Angular, HeidiSQL, Git e GitHub." },
          { text: "Desenvolvi habilidades de trabalho em equipe, seguindo metodologias ágeis como Scrum, além de práticas de CI/CD para integração e entrega contínua." },
        ],
      },
    ]),
    "resume.education": JSON.stringify([
      {
        degree: "Técnico em Informática para Internet",
        institution: "ETEC Dr. Geraldo José Rodrigues Alckmin",
        period: "2018 – 2019",
        status: "Concluído",
        color: "#a78bfa",
        description: "Formação técnica com foco em desenvolvimento web, lógica de programação, banco de dados e infraestrutura de redes. Base que impulsionou minha entrada no mercado de tecnologia.",
      },
      {
        degree: "Engenharia de Software",
        institution: "UniCesumar",
        period: "2026 – 2030",
        status: "Em andamento · EAD",
        color: "#61DAFB",
        description: "Graduação em Engenharia de Software com foco em fundamentos de engenharia, arquitetura de sistemas, qualidade de software e gestão de projetos tecnológicos.",
      },
    ]),
    "resume.stats": JSON.stringify([
      { value: "7+",   label: "Anos de experiência" },
      { value: "2",    label: "Empresas atuadas" },
      { value: "50+",  label: "Projetos entregues" },
      { value: "2018", label: "Início na área" },
    ]),
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
