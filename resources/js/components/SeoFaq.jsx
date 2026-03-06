import React from 'react';

const defaultFaqItems = [
  {
    question: 'Сколько стоит разработка сайта под ключ?',
    answer:
      'Стоимость зависит от типа проекта, сложности функционала и сроков. После брифа мы формируем прозрачную смету и поэтапный план работ.',
  },
  {
    question: 'Вы разрабатываете мобильные приложения для iOS и Android?',
    answer:
      'Да, мы создаём мобильные приложения под iOS и Android: нативные и кроссплатформенные решения в зависимости от задач бизнеса.',
  },
  {
    question: 'Какие сроки создания корпоративного сайта или веб-приложения?',
    answer:
      'Обычно корпоративный сайт занимает от 3 до 8 недель, веб-приложение — от 2 до 4 месяцев. Точные сроки определяются после анализа требований.',
  },
  {
    question: 'Можно ли заказать редизайн и SEO-оптимизацию существующего сайта?',
    answer:
      'Да, мы выполняем редизайн, техническую SEO-оптимизацию, ускорение загрузки и доработку структуры под поисковые запросы.',
  },
  {
    question: 'Работаете ли вы с поддержкой и развитием проекта после запуска?',
    answer:
      'Да, предоставляем техническую поддержку, мониторинг, обновления и развитие продукта после релиза.',
  },
];

export default function SeoFaq({ content = null }) {
  const faqTitle = content?.title || 'Частые вопросы о разработке сайтов и мобильных приложений';
  const faqSubtitle = content?.subtitle || 'Ответы на популярные вопросы клиентов перед стартом проекта.';
  const faqItems = Array.isArray(content?.items) && content.items.length
    ? content.items
    : defaultFaqItems;

  return (
    <section id="faq" className="relative py-24 bg-[#020618] overflow-hidden" aria-labelledby="faq-title">
      <div className="relative z-10 max-w-4xl mx-auto px-6">
        <div className="text-center mb-12">
          <h2
            id="faq-title"
            className="text-xl bg-gradient-to-r from-cyan-300 to-purple-400 bg-clip-text text-transparent mb-4"
          >
            {faqTitle}
          </h2>
          <p className="text-gray-400">
            {faqSubtitle}
          </p>
        </div>

        <div className="space-y-4">
          {faqItems.map(({ question, answer }) => (
            <article
              key={question}
              className="rounded-2xl border border-gray-700 bg-[rgba(15,23,43,0.5)] p-6"
              itemScope
              itemType="https://schema.org/Question"
            >
              <h3 className="text-base md:text-lg font-semibold text-white" itemProp="name">
                {question}
              </h3>
              <div className="mt-3 text-gray-300 leading-relaxed" itemProp="acceptedAnswer" itemScope itemType="https://schema.org/Answer">
                <p itemProp="text">{answer}</p>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
