import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';
import Root from './Root';

function mount() {
  const rootElement = document.getElementById('app');
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
    console.error('React root element #app not found');
    return;
  }

  ReactDOM.createRoot(rootElement).render(
    <React.StrictMode>
      <Root content={landingContent} />
    </React.StrictMode>
  );
}

// module scripts обычно defer, но на всякий случай
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mount);
} else {
  mount();
}
