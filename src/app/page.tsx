import Navigation from '@/components/Navigation'
import Hero from '@/components/Hero'
import StatsBar from '@/components/StatsBar'
import ProblemSection from '@/components/ProblemSection'
import SolutionSection from '@/components/SolutionSection'
import HowItWorks from '@/components/HowItWorks'
import PricingSection from '@/components/PricingSection'
import FAQSection from '@/components/FAQSection'
import FinalCTA from '@/components/FinalCTA'
import Footer from '@/components/Footer'

export default function Home() {
  return (
    <>
      <Navigation />
      <main>
        <Hero />
        <StatsBar />
        <ProblemSection />
        <SolutionSection />
        <HowItWorks />
        <PricingSection />
        <FAQSection />
        <FinalCTA />
      </main>
      <Footer />
    </>
  )
}
