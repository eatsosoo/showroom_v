<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        return view('admin.site-settings.index', [
            'title' => 'Cấu hình website',
            'settings' => SiteSetting::orderBy('group')->orderBy('key')->paginate(50),
        ]);
    }

    public function create()
    {
        return view('admin.site-settings.form', [
            'title' => 'Thêm cấu hình',
            'setting' => new SiteSetting(['group' => 'general', 'type' => 'text']),
        ]);
    }

    public function store(Request $request)
    {
        SiteSetting::create($this->validated($request));

        return redirect()->route('admin.site-settings.index')->with('success', 'Đã tạo cấu hình.');
    }

    public function edit(SiteSetting $siteSetting)
    {
        return view('admin.site-settings.form', [
            'title' => 'Sửa cấu hình',
            'setting' => $siteSetting,
        ]);
    }

    public function update(Request $request, SiteSetting $siteSetting)
    {
        $siteSetting->update($this->validated($request, $siteSetting->id));

        return redirect()->route('admin.site-settings.index')->with('success', 'Đã cập nhật cấu hình.');
    }

    public function destroy(SiteSetting $siteSetting)
    {
        $siteSetting->delete();

        return redirect()->route('admin.site-settings.index')->with('success', 'Đã xóa cấu hình.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'group' => ['required', 'string', 'max:191'],
            'key' => ['required', 'string', 'max:191', 'unique:site_settings,key,'.($id ?? 'NULL')],
            'value' => ['nullable', 'string'],
            'type' => ['required', 'in:text,textarea,image,url,phone,email'],
            'label' => ['nullable', 'string', 'max:191'],
        ]);
    }
}
