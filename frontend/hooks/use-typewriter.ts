"use client"

import { useCallback, useEffect, useState } from "react"

interface UseTypewriterOptions {
  speed?: number
  keepCursor?: boolean
}

export function useTypewriter(text: string, { speed = 80, keepCursor = false }: UseTypewriterOptions = {}) {
  const [started, setStarted] = useState(false)
  const [displayed, setDisplayed] = useState("")
  const [done, setDone] = useState(false)
  const [cursorVisible, setCursorVisible] = useState(true)

  const triggerRef = useCallback((node: Element | null) => {
    if (!node) return
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setStarted(true)
          observer.disconnect()
        }
      },
      { threshold: 0.1 }
    )
    observer.observe(node)
  }, [])

  useEffect(() => {
    if (!started) return
    setDisplayed("")
    setDone(false)
    let i = 0
    const interval = setInterval(() => {
      i++
      setDisplayed(text.slice(0, i))
      if (i >= text.length) {
        clearInterval(interval)
        setDone(true)
      }
    }, speed)
    return () => clearInterval(interval)
  }, [started, text, speed])

  useEffect(() => {
    if (done && !keepCursor) return
    const blink = setInterval(() => setCursorVisible(v => !v), 530)
    return () => clearInterval(blink)
  }, [done, keepCursor])

  return {
    displayed,
    cursorVisible: done && !keepCursor ? false : cursorVisible,
    triggerRef,
  }
}
