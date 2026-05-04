"use client"

import { useEffect, useRef, useState, useCallback } from "react"
import { useTypewriter } from "@/hooks/use-typewriter"
import { useSiteConfig } from "@/hooks/use-site-config"
import {
  SiDocker, SiPhp, SiLaravel, SiMysql, SiJavascript, SiReact,
  SiHtml5, SiCss, SiTypescript, SiNodedotjs, SiGit, SiTailwindcss,
  SiGitlab, SiGithubactions, SiPython, SiNextdotjs, SiPostgresql, SiSqlite,
} from "react-icons/si"
import { Cloud, X } from "lucide-react"
import { Button } from "@/components/ui/button"
import type { IconType } from "react-icons"
import type { LucideIcon } from "lucide-react"

type AnyIcon = IconType | LucideIcon

// Mapa slug → ícone
const iconMap: Record<string, AnyIcon> = {
  "react":       SiReact,
  "nextjs":      SiNextdotjs,
  "next-js":     SiNextdotjs,
  "typescript":  SiTypescript,
  "javascript":  SiJavascript,
  "html5":       SiHtml5,
  "css3":        SiCss,
  "tailwind":    SiTailwindcss,
  "tailwindcss": SiTailwindcss,
  "php":         SiPhp,
  "laravel":     SiLaravel,
  "nodejs":      SiNodedotjs,
  "node-js":     SiNodedotjs,
  "python":      SiPython,
  "mysql":       SiMysql,
  "postgresql":  SiPostgresql,
  "sqlite":      SiSqlite,
  "docker":      SiDocker,
  "git":         SiGit,
  "gitlab":      SiGitlab,
  "ci-cd":       SiGithubactions,
  "cicd":        SiGithubactions,
  "aws":         Cloud,
}

// Mapa slug → descrição
const descriptionMap: Record<string, string> = {
  "react":       "Biblioteca para criação de interfaces de usuário reativas e componentizadas.",
  "nextjs":      "Framework React para aplicações web com SSR, SSG e rotas automáticas.",
  "next-js":     "Framework React para aplicações web com SSR, SSG e rotas automáticas.",
  "typescript":  "Superset tipado do JavaScript que adiciona segurança e escalabilidade ao código.",
  "javascript":  "Linguagem de programação universal da web, base de todo desenvolvimento moderno.",
  "html5":       "Linguagem de marcação para estruturação semântica de páginas web.",
  "css3":        "Linguagem de estilo para design, animações e responsividade de interfaces.",
  "tailwind":    "Framework CSS utilitário que acelera a criação de interfaces customizadas.",
  "tailwindcss": "Framework CSS utilitário que acelera a criação de interfaces customizadas.",
  "php":         "Linguagem de programação server-side, base de grande parte da web moderna.",
  "laravel":     "Framework PHP elegante para construção de APIs e aplicações web robustas.",
  "nodejs":      "Runtime JavaScript no servidor, ideal para APIs rápidas e em tempo real.",
  "node-js":     "Runtime JavaScript no servidor, ideal para APIs rápidas e em tempo real.",
  "python":      "Linguagem versátil e legível, usada em automação, APIs e ciência de dados.",
  "mysql":       "Sistema de gerenciamento de banco de dados relacional open-source.",
  "postgresql":  "Banco de dados relacional avançado, robusto e com suporte a JSON nativo.",
  "sqlite":      "Banco de dados leve e embutido, ideal para desenvolvimento e apps mobile.",
  "docker":      "Containerização e orquestração de ambientes de desenvolvimento e produção.",
  "git":         "Sistema de controle de versão distribuído para rastrear alterações no código.",
  "gitlab":      "Plataforma completa de versionamento, CI/CD e colaboração em projetos.",
  "ci-cd":       "Automação de integração e entrega contínua para deploys rápidos e confiáveis.",
  "cicd":        "Automação de integração e entrega contínua para deploys rápidos e confiáveis.",
  "aws":         "Plataforma de computação em nuvem da Amazon com serviços de infraestrutura global.",
}

// Mapa categoria backend → label exibida
const categoryLabel: Record<string, string> = {
  frontend: "Frontend",
  backend:  "Backend",
  database: "Banco de Dados",
  devops:   "DevOps",
  mobile:   "Mobile",
  other:    "Cloud / Outros",
}

const categoryColor: Record<string, string> = {
  frontend: "#61DAFB",
  backend:  "#a78bfa",
  database: "#4479A1",
  devops:   "#F05032",
  mobile:   "#34d399",
  other:    "#FF9900",
}

export function TechStack() {
  const scrollRef    = useRef<HTMLDivElement>(null)
  const animationRef = useRef<number>(0)
  const positionRef  = useRef(0)
  const isDragging   = useRef(false)
  const startX       = useRef(0)
  const scrollLeft   = useRef(0)
  const paused       = useRef(false)
  const [modalOpen, setModalOpen] = useState(false)

  const { displayed, cursorVisible, triggerRef } = useTypewriter("<Stacks />")
  const { stacks: apiStacks } = useSiteConfig()

  // Auto-scroll
  useEffect(() => {
    const el = scrollRef.current
    if (!el) return
    const tick = () => {
      if (!paused.current && el) {
        positionRef.current += 0.5
        if (positionRef.current >= el.scrollWidth / 2) positionRef.current = 0
        el.scrollLeft = positionRef.current
      }
      animationRef.current = requestAnimationFrame(tick)
    }
    animationRef.current = requestAnimationFrame(tick)
    return () => cancelAnimationFrame(animationRef.current)
  }, [])

  // Drag – mouse
  const onMouseDown = useCallback((e: React.MouseEvent) => {
    const el = scrollRef.current
    if (!el) return
    isDragging.current = true
    paused.current     = true
    startX.current     = e.pageX - el.offsetLeft
    scrollLeft.current = el.scrollLeft
    el.style.cursor    = "grabbing"
  }, [])

  const onMouseMove = useCallback((e: React.MouseEvent) => {
    if (!isDragging.current) return
    const el = scrollRef.current
    if (!el) return
    e.preventDefault()
    el.scrollLeft = scrollLeft.current - (e.pageX - el.offsetLeft - startX.current) * 1.5
  }, [])

  const onMouseUp = useCallback(() => {
    if (!isDragging.current) return
    isDragging.current = false
    if (scrollRef.current) {
      positionRef.current = scrollRef.current.scrollLeft
      scrollRef.current.style.cursor = "grab"
    }
    paused.current = false
  }, [])

  // Drag – touch
  const onTouchStart = useCallback((e: React.TouchEvent) => {
    const el = scrollRef.current
    if (!el) return
    isDragging.current = true
    paused.current     = true
    startX.current     = e.touches[0].pageX - el.offsetLeft
    scrollLeft.current = el.scrollLeft
  }, [])

  const onTouchMove = useCallback((e: React.TouchEvent) => {
    if (!isDragging.current) return
    const el = scrollRef.current
    if (!el) return
    el.scrollLeft = scrollLeft.current - (e.touches[0].pageX - el.offsetLeft - startX.current) * 1.5
  }, [])

  const onTouchEnd = useCallback(() => {
    if (!isDragging.current) return
    isDragging.current = false
    if (scrollRef.current) positionRef.current = scrollRef.current.scrollLeft
    paused.current = false
  }, [])

  const categories = [...new Set(apiStacks.map(s => s.category))]

  return (
    <>
      <section ref={triggerRef} id="sobre" className="py-16 md:py-24">
        <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
          <div className="text-center mb-12">
            <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
              {displayed}<span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
            </span>
            <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
              Tecnologias & <span className="text-primary">Ferramentas</span>
            </h2>
            <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
              Stacks que utilizo para criar soluções web modernas.
            </p>
          </div>

          <div className="relative overflow-hidden">
            <div className="absolute left-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-r from-background to-transparent z-10 pointer-events-none" />
            <div className="absolute right-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-l from-background to-transparent z-10 pointer-events-none" />

            <div
              ref={scrollRef}
              className="flex gap-6 md:gap-8 overflow-x-hidden py-4 select-none"
              style={{ cursor: "grab" }}
              onMouseDown={onMouseDown}
              onMouseMove={onMouseMove}
              onMouseUp={onMouseUp}
              onMouseLeave={onMouseUp}
              onTouchStart={onTouchStart}
              onTouchMove={onTouchMove}
              onTouchEnd={onTouchEnd}
            >
              {[...apiStacks, ...apiStacks].map((stack, index) => {
                const Icon = iconMap[stack.slug]
                return (
                  <div key={`${stack.slug}-${index}`} className="flex-shrink-0 group">
                    <div className="bg-card border border-border rounded-xl p-4 md:p-6 flex flex-col items-center gap-3 transition-all duration-300 hover:border-primary/50 hover:bg-card/80 min-w-[100px] md:min-w-[120px]">
                      <div
                        className="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center transition-all duration-300"
                        style={{ backgroundColor: `${stack.color}20` }}
                      >
                        {Icon
                          ? <Icon size={26} color={stack.color} style={{ color: stack.color }} />
                          : <span className="text-xs font-bold" style={{ color: stack.color }}>{stack.name.slice(0, 3)}</span>
                        }
                      </div>
                      <span className="text-xs md:text-sm text-muted-foreground group-hover:text-foreground transition-colors duration-300 font-medium">
                        {stack.name}
                      </span>
                    </div>
                  </div>
                )
              })}
            </div>
          </div>

          <div className="flex justify-center mt-8">
            <Button
              size="default"
              className="rounded-full px-6 bg-primary text-primary-foreground hover:bg-primary/90 transition-all duration-300 animate-pulse-subtle"
              onClick={() => setModalOpen(true)}
            >
              Saber mais
            </Button>
          </div>
        </div>
      </section>

      {/* Modal */}
      {modalOpen && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center p-4"
          onClick={() => setModalOpen(false)}
        >
          <div className="absolute inset-0 bg-black/60 backdrop-blur-sm" />
          <div
            className="relative bg-card border border-border rounded-2xl w-full max-w-2xl max-h-[85vh] overflow-y-auto shadow-2xl"
            onClick={e => e.stopPropagation()}
          >
            {/* Header */}
            <div className="sticky top-0 bg-card border-b border-border px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
              <div>
                <h3 className="text-lg font-bold text-foreground">Todas as Stacks</h3>
                <p className="text-xs text-muted-foreground mt-0.5">Tecnologias e categorias que utilizo</p>
              </div>
              <button
                onClick={() => setModalOpen(false)}
                className="w-8 h-8 rounded-full flex items-center justify-center text-muted-foreground hover:text-foreground hover:bg-secondary transition-all duration-200"
              >
                <X className="h-4 w-4" />
              </button>
            </div>

            {/* Content grouped by category */}
            <div className="px-6 py-5 space-y-6">
              {categories.map(cat => (
                <div key={cat}>
                  <div className="flex items-center gap-2 mb-3">
                    <span
                      className="inline-block w-2 h-2 rounded-full"
                      style={{ backgroundColor: categoryColor[cat] ?? "#888" }}
                    />
                    <h4 className="text-xs font-semibold uppercase tracking-widest text-muted-foreground">
                      {categoryLabel[cat] ?? cat}
                    </h4>
                  </div>
                  <div className="space-y-2">
                    {apiStacks.filter(s => s.category === cat).map(stack => {
                      const Icon = iconMap[stack.slug]
                      return (
                        <div
                          key={stack.slug}
                          className="flex items-start gap-4 p-3 rounded-xl bg-secondary/50 hover:bg-secondary transition-colors duration-200"
                        >
                          <div
                            className="w-9 h-9 rounded-lg flex-shrink-0 flex items-center justify-center mt-0.5"
                            style={{ backgroundColor: `${stack.color}20` }}
                          >
                            {Icon
                              ? <Icon size={20} color={stack.color} style={{ color: stack.color }} />
                              : <span className="text-[10px] font-bold" style={{ color: stack.color }}>{stack.name.slice(0, 3)}</span>
                            }
                          </div>
                          <div className="min-w-0">
                            <p className="text-sm font-semibold text-foreground">{stack.name}</p>
                            <p className="text-xs text-muted-foreground leading-relaxed mt-0.5">
                              {descriptionMap[stack.slug] ?? "Tecnologia utilizada no desenvolvimento de soluções web."}
                            </p>
                          </div>
                        </div>
                      )
                    })}
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}
    </>
  )
}
