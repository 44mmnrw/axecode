import React, { useEffect, useMemo, useRef, useState } from 'react';

function usePrefersReducedMotion() {
  const [reduced, setReduced] = useState(false);

  useEffect(() => {
    if (typeof window === 'undefined' || typeof window.matchMedia !== 'function') return;

    const mq = window.matchMedia('(prefers-reduced-motion: reduce)');
    const update = () => setReduced(!!mq.matches);

    update();

    // Safari < 14
    if (typeof mq.addEventListener === 'function') {
      mq.addEventListener('change', update);
      return () => mq.removeEventListener('change', update);
    }

    mq.addListener(update);
    return () => mq.removeListener(update);
  }, []);

  return reduced;
}

function compileShader(gl, type, source) {
  const shader = gl.createShader(type);
  if (!shader) return null;

  gl.shaderSource(shader, source);
  gl.compileShader(shader);

  if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
    // eslint-disable-next-line no-console
    console.warn('WebGL shader compile failed:', gl.getShaderInfoLog(shader));
    gl.deleteShader(shader);
    return null;
  }

  return shader;
}

function createProgram(gl, vsSource, fsSource) {
  const vs = compileShader(gl, gl.VERTEX_SHADER, vsSource);
  const fs = compileShader(gl, gl.FRAGMENT_SHADER, fsSource);
  if (!vs || !fs) return null;

  const program = gl.createProgram();
  if (!program) return null;

  gl.attachShader(program, vs);
  gl.attachShader(program, fs);
  gl.linkProgram(program);

  gl.deleteShader(vs);
  gl.deleteShader(fs);

  if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
    // eslint-disable-next-line no-console
    console.warn('WebGL program link failed:', gl.getProgramInfoLog(program));
    gl.deleteProgram(program);
    return null;
  }

  return program;
}

/**
 * Canvas/WebGL волны, вдохновлённые эффектом figma.site (процедурные линии + градиент).
 * Важно: если WebGL недоступен, просто верните fallback (SVG/ничего).
 */
export default function HeroWavesCanvas({
  height = 420,
  opacity = 0.95,
  speed = 1.2,
  lineCount = 12,
  amplitude = 0.18,
  yOffset = 0.15,
  fallback = null,
}) {
  const containerRef = useRef(null);
  const canvasRef = useRef(null);
  const rafRef = useRef(0);
  const startRef = useRef(0);

  const [supported, setSupported] = useState(true);
  const prefersReducedMotion = usePrefersReducedMotion();

  const shaders = useMemo(() => {
    const vs = `
attribute vec2 aPosition;
varying vec2 vUv;
void main() {
  vUv = aPosition * 0.5 + 0.5;
  gl_Position = vec4(aPosition, 0.0, 1.0);
}
`;

    // WebGL1 fragment shader (gl_FragColor)
    const fs = `
precision mediump float;

uniform vec2 iResolution;
uniform float iTime;
uniform float uSpeed;
uniform float uLineCount;
uniform float uAmplitude;
uniform float uYOffset;

varying vec2 vUv;

vec3 grad(float t) {
  vec3 c1 = vec3(0.325, 0.918, 0.992); // cyan
  vec3 c2 = vec3(0.678, 0.275, 1.000); // purple
  vec3 c3 = vec3(0.965, 0.200, 0.604); // pink
  if (t < 0.5) return mix(c1, c2, t / 0.5);
  return mix(c2, c3, (t - 0.5) / 0.5);
}

float sdSegment(vec2 p, vec2 a, vec2 b) {
  vec2 pa = p - a;
  vec2 ba = b - a;
  float h = clamp(dot(pa, ba) / dot(ba, ba), 0.0, 1.0);
  return length(pa - ba * h);
}

float waveLine(vec2 uv, float idx, float count, float t) {
  float n = (idx + 1.0) / (count + 1.0);

  // Раскладка линий по высоте (ниже = плотнее/ярче)
  float baseY = mix(0.58, 0.86, n) + (uYOffset - 0.15) * 0.25;

  float freq = mix(1.25, 2.75, n);
  float phase = idx * 0.55;
  float amp = uAmplitude * mix(0.14, 1.0, n);

  float y = baseY + sin((uv.x * 6.28318 * freq) + (t * uSpeed) + phase) * amp;
  float d = abs(uv.y - y);

  float width = mix(0.0018, 0.0032, 1.0 - n);
  float core = smoothstep(width, 0.0, d);
  float glow = smoothstep(width * 6.0, 0.0, d) * 0.55;

  return core + glow;
}

float vortex(vec2 uv, float t) {
  // Точка вихря справа
  vec2 c = vec2(0.915, 0.62);
  vec2 p = uv - c;

  float r = length(p);
  float a = atan(p.y, p.x);

  // Вращение колец
  float spin = a + t * 0.55;
  float rings = 0.5 + 0.5 * sin(spin * 10.0 - r * 42.0);

  float falloff = smoothstep(0.22, 0.0, r);
  return rings * falloff;
}

void main() {
  vec2 uv = vUv;
  float t = iTime;

  float count = clamp(uLineCount, 1.0, 20.0);

  float intensity = 0.0;
  for (int i = 0; i < 20; i++) {
    float fi = float(i);
    if (fi >= count) {
      break;
    }
    intensity += waveLine(uv, fi, count, t);
  }

  // Луч/переход к вихрю
  float beam = 1.0 - smoothstep(0.006, 0.030, sdSegment(uv, vec2(0.62, 0.62), vec2(0.92, 0.62)));
  beam *= smoothstep(0.55, 0.80, uv.x);

  float v = vortex(uv, t);

  // Фейды (в рефе волны «живут» внизу)
  float fadeTop = smoothstep(0.35, 0.60, uv.y);
  float fadeBottom = smoothstep(1.05, 0.70, uv.y);
  float fade = fadeTop * fadeBottom;

  float aOut = clamp((intensity * 0.35 + v * 0.8 + beam * 0.9) * fade, 0.0, 1.0);

  vec3 col = grad(uv.x);
  // Добавим «белую» сердцевину для луча/вихря
  col = mix(col, vec3(1.0), clamp(beam * 0.35 + v * 0.30, 0.0, 1.0));

  vec3 rgb = col * aOut;
  gl_FragColor = vec4(rgb, aOut);
}
`;

    return { vs, fs };
  }, []);

  useEffect(() => {
    const container = containerRef.current;
    const canvas = canvasRef.current;

    if (!container || !canvas) return;

    let gl = null;

    try {
      gl = canvas.getContext('webgl', {
        alpha: true,
        antialias: true,
        depth: false,
        stencil: false,
        premultipliedAlpha: true,
        preserveDrawingBuffer: false,
      });
    } catch {
      gl = null;
    }

    if (!gl) {
      setSupported(false);
      return;
    }

    const program = createProgram(gl, shaders.vs, shaders.fs);
    if (!program) {
      setSupported(false);
      return;
    }

    const aPosition = gl.getAttribLocation(program, 'aPosition');

    const uResolution = gl.getUniformLocation(program, 'iResolution');
    const uTime = gl.getUniformLocation(program, 'iTime');
    const uSpeed = gl.getUniformLocation(program, 'uSpeed');
    const uLineCount = gl.getUniformLocation(program, 'uLineCount');
    const uAmplitude = gl.getUniformLocation(program, 'uAmplitude');
    const uYOffset = gl.getUniformLocation(program, 'uYOffset');

    const buffer = gl.createBuffer();
    if (!buffer) {
      gl.deleteProgram(program);
      setSupported(false);
      return;
    }

    gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
    // Fullscreen quad: 2 triangles
    gl.bufferData(
      gl.ARRAY_BUFFER,
      new Float32Array([
        -1, -1,
        1, -1,
        -1, 1,
        -1, 1,
        1, -1,
        1, 1,
      ]),
      gl.STATIC_DRAW
    );

    gl.useProgram(program);
    gl.enableVertexAttribArray(aPosition);
    gl.vertexAttribPointer(aPosition, 2, gl.FLOAT, false, 0, 0);

    gl.disable(gl.DEPTH_TEST);
    gl.disable(gl.CULL_FACE);
    gl.clearColor(0, 0, 0, 0);

    const resize = () => {
      const rect = container.getBoundingClientRect();
      const dpr = Math.min(window.devicePixelRatio || 1, 2);

      const w = Math.max(1, Math.floor(rect.width * dpr));
      const h = Math.max(1, Math.floor(rect.height * dpr));

      if (canvas.width !== w || canvas.height !== h) {
        canvas.width = w;
        canvas.height = h;
      }

      gl.viewport(0, 0, canvas.width, canvas.height);
      if (uResolution) gl.uniform2f(uResolution, canvas.width, canvas.height);
    };

    resize();

    const ro = new ResizeObserver(() => resize());
    ro.observe(container);

    startRef.current = performance.now();

    const draw = () => {
      const now = performance.now();
      const t = prefersReducedMotion ? 0.0 : (now - startRef.current) / 1000.0;

      gl.clear(gl.COLOR_BUFFER_BIT);

      if (uTime) gl.uniform1f(uTime, t);
      if (uSpeed) gl.uniform1f(uSpeed, speed);
      if (uLineCount) gl.uniform1f(uLineCount, lineCount);
      if (uAmplitude) gl.uniform1f(uAmplitude, amplitude);
      if (uYOffset) gl.uniform1f(uYOffset, yOffset);

      gl.drawArrays(gl.TRIANGLES, 0, 6);

      if (!prefersReducedMotion) {
        rafRef.current = requestAnimationFrame(draw);
      }
    };

    draw();

    return () => {
      cancelAnimationFrame(rafRef.current);
      ro.disconnect();
      gl.bindBuffer(gl.ARRAY_BUFFER, null);
      gl.deleteBuffer(buffer);
      gl.useProgram(null);
      gl.deleteProgram(program);
    };
  }, [amplitude, lineCount, prefersReducedMotion, shaders.fs, shaders.vs, speed, yOffset]);

  if (!supported) return fallback;

  return (
    <div
      ref={containerRef}
      className="pointer-events-none absolute inset-x-0 bottom-0 z-0 overflow-hidden"
      style={{ height }}
      aria-hidden="true"
    >
      <canvas
        ref={canvasRef}
        className="h-full w-full"
        style={{
          opacity,
          mixBlendMode: 'screen',
          display: 'block',
        }}
      />

      {/* Подсветка/фейд к низу (как в текущей версии) */}
      <div className="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#020618] to-transparent" />
    </div>
  );
}
