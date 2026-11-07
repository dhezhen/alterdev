<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Service;
use App\Support\Icons;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.services.index', ['services' => Service::ordered()->get()]);
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service(['is_active' => true, 'icon' => 'globe'])]);
    }

    public function store(Request $request)
    {
        Service::create($this->validated($request));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validated($request, $service));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Layanan dihapus.');
    }

    private function validated(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', 'alpha_dash', Rule::unique('services', 'slug')->ignore($service)],
            'icon' => ['required', Rule::in(array_keys(Icons::OPTIONS))],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'features_text' => ['nullable', 'string', 'max:2000'],
            'price_label' => ['nullable', 'string', 'max:120'],
            'packages' => ['nullable', 'array', 'max:10'],
            'packages.*.name' => ['nullable', 'string', 'max:100'],
            'packages.*.summary' => ['nullable', 'string', 'max:255'],
            'packages.*.price' => ['nullable', 'integer', 'min:0', 'max:9999999999'],
            'packages.*.price_display' => ['nullable', 'string', 'max:80'],
            'packages.*.price_kicker' => ['nullable', 'string', 'max:40'],
            'packages.*.compare_price' => ['nullable', 'integer', 'min:0', 'max:9999999999'],
            'packages.*.compare_price_display' => ['nullable', 'string', 'max:80'],
            'packages.*.discount_label' => ['nullable', 'string', 'max:30'],
            'packages.*.price_note' => ['nullable', 'string', 'max:255'],
            'packages.*.core_price' => ['nullable', 'integer', 'min:0', 'max:9999999999'],
            'packages.*.features_text' => ['nullable', 'string', 'max:2000'],
            'packages.*.excluded_features_text' => ['nullable', 'string', 'max:2000'],
            'packages.*.services_text' => ['nullable', 'string', 'max:2000'],
            'packages.*.renewal_label' => ['nullable', 'string', 'max:120'],
            'packages.*.accent_color' => ['nullable', Rule::in(['blue', 'teal', 'coral'])],
            'packages.*.is_published' => ['nullable', 'boolean'],
            'portfolio_category' => ['nullable', Rule::in(Portfolio::CATEGORIES)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], ['title' => 'judul', 'short_description' => 'deskripsi singkat']);

        $data['features'] = $this->linesToArray($data['features_text'] ?? '');
        unset($data['features_text']);
        $data['pricing_packages'] = collect($data['packages'] ?? [])
            ->values()
            ->map(function (array $package): array {
                return [
                    'name' => trim($package['name'] ?? ''),
                    'summary' => trim($package['summary'] ?? ''),
                    'price' => ($package['price'] ?? '') !== '' ? (int) $package['price'] : null,
                    'price_display' => trim($package['price_display'] ?? ''),
                    'price_kicker' => trim($package['price_kicker'] ?? ''),
                    'compare_price' => ($package['compare_price'] ?? '') !== '' ? (int) $package['compare_price'] : null,
                    'compare_price_display' => trim($package['compare_price_display'] ?? ''),
                    'discount_label' => trim($package['discount_label'] ?? ''),
                    'price_note' => trim($package['price_note'] ?? ''),
                    'core_price' => ($package['core_price'] ?? '') !== '' ? (int) $package['core_price'] : null,
                    'features' => $this->linesToArray($package['features_text'] ?? ''),
                    'excluded_features' => $this->linesToArray($package['excluded_features_text'] ?? ''),
                    'services' => $this->linesToArray($package['services_text'] ?? ''),
                    'renewal_label' => trim($package['renewal_label'] ?? ''),
                    'accent_color' => $package['accent_color'] ?? 'blue',
                    'is_published' => filter_var($package['is_published'] ?? false, FILTER_VALIDATE_BOOLEAN),
                ];
            })
            ->filter(fn (array $package) => $package['name'] !== '')
            ->values()
            ->all();
        unset($data['packages']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
