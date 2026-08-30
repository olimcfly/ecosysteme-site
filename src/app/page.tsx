import Nav from '@/components/Nav';
import Hero from '@/components/Hero';
import Problem from '@/components/Problem';
import System from '@/components/System';
import Proof from '@/components/Proof';
import Pricing from '@/components/Pricing';
import CityChecker from '@/components/CityChecker';
import FAQ from '@/components/FAQ';
import FinalCTA from '@/components/FinalCTA';
import Footer from '@/components/Footer';

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
        <CityChecker />
        <FAQ />
        <FinalCTA />
      </main>
      <Footer />
    </>
  );
}
