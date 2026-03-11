{{--
    Reusable blog articles section for landing pages.
    Usage: @include('partials.blog-articles-section', ['slugs' => [...], 'heading' => 'Статьи по теме'])
--}}
@php
    $sectionHeading = $heading ?? 'Статьи по теме';
    $articleSlugs   = $slugs ?? [];
    $sectionPosts   = \App\Models\BlogPost::query()
        ->with('category:id,name,slug')
        ->published()
        ->whereIn('slug', $articleSlugs)
        ->get(['id', 'title', 'slug', 'excerpt', 'category_id'])
        ->sortBy(fn($p) => array_search($p->slug, $articleSlugs))
        ->values();
@endphp

@if($sectionPosts->isNotEmpty())
<section class="py-16 border-t border-white/5">
    <div class="mx-auto max-w-6xl px-6">
        <h2 class="text-2xl font-semibold mb-8">{{ $sectionHeading }}</h2>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach($sectionPosts as $article)
                <article class="rounded-2xl border border-white/10 p-5 bg-white/[0.02] hover:border-cyan-400/60 transition-colors">
                    @if($article->category)
                        <p class="text-xs uppercase tracking-wide text-cyan-300 mb-2">{{ $article->category->name }}</p>
                    @endif
                    <h3 class="text-base font-semibold leading-snug">
                        <a href="{{ url('/blog/' . $article->slug) }}" class="hover:text-cyan-300 transition-colors">
                            {{ $article->title }}
                        </a>
                    </h3>
                    @if($article->excerpt)
                        <p class="mt-2 text-sm text-gray-400 line-clamp-2">{{ $article->excerpt }}</p>
                    @endif
                    <a href="{{ url('/blog/' . $article->slug) }}"
                       class="inline-block mt-3 text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                        Читать →
                    </a>
                </article>
            @endforeach
        </div>
        <div class="mt-8">
            <a href="/blog" class="text-sm text-gray-400 hover:text-cyan-300 transition-colors">Все статьи блога →</a>
        </div>
    </div>
</section>
@endif
