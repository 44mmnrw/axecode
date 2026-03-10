import React from 'react';

function IconSpark(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M4.5 16.5001C3 17.7601 2.5 21.5001 2.5 21.5001C2.5 21.5001 6.24 21.0001 7.5 19.5001C8.21 18.6601 8.2 17.3701 7.41 16.5901C7.02131 16.2191 6.50929 16.0047 5.97223 15.9881C5.43516 15.9715 4.91088 16.1538 4.5 16.5001Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M12 15L9 12C9.53214 10.6194 10.2022 9.29607 11 8.05C12.1652 6.18699 13.7876 4.65305 15.713 3.5941C17.6384 2.53514 19.8027 1.98637 22 2C22 4.72 21.22 9.5 16 13C14.7369 13.7987 13.3968 14.4687 12 15Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M9 12H4C4 12 4.55 8.97002 6 8.00002C7.62 6.92002 11 8.00002 11 8.00002" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M12 15V20C12 20 15.03 19.45 16 18C17.08 16.38 16 13 16 13" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

function IconUsers(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M16 21V19C16 17.9391 15.5786 16.9217 14.8284 16.1716C14.0783 15.4214 13.0609 15 12 15H6C4.93913 15 3.92172 15.4214 3.17157 16.1716C2.42143 16.9217 2 17.9391 2 19V21" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M16 3.12793C16.8578 3.3503 17.6174 3.85119 18.1597 4.55199C18.702 5.25279 18.9962 6.11382 18.9962 6.99993C18.9962 7.88604 18.702 8.74707 18.1597 9.44787C17.6174 10.1487 16.8578 10.6496 16 10.8719" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M22 20.9999V18.9999C21.9993 18.1136 21.7044 17.2527 21.1614 16.5522C20.6184 15.8517 19.8581 15.3515 19 15.1299" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
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
      <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

export default function About() {
  const values = [
    { Icon: IconSpark, title: 'Технологичность', description: 'Подбираем современные решения под конкретные задачи, а не «ради моды»' },
    { Icon: IconUsers, title: 'Сильная команда', description: 'Над проектом работает связка специалистов: аналитика, дизайн, разработка и QA' },
    { Icon: IconShield, title: 'Надёжность', description: 'Следим за качеством кода, стабильностью и предсказуемостью релизов' },
    { Icon: IconTarget, title: 'Бизнес-фокус', description: 'Оцениваем успех не по «красоте», а по влиянию на ваши KPI и рост продукта' }
  ];

  const process = [
    { number: '01', title: 'Бриф и анализ', description: 'Фиксируем цели, ограничения и критерии успеха' },
    { number: '02', title: 'Проектирование', description: 'Продумываем UX, архитектуру и сценарии пользователей' },
    { number: '03', title: 'Разработка', description: 'Реализуем функционал, интеграции и админ-инструменты' },
    { number: '04', title: 'Запуск и развитие', description: 'Выводим продукт в прод и сопровождаем дальнейший рост' }
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
                Мы помогаем компаниям запускать и развивать цифровые продукты: сайты, веб-сервисы и мобильные приложения. Работаем как технологический партнёр и берём ответственность за результат.
              </p>
            </div>

            <p className="text-gray-400 leading-relaxed">
              Наш подход сочетает продуктовую экспертизу, понятную коммуникацию и инженерную дисциплину — поэтому вы получаете не просто красивый интерфейс, а рабочий инструмент для роста бизнеса.
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
            <h2 className="text-2xl font-bold text-white">Как мы ведём проект</h2>
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
