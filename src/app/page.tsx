import Nav from '@/components/Nav'
import Hero from '@/components/Hero'
import ProofStrip from '@/components/ProofStrip'
import Problem from '@/components/Problem'
import Solution from '@/components/Solution'
import Exclusivity from '@/components/Exclusivity'
import Features from '@/components/Features'
import Pricing from '@/components/Pricing'
import FAQ from '@/components/FAQ'
import FinalCTA from '@/components/FinalCTA'
import Footer from '@/components/Footer'

export default function Home() {
  return (
    <main>
      <Nav />
      <Hero />
      <ProofStrip />
      <Problem />
      <Solution />
      <Exclusivity />
      <Features />
      <Pricing />
      <FAQ />
      <FinalCTA />
      <Footer />
    </main>
  )
}
