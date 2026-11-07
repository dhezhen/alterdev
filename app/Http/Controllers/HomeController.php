<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Portfolio::active()->distinct()->pluck('category')->values();
        $category = $request->query('kategori');

        return view('home', [
            'services' => Service::active()->ordered()->get(),
            'portfolios' => Portfolio::active()
                ->when($category, fn ($q) => $q->where('category', $category))
                ->orderByDesc('is_featured')->ordered()->take(6)->get(),
            'categories' => $categories,
            'activeCategory' => $category,
            'testimonials' => Testimonial::active()->ordered()->take(6)->get(),
            'faqs' => Faq::active()->ordered()->get(),
            'posts' => Post::published()->latest('published_at')->take(3)->get(),
        ]);
    }
}
