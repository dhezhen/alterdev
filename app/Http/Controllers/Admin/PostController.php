<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        return view('admin.posts.index', [
            'posts' => Post::with('author')
                ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
                ->when($request->query('status') === 'terbit', fn ($q) => $q->where('is_published', true))
                ->when($request->query('status') === 'draf', fn ($q) => $q->where('is_published', false))
                ->latest('updated_at')->paginate(20)->withQueryString(),
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post(['published_at' => now()])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['cover_image'] = $this->storeUpload($request, 'cover_image', 'posts');
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);

        return redirect()->route('admin.posts.edit', $post)->with('success', $post->is_published ? 'Artikel diterbitkan.' : 'Draf artikel disimpan.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);
        $data['cover_image'] = $this->storeUpload($request, 'cover_image', 'posts', $post->cover_image);
        $post->update($data);

        return redirect()->route('admin.posts.edit', $post)->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $this->deleteFile($post->cover_image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel dihapus.');
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:210', 'alpha_dash', Rule::unique('posts', 'slug')->ignore($post)],
            'category' => ['nullable', 'string', 'max:60'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'dimensions:max_width=6000,max_height=6000', 'max:3072'],
            'published_at' => ['nullable', 'date'],
        ], [], ['title' => 'judul', 'body' => 'isi artikel', 'cover_image' => 'gambar sampul']);

        unset($data['cover_image']);
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
