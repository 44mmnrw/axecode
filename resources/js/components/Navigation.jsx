import React from 'react';
import Logo from './Logo';

const navLinks = [
  { label: 'Главная', href: '#home' },
  { label: 'Блог', href: '/blog' },
  { label: 'Услуги', href: '#services' },
  { label: 'Портфолио', href: '#portfolio' },
  { label: 'О нас', href: '#about' },
  { label: 'FAQ', href: '#faq' },
  { label: 'Контакты', href: '#contact' },
];

export default function Navigation() {
  const resolveHref = (href) => {
    if (!href.startsWith('#')) {
      return href;
    }

    if (typeof document !== 'undefined' && document.getElementById(href.slice(1))) {
      return href;
    }

    return `/${href}`;
  };

  const logoHref = (typeof document !== 'undefined' && document.getElementById('home')) ? '#home' : '/';

  return (
    <nav
      className="fixed inset-x-0 top-0 z-50 h-20 border-b border-white/5 bg-[rgba(2,6,24,0.75)] backdrop-blur-md"
      aria-label="Основная навигация"
    >
      <div className="mx-auto flex h-full w-full max-w-6xl items-center justify-between px-6 lg:px-10">
        {/* Logo */}
        <a href={logoHref}>
          <Logo />
        </a>

        {/* Navigation Links */}
        <div className="hidden items-center gap-10 md:flex">
          {navLinks.map((item) => (
            <a
              key={item.href}
              href={resolveHref(item.href)}
              className="relative text-sm font-medium text-[#cad5e2] transition-colors duration-200 hover:text-white"
            >
              <span className="relative group">
                {item.label}
                <span className="absolute -bottom-2 left-0 h-0.5 w-0 bg-gradient-to-r from-[#00d3f2] to-purple-400 transition-all duration-300 group-hover:w-full" />
              </span>
            </a>
          ))}
        </div>
      </div>
    </nav>
  );
}
