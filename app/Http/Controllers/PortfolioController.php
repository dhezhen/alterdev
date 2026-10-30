<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');

        return view('portfolios.index', [
            'portfolios' => Portfolio::active()
                ->when($category, fn ($q) => $q->where('category', $category))
                ->orderByDesc('is_featured')->ordered()
                ->paginate(9)->withQueryString(),
            'categories' => Portfolio::active()->distinct()->pluck('category')->values(),
            'activeCategory' => $category,
        ]);
    }

    public function show(Portfolio $portfolio)
    {
        abort_unless($portfolio->is_active, 404);

        return view('portfolios.show', [
            'portfolio' => $portfolio,
            'others' => Portfolio::active()->whereKeyNot($portfolio->id)
                ->where('category', $portfolio->category)->ordered()->take(3)->get(),
        ]);
    }
}
