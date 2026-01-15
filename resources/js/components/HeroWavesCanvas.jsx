import React, { useRef, useEffect } from 'react';



export default function HeroWavesCanvas({
  height = 420,
  opacity = 0.95,
  speed = 1.2,
  lineCount = 8,
  amplitude = 0.18,
  yOffset = 0.15,
  fallback = null,
}) {
  const canvasRef = useRef(null);
  const animationFrameRef = useRef(null);
  const startTimeRef = useRef(Date.now());
  const glRef = useRef(null);
  const programRef = useRef(null);
  const uniformLocationsRef = useRef({});

  // Vertex shader
  const vertexShaderSource = `
    attribute vec2 a_position;
    void main() {
      gl_Position = vec4(a_position, 0, 1);
    }
  `;

  // Fragment shader - луч + волны, вращающиеся вокруг оси
  const fragmentShaderSource = `
    precision mediump float;
    uniform vec2 iResolution;
    uniform float iTime;
    uniform float uSpeed;
    uniform float uLineCount;
    uniform float uAmplitude;
    uniform float uYOffset;

    const float MAX_LINES = 20.0;

    // Create a wavy line (0.0 black, 1.0 white)
    float wave(vec2 uv, float speed, float yPos, float thickness, float softness) {
      float falloff = smoothstep(1.0, 0.5, abs(uv.x));
      float y = falloff * sin(iTime * speed + uv.x * 10.0) * yPos - uYOffset;
      return 1.0 - smoothstep(thickness, thickness + softness + falloff * 0.0, abs(uv.y - y));
    }

    void main() {
      vec2 uv = gl_FragCoord.xy / iResolution.y;
      vec4 col = vec4(0.0, 0.0, 0.0, 1.0);

      // Center uv coords
      uv -= 0.5;
      // Смещение луча по вертикали
      uv.y -= 0.01;
      
      // Wave colors: cyan to pink gradient
      const vec3 col1 = vec3(0.325, 0.918, 0.992); // cyan
      const vec3 col2 = vec3(0.965, 0.200, 0.604); // pink

      // Used to antialias the lines based on display pixel density
      float aaDy = iResolution.y * 0.000005;
      
      for (float i = 0.0; i < MAX_LINES; i += 1.0) {
        // Only process if within our desired line count
        if (i <= uLineCount) {
          float t = i / max(1.0, uLineCount - 1.0);
          vec3 lineCol = mix(col1, col2, t);
          float bokeh = pow(t, 3.0);
          float thickness = 0.003;
          float softness = aaDy + bokeh * 0.2;
          float amp = uAmplitude - 0.05 * t;
          float amt = max(0.0, pow(1.0 - bokeh, 2.0) * 0.9);
          col.xyz += wave(uv, uSpeed * (1.0 + t), amp, thickness, softness) * lineCol * amt;
        }
      }

      // Fade at top and bottom
      float fadeTop = smoothstep(-0.35, -0.1, uv.y);
      float fadeBot = smoothstep(0.4, 0.1, uv.y);
      col.a *= fadeTop * fadeBot;

      gl_FragColor = col;
    }
  `;

  // Initialize WebGL
  const initWebGL = () => {
    const canvas = canvasRef.current;
    if (!canvas) return false;

    const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
    if (!gl) {
      console.error('WebGL not supported');
      return false;
    }
    glRef.current = gl;

    // Compile vertex shader
    const vertexShader = gl.createShader(gl.VERTEX_SHADER);
    if (!vertexShader) return false;
    gl.shaderSource(vertexShader, vertexShaderSource);
    gl.compileShader(vertexShader);

    if (!gl.getShaderParameter(vertexShader, gl.COMPILE_STATUS)) {
      console.error('Vertex shader error:', gl.getShaderInfoLog(vertexShader));
      return false;
    }

    // Compile fragment shader
    const fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
    if (!fragmentShader) return false;
    gl.shaderSource(fragmentShader, fragmentShaderSource);
    gl.compileShader(fragmentShader);

    if (!gl.getShaderParameter(fragmentShader, gl.COMPILE_STATUS)) {
      console.error('Fragment shader error:', gl.getShaderInfoLog(fragmentShader));
      return false;
    }

    // Link program
    const program = gl.createProgram();
    if (!program) return false;
    gl.attachShader(program, vertexShader);
    gl.attachShader(program, fragmentShader);
    gl.linkProgram(program);

    if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
      console.error('Program link error:', gl.getProgramInfoLog(program));
      return false;
    }

    gl.useProgram(program);
    programRef.current = program;

    // Create buffer
    const positionBuffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
    const positions = [-1, -1, 1, -1, -1, 1, -1, 1, 1, -1, 1, 1];
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(positions), gl.STATIC_DRAW);

    // Setup attributes
    const positionAttributeLocation = gl.getAttribLocation(program, 'a_position');
    gl.enableVertexAttribArray(positionAttributeLocation);
    gl.vertexAttribPointer(positionAttributeLocation, 2, gl.FLOAT, false, 0, 0);

    // WebGL settings
    gl.disable(gl.DEPTH_TEST);
    gl.disable(gl.CULL_FACE);
    gl.clearColor(0, 0, 0, 0);

    // Save uniform locations
    uniformLocationsRef.current = {
      iResolution: gl.getUniformLocation(program, 'iResolution'),
      iTime: gl.getUniformLocation(program, 'iTime'),
      uSpeed: gl.getUniformLocation(program, 'uSpeed'),
      uLineCount: gl.getUniformLocation(program, 'uLineCount'),
      uAmplitude: gl.getUniformLocation(program, 'uAmplitude'),
      uYOffset: gl.getUniformLocation(program, 'uYOffset'),
    };

    return true;
  };

  // Handle resize
  const handleResize = () => {
    const canvas = canvasRef.current;
    const gl = glRef.current;

    if (!canvas || !gl) return;

    const displayWidth = canvas.clientWidth;
    const displayHeight = canvas.clientHeight;

    if (canvas.width !== displayWidth || canvas.height !== displayHeight) {
      canvas.width = displayWidth;
      canvas.height = displayHeight;
      gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);
    }
  };

  // Render loop
  const render = () => {
    const gl = glRef.current;
    const program = programRef.current;
    const uniforms = uniformLocationsRef.current;

    if (!gl || !program) return;

    const currentTime = Date.now();
    const elapsedTime = (currentTime - startTimeRef.current) / 1000;

    gl.clear(gl.COLOR_BUFFER_BIT);

    if (uniforms.iResolution) {
      gl.uniform2f(uniforms.iResolution, gl.canvas.width, gl.canvas.height);
    }
    if (uniforms.iTime) {
      gl.uniform1f(uniforms.iTime, elapsedTime);
    }
    if (uniforms.uSpeed) {
      gl.uniform1f(uniforms.uSpeed, speed);
    }
    if (uniforms.uLineCount) {
      gl.uniform1f(uniforms.uLineCount, lineCount);
    }
    if (uniforms.uAmplitude) {
      gl.uniform1f(uniforms.uAmplitude, amplitude);
    }
    if (uniforms.uYOffset) {
      gl.uniform1f(uniforms.uYOffset, yOffset);
    }

    gl.drawArrays(gl.TRIANGLES, 0, 6);
    animationFrameRef.current = requestAnimationFrame(render);
  };

  useEffect(() => {
    if (initWebGL()) {
      handleResize();
      render();

      window.addEventListener('resize', handleResize);

      return () => {
        window.removeEventListener('resize', handleResize);
        if (animationFrameRef.current) {
          cancelAnimationFrame(animationFrameRef.current);
        }
      };
    }
  }, []);

  // Update uniforms
  useEffect(() => {
    const gl = glRef.current;
    const uniforms = uniformLocationsRef.current;

    if (gl) {
      if (uniforms.uSpeed) gl.uniform1f(uniforms.uSpeed, speed);
      if (uniforms.uLineCount) gl.uniform1f(uniforms.uLineCount, lineCount);
      if (uniforms.uYOffset) gl.uniform1f(uniforms.uYOffset, yOffset);
      if (uniforms.uAmplitude) gl.uniform1f(uniforms.uAmplitude, amplitude);
    }
  }, [speed, lineCount, amplitude, yOffset]);

  return (
    <div
      className="pointer-events-none absolute inset-0 z-0 overflow-hidden"
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

      {/* Fade gradient to background */}
      <div className="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#020618] to-transparent" />
    </div>
  );
}
