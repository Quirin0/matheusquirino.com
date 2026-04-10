import { notFound } from "next/navigation"
import Image from "next/image"
import Link from "next/link"
import { ArrowLeft } from "lucide-react"
import { Button } from "@/components/ui/button"
import { Navbar } from "@/components/navbar"
import { ContactSection } from "@/components/contact-section"
import { Footer } from "@/components/footer"
import { WhatsAppButton } from "@/components/whatsapp-button"
import {
  projects,
  getProjectById,
  getOtherProjects,
} from "@/lib/projects-data"

export function generateStaticParams() {
  return projects.map((project) => ({
    id: project.id,
  }))
}

export async function generateMetadata({
  params,
}: {
  params: Promise<{ id: string }>
}) {
  const { id } = await params
  const project = getProjectById(id)

  if (!project) {
    return {
      title: "Projeto nao encontrado",
    }
  }

  return {
    title: `${project.title} | Matheus Quirino`,
    description: project.description,
  }
}

export default async function ProjectPage({
  params,
}: {
  params: Promise<{ id: string }>
}) {
  const { id } = await params
  const project = getProjectById(id)

  if (!project) {
    notFound()
  }

  const otherProjects = getOtherProjects(id)

  return (
    <main className="min-h-screen bg-background">
      <Navbar />

      <article className="pt-24 pb-16">
        <div className="max-w-5xl mx-auto px-6 md:px-8 lg:px-12">
          {/* Back Button */}
          <Link href="/#projetos">
            <Button
              variant="ghost"
              size="sm"
              className="mb-8 text-muted-foreground hover:text-foreground transition-colors"
            >
              <ArrowLeft className="mr-2 h-4 w-4" />
              Voltar aos projetos
            </Button>
          </Link>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* Main Content */}
            <div className="lg:col-span-2">
              {/* Project Image */}
              <div className="relative aspect-video bg-card rounded-2xl overflow-hidden border border-border mb-8">
                <div className="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                  <span className="text-6xl font-bold text-primary/20">
                    {project.title.charAt(0)}
                  </span>
                </div>
              </div>

              {/* Project Title */}
              <div className="mb-6">
                <div className="flex flex-wrap gap-2 mb-4">
                  {project.tags.map((tag) => (
                    <span
                      key={tag}
                      className="px-3 py-1 bg-primary/10 text-primary text-xs rounded-full"
                    >
                      {tag}
                    </span>
                  ))}
                </div>
                <h1 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                  {project.title}
                </h1>
                <p className="text-muted-foreground text-lg">
                  {project.description}
                </p>
              </div>

              {/* Project Description */}
              <div className="prose prose-invert max-w-none">
                <div className="bg-card rounded-xl border border-border p-6 md:p-8">
                  {project.fullDescription.split("\n\n").map((paragraph, index) => (
                    <p
                      key={index}
                      className="text-muted-foreground leading-relaxed mb-4 last:mb-0"
                    >
                      {paragraph}
                    </p>
                  ))}
                </div>
              </div>
            </div>

            {/* Sidebar - Other Projects */}
            <aside className="lg:col-span-1">
              <div className="sticky top-24">
                <h3 className="text-lg font-semibold text-foreground mb-4">
                  Outros <span className="text-primary">Projetos</span>
                </h3>
                <div className="space-y-3">
                  {otherProjects.map((otherProject) => (
                    <Link
                      key={otherProject.id}
                      href={`/projetos/${otherProject.id}`}
                    >
                      <div className="group flex gap-3 p-3 bg-card rounded-xl border border-border hover:border-primary/40 transition-all duration-300 cursor-pointer">
                        {/* Mini Image */}
                        <div className="relative w-16 h-16 flex-shrink-0 bg-secondary rounded-lg overflow-hidden">
                          <div className="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                            <span className="text-lg font-bold text-primary/40">
                              {otherProject.title.charAt(0)}
                            </span>
                          </div>
                        </div>
                        {/* Info */}
                        <div className="flex-1 min-w-0">
                          <h4 className="text-sm font-medium text-foreground group-hover:text-primary transition-colors line-clamp-1">
                            {otherProject.title}
                          </h4>
                          <p className="text-xs text-muted-foreground line-clamp-2 mt-1">
                            {otherProject.description}
                          </p>
                        </div>
                      </div>
                    </Link>
                  ))}
                </div>
              </div>
            </aside>
          </div>
        </div>
      </article>

      <ContactSection />
      <Footer />
      <WhatsAppButton />
    </main>
  )
}
