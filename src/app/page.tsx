import Navigation from "@/components/Navigation";
import Hero from "@/components/Hero";
import ScarcityBar from "@/components/ScarcityBar";
import ProblemSection from "@/components/ProblemSection";
import SystemSection from "@/components/SystemSection";
import HowItWorks from "@/components/HowItWorks";
import Pricing from "@/components/Pricing";
import Testimonials from "@/components/Testimonials";
import FAQ from "@/components/FAQ";
import CityChecker from "@/components/CityChecker";
import Footer from "@/components/Footer";

export default function Home() {
  return (
    <main>
      <Navigation />
      <Hero />
      <ScarcityBar />
      <ProblemSection />
      <SystemSection />
      <HowItWorks />
      <Pricing />
      <Testimonials />
      <FAQ />
      <CityChecker />
      <Footer />
    </main>
  );
}
