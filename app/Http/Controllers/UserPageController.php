<?php

namespace App\Http\Controllers;

use App\Models\UserPage;
use Illuminate\Contracts\View\View;

class UserPageController extends Controller
{
    public function showBySlug(string $slug): View
    {
        $page = UserPage::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('user-page', [
            'page' => $page,
        ]);
    }
}
