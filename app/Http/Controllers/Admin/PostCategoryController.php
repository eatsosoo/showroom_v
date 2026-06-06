<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        return view('admin.post-categories.index', [
            'title' => 'app.pages.post_categories',
            'categories' => PostCategory::orderBy('sort_order')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.post-categories.form', [
            'title' => 'app.pages.post_category_create',
            'category' => new PostCategory(['type' => 'news', 'is_active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        PostCategory::create($this->validated($request));

        return redirect()->route('admin.post-categories.index')->with('success', 'Đã tạo danh mục mới.');
    }

    public function edit(PostCategory $postCategory)
    {
        return view('admin.post-categories.form', [
            'title' => 'app.pages.post_category_edit',
            'category' => $postCategory,
        ]);
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $postCategory->update($this->validated($request, $postCategory->id));

        return redirect()->route('admin.post-categories.index')->with('success', 'Đã cập nhật danh mục.');
    }

    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();

        return redirect()->route('admin.post-categories.index')->with('success', 'Đã xóa danh mục.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:post_categories,slug,'.($id ?? 'NULL')],
            'type' => ['required', 'in:news,promotion,price,service,page'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
