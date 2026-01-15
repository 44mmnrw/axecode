import React, { useState } from 'react';
import axios from 'axios';

function IconMail(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M4 6h16v12H4V6z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
      <path d="M4 7l8 6 8-6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

function IconPhone(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path
        d="M8 3h8l1 4-3 2c1.5 3.5 3.5 5.5 7 7l-2 3-4-1c-2 1-6 0-8-2s-3-6-2-8l-1-4 4-1z"
        stroke="currentColor"
        strokeWidth="2"
        strokeLinejoin="round"
      />
    </svg>
  );
}

function IconPin(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M12 21s7-4.4 7-11a7 7 0 10-14 0c0 6.6 7 11 7 11z" stroke="currentColor" strokeWidth="2" />
      <path d="M12 10a2 2 0 100-4 2 2 0 000 4z" stroke="currentColor" strokeWidth="2" />
    </svg>
  );
}

function IconSend(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" {...props}>
      <path d="M22 2L11 13" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
      <path d="M22 2l-7 20-4-9-9-4 20-7z" stroke="currentColor" strokeWidth="2" strokeLinejoin="round" />
    </svg>
  );
}

export default function Contact() {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    message: ''
  });
  const [status, setStatus] = useState({ loading: false, message: '', type: '' });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setStatus({ loading: true, message: '', type: '' });

    try {
      const response = await axios.post('/api/contact', formData);
      
      setStatus({
        loading: false,
        message: response.data.message,
        type: 'success'
      });
      setFormData({ name: '', email: '', message: '' });
    } catch (error) {
      setStatus({
        loading: false,
        message: error.response?.data?.message || 'Ошибка при отправке. Попробуйте позже.',
        type: 'error'
      });
    }
  };

  const contactInfo = [
    { Icon: IconMail, label: 'Email', value: 'hello@axecode.tech' },
    { Icon: IconPhone, label: 'Телефон', value: '+7 (495) 109-25-44' },
    // { Icon: IconPin, label: 'Адрес', value: 'г. Москва, ул. Примерная, 123' }
  ];

  return (
    <section id="contact" className="relative py-32 bg-[#020618] overflow-hidden">
      {/* Decorative blurs */}
      <div className="absolute left-1/4 top-0 w-96 h-96 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full blur-3xl opacity-10" />
      <div className="absolute right-1/4 bottom-0 w-96 h-96 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full blur-3xl opacity-10" />

      <div className="relative z-10 max-w-6xl mx-auto px-6">
        {/* Header */}
        <div className="text-center mb-16">
          <h2 className="text-xl bg-gradient-to-r from-cyan-300 to-purple-400 bg-clip-text text-transparent mb-4">
            Свяжитесь с нами
          </h2>
          <p className="text-gray-400 text-lg max-w-2xl mx-auto">
            Готовы начать ваш проект? Напишите нам, и мы обсудим как воплотить вашу идею в жизнь
          </p>
        </div>

        {/* Content Grid */}
        <div className="grid lg:grid-cols-2 gap-12">
          {/* Left side - Contact Info */}
          <div className="space-y-8">
            <div>
              <h3 className="text-2xl font-bold text-white mb-8">Контактная информация</h3>

              {/* Contact items */}
              <div className="space-y-4">
                {contactInfo.map(({ Icon, label, value }) => (
                  <div
                    key={label}
                    className="bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl p-6 flex gap-4 hover:border-cyan-500/50 transition-all duration-300"
                  >
                    <div className="w-11 h-11 rounded-lg bg-gradient-to-br from-cyan-400/20 to-purple-400/20 flex items-center justify-center flex-shrink-0">
                      <Icon className="h-5 w-5 text-white" />
                    </div>
                    <div>
                      <p className="text-gray-400 text-sm">{label}</p>
                      <p className="text-white font-semibold">{value}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* Working hours */}
            <div className="rounded-2xl border border-[rgba(0,184,219,0.20)] bg-[linear-gradient(167deg,rgba(0,184,219,0.10),rgba(173,70,255,0.10))] p-6">
              <h4 className="font-semibold text-white mb-4">Время работы</h4>
              <p className="text-gray-300 mb-2">Понедельник - Пятница: 9:00 - 18:00</p>
              <p className="text-gray-400">Суббота - Воскресенье: Выходной</p>
            </div>
          </div>

          {/* Right side - Form */}
          <form onSubmit={handleSubmit} className="space-y-6">
            {/* Status message */}
            {status.message && (
              <div className={`p-4 rounded-2xl border ${
                status.type === 'success' 
                  ? 'bg-green-500/10 border-green-500/30 text-green-300' 
                  : 'bg-red-500/10 border-red-500/30 text-red-300'
              }`}>
                {status.message}
              </div>
            )}

            {/* Name field */}
            <div>
              <label className="block text-gray-300 font-semibold mb-2">Ваше имя</label>
              <input
                type="text"
                name="name"
                value={formData.name}
                onChange={handleChange}
                placeholder="Иван Иванов"
                required
                className="w-full bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500/50 transition-colors"
              />
            </div>

            {/* Email field */}
            <div>
              <label className="block text-gray-300 font-semibold mb-2">Email</label>
              <input
                type="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                placeholder="ivan@example.com"
                required
                className="w-full bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500/50 transition-colors"
              />
            </div>

            {/* Message field */}
            <div>
              <label className="block text-gray-300 font-semibold mb-2">Сообщение</label>
              <textarea
                name="message"
                value={formData.message}
                onChange={handleChange}
                placeholder="Расскажите о вашем проекте..."
                rows="5"
                required
                className="w-full bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500/50 transition-colors resize-none"
              />
            </div>

            {/* Submit button */}
            <button
              type="submit"
              disabled={status.loading}
              className="w-full bg-gradient-to-r from-cyan-400 to-purple-600 hover:from-cyan-300 hover:to-purple-500 disabled:from-gray-600 disabled:to-gray-700 text-white font-semibold py-3 rounded-2xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-70"
            >
              <IconSend className="h-5 w-5" />
              {status.loading ? 'Отправляю...' : 'Отправить сообщение'}
            </button>
          </form>
        </div>
      </div>
    </section>
  );
}
