"use client"

import Image from "next/image"
import Link from "next/link"
import { Button } from "@/components/ui/button"
import { useEffect, useRef, useState } from "react"
import { projects, type Project } from "@/lib/projects-data"
import { useTypewriter } from "@/hooks/use-typewriter"

function ProjectCard({
  project,
  index,
}: {
  project: Project
  index: number
}) {
  const [isVisible, setIsVisible] = useState(false)
  const ref = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsVisible(true)
          observer.unobserve(entry.target)
        }
      },
      { threshold: 0.1 }
    )

    if (ref.current) {
      observer.observe(ref.current)
    }

    return () => observer.disconnect()
  }, [])

  return (
    <Link href={`/projetos/${project.id}`}>
      <div
        ref={ref}
        className={`group bg-card border border-border rounded-xl overflow-hidden transition-all duration-500 hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 cursor-pointer ${
          isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
        }`}
        style={{ transitionDelay: `${index * 100}ms` }}
      >
        <div
          className="relative bg-secondary overflow-hidden"
          style={{ height: "calc(var(--spacing) * 60)" }}
        >
          <Image
            src={project.image}
            alt={project.title}
            fill
            className="object-cover transition-transform duration-500 group-hover:scale-[1.02]"
            sizes="(max-width: 640px) 100vw, 400px"
          />
          <div className="absolute inset-0 bg-gradient-to-t from-card/80 via-transparent to-transparent pointer-events-none" />
        </div>

        <div className="p-4">
          <div className="flex items-start justify-between gap-2 mb-2">
            <h3 className="text-sm font-semibold text-foreground group-hover:text-primary transition-colors duration-300 line-clamp-1">
              {project.title}
            </h3>
          </div>
          
          <p className="text-muted-foreground text-xs leading-relaxed mb-3 line-clamp-2">
            {project.description}
          </p>

          <div className="flex flex-wrap gap-1.5">
            {project.tags.slice(0, 3).map((tag) => (
              <span
                key={tag}
                className="px-2 py-0.5 bg-secondary text-[10px] text-muted-foreground rounded-full"
              >
                {tag}
              </span>
            ))}
          </div>
        </div>
      </div>
    </Link>
  )
}

export function ProjectsSection() {
  const { displayed, cursorVisible, triggerRef } = useTypewriter("<Projetos />")

  return (
    <section ref={triggerRef} id="projetos" className="py-16 md:py-24">
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        <div className="text-center mb-10">
          <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
            {displayed}<span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
          </span>
          <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
            Projetos em <span className="text-primary">Destaque</span>
          </h2>
          <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
            Uma selecao dos meus projetos mais recentes e relevantes.
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
          {projects.map((project, index) => (
            <ProjectCard key={project.id} project={project} index={index} />
          ))}
        </div>

        <div className="flex justify-center mt-8">
          <Button
            size="default"
            className="rounded-full px-6 bg-primary text-primary-foreground hover:bg-primary/90 transition-all duration-300 animate-pulse-subtle"
            asChild
          >
            <Link href="/projetos">Ver Todos os Projetos</Link>
          </Button>
        </div>
      </div>
    </section>
  )
}
