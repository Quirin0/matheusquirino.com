"use client"

import { useEffect, useRef, useState } from "react"
import { GraduationCap, Calendar, BookOpen } from "lucide-react"
import { useTypewriter } from "@/hooks/use-typewriter"
import { useSiteConfig } from "@/hooks/use-site-config"

interface EducationEntry {
  degree: string
  institution: string
  period: string
  status: string
  color: string
  description: string
}

interface StatEntry {
  value: string
  label: string
}

function EducationCard({
  edu,
  index,
}: {
  edu: EducationEntry
  index: number
}) {
  const [isVisible, setIsVisible] = useState(false)
  const ref = useRef<HTMLDivElement>(null)
  const Icon = index === 0 ? BookOpen : GraduationCap

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
      className={`transition-all duration-700 ${
        isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
      }`}
      style={{ transitionDelay: `${index * 150}ms` }}
    >
      <div className="bg-card border border-border rounded-xl p-5 hover:border-primary/40 transition-colors duration-300 h-full">
        <div className="flex items-start gap-4">
          <div
            className="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
            style={{ backgroundColor: `${edu.color}20` }}
          >
            <Icon size={18} style={{ color: edu.color }} />
          </div>

          <div className="flex-1 min-w-0">
            <div className="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-1 mb-1">
              <h3 className="text-sm font-bold text-foreground leading-snug">{edu.degree}</h3>
              <div className="flex items-center gap-1.5 text-[10px] text-muted-foreground flex-shrink-0">
                <Calendar size={11} />
                <span>{edu.period}</span>
              </div>
            </div>

            <div className="flex items-center gap-2 mb-3 flex-wrap">
              <span className="text-xs font-semibold" style={{ color: edu.color }}>
                {edu.institution}
              </span>
              <span className="text-muted-foreground">·</span>
              <span
                className="text-[10px] px-2 py-0.5 rounded-full border"
                style={{
                  borderColor: `${edu.color}40`,
                  color: edu.color,
                  backgroundColor: `${edu.color}10`,
                }}
              >
                {edu.status}
              </span>
            </div>

            <p className="text-xs text-muted-foreground leading-relaxed">
              {edu.description}
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}

export function EducationSection() {
  const { displayed, cursorVisible, triggerRef } = useTypewriter("<Formação />")
  const { settings } = useSiteConfig()

  const education: EducationEntry[] = (() => {
    try {
      const parsed = JSON.parse(settings["resume.education"] || "[]")
      return Array.isArray(parsed) ? parsed : []
    } catch {
      return []
    }
  })()

  const stats: StatEntry[] = (() => {
    try {
      const parsed = JSON.parse(settings["resume.stats"] || "[]")
      return Array.isArray(parsed) ? parsed : []
    } catch {
      return []
    }
  })()

  return (
    <section ref={triggerRef} id="formacao" className="py-16 md:py-24 bg-card/30">
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        {/* Header */}
        <div className="text-center mb-10">
          <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
            {displayed}
            <span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
          </span>
          <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
            Formação <span className="text-primary">Acadêmica</span>
          </h2>
          <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
            Educação formal que complementa minha experiência prática no mercado.
          </p>
        </div>

        {/* Education Cards */}
        {education.length > 0 && (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {education.map((edu, index) => (
              <EducationCard key={`${edu.institution}-${index}`} edu={edu} index={index} />
            ))}
          </div>
        )}

        {/* Stats */}
        {stats.length > 0 && (
          <div className="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-4">
            {stats.map((stat, i) => (
              <div
                key={i}
                className="bg-card border border-border rounded-xl p-4 text-center"
              >
                <p className="text-2xl font-bold text-primary mb-1">{stat.value}</p>
                <p className="text-[11px] text-muted-foreground leading-snug">{stat.label}</p>
              </div>
            ))}
          </div>
        )}
      </div>
    </section>
  )
}
