import Nav from '@/components/Nav'
import HeroSection from '@/components/HeroSection'
import ProofBar from '@/components/ProofBar'
import RealitySection from '@/components/RealitySection'
import SystemSection from '@/components/SystemSection'
import ExclusivitySection from '@/components/ExclusivitySection'
import ProofSection from '@/components/ProofSection'
import Testimonials from '@/components/Testimonials'
import PricingSection from '@/components/PricingSection'
import FAQSection from '@/components/FAQSection'
import CTASection from '@/components/CTASection'
import Footer from '@/components/Footer'
import StickyCTA from '@/components/StickyCTA'

export default function Home() {
  return (
    <>
      <Nav />
      <main>
        <HeroSection />
        <ProofBar />
        <RealitySection />
        <SystemSection />
        <ExclusivitySection />
        <ProofSection />
        <Testimonials />
        <PricingSection />
        <FAQSection />
        <CTASection />
      </main>
      <Footer />
      <StickyCTA />
    </>
  )
}
