"use client"

import { useSearchParams } from "next/navigation"

import { useState, useMemo } from "react"
import Link from "next/link"
import { Search, X } from "lucide-react"
import { Button } from "@/components/ui/button"
import { Navbar } from "@/components/navbar"
import { ContactSection } from "@/components/contact-section"
import { Footer } from "@/components/footer"
import { WhatsAppButton } from "@/components/whatsapp-button"
import { projects, getAllTags } from "@/lib/projects-data"


export default function ProjectsPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [selectedTags, setSelectedTags] = useState<string[]>([])
  const allTags = getAllTags()
  const searchParams = useSearchParams()

  const filteredProjects = useMemo(() => {
    return projects.filter((project) => {
      const matchesSearch =
        searchQuery === "" ||
        project.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
        project.description.toLowerCase().includes(searchQuery.toLowerCase())

      const matchesTags =
        selectedTags.length === 0 ||
        selectedTags.some((tag) => project.tags.includes(tag))

      return matchesSearch && matchesTags
    })
  }, [searchQuery, selectedTags])

  const toggleTag = (tag: string) => {
    setSelectedTags((prev) =>
      prev.includes(tag) ? prev.filter((t) => t !== tag) : [...prev, tag]
    )
  }

  const clearFilters = () => {
    setSearchQuery("")
    setSelectedTags([])
  }

  return (
    <main className="min-h-screen bg-background">
      <Navbar />

      <section className="pt-28 pb-16 md:pt-32 md:pb-20">
        <div className="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">
          {/* Header */}
          <div className="text-center mb-10">
            <span className="inline-block px-4 py-1.5 mb-4 text-xs font-mono bg-card border border-border rounded-full text-muted-foreground">
              {"<TodosProjetos />"}
            </span>
            <h1 className="text-3xl md:text-4xl font-bold text-foreground mb-3">
              Todos os <span className="text-primary">Projetos</span>
            </h1>
            <p className="text-muted-foreground text-sm md:text-base max-w-lg mx-auto">
              Explore todos os meus projetos. Filtre por tecnologia ou pesquise
              pelo nome.
            </p>
          </div>

          {/* Search and Filters */}
          <div className="mb-8 space-y-4">
            {/* Search Input */}
            <div className="relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <input
                type="text"
                placeholder="Pesquisar projetos..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-11 pr-10 py-3 bg-card border border-border rounded-xl text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-primary/50 focus:border-primary transition-all duration-300"
              />
              {searchQuery && (
                <button
                  type="button"
                  onClick={() => setSearchQuery("")}
                  className="absolute right-4 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors"
                >
                  <X className="h-4 w-4" />
                </button>
              )}
            </div>

            {/* Tags Filter */}
            <div className="flex flex-wrap gap-2">
              {allTags.map((tag) => (
                <button
                  key={tag}
                  type="button"
                  onClick={() => toggleTag(tag)}
                  className={`px-3 py-1.5 text-xs rounded-full border transition-all duration-300 ${
                    selectedTags.includes(tag)
                      ? "bg-primary text-primary-foreground border-primary"
                      : "bg-card text-muted-foreground border-border hover:border-primary/50"
                  }`}
                >
                  {tag}
                </button>
              ))}
              {(selectedTags.length > 0 || searchQuery) && (
                <button
                  type="button"
                  onClick={clearFilters}
                  className="px-3 py-1.5 text-xs rounded-full border border-destructive/50 text-destructive hover:bg-destructive/10 transition-all duration-300"
                >
                  Limpar filtros
                </button>
              )}
            </div>
          </div>

          {/* Results Count */}
          <p className="text-sm text-muted-foreground mb-6">
            {filteredProjects.length}{" "}
            {filteredProjects.length === 1
              ? "projeto encontrado"
              : "projetos encontrados"}
          </p>

          {/* Projects Grid */}
          {filteredProjects.length > 0 ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              {filteredProjects.map((project, index) => (
                <Link key={project.id} href={`/projetos/${project.id}`}>
                  <div
                    className="group bg-card border border-border rounded-xl overflow-hidden transition-all duration-500 hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 cursor-pointer animate-in fade-in slide-in-from-bottom-4"
                    style={{ animationDelay: `${index * 50}ms` }}
                  >
                    {/* Project Image */}
                    <div className="relative h-32 bg-secondary overflow-hidden">
                      <div className="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                        <span className="text-3xl font-bold text-primary/30">
                          {String(index + 1).padStart(2, "0")}
                        </span>
                      </div>
                      <div className="absolute inset-0 bg-gradient-to-t from-card to-transparent" />
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
                            className={`px-2 py-0.5 text-[10px] rounded-full ${
                              selectedTags.includes(tag)
                                ? "bg-primary/20 text-primary"
                                : "bg-secondary text-muted-foreground"
                            }`}
                          >
                            {tag}
                          </span>
                        ))}
                      </div>
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          ) : (
            <div className="text-center py-16 bg-card border border-border rounded-xl">
              <p className="text-muted-foreground mb-4">
                Nenhum projeto encontrado com os filtros selecionados.
              </p>
              <Button
                variant="outline"
                onClick={clearFilters}
                className="rounded-full bg-transparent text-foreground"
              >
                Limpar filtros
              </Button>
            </div>
          )}

          {/* Back Button */}
          <div className="flex justify-center mt-10">
            <Button
              variant="outline"
              className="rounded-full px-6 border-border hover:border-primary hover:bg-primary/10 transition-all duration-300 bg-transparent text-foreground"
              asChild
            >
              <Link href="/#projetos">Voltar ao Inicio</Link>
            </Button>
          </div>
        </div>
      </section>

      <ContactSection />
      <Footer />
      <WhatsAppButton />
    </main>
  )
}
