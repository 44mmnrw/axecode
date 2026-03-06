import React from 'react';

export default function Logo() {
  return (
    <span className="inline-flex items-center gap-3 text-white select-none" aria-label="AXECODE logo">
      <img
        src="/logo.png"
        alt="Axecode logo"
        width="38"
        height="38"
        className="h-[38px] w-[38px] shrink-0"
        loading="eager"
        decoding="async"
      />

      <span
        className="text-xl sm:text-2xl font-semibold tracking-[0.12em] leading-none text-white"
        style={{ fontFamily: 'Inter, Segoe UI, Helvetica Neue, Arial, sans-serif' }}
      >
        AXECODE
      </span>
    </span>
  );
}
