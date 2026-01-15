import React from 'react';

const navLinks = [
  { label: 'Главная', href: '#home' },
  { label: 'Услуги', href: '#services' },
  // { label: 'Портфолио', href: '#portfolio' },
  { label: 'О нас', href: '#about' },
  { label: 'Контакты', href: '#contact' },
];

export default function Navigation() {
  return (
    <nav
      className="fixed inset-x-0 top-0 z-50 h-20 border-b border-white/5 bg-[rgba(2,6,24,0.75)] backdrop-blur-md"
      aria-label="Основная навигация"
    >
      <div className="mx-auto flex h-full w-full max-w-6xl items-center justify-between px-6 lg:px-10">
        {/* Logo */}
        <a href="#home" className="text-lg font-bold tracking-tight">
          <span className="bg-gradient-to-r from-[#00d3f2] via-purple-400 to-pink-400 bg-clip-text text-transparent">
            Axecode
          </span>
        </a>

        {/* Navigation Links */}
        <div className="hidden items-center gap-10 md:flex">
          {navLinks.map((item) => (
            <a
              key={item.href}
              href={item.href}
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
