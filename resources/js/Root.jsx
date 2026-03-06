import React from 'react';
import Navigation from './components/Navigation';
import Hero from './components/Hero';
import Services from './components/Services';
import Portfolio from './components/Portfolio';
import About from './components/About';
import SeoFaq from './components/SeoFaq';
import Contact from './components/Contact';

export default function Root({ content = {} }) {
  const heroContent = content?.hero ?? null;
  const servicesContent = content?.services ?? null;
  const faqContent = content?.faq ?? null;

  return (
    <div className="min-h-screen bg-[#020618] text-white">
      <Navigation />
      <main>
        <Hero content={heroContent} />
        <Services content={servicesContent} />
        <Portfolio />
        <About />
        <SeoFaq content={faqContent} />
        <Contact />
      </main>
    </div>
  );
}
