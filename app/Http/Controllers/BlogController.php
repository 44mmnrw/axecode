<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::query()
            ->with('category:id,name,slug')
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12);

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->with('category:id,name,slug')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', [
            'post' => $post,
        ]);
    }
}
