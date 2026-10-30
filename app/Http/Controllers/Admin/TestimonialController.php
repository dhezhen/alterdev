<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.testimonials.index', ['testimonials' => Testimonial::ordered()->get()]);
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial(['is_active' => true, 'rating' => 5])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['photo'] = $this->storeUpload($request, 'photo', 'testimonials');
        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validated($request);
        $data['photo'] = $this->storeUpload($request, 'photo', 'testimonials', $testimonial->photo);
        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteFile($testimonial->photo);
        $testimonial->delete();

        return back()->with('success', 'Testimoni dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'position' => ['nullable', 'string', 'max:120'],
            'organization' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string', 'max:1500'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'dimensions:max_width=6000,max_height=6000', 'max:1024'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], ['name' => 'nama', 'content' => 'isi testimoni', 'photo' => 'foto']);

        unset($data['photo']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
