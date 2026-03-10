import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';
import Navigation from './components/Navigation';
import Services from './components/Services';
import Portfolio from './components/Portfolio';
import About from './components/About';
import SeoFaq from './components/SeoFaq';
import Contact from './components/Contact';

function mount() {
  const rootElement = document.getElementById('landing-sections-root');
  const payloadEl = document.getElementById('landing-content-data');

  let landingContent = {};
  if (payloadEl?.textContent) {
    try {
      landingContent = JSON.parse(payloadEl.textContent);
    } catch (error) {
      console.error('Failed to parse landing content payload', error);
    }
  }

  if (!rootElement) {
    console.error('React root element #landing-sections-root not found');
    return;
  }

  ReactDOM.createRoot(rootElement).render(
    <React.StrictMode>
      <div className="min-h-screen bg-[#020618] text-white">
        <Navigation />
        <Services content={landingContent?.services ?? null} />
        <Portfolio />
        <About />
        <SeoFaq content={landingContent?.faq ?? null} />
        <Contact />
      </div>
    </React.StrictMode>
  );
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mount);
} else {
  mount();
}