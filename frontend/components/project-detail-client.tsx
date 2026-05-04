"use client"

import { useEffect, useMemo, useState } from "react"
import Image from "next/image"
import Link from "next/link"
import { usePathname } from "next/navigation"
import { ArrowLeft, ExternalLink, Github, ZoomIn, ZoomOut } from "lucide-react"
import { Button } from "@/components/ui/button"
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"
import { Navbar } from "@/components/navbar"
import { ContactSection } from "@/components/contact-section"
import { Footer } from "@/components/footer"
import { WhatsAppButton } from "@/components/whatsapp-button"
import type { PortfolioProject } from "@/lib/project-types"
import {
  mapApiProjectToPortfolio,
  PROJECT_CATCH_SHELL_SLUG,
  type ApiProjectJson,
} from "@/lib/projects-api"

/** Há conteúdo real na descrição longa (texto ou mídia embutida). */
function hasLongDescription(body: string): boolean {
  const raw = body.trim()
  if (!raw) return false
  if (/<(img|video|iframe|figure|picture)\b/i.test(raw)) return true
  const textOnly = raw.replace(/<[^>]+>/g, " ").replace(/\s+/g, " ").trim()
  return textOnly.length > 0
}

function ProjectDescription({ body }: { body: string }) {
  const trimmed = body.trim()
  const looksHtml = /<[a-z][\s\S]*>/i.test(trimmed)

  if (looksHtml) {
    return (
      <div
        className="prose prose-invert prose-sm md:prose-base max-w-none text-muted-foreground [&_a]:text-primary [&_img]:rounded-lg"
        dangerouslySetInnerHTML={{ __html: trimmed }}
      />
    )
  }

  return (
    <>
      {trimmed.split("\n\n").map((paragraph, index) => (
        <p
          key={index}
          className="text-muted-foreground leading-relaxed mb-4 last:mb-0"
        >
          {paragraph}
        </p>
      ))}
    </>
  )
}

export default function ProjectDetailClient({
  slug,
  initialProject,
  initialOthers,
}: {
  slug: string
  initialProject: PortfolioProject
  initialOthers: PortfolioProject[]
}) {
  const pathname = usePathname() || ""
  const effectiveSlug = useMemo(() => {
    const parts = pathname.split("/").filter(Boolean)
    if (parts[0] !== "projetos" || parts.length < 2) return slug
    const fromUrl = parts[1]
    if (slug === PROJECT_CATCH_SHELL_SLUG && fromUrl !== PROJECT_CATCH_SHELL_SLUG) {
      return fromUrl
    }
    return fromUrl || slug
  }, [pathname, slug])

  const [project, setProject] = useState(initialProject)
  const [otherProjects, setOtherProjects] = useState(initialOthers)
  const [coverOpen, setCoverOpen] = useState(false)
  const [coverZoom, setCoverZoom] = useState(1)

  useEffect(() => {
    let cancelled = false
    const origin = window.location.origin

    const load = async () => {
      try {
        const [oneRes, allRes] = await Promise.all([
          fetch(
            `${origin}/api/projects/${encodeURIComponent(effectiveSlug)}`
          ),
          fetch(`${origin}/api/projects`),
        ])

        if (cancelled) return

        if (oneRes.ok) {
          const raw = (await oneRes.json()) as ApiProjectJson
          setProject(mapApiProjectToPortfolio(raw))
        }

        if (allRes.ok) {
          const rawList = (await allRes.json()) as ApiProjectJson[]
          if (Array.isArray(rawList)) {
            setOtherProjects(
              rawList
                .map(mapApiProjectToPortfolio)
                .filter((p) => p.slug !== effectiveSlug)
            )
          }
        }
      } catch {
        /* mantém dados do SSR / fallback */
      }
    }

    load()
    return () => {
      cancelled = true
    }
  }, [effectiveSlug])

  const showLongDescription = hasLongDescription(project.fullDescription)

  return (
    <main className="min-h-screen bg-background">
      <Navbar />

      <Dialog
        open={coverOpen}
        onOpenChange={(open) => {
          setCoverOpen(open)
          if (!open) setCoverZoom(1)
        }}
      >
        <DialogContent
          showCloseButton
          className="max-h-[92vh] w-[min(96vw,1100px)] max-w-[min(96vw,1100px)] translate-x-[-50%] translate-y-[-50%] gap-3 border-border bg-card p-3 sm:p-4 sm:max-w-[min(96vw,1100px)]"
        >
          <DialogHeader className="sr-only">
            <DialogTitle>Imagem — {project.title}</DialogTitle>
            <DialogDescription>
              Use os botões ou a roda do rato sobre a imagem para aproximar ou afastar.
            </DialogDescription>
          </DialogHeader>
          <div
            className="relative max-h-[min(78vh,800px)] min-h-[200px] overflow-auto rounded-lg bg-black/30 outline-none"
            tabIndex={-1}
            onWheel={(e) => {
              e.preventDefault()
              setCoverZoom((z) =>
                Math.min(4, Math.max(1, z - e.deltaY * 0.0015))
              )
            }}
          >
            <div
              className="inline-block origin-top-left p-4"
              style={{
                transform: `scale(${coverZoom})`,
                transition: "transform 0.12s ease-out",
              }}
            >
              <img
                src={project.coverImage}
                alt=""
                className="max-h-[70vh] w-auto max-w-[85vw] rounded-md object-contain shadow-lg select-none sm:max-w-[90vw]"
                draggable={false}
              />
            </div>
          </div>
          <DialogFooter className="flex flex-row flex-wrap items-center justify-between gap-2 border-t border-border pt-3 sm:justify-between">
            <p className="text-xs text-muted-foreground">
              Roda do rato na área da imagem: zoom · arraste as barras de rolagem quando ampliado
            </p>
            <div className="flex gap-2">
              <Button
                type="button"
                variant="outline"
                size="icon"
                className="h-9 w-9 shrink-0"
                aria-label="Diminuir zoom"
                onClick={() =>
                  setCoverZoom((z) => Math.max(1, Math.round((z - 0.25) * 100) / 100))
                }
              >
                <ZoomOut className="h-4 w-4" />
              </Button>
              <Button
                type="button"
                variant="outline"
                size="icon"
                className="h-9 w-9 shrink-0"
                aria-label="Aumentar zoom"
                onClick={() =>
                  setCoverZoom((z) => Math.min(4, Math.round((z + 0.25) * 100) / 100))
                }
              >
                <ZoomIn className="h-4 w-4" />
              </Button>
              <Button
                type="button"
                variant="secondary"
                size="sm"
                className="shrink-0"
                onClick={() => setCoverZoom(1)}
              >
                Reset
              </Button>
            </div>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <article className="pt-24 pb-16">
        <div className="max-w-5xl mx-auto px-6 md:px-8 lg:px-12">
          <Link href="/#projetos">
            <Button
              variant="ghost"
              size="sm"
              className="mb-8 text-muted-foreground hover:text-foreground transition-colors"
            >
              <ArrowLeft className="mr-2 h-4 w-4" />
              Voltar aos projetos
            </Button>
          </Link>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div className="lg:col-span-2">
              <button
                type="button"
                className="group relative mb-8 aspect-video w-full cursor-zoom-in overflow-hidden rounded-2xl border border-border bg-card text-left ring-offset-background transition-shadow hover:ring-2 hover:ring-primary/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                onClick={() => {
                  setCoverZoom(1)
                  setCoverOpen(true)
                }}
                aria-label={`Abrir imagem de ${project.title} em tela cheia com zoom`}
              >
                <Image
                  src={project.coverImage}
                  alt={project.title}
                  fill
                  className="object-cover transition-transform duration-300 group-hover:scale-[1.02]"
                  sizes="(max-width: 1024px) 100vw, 66vw"
                  priority
                />
                <div className="pointer-events-none absolute inset-0 bg-gradient-to-t from-card/90 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
                <span className="pointer-events-none absolute bottom-3 left-3 flex items-center gap-2 rounded-full bg-background/80 px-3 py-1.5 text-xs font-medium text-foreground opacity-0 shadow-sm backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100 group-focus-visible:opacity-100">
                  <ZoomIn className="h-3.5 w-3.5 text-primary" />
                  Ampliar
                </span>
              </button>

              <div className="mb-6">
                <div className="flex flex-wrap gap-2 mb-4">
                  {project.tags.map((tag) => (
                    <span
                      key={tag}
                      className="px-3 py-1 bg-primary/10 text-primary text-xs rounded-full"
                    >
                      {tag}
                    </span>
                  ))}
                </div>
                <h1 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                  {project.title}
                </h1>
                <p className="text-muted-foreground text-lg mb-6">
                  {project.description}
                </p>

                {(project.liveUrl || project.githubUrl) && (
                  <div className="flex flex-wrap gap-3 mb-8">
                    {project.liveUrl && (
                      <Button
                        asChild
                        variant="outline"
                        size="sm"
                        className="rounded-full bg-transparent border-border"
                      >
                        <a
                          href={project.liveUrl}
                          target="_blank"
                          rel="noopener noreferrer"
                        >
                          <ExternalLink className="mr-2 h-4 w-4 shrink-0" />
                          URL ao vivo
                        </a>
                      </Button>
                    )}
                    {project.githubUrl && (
                      <Button
                        asChild
                        variant="outline"
                        size="sm"
                        className="rounded-full bg-transparent border-border"
                      >
                        <a
                          href={project.githubUrl}
                          target="_blank"
                          rel="noopener noreferrer"
                        >
                          <Github className="mr-2 h-4 w-4 shrink-0" />
                          GitHub
                        </a>
                      </Button>
                    )}
                  </div>
                )}
              </div>

              {showLongDescription ? (
                <div className="prose prose-invert max-w-none">
                  <div className="bg-card rounded-xl border border-border p-6 md:p-8">
                    <ProjectDescription body={project.fullDescription} />
                  </div>
                </div>
              ) : null}
            </div>

            <aside className="lg:col-span-1">
              <div className="sticky top-24">
                <h3 className="text-lg font-semibold text-foreground mb-4">
                  Outros <span className="text-primary">Projetos</span>
                </h3>
                <div className="space-y-4" style={{ display: "inline-grid" }}>
                  {otherProjects.map((otherProject) => (
                    <Link
                      key={otherProject.slug}
                      href={`/projetos/${otherProject.slug}`}
                    >
                      <div className="group flex gap-4 px-4 py-5 bg-card rounded-xl border border-border hover:border-primary/40 transition-all duration-300 cursor-pointer">
                        <div className="relative w-16 h-16 flex-shrink-0 bg-secondary rounded-lg overflow-hidden self-center">
                          <Image
                            src={otherProject.coverImage}
                            alt={otherProject.title}
                            fill
                            className="object-cover"
                            sizes="64px"
                          />
                        </div>
                        <div className="flex-1 min-w-0 flex flex-col justify-center gap-1.5">
                          <h4 className="text-sm font-medium text-foreground group-hover:text-primary transition-colors line-clamp-1">
                            {otherProject.title}
                          </h4>
                          <p className="text-xs text-muted-foreground line-clamp-2 leading-relaxed">
                            {otherProject.description}
                          </p>
                        </div>
                      </div>
                    </Link>
                  ))}
                </div>
              </div>
            </aside>
          </div>
        </div>
      </article>

      <ContactSection />
      <Footer />
      <WhatsAppButton />
    </main>
  )
}
