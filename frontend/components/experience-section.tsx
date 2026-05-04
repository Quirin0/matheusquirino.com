"use client"

import { useEffect, useRef, useState } from "react"
import { Briefcase, Calendar, MapPin, Quote, FileDown } from "lucide-react"
import { useTypewriter } from "@/hooks/use-typewriter"
import { useSiteConfig } from "@/hooks/use-site-config"
import { Button } from "@/components/ui/button"

interface Highlight {
  text: string
}

interface Experience {
  role: string
  company: string
  type: string
  period: string
  color: string
  tags: string
  highlights: Highlight[]
}

function ExperienceCard({
  exp,
  index,
  total,
}: {
  exp: Experience
  index: number
  total: number
}) {
  const [isVisible, setIsVisible] = useState(false)
  const ref = useRef<HTMLDivElement>(null)
  const tags = exp.tags ? exp.tags.split(",").map((t) => t.trim()).filter(Boolean) : []

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
    if (ref.current) observer.observe(ref.current)
    return () => observer.disconnect()
  }, [])

  return (
    <div
      ref={ref}
      className={`relative transition-all duration-700 ${
        isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
      }`}
      style={{ transitionDelay: `${index * 150}ms` }}
    >
      {index < total - 1 && (
        <div
          className="absolute left-5 top-full w-0.5 h-6 bg-border z-10"
          aria-hidden="true"
        />
      )}

      <div className="bg-card border border-border rounded-xl p-5 hover:border-primary/40 transition-colors duration-300">
        <div className="flex items-start gap-4">
          <div
            className="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
            style={{ backgroundColor: `${exp.color}20` }}
          >
            <Briefcase size={18} style={{ color: exp.color }} />
          </div>

          <div className="flex-1 min-w-0">
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-1">
              <h3 className="text-sm font-bold text-foreground">{exp.role}</h3>
              <div className="flex items-center gap-1.5 text-[10px] text-muted-foreground">
                <Calendar size={11} />
                <span>{exp.period}</span>
              </div>
            </div>

            <div className="flex items-center gap-2 mb-3">
              <span className="text-xs font-semibold" style={{ color: exp.color }}>
                {exp.company}
              </span>
              <span className="text-muted-foreground">·</span>
              <div className="flex items-center gap-1 text-xs text-muted-foreground">
                <MapPin size={11} />
                <span>{exp.type}</span>
              </div>
            </div>

            {exp.highlights?.length > 0 && (
              <ul className="space-y-2 mb-4">
                {exp.highlights.map((item, i) => (
                  <li key={i} className="flex items-start gap-2 text-xs text-muted-foreground leading-relaxed">
                    <span
                      className="inline-block w-1.5 h-1.5 rounded-full mt-1.5 flex-shrink-0"
                      style={{ backgroundColor: exp.color }}
                    />
                    {item.text}
                  </li>
                ))}
              </ul>
            )}

            {tags.length > 0 && (
              <div className="flex flex-wrap gap-1.5">
                {tags.map((tag) => (
                  <span
                    key={tag}
                    className="px-2 py-0.5 text-[10px] rounded-full border"
                    style={{
                      borderColor: `${exp.color}40`,
                      color: exp.color,
                      backgroundColor: `${exp.color}10`,
                    }}
                  >
                    {tag}
                  </span>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  )
}

export function ExperienceSection() {
  const { displayed, cursorVisible, triggerRef } = useTypewriter("<Experiência />")
  const { settings } = useSiteConfig()
  const [statementVisible, setStatementVisible] = useState(false)
  const statementRef = useRef<HTMLDivElement>(null)

  const personalStatement =
    settings["resume.personal_statement"] ||
    "Atuo com desenvolvimento de software desde 2018, participando da criação e manutenção de aplicações web que recebem centenas de acessos diariamente."

  const cvUrl = settings["resume.cv_file"] || "/cv/curriculo.pdf"

  const experiences: Experience[] = (() => {
    try {
      const parsed = JSON.parse(settings["resume.experiences"] || "[]")
      return Array.isArray(parsed) ? parsed : []
    } catch {
      return []
    }
  })()

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
    if (statementRef.current) observer.observe(statementRef.current)
    return () => observer.disconnect()
  }, [])

  const [isVisible, setIsVisible] = useState(false)

  return (
    <section ref={triggerRef} id="experiencia" className="py-16 md:py-24">
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        {/* Header */}
        <div className="text-center mb-10">
          <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
            {displayed}
            <span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
          </span>
          <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
            Trajetória <span className="text-primary">Profissional</span>
          </h2>
          <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
            Experiências que moldaram minha visão sobre desenvolvimento de software.
          </p>
        </div>

        {/* Personal Statement */}
        <div
          ref={statementRef}
          className={`mb-8 transition-all duration-700 ${
            isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
          }`}
        >
          <div className="bg-card border border-border rounded-xl p-5 relative overflow-hidden">
            <div className="absolute top-4 right-4 opacity-10">
              <Quote size={48} className="text-primary" />
            </div>
            <div className="flex items-start gap-3">
              <div className="w-1 self-stretch rounded-full bg-primary flex-shrink-0" />
              <div>
                <p className="text-xs font-semibold uppercase tracking-widest text-primary mb-2">
                  Afirmação Pessoal
                </p>
                <p className="text-sm text-muted-foreground leading-relaxed">
                  {personalStatement}
                </p>
              </div>
            </div>
          </div>
        </div>

        {/* Experience Cards */}
        <div className="space-y-6">
          {experiences.map((exp, index) => (
            <ExperienceCard
              key={`${exp.company}-${index}`}
              exp={exp}
              index={index}
              total={experiences.length}
            />
          ))}
        </div>

        {/* CV Button */}
        {cvUrl && (
          <div className="flex justify-center mt-10">
            <Button
              size="default"
              className="rounded-full px-6 bg-primary text-primary-foreground hover:bg-primary/90 transition-all duration-300 gap-2"
              asChild
            >
              <a href={cvUrl} target="_blank" rel="noopener noreferrer" download>
                <FileDown className="h-4 w-4" />
                Ver Currículo
              </a>
            </Button>
          </div>
        )}
      </div>
    </section>
  )
}
