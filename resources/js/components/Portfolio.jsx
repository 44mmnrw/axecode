import React, { useState } from 'react';

function ExternalLinkIcon(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M14 4h6v6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M10 14L20 4" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M20 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1h5" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

const projects = [
  {
    accent: 'from-cyan-500/30 to-blue-600/20',
    category: 'Веб-разработка',
    title: 'Корпоративный сайт TechCorp',
    description: 'Современный корпоративный сайт с адаптивным дизайном и интеграцией CMS',
    tags: ['React', 'Next.js', 'CMS']
  },
  {
    accent: 'from-purple-500/30 to-pink-600/20',
    category: 'Мобильная разработка',
    title: 'Мобильное приложение FitTracker',
    description: 'iOS и Android приложение для отслеживания фитнес-активности',
    tags: ['React Native', 'Firebase', 'UI/UX']
  },
  {
    accent: 'from-emerald-500/25 to-cyan-500/15',
    category: 'Веб-разработка',
    title: 'E-commerce платформа ShopFlow',
    description: 'Масштабируемая платформа для онлайн-торговли с системой платежей',
    tags: ['Node.js', 'PostgreSQL', 'Stripe']
  },
  {
    accent: 'from-fuchsia-500/25 to-purple-600/15',
    category: 'Веб-приложение',
    title: 'Аналитическая панель DataViz',
    description: 'Интерактивный дашборд для визуализации бизнес-данных',
    tags: ['React', 'D3.js', 'TypeScript']
  },
  {
    accent: 'from-orange-500/25 to-red-600/15',
    category: 'Мобильная разработка',
    title: 'Финтех приложение PayFlow',
    description: 'Безопасное приложение для управления финансами и переводов',
    tags: ['Flutter', 'Blockchain', 'Security']
  },
  {
    accent: 'from-sky-500/25 to-indigo-600/15',
    category: 'Веб-приложение',
    title: 'Социальная сеть ConnectHub',
    description: 'Платформа для общения и обмена контентом в реальном времени',
    tags: ['Vue.js', 'WebSocket', 'MongoDB']
  }
];

const filterOptions = ['Все проекты', 'Веб-разработка', 'Мобильная разработка', 'Веб-приложение'];

export default function Portfolio() {
  const [activeFilter, setActiveFilter] = useState('Все проекты');

  const filteredProjects = activeFilter === 'Все проекты'
    ? projects
    : projects.filter(p => p.category === activeFilter);

  return (
    <section id="portfolio" className="relative py-32 bg-[#020618] overflow-hidden">
      {/* Decorative blurs */}
      <div className="absolute right-0 top-0 w-96 h-96 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full blur-3xl opacity-10" />
      <div className="absolute left-1/4 bottom-0 w-96 h-96 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full blur-3xl opacity-10" />

      <div className="relative z-10 max-w-6xl mx-auto px-6">
        {/* Header */}
        <div className="text-center mb-16">
          <h2 className="text-xl bg-gradient-to-r from-cyan-300 to-purple-400 bg-clip-text text-transparent mb-4">
            Портфолио
          </h2>
          <p className="text-gray-400 text-lg">Наши лучшие проекты, которыми мы гордимся</p>
        </div>

        {/* Filter buttons */}
        <div className="flex flex-wrap justify-center gap-4 mb-16">
          {filterOptions.map((option) => (
            <button
              key={option}
              onClick={() => setActiveFilter(option)}
              className={`px-6 py-2.5 rounded-full font-semibold transition-all duration-300 ${
                activeFilter === option
                  ? 'bg-gradient-to-r from-cyan-400 to-purple-600 text-white shadow-lg shadow-cyan-500/30'
                  : 'bg-[rgba(15,23,43,0.5)] border border-gray-700 text-gray-300 hover:border-gray-500'
              }`}
            >
              {option}
            </button>
          ))}
        </div>

        {/* Projects Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredProjects.map((project, i) => (
            <div
              key={i}
              className="bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl overflow-hidden hover:border-cyan-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-cyan-500/20 group"
            >
              {/* Image */}
              <div className="relative overflow-hidden h-48 bg-gray-900">
                <div className={`absolute inset-0 bg-gradient-to-br ${project.accent}`} />
                <div className="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.12)_0%,rgba(255,255,255,0)_60%)]" />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
                <div className="absolute bottom-4 left-4">
                  <div className="rounded-full border border-white/10 bg-black/30 px-3 py-1 text-xs text-white/80 backdrop-blur-sm">
                    Превью
                  </div>
                </div>
                <div className="absolute top-4 right-4 rounded-lg bg-black/60 p-2 backdrop-blur-sm">
                  <ExternalLinkIcon className="h-5 w-5 text-white/90" />
                </div>
              </div>

              {/* Content */}
              <div className="p-6">
                {/* Category */}
                <span className="text-xs text-cyan-400 font-semibold uppercase">
                  {project.category}
                </span>

                {/* Title */}
                <h3 className="text-lg font-semibold text-white mt-2 mb-2">
                  {project.title}
                </h3>

                {/* Description */}
                <p className="text-gray-400 text-sm mb-4 leading-relaxed">
                  {project.description}
                </p>

                {/* Tags */}
                <div className="flex flex-wrap gap-2 mb-4">
                  {project.tags.map((tag, j) => (
                    <span
                      key={j}
                      className="text-xs bg-[rgba(29,41,61,0.5)] border border-gray-700 text-gray-400 px-3 py-1 rounded-full"
                    >
                      {tag}
                    </span>
                  ))}
                </div>

                {/* Link */}
                <a
                  href="#"
                  className="text-cyan-400 hover:text-cyan-300 font-semibold text-sm flex items-center gap-2 transition-colors"
                >
                  Посмотреть проект
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>
          ))}
        </div>

        {/* CTA */}
        <div className="text-center mt-20">
          <p className="text-gray-400 mb-6">
            Хотите увидеть больше проектов или обсудить вашу идею?
          </p>
          <button className="bg-gradient-to-r from-cyan-400 to-purple-600 hover:from-cyan-300 hover:to-purple-500 text-white font-semibold py-3 px-8 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl">
            Связаться с нами
          </button>
        </div>
      </div>
    </section>
  );
}
