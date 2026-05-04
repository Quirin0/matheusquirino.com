"use client"

import { useEffect, useRef, useState } from "react"
import { CheckCircle2, Rocket } from "lucide-react"
import { useTypewriter } from "@/hooks/use-typewriter"
import { useSiteConfig } from "@/hooks/use-site-config"

interface Differential {
  text: string
}

export function DifferentialsSection() {
  const { displayed, cursorVisible, triggerRef } = useTypewriter("<Diferenciais />")
  const { settings } = useSiteConfig()
  const [isVisible, setIsVisible] = useState(false)
  const sectionRef = useRef<HTMLDivElement>(null)

  const differentials: Differential[] = (() => {
    try {
      const parsed = JSON.parse(settings["resume.differentials"] || "[]")
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
    if (sectionRef.current) observer.observe(sectionRef.current)
    return () => observer.disconnect()
  }, [])

  if (!differentials.length) return null

  return (
    <section ref={triggerRef} id="diferenciais" className="py-16 md:py-24">
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        {/* Header */}
        <div className="text-center mb-10">
          <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
            {displayed}
            <span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
          </span>
          <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
            O Que Me <span className="text-primary">Diferencia</span>
          </h2>
          <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
            Capacidades que vão além do código e entregam valor real nos projetos.
          </p>
        </div>

        {/* Cards */}
        <div
          ref={sectionRef}
          className={`grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 transition-all duration-700 ${
            isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
          }`}
        >
          {differentials.map((diff, i) => (
            <div
              key={i}
              className="bg-card border border-border rounded-xl p-5 hover:border-primary/40 transition-colors duration-300"
              style={{ transitionDelay: `${i * 80}ms` }}
            >
              <div className="flex items-start gap-3">
                <div className="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                  {i === 0 ? (
                    <Rocket size={15} className="text-primary" />
                  ) : (
                    <CheckCircle2 size={15} className="text-primary" />
                  )}
                </div>
                <p className="text-sm text-muted-foreground leading-relaxed">{diff.text}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
