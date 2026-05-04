"use client"

import { useEffect } from "react"
import { usePathname } from "next/navigation"
import { useSiteConfig } from "@/hooks/use-site-config"

function metaByName(name: string): HTMLMetaElement {
  let el = document.querySelector(
    `meta[name="${CSS.escape(name)}"]`
  ) as HTMLMetaElement | null
  if (!el) {
    el = document.createElement("meta")
    el.setAttribute("name", name)
    document.head.appendChild(el)
  }
  return el
}

function metaByProperty(property: string): HTMLMetaElement {
  let el = document.querySelector(
    `meta[property="${CSS.escape(property)}"]`
  ) as HTMLMetaElement | null
  if (!el) {
    el = document.createElement("meta")
    el.setAttribute("property", property)
    document.head.appendChild(el)
  }
  return el
}

/** Aplica SEO e tags opcionais da página Admin → SEO no documento (home). */
export function SiteMeta() {
  const pathname = usePathname()
  const { settings } = useSiteConfig()

  useEffect(() => {
    const isHome = pathname === "/" || pathname === ""

    if (isHome) {
      const title = settings["seo.home_title"]?.trim()
      const desc = settings["seo.home_description"]?.trim()
      const keywords = settings["seo.home_keywords"]?.trim()

      if (title) {
        document.title = title
        metaByProperty("og:title").setAttribute("content", title)
        metaByName("twitter:title").setAttribute("content", title)
      }

      if (desc) {
        metaByName("description").setAttribute("content", desc)
        metaByProperty("og:description").setAttribute("content", desc)
        metaByName("twitter:description").setAttribute("content", desc)
      }

      if (keywords) {
        metaByName("keywords").setAttribute("content", keywords)
      }

      let ogImage = settings["seo.og_image"]?.trim()
      if (ogImage) {
        if (ogImage.startsWith("/")) {
          ogImage = `${window.location.origin}${ogImage}`
        }
        metaByProperty("og:image").setAttribute("content", ogImage)
        metaByName("twitter:image").setAttribute("content", ogImage)
      }
    }

    const ga = settings["seo.google_analytics"]?.trim()
    if (ga?.startsWith("G-") && !document.getElementById("script-ga4")) {
      const loader = document.createElement("script")
      loader.id = "script-ga4-loader"
      loader.async = true
      loader.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(ga)}`
      document.head.appendChild(loader)

      const inline = document.createElement("script")
      inline.id = "script-ga4"
      const idJson = JSON.stringify(ga)
      inline.textContent = `
window.dataLayer = window.dataLayer || [];
function gtag(){window.dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', ${idJson});
`
      document.head.appendChild(inline)
    }

    const gtm = settings["seo.google_tag_manager"]?.trim()
    if (gtm?.startsWith("GTM-") && !document.getElementById("script-gtm")) {
      const inline = document.createElement("script")
      inline.id = "script-gtm"
      const idJson = JSON.stringify(gtm)
      inline.textContent = `
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer',${idJson});
`
      document.head.appendChild(inline)
    }
  }, [pathname, settings])

  return null
}
