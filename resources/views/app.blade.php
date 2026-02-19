<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Axecode - Технологии будущего</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    @php
        $yandexId = \App\Models\Setting::get('yandex_metrika_id');
        $googleId  = \App\Models\Setting::get('google_analytics_id');
    @endphp

    @if ($googleId)
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleId }}');
    </script>
    @endif

    @if ($yandexId)
    <!-- Yandex Metrika -->
    <script>
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym({{ $yandexId }}, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/{{ $yandexId }}" style="position:absolute; left:-9999px;" alt=""/></div></noscript>
    @endif
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
    <div id="app" class="min-h-screen">Загрузка интерфейса…</div>
</body>
</html>
