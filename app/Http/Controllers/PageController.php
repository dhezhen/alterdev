<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Training;

class PageController extends Controller
{
    public function about()
    {
        return view('about', [
            'team' => TeamMember::active()->ordered()->get(),
            'stats' => [
                'Layanan' => Service::active()->count(),
                'Proyek' => Portfolio::active()->count(),
                'Program pelatihan' => Training::active()->count(),
            ],
        ]);
    }

    public function sitemap()
    {
        $urls = collect([
            route('home'), route('services.index'), route('portfolios.index'),
            route('trainings.index'), route('blog.index'), route('about'), route('contact'),
        ])->map(fn ($u) => ['loc' => $u, 'lastmod' => null]);

        foreach (Service::active()->get() as $item) {
            $urls->push(['loc' => route('services.show', $item), 'lastmod' => $item->updated_at]);
        }
        foreach (Portfolio::active()->get() as $item) {
            $urls->push(['loc' => route('portfolios.show', $item), 'lastmod' => $item->updated_at]);
        }
        foreach (Training::active()->get() as $item) {
            $urls->push(['loc' => route('trainings.show', $item), 'lastmod' => $item->updated_at]);
        }
        foreach (Post::published()->get() as $item) {
            $urls->push(['loc' => route('blog.show', $item), 'lastmod' => $item->updated_at]);
        }

        return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
    }
}
