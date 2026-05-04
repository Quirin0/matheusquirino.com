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
  tags?: string[] | null
  featured?: boolean
  order?: number
}

const PLACEHOLDER_COVER = "/placeholder.jpg"

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

export function mapApiProjectToPortfolio(p: ApiProjectJson): PortfolioProject {
  const raw = normalizeCoverUrl(p.image_url)
  const coverImage = raw.length > 0 ? raw : PLACEHOLDER_COVER
  return {
    slug: p.slug,
    title: p.title,
    description: p.description,
    fullDescription: p.full_description ?? "",
    coverImage,
    tags: Array.isArray(p.tags) ? p.tags : [],
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
  if (slugs.length) return slugs
  return [...FALLBACK_SLUGS]
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
