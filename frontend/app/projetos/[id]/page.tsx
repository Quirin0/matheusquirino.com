import { notFound } from "next/navigation"
import ProjectDetailClient from "@/components/project-detail-client"
import {
  fetchProjectAtBuild,
  fetchProjectsAtBuild,
  fetchProjectSlugsAtBuild,
  fallbackProjectBySlug,
  PROJECT_CATCH_SHELL_SLUG,
} from "@/lib/projects-api"
import { FALLBACK_PROJECT_LIST } from "@/lib/projects-fallback"

export async function generateStaticParams() {
  const slugs = await fetchProjectSlugsAtBuild()
  return slugs.map((id) => ({ id }))
}

export async function generateMetadata({
  params,
}: {
  params: Promise<{ id: string }>
}) {
  const { id } = await params
  if (id === PROJECT_CATCH_SHELL_SLUG) {
    return {
      title: "Projeto | Matheus Quirino",
      description: "Detalhes do projeto.",
    }
  }
  const project =
    (await fetchProjectAtBuild(id)) ?? fallbackProjectBySlug(id)

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

  if (id === PROJECT_CATCH_SHELL_SLUG) {
    const placeholder = FALLBACK_PROJECT_LIST[0]
    const initialOthers = (await fetchProjectsAtBuild()).filter(
      (p) => p.slug !== placeholder.slug
    )
    return (
      <ProjectDetailClient
        slug={PROJECT_CATCH_SHELL_SLUG}
        initialProject={placeholder}
        initialOthers={initialOthers}
      />
    )
  }

  const initial =
    (await fetchProjectAtBuild(id)) ?? fallbackProjectBySlug(id)

  if (!initial) {
    notFound()
  }

  const initialOthers = (await fetchProjectsAtBuild()).filter(
    (p) => p.slug !== initial.slug
  )

  return (
    <ProjectDetailClient
      slug={id}
      initialProject={initial}
      initialOthers={initialOthers}
    />
  )
}
