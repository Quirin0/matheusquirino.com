import { notFound } from "next/navigation"
import ProjectDetailClient from "@/components/project-detail-client"
import {
  fetchProjectAtBuild,
  fetchProjectsAtBuild,
  fetchProjectSlugsAtBuild,
  fallbackProjectBySlug,
} from "@/lib/projects-api"

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
