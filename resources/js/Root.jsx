import React from 'react';
import Navigation from './components/Navigation';
import Hero from './components/Hero';
import Services from './components/Services';
// import Portfolio from './components/Portfolio';
import About from './components/About';
import Contact from './components/Contact';

export default function Root() {
  return (
    <div className="min-h-screen bg-[#020618] text-white">
      <Navigation />
      <main>
        <Hero />
        <Services />
        {/* <Portfolio /> */}
        <About />
        <Contact />
      </main>
    </div>
  );
}
