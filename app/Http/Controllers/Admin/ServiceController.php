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
            'portfolio_category' => ['nullable', Rule::in(Portfolio::CATEGORIES)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], ['title' => 'judul', 'short_description' => 'deskripsi singkat']);

        $data['features'] = $this->linesToArray($data['features_text'] ?? '');
        unset($data['features_text']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
