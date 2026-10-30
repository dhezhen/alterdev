<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        return view('admin.portfolios.index', [
            'portfolios' => Portfolio::query()
                ->when($request->query('kategori'), fn ($q, $c) => $q->where('category', $c))
                ->when($request->query('q'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
                ->ordered()->paginate(20)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.portfolios.form', ['portfolio' => new Portfolio(['is_active' => true, 'category' => Portfolio::CATEGORIES[0]])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeUpload($request, 'image', 'portfolios');
        Portfolio::create($data);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.form', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $this->validated($request, $portfolio);
        $data['image'] = $this->storeUpload($request, 'image', 'portfolios', $portfolio->image);
        $portfolio->update($data);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->deleteFile($portfolio->image);
        $portfolio->delete();

        return back()->with('success', 'Portofolio dihapus.');
    }

    private function validated(Request $request, ?Portfolio $portfolio = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', 'alpha_dash', Rule::unique('portfolios', 'slug')->ignore($portfolio)],
            'category' => ['required', Rule::in(Portfolio::CATEGORIES)],
            'client' => ['nullable', 'string', 'max:150'],
            'year' => ['nullable', 'string', 'max:10'],
            'summary' => ['required', 'string', 'max:300'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'result' => ['nullable', 'string'],
            'tags_text' => ['nullable', 'string', 'max:300'],
            'url' => ['nullable', 'url:http,https', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'dimensions:max_width=6000,max_height=6000', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], ['title' => 'judul', 'summary' => 'ringkasan', 'image' => 'gambar']);

        $data['tags'] = $this->commaToArray($data['tags_text'] ?? '');
        unset($data['tags_text'], $data['image']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
