import React from 'react';

function IconCode(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M9 9l-3 3 3 3" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M15 9l3 3-3 3" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M13 7l-2 10" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
    </svg>
  );
}

function IconMobile(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M9 3h6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <rect x="7" y="3" width="10" height="18" rx="2" stroke="currentColor" strokeWidth="2" />
      <path d="M12 17h.01" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
    </svg>
  );
}

function IconPalette(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path
        d="M12 3c-5 0-9 3.58-9 8 0 3.31 2.69 6 6 6h1a2 2 0 012 2 2 2 0 002 2c4.42 0 8-3.58 8-8 0-5-4-10-10-10z"
        stroke="currentColor"
        strokeWidth="2"
        strokeLinejoin="round"
      />
      <path d="M7.5 10.5h.01" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
      <path d="M10.5 8.5h.01" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
      <path d="M13.8 8.8h.01" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
      <path d="M16.5 11h.01" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
    </svg>
  );
}

function IconPuzzle(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path
        d="M10 4a2 2 0 114 0v2h2a2 2 0 110 4h-2v2h2a2 2 0 110 4h-2v2a2 2 0 11-4 0v-2H8a2 2 0 110-4h2v-2H8a2 2 0 110-4h2V4z"
        stroke="currentColor"
        strokeWidth="2"
        strokeLinejoin="round"
      />
    </svg>
  );
}

function IconSpeed(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M12 20a8 8 0 100-16 8 8 0 000 16z" stroke="currentColor" strokeWidth="2" />
      <path d="M12 12l4-2" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <path d="M12 12v4" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
    </svg>
  );
}

function IconSupport(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M4 12a8 8 0 0116 0v5a2 2 0 01-2 2h-2" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <path d="M6 12v2a2 2 0 01-2 2H3v-4h3z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
      <path d="M18 12v2a2 2 0 002 2h1v-4h-3z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
      <path d="M12 18h.01" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
    </svg>
  );
}

const services = [
  {
    Icon: IconCode,
    title: 'Веб-разработка',
    description: 'Создаём современные и производительные веб-сайты с адаптивным дизайном и интуитивным интерфейсом.',
    gradient: 'from-cyan-400 to-blue-600'
  },
  {
    Icon: IconMobile,
    title: 'Мобильные приложения',
    description: 'Разрабатываем нативные и кроссплатформенные приложения для iOS и Android с безупречным UX.',
    gradient: 'from-purple-400 to-pink-600'
  },
  {
    Icon: IconPalette,
    title: 'UI/UX Дизайн',
    description: 'Проектируем пользовательские интерфейсы, которые сочетают эстетику с функциональностью.',
    gradient: 'from-pink-400 to-red-600'
  },
  {
    Icon: IconPuzzle,
    title: 'Кастомные решения',
    description: 'Создаём индивидуальные программные решения под уникальные задачи вашего бизнеса.',
    gradient: 'from-indigo-400 to-purple-600'
  },
  {
    Icon: IconSpeed,
    title: 'Оптимизация',
    description: 'Повышаем производительность существующих приложений и сайтов для лучшего пользовательского опыта.',
    gradient: 'from-yellow-400 to-orange-600'
  },
  {
    Icon: IconSupport,
    title: 'Техподдержка',
    description: 'Обеспечиваем надёжную поддержку и обслуживание ваших цифровых продуктов 24/7.',
    gradient: 'from-teal-400 to-cyan-600'
  }
];

export default function Services() {
  return (
    <section id="services" className="relative py-32 bg-[#020618] overflow-hidden">
      {/* Decorative blurs */}
      <div className="absolute left-0 top-1/3 w-96 h-96 bg-gradient-to-r from-purple-500 to-red-500 rounded-full blur-3xl opacity-10" />
      <div className="absolute right-0 bottom-0 w-96 h-96 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full blur-3xl opacity-10" />

      <div className="relative z-10 max-w-6xl mx-auto px-6">
        {/* Header */}
        <div className="text-center mb-20">
          <h2 className="text-xl bg-gradient-to-r from-cyan-300 to-purple-400 bg-clip-text text-transparent mb-4">
            Наши услуги
          </h2>
          <p className="text-gray-400 text-lg">Комплексные решения для вашего цифрового успеха</p>
        </div>

        {/* Services Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {services.map(({ Icon, title, description, gradient }) => (
            <div
              key={title}
              className="group bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl p-8 hover:border-cyan-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-cyan-500/20"
            >
              {/* Icon */}
              <div className={`w-12 h-12 rounded-lg bg-gradient-to-br ${gradient} p-3 mb-6`}>
                <Icon className="h-full w-full text-white" />
              </div>

              {/* Title */}
              <h3 className="text-xl font-semibold mb-4 text-white">{title}</h3>

              {/* Description */}
              <p className="text-gray-400 mb-6 leading-relaxed">{description}</p>

              {/* Accent line */}
              <div className="h-1 w-0 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 transition-all duration-500 group-hover:w-full" />
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
