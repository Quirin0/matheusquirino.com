import React from "react"
import type { Metadata, Viewport } from 'next'
import { Analytics } from '@vercel/analytics/next'
import { Toaster } from '@/components/ui/toaster'
import { SiteMeta } from '@/components/site-meta'
import './globals.css'

export const metadata: Metadata = {
  title: 'Dev Portfolio | Desenvolvedor Fullstack Júnior',
  description: 'Portfolio de desenvolvedor fullstack júnior especializado em PHP, Laravel, React, MySQL e tecnologias web modernas.',
  generator: 'v0.app',
  icons: {
    icon: [
      {
        url: '/icon-light-32x32.png',
        media: '(prefers-color-scheme: light)',
      },
      {
        url: '/icon-dark-32x32.png',
        media: '(prefers-color-scheme: dark)',
      },
      {
        url: '/icon.svg',
        type: 'image/svg+xml',
      },
    ],
    apple: '/apple-icon.png',
  },
}

export const viewport: Viewport = {
  themeColor: '#1a1a2e',
  width: 'device-width',
  initialScale: 1,
}

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode
}>) {
  return (
    <html lang="pt-BR" className="scroll-smooth">
      <body className={`font-sans antialiased bg-background text-foreground`}>
        <SiteMeta />
        {children}
        <Toaster />
        <Analytics />
      </body>
    </html>
  )
}
