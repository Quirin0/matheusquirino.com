"use client"

import Image from "next/image"
import { Github, Linkedin, Mail } from "lucide-react"
import { Button } from "@/components/ui/button"
import { useSiteConfig } from "@/hooks/use-site-config"
import { useTypewriter } from "@/hooks/use-typewriter"

export function HeroSection() {
  const config = useSiteConfig()
  const s = config.settings

  const heroName        = s["site.hero_name"]        || "Hello World_"
  const heroTitle       = s["site.hero_title"]        || "Desenvolvedor\nFullstack Junior"
  const heroDescription = s["site.hero_description"]  || "Apaixonado por criar soluções web modernas e eficientes."
  const githubUrl       = s["social.github"]           || "https://github.com"
  const linkedinUrl     = s["social.linkedin"]         || "https://linkedin.com"
  const profilePhoto    = s["site.profile_photo"]      || "/images/1632870446247.jpeg"

  const fullText = heroName.endsWith("_") ? heroName.slice(0, -1) : heroName
  const { displayed, cursorVisible, triggerRef } = useTypewriter(fullText, { speed: 90, keepCursor: true })

  const [titleLine1, titleLine2] = heroTitle.split("\n")

  return (
    <section
      ref={triggerRef}
      id="inicio"
      className="min-h-screen flex items-center pt-20 md:pt-0"
    >
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12 w-full">
        <div className="flex flex-col lg:flex-row gap-10 lg:gap-16 items-center">
          {/* Photo Card */}
          <div className="flex justify-center lg:justify-start">
            <div className="relative group">
              <div className="absolute -inset-1 bg-gradient-to-r from-primary/50 to-primary/20 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-500" />
              <div className="relative bg-card rounded-2xl p-2 border border-border">
                <div className="w-40 h-40 md:w-48 md:h-48 rounded-xl overflow-hidden bg-secondary">
                  <Image
                    src={profilePhoto}
                    alt="Matheus Quirino"
                    width={192}
                    height={192}
                    className="w-full h-full object-cover"
                    priority
                  />
                </div>
              </div>
            </div>
          </div>

          {/* Description */}
          <div className="text-center lg:text-left flex-1">
            <div className="space-y-5">
              <span className="inline-block px-4 py-1.5 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground animate-in fade-in slide-in-from-bottom-4 duration-500">
                {displayed}
                <span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
              </span>
              <h1 className="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground leading-tight animate-in fade-in slide-in-from-bottom-4 duration-500 delay-100">
                <span className="text-balance">{titleLine1}</span>
                {titleLine2 && (
                  <>
                    <br />
                    <span className="text-primary">{titleLine2}</span>
                  </>
                )}
              </h1>
              <p className="text-muted-foreground text-sm md:text-base max-w-md mx-auto lg:mx-0 leading-relaxed animate-in fade-in slide-in-from-bottom-4 duration-500 delay-200">
                {heroDescription}
              </p>

              {/* Social Links */}
              <div className="flex items-center justify-center lg:justify-start gap-3 pt-2 animate-in fade-in slide-in-from-bottom-4 duration-500 delay-300">
                <Button
                  variant="outline"
                  size="icon"
                  className="rounded-full border-border hover:border-primary hover:bg-primary/10 transition-all duration-300 bg-transparent h-9 w-9 text-foreground animate-pulse-subtle"
                  asChild
                >
                  <a href={githubUrl} target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                    <Github className="h-4 w-4" />
                  </a>
                </Button>
                <Button
                  variant="outline"
                  size="icon"
                  className="rounded-full border-border hover:border-primary hover:bg-primary/10 transition-all duration-300 bg-transparent h-9 w-9 text-foreground animate-pulse-subtle"
                  asChild
                >
                  <a href={linkedinUrl} target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                    <Linkedin className="h-4 w-4" />
                  </a>
                </Button>
                <Button
                  variant="outline"
                  size="icon"
                  className="rounded-full border-border hover:border-primary hover:bg-primary/10 transition-all duration-300 bg-transparent h-9 w-9 text-foreground animate-pulse-subtle"
                  asChild
                >
                  <a href="#contato" aria-label="Email">
                    <Mail className="h-4 w-4" />
                  </a>
                </Button>
              </div>

              {/* CTA Button */}
              <div className="pt-2 animate-in fade-in slide-in-from-bottom-4 duration-500 delay-400">
                <Button
                  size="default"
                  className="rounded-full px-6 bg-primary text-primary-foreground hover:bg-primary/90 transition-all duration-300 animate-pulse-subtle"
                  asChild
                >
                  <a href="#projetos">Ver Projetos</a>
                </Button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
