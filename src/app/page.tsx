"use client";

import { useState } from "react";
import Nav from "@/components/Nav";
import CityCheckerModal from "@/components/CityCheckerModal";
import Hero from "@/components/sections/Hero";
import Problem from "@/components/sections/Problem";
import Solution from "@/components/sections/Solution";
import HowItWorks from "@/components/sections/HowItWorks";
import Exclusivity from "@/components/sections/Exclusivity";
import ClosedCities from "@/components/sections/ClosedCities";
import Pricing from "@/components/sections/Pricing";
import Testimonials from "@/components/sections/Testimonials";
import FAQ from "@/components/sections/FAQ";
import FinalCTA from "@/components/sections/FinalCTA";
import Footer from "@/components/Footer";

export default function Home() {
  const [modalOpen, setModalOpen] = useState(false);
  const openModal = () => setModalOpen(true);
  const closeModal = () => setModalOpen(false);

  return (
    <>
      <CityCheckerModal open={modalOpen} onClose={closeModal} />
      <Nav onCTA={openModal} />
      <main>
        <Hero onCTA={openModal} />
        <Problem />
        <Solution />
        <HowItWorks />
        <Exclusivity />
        <ClosedCities onCTA={openModal} />
        <Pricing onCTA={openModal} />
        <Testimonials />
        <FAQ />
        <FinalCTA onCTA={openModal} />
      </main>
      <Footer />
    </>
  );
}
