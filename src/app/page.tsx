import { Navigation } from "@/components/Navigation";
import { Hero } from "@/components/Hero";
import { ClosedCitiesBar } from "@/components/ClosedCitiesBar";
import { Problem } from "@/components/Problem";
import { HowItWorks } from "@/components/HowItWorks";
import { Features } from "@/components/Features";
import { Exclusivity } from "@/components/Exclusivity";
import { Pricing } from "@/components/Pricing";
import { FAQ } from "@/components/FAQ";
import { FinalCTA } from "@/components/FinalCTA";
import { Footer } from "@/components/Footer";

export default function Home() {
  return (
    <>
      <Navigation />
      <main>
        <Hero />
        <ClosedCitiesBar />
        <Problem />
        <HowItWorks />
        <Features />
        <Exclusivity />
        <Pricing />
        <FAQ />
        <FinalCTA />
      </main>
      <Footer />
    </>
  );
}
