<header class="sticky top-0 z-50 border-b border-white/5 bg-[rgba(2,6,24,0.85)] backdrop-blur-md">
    <div class="mx-auto flex h-16 {{ $maxWidthClass ?? 'max-w-6xl' }} items-center justify-between px-6">
        <a href="/" class="text-lg font-bold bg-gradient-to-r from-[#00d3f2] via-purple-400 to-pink-400 bg-clip-text text-transparent">Axecode</a>
        <a href="{{ $actionHref ?? '/#contact' }}" class="text-sm {{ $actionTextClass ?? 'text-cyan-300' }} hover:text-white transition-colors">
            {{ $actionText ?? 'Обсудить проект' }}
        </a>
    </div>
</header>
