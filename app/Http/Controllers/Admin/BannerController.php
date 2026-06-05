<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banners.index', [
            'title' => 'Banner',
            'banners' => Banner::orderBy('position')->orderBy('sort_order')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.banners.form', [
            'title' => 'Thêm banner',
            'banner' => new Banner(['position' => 'home_hero', 'is_active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        Banner::create($this->validated($request));

        return redirect()->route('admin.banners.index')->with('success', 'Đã tạo banner.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.form', [
            'title' => 'Sửa banner',
            'banner' => $banner,
        ]);
    }

    public function update(Request $request, Banner $banner)
    {
        $banner->update($this->validated($request));

        return redirect()->route('admin.banners.index')->with('success', 'Đã cập nhật banner.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Đã xóa banner.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'position' => ['required', 'string', 'max:191'],
            'image' => ['nullable', 'string', 'max:191'],
            'link_url' => ['nullable', 'string', 'max:191'],
            'button_text' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
