import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';
import Root from './Root';

function mount() {
  const rootElement = document.getElementById('app');

  if (!rootElement) {
    console.error('React root element #app not found');
    return;
  }

  ReactDOM.createRoot(rootElement).render(
    <React.StrictMode>
      <Root />
    </React.StrictMode>
  );
}

// module scripts обычно defer, но на всякий случай
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mount);
} else {
  mount();
}
