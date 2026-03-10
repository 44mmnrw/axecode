<?php

namespace App\Http\Controllers;

use App\Support\SeoDKeywordLanding;
use Illuminate\Contracts\View\View;

class SeoDKeywordLandingController extends Controller
{
    public function index(): View
    {
        $rows = array_values(SeoDKeywordLanding::bySlugMap());

        return view('landing.d-keyword-index', [
            'rows' => $rows,
        ]);
    }

    public function show(string $slug): View
    {
        $map = SeoDKeywordLanding::bySlugMap();
        abort_unless(isset($map[$slug]), 404);

        $item = $map[$slug];

        return view('landing.d-keyword', [
            'item' => $item,
        ]);
    }
}
