import React from 'react';
import HeroWavesCanvas from './HeroWavesCanvas';

function ArrowRightIcon(props) {
  return (
    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" {...props}>
      <path
        d="M11.25 4.5L16.75 10l-5.5 5.5"
        stroke="currentColor"
        strokeWidth="1.8"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
      <path
        d="M16.5 10H3.25"
        stroke="currentColor"
        strokeWidth="1.8"
        strokeLinecap="round"
      />
    </svg>
  );
}

function HeroWavesSvg() {
  // Fallback: SVG-волны, если WebGL недоступен.
  return (
    <div className="pointer-events-none absolute inset-x-0 bottom-0 z-0 h-[420px] overflow-hidden">
      <svg
        className="hero-waves-float h-full w-full opacity-95 [mix-blend-mode:screen]"
        viewBox="0 0 1440 420"
        preserveAspectRatio="none"
        aria-hidden="true"
      >
        <defs>
          <linearGradient id="waveGradient" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0%" stopColor="#53EAFD" stopOpacity="0.95" />
            <stop offset="50%" stopColor="#AD46FF" stopOpacity="0.95" />
            <stop offset="100%" stopColor="#F6339A" stopOpacity="0.95" />
          </linearGradient>

          <linearGradient id="waveGradientSoft" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0%" stopColor="#53EAFD" stopOpacity="0.55" />
            <stop offset="50%" stopColor="#AD46FF" stopOpacity="0.55" />
            <stop offset="100%" stopColor="#F6339A" stopOpacity="0.55" />
          </linearGradient>

          <filter id="waveGlow" x="-20%" y="-50%" width="140%" height="200%">
            <feGaussianBlur stdDeviation="5" result="blur" />
            <feMerge>
              <feMergeNode in="blur" />
              <feMergeNode in="SourceGraphic" />
            </feMerge>
          </filter>

          <radialGradient id="vortexCore" cx="50%" cy="50%" r="60%">
            <stop offset="0%" stopColor="#FFFFFF" stopOpacity="0.85" />
            <stop offset="35%" stopColor="#F7F0FF" stopOpacity="0.35" />
            <stop offset="100%" stopColor="#F6339A" stopOpacity="0" />
          </radialGradient>
        </defs>

        {/* Основные волны */}
        <g filter="url(#waveGlow)" fill="none" strokeLinecap="round" strokeLinejoin="round">
          <path
            d="M0,250 C120,160 240,340 360,250 C480,160 600,340 720,250 C840,160 960,340 1080,250 C1200,160 1320,340 1440,250"
            stroke="url(#waveGradient)"
            strokeWidth="6"
            opacity="0.90"
            strokeDasharray="34 22"
          >
            <animate attributeName="stroke-dashoffset" values="0;-280" dur="4.8s" repeatCount="indefinite" />
            <animate attributeName="opacity" values="0.78;0.95;0.78" dur="3.2s" repeatCount="indefinite" />
          </path>

          <path
            d="M0,265 C120,175 240,355 360,265 C480,175 600,355 720,265 C840,175 960,355 1080,265 C1200,175 1320,355 1440,265"
            stroke="url(#waveGradientSoft)"
            strokeWidth="4"
            opacity="0.85"
            strokeDasharray="26 18"
          >
            <animate attributeName="stroke-dashoffset" values="0;-240" dur="6.0s" repeatCount="indefinite" />
            <animate attributeName="opacity" values="0.62;0.88;0.62" dur="4.0s" repeatCount="indefinite" />
          </path>

          <path
            d="M0,235 C120,145 240,325 360,235 C480,145 600,325 720,235 C840,145 960,325 1080,235 C1200,145 1320,325 1440,235"
            stroke="url(#waveGradientSoft)"
            strokeWidth="3"
            opacity="0.70"
            strokeDasharray="20 16"
          >
            <animate attributeName="stroke-dashoffset" values="0;-200" dur="7.2s" repeatCount="indefinite" />
          </path>

          <path
            d="M0,295 C120,205 240,385 360,295 C480,205 600,385 720,295 C840,205 960,385 1080,295 C1200,205 1320,385 1440,295"
            stroke="url(#waveGradientSoft)"
            strokeWidth="2"
            opacity="0.55"
            strokeDasharray="18 18"
          >
            <animate attributeName="stroke-dashoffset" values="0;-180" dur="8.0s" repeatCount="indefinite" />
          </path>

          {/* Луч справа, который «втекает» в вращающиеся волны */}
          <g className="hero-beam-pulse">
            <path
              d="M860,250 C990,250 1100,250 1248,250"
              stroke="#F7F0FF"
              strokeWidth="10"
              opacity="0.55"
              strokeDasharray="30 22"
            >
              <animate attributeName="stroke-dashoffset" values="0;-220" dur="2.2s" repeatCount="indefinite" />
            </path>
            <path
              d="M940,250 C1070,250 1165,250 1248,250"
              stroke="#FFFFFF"
              strokeWidth="5"
              opacity="0.35"
              strokeDasharray="22 18"
            >
              <animate attributeName="stroke-dashoffset" values="0;-180" dur="1.7s" repeatCount="indefinite" />
            </path>
          </g>

          {/* Вихрь/вращающиеся волны справа */}
          <g transform="translate(1248 250)">
            <g>
              <animateTransform
                attributeName="transform"
                type="rotate"
                from="0 0 0"
                to="360 0 0"
                dur="6.5s"
                repeatCount="indefinite"
              />

              <circle
                cx="0"
                cy="0"
                r="58"
                stroke="url(#waveGradient)"
                strokeWidth="4"
                opacity="0.85"
                fill="none"
                strokeDasharray="14 10"
              >
                <animate attributeName="stroke-dashoffset" values="0;-160" dur="2.8s" repeatCount="indefinite" />
              </circle>
              <circle
                cx="0"
                cy="0"
                r="40"
                stroke="url(#waveGradientSoft)"
                strokeWidth="3"
                opacity="0.75"
                fill="none"
                strokeDasharray="10 12"
              >
                <animate attributeName="stroke-dashoffset" values="0;140" dur="2.4s" repeatCount="indefinite" />
              </circle>
              <circle
                cx="0"
                cy="0"
                r="24"
                stroke="#FFFFFF"
                strokeWidth="2"
                opacity="0.35"
                fill="none"
                strokeDasharray="6 10"
              >
                <animate attributeName="stroke-dashoffset" values="0;-120" dur="2.0s" repeatCount="indefinite" />
              </circle>

              <path
                d="M-46,-6 C-28,-26 -8,-30 12,-18 C28,-8 40,6 52,22"
                stroke="#F7F0FF"
                strokeWidth="3"
                opacity="0.30"
                fill="none"
                strokeDasharray="12 14"
              >
                <animate attributeName="stroke-dashoffset" values="0;-120" dur="2.1s" repeatCount="indefinite" />
              </path>
              <path
                d="M-54,10 C-36,28 -12,34 10,22 C28,12 44,-2 56,-18"
                stroke="#FFFFFF"
                strokeWidth="2"
                opacity="0.22"
                fill="none"
                strokeDasharray="10 16"
              >
                <animate attributeName="stroke-dashoffset" values="0;120" dur="2.6s" repeatCount="indefinite" />
              </path>
            </g>

            <circle cx="0" cy="0" r="52" fill="url(#vortexCore)" opacity="0.55" />
          </g>
        </g>

        {/* Лёгкая дымка под волнами */}
        <rect x="0" y="280" width="1440" height="160" fill="url(#waveGradientSoft)" opacity="0.08" />
      </svg>

      {/* Подсветка/фейд к низу */}
      <div className="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#020618] to-transparent" />
    </div>
  );
}

export default function Hero() {
  return (
    <section
      id="home"
      className="relative flex min-h-screen w-full flex-col items-center justify-center overflow-hidden bg-[#020618] pt-20"
    >
      {/* Background */}
      <div className="absolute inset-0 -z-10">
        <div className="absolute inset-0 bg-[radial-gradient(80%_50%_at_50%_0%,rgba(0,211,242,0.25)_0%,rgba(2,6,24,0)_70%)]" />
        <div className="absolute -top-40 left-1/2 h-[34rem] w-[34rem] -translate-x-1/2 rounded-full bg-purple-500/15 blur-3xl" />
        <div className="absolute -bottom-40 left-10 h-[28rem] w-[28rem] rounded-full bg-cyan-500/10 blur-3xl" />
        <div className="absolute -bottom-52 right-10 h-[30rem] w-[30rem] rounded-full bg-pink-500/10 blur-3xl" />
      </div>

      {/* Waves (WebGL, fallback to SVG) */}
      <HeroWavesCanvas fallback={<HeroWavesSvg />} />

      {/* Content container */}
      <div className="relative z-10 max-w-4xl mx-auto text-center px-6 space-y-8">
        {/* Badge */}
        <div className="flex justify-center">
          <div className="relative">
            {/* Glow effect */}
            <div className="absolute inset-0 blur-xl opacity-50 bg-gradient-to-r from-cyan-400 to-cyan-400 rounded-full" />
            
            {/* Badge content */}
            <div className="relative bg-[#0f172b] border border-cyan-500/50 rounded-full px-6 py-3 flex items-center gap-3 backdrop-blur-sm">
              <span className="text-sm bg-gradient-to-r from-cyan-300 via-purple-300 to-pink-300 bg-clip-text text-transparent font-medium whitespace-nowrap">
                Технологии будущего • Здесь и сейчас
              </span>
            </div>
          </div>
        </div>

        {/* Main heading */}
        <h1 className="text-5xl md:text-6xl font-bold leading-tight shadow-lg">
          Создаём будущее<br />
          цифровых технологий
        </h1>

        {/* Description */}
        <p className="text-gray-300 text-lg max-w-2xl mx-auto leading-relaxed shadow-lg">
          Разрабатываем современные веб-сайты и мобильные приложения, которые помогают бизнесу расти и развиваться в цифровой среде. Наши решения сочетают передовые технологии с безупречным дизайном.
        </p>

        {/* Buttons */}
        <div className="flex gap-4 justify-center">
          {/* Primary button */}
          <button className="bg-gradient-to-r from-cyan-400 to-purple-600 hover:from-cyan-300 hover:to-purple-500 text-white font-semibold py-3 px-8 rounded-full transition-all duration-300 flex items-center gap-2 shadow-lg hover:shadow-xl">
            Начать проект
            <ArrowRightIcon className="h-5 w-5" />
          </button>

          {/* Secondary button */}
          <a
            href="#services"
            className="border border-gray-600 hover:border-gray-400 text-white font-semibold py-3 px-8 rounded-full transition-all duration-300 backdrop-blur-sm"
          >
            Наши услуги
          </a>
        </div>

        {/* Statistics */}
        <div className="grid grid-cols-4 gap-4 pt-8">
          {[
            { number: '150+', label: 'Проектов' },
            { number: '98%', label: 'Довольных клиентов' },
            { number: '5+', label: 'Лет опыта' },
            { number: '24/7', label: 'Поддержка' }
          ].map((stat, i) => (
            <div
              key={i}
              className="bg-[rgba(15,23,43,0.4)] border border-gray-700/30 rounded-lg p-4 backdrop-blur-sm"
            >
              <div className="text-2xl font-bold mb-2 shadow-lg">{stat.number}</div>
              <div className="text-gray-400 text-sm">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
