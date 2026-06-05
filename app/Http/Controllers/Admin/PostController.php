<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'title' => 'Bài viết',
            'posts' => Post::with('category')->orderBy('sort_order')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.posts.form', [
            'title' => 'Thêm bài viết',
            'post' => new Post(['type' => 'news', 'is_active' => true]),
            'categories' => PostCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Post::create($this->validated($request));

        return redirect()->route('admin.posts.index')->with('success', 'Đã tạo bài viết.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', [
            'title' => 'Sửa bài viết',
            'post' => $post,
            'categories' => PostCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($this->validated($request, $post->id));

        return redirect()->route('admin.posts.index')->with('success', 'Đã cập nhật bài viết.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
            'title' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:posts,slug,'.($id ?? 'NULL')],
            'type' => ['required', 'in:news,promotion,price,service,page'],
            'thumbnail' => ['nullable', 'string', 'max:191'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
