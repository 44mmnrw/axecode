<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $categorySlug = request()->query('category');

        $query = BlogPost::query()
            ->with('category:id,name,slug')
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        if ($categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $posts = $query->paginate(12)->withQueryString();

        return view('blog.index', [
            'posts'          => $posts,
            'activeCategory' => $categorySlug,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->with('category:id,name,slug')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = BlogPost::query()
            ->with('category:id,name,slug')
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(4)
            ->get(['id', 'title', 'slug', 'excerpt', 'category_id', 'published_at']);

        $serviceLinks = $this->serviceLinksForCategory($post->category?->slug);

        return view('blog.show', [
            'post'         => $post,
            'relatedPosts' => $relatedPosts,
            'serviceLinks' => $serviceLinks,
        ]);
    }

    private function serviceLinksForCategory(?string $categorySlug): array
    {
        return match ($categorySlug) {
            'mobile-development' => [
                ['href' => '/razrabotka-mobilnyh-prilozheniy', 'title' => 'Разработка мобильных приложений'],
                ['href' => '/razrabotka-veb-prilozheniy',      'title' => 'Разработка веб-приложений'],
            ],
            'design-and-ux' => [
                ['href' => '/razrabotka-saitov-pod-klyuch',   'title' => 'Разработка сайтов под ключ'],
                ['href' => '/razrabotka-veb-prilozheniy',     'title' => 'Разработка веб-приложений'],
                ['href' => '/razrabotka-mobilnyh-prilozheniy','title' => 'Разработка мобильных приложений'],
            ],
            'technologies' => [
                ['href' => '/razrabotka-veb-prilozheniy',    'title' => 'Разработка веб-приложений'],
                ['href' => '/razrabotka-saitov-pod-klyuch',  'title' => 'Разработка сайтов под ключ'],
                ['href' => '/tehnicheskaya-podderzhka-sayta','title' => 'Техническая поддержка сайта'],
            ],
            default => [ // guides-and-analytics
                ['href' => '/razrabotka-saitov-pod-klyuch',  'title' => 'Разработка сайтов под ключ'],
                ['href' => '/razrabotka-veb-prilozheniy',    'title' => 'Разработка веб-приложений'],
                ['href' => '/razrabotka-internet-magazina',  'title' => 'Разработка интернет-магазина'],
            ],
        };
    }
}
