export type PortfolioProject = {
  slug: string
  title: string
  description: string
  fullDescription: string
  coverImage: string
  tags: string[]
  featured: boolean
  order: number
  liveUrl: string | null
  githubUrl: string | null
}
