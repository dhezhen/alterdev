<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $search = trim((string) $request->query('cari'));

        return view('blog.index', [
            'posts' => Post::published()
                ->when($category, fn ($q) => $q->where('category', $category))
                ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")))
                ->latest('published_at')
                ->paginate(9)->withQueryString(),
            'categories' => Post::published()->whereNotNull('category')->distinct()->pluck('category'),
            'activeCategory' => $category,
            'search' => $search,
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->is_published && $post->published_at && $post->published_at->isPast(), 404);

        $post->increment('views');

        return view('blog.show', [
            'post' => $post,
            'related' => Post::published()->whereKeyNot($post->id)
                ->when($post->category, fn ($q) => $q->where('category', $post->category))
                ->latest('published_at')->take(3)->get(),
        ]);
    }
}
