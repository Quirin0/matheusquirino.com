"use client"

import { Github, Linkedin, Mail } from "lucide-react"
import { useSiteConfig } from "@/hooks/use-site-config"
import { mailtoHref, publicContactEmail } from "@/lib/contact-utils"

export function Footer() {
  const currentYear = new Date().getFullYear()
  const { settings } = useSiteConfig()

  const logoText = settings["site.logo_text"] || "<MatheusQuirino />"
  const githubUrl = (settings["social.github"] || "").trim()
  const linkedinUrl = (settings["social.linkedin"] || "").trim()
  const mail = publicContactEmail(settings)
  const mailHref = mailtoHref(mail)

  return (
    <footer className="border-t border-border py-6">
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        <div className="flex flex-col sm:flex-row items-center justify-between gap-4">
          <span className="text-sm font-bold text-primary">{logoText}</span>

          <div className="flex items-center gap-3">
            {githubUrl ? (
              <a
                href={githubUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="text-muted-foreground hover:text-primary transition-colors duration-300"
                aria-label="GitHub"
              >
                <Github className="h-4 w-4" />
              </a>
            ) : null}
            {linkedinUrl ? (
              <a
                href={linkedinUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="text-muted-foreground hover:text-primary transition-colors duration-300"
                aria-label="LinkedIn"
              >
                <Linkedin className="h-4 w-4" />
              </a>
            ) : null}
            {mailHref ? (
              <a
                href={mailHref}
                className="text-muted-foreground hover:text-primary transition-colors duration-300"
                aria-label="E-mail"
              >
                <Mail className="h-4 w-4" />
              </a>
            ) : null}
          </div>

          <p className="text-xs text-muted-foreground">
            {currentYear} Todos os direitos reservados.
          </p>
        </div>
      </div>
    </footer>
  )
}
