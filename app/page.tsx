'use client'
import { useState } from 'react'
import Nav from '@/components/Nav'
import Hero from '@/components/Hero'
import ProofBar from '@/components/ProofBar'
import Problem from '@/components/Problem'
import Solution from '@/components/Solution'
import Exclusivity from '@/components/Exclusivity'
import Pricing from '@/components/Pricing'
import FAQ from '@/components/FAQ'
import FinalCTA from '@/components/FinalCTA'
import Footer from '@/components/Footer'
import CityModal from '@/components/CityModal'
import StickyMobileCTA from '@/components/StickyMobileCTA'

export default function Home() {
  const [modalOpen, setModalOpen] = useState(false)

  return (
    <>
      <Nav onOpenModal={() => setModalOpen(true)} />

      <main>
        <Hero onOpenModal={() => setModalOpen(true)} />
        <ProofBar />
        <Problem />
        <Solution />
        <Exclusivity />
        <Pricing onOpenModal={() => setModalOpen(true)} />
        <FAQ />
        <FinalCTA onOpenModal={() => setModalOpen(true)} />
      </main>

      <Footer />

      <CityModal open={modalOpen} onClose={() => setModalOpen(false)} />
      <StickyMobileCTA onOpenModal={() => setModalOpen(true)} />
    </>
  )
}
