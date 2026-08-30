import Nav from '@/components/Nav'
import UrgencyBar from '@/components/UrgencyBar'
import HeroSection from '@/components/HeroSection'
import HowItWorksSection from '@/components/HowItWorksSection'
import RealitySection from '@/components/RealitySection'
import SystemSection from '@/components/SystemSection'
import ExclusivitySection from '@/components/ExclusivitySection'
import ProofSection from '@/components/ProofSection'
import PricingSection from '@/components/PricingSection'
import FAQSection from '@/components/FAQSection'
import CTASection from '@/components/CTASection'
import Footer from '@/components/Footer'
import StickyMobileCTA from '@/components/StickyMobileCTA'

export default function Home() {
  return (
    <>
      <Nav />
      <UrgencyBar />
      <main>
        <HeroSection />
        <HowItWorksSection />
        <RealitySection />
        <SystemSection />
        <ExclusivitySection />
        <ProofSection />
        <PricingSection />
        <FAQSection />
        <CTASection />
      </main>
      <Footer />
      <StickyMobileCTA />
    </>
  )
}
