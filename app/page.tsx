import Hero from '@/components/sections/Hero'
import SocialProofBar from '@/components/sections/SocialProofBar'
import Problem from '@/components/sections/Problem'
import System from '@/components/sections/System'
import Proof from '@/components/sections/Proof'
import Pricing from '@/components/sections/Pricing'
import Exclusivity from '@/components/sections/Exclusivity'
import FAQ from '@/components/sections/FAQ'
import FinalCTA from '@/components/sections/FinalCTA'

export default function Home() {
  return (
    <>
      <Hero />
      <SocialProofBar />
      <Problem />
      <System />
      <Proof />
      <Pricing />
      <Exclusivity />
      <FAQ />
      <FinalCTA />
    </>
  )
}
