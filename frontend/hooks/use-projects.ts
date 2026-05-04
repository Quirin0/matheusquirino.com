"use client"

import { useEffect, useState } from "react"
import type { PortfolioProject } from "@/lib/project-types"
import {
  mapApiProjectToPortfolio,
  type ApiProjectJson,
} from "@/lib/projects-api"
import { FALLBACK_PROJECT_LIST } from "@/lib/projects-fallback"

export function useProjects() {
  const [projects, setProjects] = useState<PortfolioProject[]>([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const origin =
      typeof window !== "undefined" ? window.location.origin : ""

    fetch(`${origin}/api/projects`)
      .then((r) => (r.ok ? r.json() : Promise.reject(new Error("api"))))
      .then((raw: ApiProjectJson[]) => {
        if (!Array.isArray(raw) || raw.length === 0) {
          setProjects([...FALLBACK_PROJECT_LIST])
          return
        }
        setProjects(raw.map(mapApiProjectToPortfolio))
      })
      .catch(() => {
        setProjects([...FALLBACK_PROJECT_LIST])
      })
      .finally(() => setLoading(false))
  }, [])

  return { projects, loading }
}
