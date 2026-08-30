import Nav from '@/components/Nav'
import Hero from '@/components/Hero'
import Problem from '@/components/Problem'
import System from '@/components/System'
import Proof from '@/components/Proof'
import Pricing from '@/components/Pricing'
import Footer from '@/components/Footer'

export default function Home() {
  return (
    <>
      <Nav />
      <main>
        <Hero />
        <Problem />
        <System />
        <Proof />
        <Pricing />
      </main>
      <Footer />
    </>
  )
}
