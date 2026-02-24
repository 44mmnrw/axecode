import React from 'react';

function IconSpark(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M12 2l1.2 4.8L18 8l-4.8 1.2L12 14l-1.2-4.8L6 8l4.8-1.2L12 2z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
      <path d="M19 13l.7 2.8 2.3.7-2.3.7L19 20l-.7-2.8-2.3-.7 2.3-.7L19 13z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
    </svg>
  );
}

function IconUsers(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M16 11a4 4 0 10-8 0 4 4 0 008 0z" stroke="currentColor" strokeWidth="2" />
      <path d="M4 20a8 8 0 0116 0" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <path d="M18 8a3 3 0 10-6 0" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
    </svg>
  );
}

function IconShield(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
      <path d="M9 12l2 2 4-5" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

function IconTarget(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M12 21a9 9 0 109-9" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <path d="M12 17a5 5 0 105-5" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <path d="M12 13a1 1 0 101-1" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
      <path d="M14 6l6-2-2 6" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
      <path d="M20 4l-8 8" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
    </svg>
  );
}

export default function About() {
  const values = [
    { Icon: IconSpark, title: 'Инновации', description: 'Используем новейшие технологии и подходы для создания передовых решений' },
    { Icon: IconUsers, title: 'Команда экспертов', description: 'Опытные специалисты с глубокими знаниями в разработке и дизайне' },
    { Icon: IconShield, title: 'Качество', description: 'Гарантируем высокое качество кода и безупречную работу продуктов' },
    { Icon: IconTarget, title: 'Результат', description: 'Фокусируемся на достижении бизнес-целей наших клиентов' }
  ];

  const process = [
    { number: '01', title: 'Анализ', description: 'Изучаем ваши цели и требования' },
    { number: '02', title: 'Проектирование', description: 'Создаём прототипы и дизайн' },
    { number: '03', title: 'Разработка', description: 'Реализуем проект с нуля' },
    { number: '04', title: 'Запуск', description: 'Тестируем и запускаем продукт' }
  ];

  const techBadges = [
    {
      label: 'React & Next.js',
      className:
        'bg-[linear-gradient(167deg,rgba(0,184,219,0.10),rgba(173,70,255,0.10))] border-[rgba(0,184,219,0.20)] text-[#00d3f2]',
    },
    {
      label: 'Node.js',
      className:
        'bg-[linear-gradient(167deg,rgba(173,70,255,0.10),rgba(246,51,154,0.10))] border-[rgba(173,70,255,0.20)] text-[#c27aff]',
    },
    {
      label: 'Mobile Dev',
      className:
        'bg-[linear-gradient(167deg,rgba(246,51,154,0.10),rgba(255,32,86,0.10))] border-[rgba(246,51,154,0.20)] text-[#fb64b6]',
    },
  ];

  return (
    <section id="about" className="relative py-32 bg-[#020618] overflow-hidden">
      <div className="relative z-10 max-w-6xl mx-auto px-6">
        {/* Main content */}
        <div className="grid lg:grid-cols-2 gap-12 mb-32">
          {/* Left side - Text */}
          <div className="space-y-8">
            <div>
              <h2 className="text-xl bg-gradient-to-r from-cyan-300 to-purple-400 bg-clip-text text-transparent mb-4">
                О нас
              </h2>
              <p className="text-gray-300 leading-relaxed">
                Мы — команда энтузиастов, создающих цифровые продукты мирового уровня. С момента основания мы помогли десяткам компаний реализовать их идеи и вывести бизнес на новый уровень.
              </p>
            </div>

            <p className="text-gray-400 leading-relaxed">
              Наш подход сочетает глубокое понимание бизнес-процессов с технической экспертизой, что позволяет создавать не просто красивые интерфейсы, а эффективные инструменты для роста вашего бизнеса.
            </p>

            {/* Tech badges */}
            <div className="flex flex-wrap gap-3">
              {techBadges.map((tech) => (
                <div
                  key={tech.label}
                  className={`rounded-full border px-6 py-2 text-sm font-semibold ${tech.className}`}
                >
                  {tech.label}
                </div>
              ))}
            </div>
          </div>

          {/* Right side - Values Grid */}
          <div className="grid grid-cols-2 gap-4">
            {values.map(({ Icon, title, description }) => (
              <div
                key={title}
                className="bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl p-6 hover:border-cyan-500/50 transition-all duration-300"
              >
                <div className="w-12 h-12 rounded-lg bg-gradient-to-br from-cyan-400/20 to-purple-400/20 p-3 mb-4">
                  <Icon className="h-full w-full text-white" />
                </div>
                <h3 className="font-semibold text-white mb-2">{title}</h3>
                <p className="text-gray-400 text-sm leading-relaxed">{description}</p>
              </div>
            ))}
          </div>
        </div>

        {/* Process section */}
        <div className="space-y-12">
          <div className="text-center">
            <h2 className="text-2xl font-bold text-white">Наш процесс работы</h2>
          </div>

          <div className="relative grid grid-cols-4 gap-6">
            {/* Single connector line from center of first to center of last circle */}
            <div className="absolute top-8 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-cyan-500/50 via-purple-500/50 to-purple-500/50" />

            {process.map((step, i) => (
              <div key={i} className="flex flex-col items-center">
                {/* Circle number */}
                <div className="relative z-10 w-16 h-16 rounded-full bg-gradient-to-br from-cyan-400 to-purple-600 flex items-center justify-center mb-4">
                  <span className="text-white font-bold text-lg">{step.number}</span>
                </div>

                {/* Title */}
                <h3 className="font-semibold text-white mb-2 text-center">{step.title}</h3>

                {/* Description */}
                <p className="text-gray-400 text-sm text-center">{step.description}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
