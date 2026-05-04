"use client"

import React, { useEffect, useRef, useState } from "react"
import { Mail, MapPin, Phone, Loader2 } from "lucide-react"
import { Button } from "@/components/ui/button"
import { useToast } from "@/hooks/use-toast"
import { useTypewriter } from "@/hooks/use-typewriter"
import { useSiteConfig } from "@/hooks/use-site-config"

export function ContactSection() {
  const { displayed, cursorVisible, triggerRef } = useTypewriter("<Contato />")
  const { settings } = useSiteConfig()
  const email = (settings["contact.email"] || "").trim()
  const phone = (settings["contact.phone"] || "").trim()
  const location = (settings["contact.location"] || "").trim()

  const [formData, setFormData] = useState({
    name: "",
    email: "",
    message: "",
  })
  const [isVisible, setIsVisible] = useState(false)
  const [isSubmitting, setIsSubmitting] = useState(false)
  const sectionRef = useRef<HTMLElement>(null)
  const { toast } = useToast()

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

    if (sectionRef.current) {
      observer.observe(sectionRef.current)
    }

    return () => observer.disconnect()
  }, [])

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setIsSubmitting(true)

    const origin =
      typeof window !== "undefined" ? window.location.origin : ""

    try {
      const response = await fetch(`${origin}/api/contact`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          name: formData.name,
          email: formData.email,
          message: formData.message,
        }),
      })

      const payload = (await response.json().catch(() => ({}))) as {
        message?: string
      }

      if (response.ok) {
        toast({
          title: "Mensagem enviada!",
          description:
            payload.message ||
            "Obrigado pelo contato. Responderei em breve!",
        })
        setFormData({ name: "", email: "", message: "" })
      } else {
        toast({
          title: "Erro ao enviar",
          description:
            payload.message ||
            "Verifique os dados ou tente mais tarde (SMTP no painel admin).",
          variant: "destructive",
        })
      }
    } catch {
      toast({
        title: "Erro ao enviar",
        description:
          "Tente novamente mais tarde ou use o telefone ou e-mail ao lado.",
        variant: "destructive",
      })
    } finally {
      setIsSubmitting(false)
    }
  }

  const hasContactDetails = Boolean(email || phone || location)

  return (
    <section ref={sectionRef} id="contato" className="py-16 md:py-24">
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        <div ref={triggerRef} className="text-center mb-10">
          <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
            {displayed}<span style={{ opacity: cursorVisible ? 1 : 0 }}>_</span>
          </span>
          <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
            Vamos <span className="text-primary">Conversar</span>?
          </h2>
          <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
            Estou sempre aberto a novas oportunidades e projetos interessantes.
          </p>
        </div>

        <div className={`grid grid-cols-1 lg:grid-cols-5 gap-6 transition-all duration-700 ${
          isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
        }`}>
          <div className="lg:col-span-2 space-y-4">
            <div className="bg-card border border-border rounded-xl p-5">
              <h3 className="text-sm font-semibold text-foreground mb-5">
                Informações de contato
              </h3>
              {hasContactDetails ? (
                <div className="space-y-4">
                  {email ? (
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 bg-primary/10 rounded-lg flex items-center justify-center">
                        <Mail className="h-4 w-4 text-primary" />
                      </div>
                      <div>
                        <p className="text-[10px] text-muted-foreground uppercase tracking-wide">
                          E-mail
                        </p>
                        <a
                          href={`mailto:${email}`}
                          className="text-foreground text-sm hover:text-primary transition-colors"
                        >
                          {email}
                        </a>
                      </div>
                    </div>
                  ) : null}
                  {phone ? (
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 bg-primary/10 rounded-lg flex items-center justify-center">
                        <Phone className="h-4 w-4 text-primary" />
                      </div>
                      <div>
                        <p className="text-[10px] text-muted-foreground uppercase tracking-wide">
                          Telefone / WhatsApp
                        </p>
                        <p className="text-foreground text-sm">{phone}</p>
                      </div>
                    </div>
                  ) : null}
                  {location ? (
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 bg-primary/10 rounded-lg flex items-center justify-center">
                        <MapPin className="h-4 w-4 text-primary" />
                      </div>
                      <div>
                        <p className="text-[10px] text-muted-foreground uppercase tracking-wide">
                          Localização
                        </p>
                        <p className="text-foreground text-sm">{location}</p>
                      </div>
                    </div>
                  ) : null}
                </div>
              ) : (
                <p className="text-sm text-muted-foreground leading-relaxed">
                  Defina e-mail, telefone e localização em{" "}
                  <strong className="text-foreground">Configurações</strong> no
                  painel admin para exibi-los aqui.
                </p>
              )}
            </div>
          </div>

          <div className="lg:col-span-3 bg-card border border-border rounded-xl p-5">
            <h3 className="text-sm font-semibold text-foreground mb-5">
              Envie uma mensagem
            </h3>
            <form onSubmit={handleSubmit} className="space-y-4">
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label
                    htmlFor="name"
                    className="block text-xs font-medium text-foreground mb-1.5"
                  >
                    Nome
                  </label>
                  <input
                    type="text"
                    id="name"
                    value={formData.name}
                    onChange={(e) =>
                      setFormData({ ...formData, name: e.target.value })
                    }
                    className="w-full px-3 py-2 bg-secondary border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                    placeholder="Seu nome"
                    required
                  />
                </div>
                <div>
                  <label
                    htmlFor="email"
                    className="block text-xs font-medium text-foreground mb-1.5"
                  >
                    E-mail
                  </label>
                  <input
                    type="email"
                    id="email"
                    value={formData.email}
                    onChange={(e) =>
                      setFormData({ ...formData, email: e.target.value })
                    }
                    className="w-full px-3 py-2 bg-secondary border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                    placeholder="seu@email.com"
                    required
                  />
                </div>
              </div>
              <div>
                <label
                  htmlFor="message"
                  className="block text-xs font-medium text-foreground mb-1.5"
                >
                  Mensagem
                </label>
                <textarea
                  id="message"
                  rows={3}
                  value={formData.message}
                  onChange={(e) =>
                    setFormData({ ...formData, message: e.target.value })
                  }
                  className="w-full px-3 py-2 bg-secondary border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-primary/50 focus:border-primary transition-all duration-300 resize-none"
                  placeholder="Sua mensagem..."
                  required
                />
              </div>
              <Button
                type="submit"
                size="default"
                disabled={isSubmitting}
                className="w-full rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition-all duration-300 disabled:opacity-50"
              >
                {isSubmitting ? (
                  <>
                    <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                    Enviando...
                  </>
                ) : (
                  "Enviar mensagem"
                )}
              </Button>
            </form>
          </div>
        </div>
      </div>
    </section>
  )
}
