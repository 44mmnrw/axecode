<footer class="border-t border-white/5 py-8 {{ $marginTopClass ?? '' }}">
    <div class="mx-auto {{ $maxWidthClass ?? 'max-w-6xl' }} px-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} Axecode. Все права защищены.

        @if (!empty($privacyLink))
            <span class="mx-2">·</span>
            <a href="{{ $privacyLink }}" class="hover:text-gray-300 transition-colors">Политика конфиденциальности</a>
        @endif
    </div>
</footer>
