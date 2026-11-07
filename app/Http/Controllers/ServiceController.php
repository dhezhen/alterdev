<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', [
            'services' => Service::active()->ordered()->get(),
        ]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        // Proyek terkait berdasarkan kategori portofolio yang dipilih di admin
        $related = $service->portfolio_category
            ? Portfolio::active()->where('category', $service->portfolio_category)->ordered()->take(3)->get()
            : collect();

        return view('services.show', [
            'service' => $service,
            'pricingPackages' => $service->publishedPricingPackages(),
            'others' => Service::active()->ordered()->whereKeyNot($service->id)->get(),
            'related' => $related,
        ]);
    }
}
