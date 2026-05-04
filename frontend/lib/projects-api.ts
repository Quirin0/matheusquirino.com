import type { PortfolioProject } from "@/lib/project-types"
import {
  FALLBACK_PROJECT_LIST,
  FALLBACK_SLUGS,
} from "@/lib/projects-fallback"

export type ApiProjectJson = {
  slug: string
  title: string
  description: string
  full_description?: string | null
  image_url?: string | string[] | null
  live_url?: string | null
  github_url?: string | null
  /** API pode enviar array, string JSON, objeto indexado ou itens `{ value }` (Filament). */
  tags?: unknown
  featured?: boolean
  order?: number
}

const PLACEHOLDER_COVER = "/placeholder.jpg"

/**
 * Rota estática extra: HTML usado pelo Laravel quando ainda não existe
 * `projetos/{slug}.html` para um projeto novo. O cliente lê o slug real na URL.
 */
export const PROJECT_CATCH_SHELL_SLUG = "catch-shell"

/** Filament às vezes expõe upload como array no JSON; backend já normaliza, mas reforçamos no cliente. */
function normalizeCoverUrl(v: unknown): string {
  if (typeof v === "string") return v.trim()
  if (Array.isArray(v) && v.length > 0 && typeof v[0] === "string") {
    return v[0].trim()
  }
  return ""
}

function pickExternalUrl(v: unknown): string | null {
  if (typeof v !== "string") return null
  const t = v.trim()
  return t.length > 0 ? t : null
}

/** Alinha tags do banco / Filament com `string[]` usada nos cards. */
export function normalizeTagsFromApi(raw: unknown): string[] {
  if (raw == null) return []

  if (typeof raw === "string") {
    const s = raw.trim()
    if (!s) return []
    if (s.startsWith("[") || s.startsWith("{")) {
      try {
        return normalizeTagsFromApi(JSON.parse(s) as unknown)
      } catch {
        return s.split(",").map((t) => t.trim()).filter(Boolean)
      }
    }
    return s.split(",").map((t) => t.trim()).filter(Boolean)
  }

  if (Array.isArray(raw)) {
    const out: string[] = []
    for (const item of raw) {
      if (typeof item === "string" || typeof item === "number") {
        const t = String(item).trim()
        if (t) out.push(t)
      } else if (item && typeof item === "object") {
        const o = item as Record<string, unknown>
        const v = o.value ?? o.name ?? o.label ?? o.tag
        if (typeof v === "string" && v.trim()) out.push(v.trim())
        else if (typeof v === "number") out.push(String(v))
      }
    }
    return out
  }

  if (typeof raw === "object") {
    return Object.values(raw as Record<string, unknown>)
      .filter((v) => v != null && v !== "")
      .flatMap((v) => normalizeTagsFromApi(v))
  }

  return []
}

export function mapApiProjectToPortfolio(p: ApiProjectJson): PortfolioProject {
  const raw = normalizeCoverUrl(p.image_url)
  const coverImage = raw.length > 0 ? raw : PLACEHOLDER_COVER
  return {
    slug: p.slug,
    title: p.title,
    description: p.description,
    fullDescription: p.full_description ?? "",
    coverImage,
    tags: normalizeTagsFromApi(p.tags),
    featured: Boolean(p.featured),
    order: typeof p.order === "number" ? p.order : 0,
    liveUrl: pickExternalUrl(p.live_url),
    githubUrl: pickExternalUrl(p.github_url),
  }
}

export function collectTags(projects: PortfolioProject[]): string[] {
  const tagsSet = new Set<string>()
  projects.forEach((p) => p.tags.forEach((tag) => tagsSet.add(tag)))
  return Array.from(tagsSet).sort()
}

function buildApiBase(): string {
  return (
    process.env.NEXT_BUILD_API_URL?.replace(/\/$/, "") ||
    process.env.NEXT_PUBLIC_SITE_URL?.replace(/\/$/, "") ||
    ""
  )
}

export async function fetchProjectsAtBuild(): Promise<PortfolioProject[]> {
  const base = buildApiBase()
  if (!base) return [...FALLBACK_PROJECT_LIST]
  try {
    const res = await fetch(`${base}/api/projects`, { cache: "no-store" })
    if (!res.ok) return [...FALLBACK_PROJECT_LIST]
    const raw = (await res.json()) as ApiProjectJson[]
    if (!Array.isArray(raw) || raw.length === 0) return [...FALLBACK_PROJECT_LIST]
    return raw.map(mapApiProjectToPortfolio)
  } catch {
    return [...FALLBACK_PROJECT_LIST]
  }
}

export async function fetchProjectSlugsAtBuild(): Promise<string[]> {
  const projects = await fetchProjectsAtBuild()
  const slugs = projects.map((p) => p.slug).filter(Boolean)
  const base = slugs.length ? slugs : [...FALLBACK_SLUGS]
  return [...new Set([...base, PROJECT_CATCH_SHELL_SLUG])]
}

export async function fetchProjectAtBuild(
  slug: string
): Promise<PortfolioProject | undefined> {
  const base = buildApiBase()
  if (!base) return FALLBACK_PROJECT_LIST.find((p) => p.slug === slug)
  try {
    const res = await fetch(`${base}/api/projects/${slug}`, { cache: "no-store" })
    if (!res.ok) return FALLBACK_PROJECT_LIST.find((p) => p.slug === slug)
    const raw = (await res.json()) as ApiProjectJson
    return mapApiProjectToPortfolio(raw)
  } catch {
    return FALLBACK_PROJECT_LIST.find((p) => p.slug === slug)
  }
}

export function fallbackProjectBySlug(slug: string): PortfolioProject | undefined {
  return FALLBACK_PROJECT_LIST.find((p) => p.slug === slug)
}
