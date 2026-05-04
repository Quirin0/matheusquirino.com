"use client"

import { useState, useEffect } from "react"
import Image from "next/image"
import { usePathname } from "next/navigation"
import { Menu, X } from "lucide-react"
import { Button } from "@/components/ui/button"
import { useSiteConfig } from "@/hooks/use-site-config"

const navItems = [
  { label: "Inicio",      hash: "inicio" },
  { label: "Sobre Mim",   hash: "sobre" },
  { label: "Experiência", hash: "experiencia" },
  { label: "Projetos",    hash: "projetos" },
  { label: "Contato",     hash: "contato" },
]

export function Navbar() {
  const [isOpen, setIsOpen] = useState(false)
  const [scrolled, setScrolled] = useState(false)
  const pathname = usePathname()
  const isHome   = pathname === "/" || pathname === ""
  const config   = useSiteConfig()
  const logoText = config.settings["site.logo_text"] || "<MatheusQuirino />"
  const logoSrc =
    config.settings["site.logo_image"] || "/images/1632870446247.jpeg"

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 20)
    window.addEventListener("scroll", handleScroll)
    return () => window.removeEventListener("scroll", handleScroll)
  }, [])

  const href = (hash: string) => isHome ? `#${hash}` : `/#${hash}`

  return (
    <header
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        scrolled
          ? "bg-background/90 backdrop-blur-md border-b border-border"
          : "bg-transparent"
      }`}
    >
      <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
        <nav className="flex items-center justify-between h-14 md:h-16">
          <a
            href={href("inicio")}
            className="flex items-center gap-2.5 text-lg font-bold text-primary transition-colors hover:text-primary/80"
          >
            <span className="relative h-9 w-9 shrink-0 overflow-hidden rounded-lg ring-1 ring-border bg-card">
              <Image
                src={logoSrc}
                alt=""
                width={36}
                height={36}
                className="h-full w-full object-cover"
              />
            </span>
            <span className="leading-tight">{logoText}</span>
          </a>

          {/* Desktop Navigation */}
          <ul className="hidden md:flex items-center gap-6">
            {navItems.map((item) => (
              <li key={item.hash}>
                <a
                  href={href(item.hash)}
                  className="text-muted-foreground hover:text-primary transition-colors duration-300 text-sm font-medium"
                >
                  {item.label}
                </a>
              </li>
            ))}
          </ul>

          {/* Mobile Menu Button */}
          <Button
            variant="ghost"
            size="icon"
            className="md:hidden text-foreground h-8 w-8"
            onClick={() => setIsOpen(!isOpen)}
          >
            {isOpen ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
          </Button>
        </nav>

        {/* Mobile Navigation */}
        <div
          className={`md:hidden overflow-hidden transition-all duration-300 ease-in-out ${
            isOpen ? "max-h-48 pb-4" : "max-h-0"
          }`}
        >
          <ul className="flex flex-col gap-3">
            {navItems.map((item) => (
              <li key={item.hash}>
                <a
                  href={href(item.hash)}
                  onClick={() => setIsOpen(false)}
                  className="block text-muted-foreground hover:text-primary transition-colors duration-300 text-sm font-medium"
                >
                  {item.label}
                </a>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </header>
  )
}
