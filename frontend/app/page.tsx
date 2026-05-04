import { Navbar } from "@/components/navbar"
import { HeroSection } from "@/components/hero-section"
import { TechStack } from "@/components/tech-stack"
import { ExperienceSection } from "@/components/experience-section"
import { DifferentialsSection } from "@/components/differentials-section"
import { EducationSection } from "@/components/education-section"
import { ProjectsSection } from "@/components/projects-section"
import { ContactSection } from "@/components/contact-section"
import { Footer } from "@/components/footer"
import { WhatsAppButton } from "@/components/whatsapp-button"

export default function Home() {
  return (
    <main className="min-h-screen bg-background">
      <Navbar />
      <HeroSection />
      <TechStack />
      <ExperienceSection />
      <DifferentialsSection />
      <EducationSection />
      <ProjectsSection />
      <ContactSection />
      <Footer />
      <WhatsAppButton />
    </main>
  )
}
