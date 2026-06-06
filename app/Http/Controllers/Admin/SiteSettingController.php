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
            'title' => 'app.pages.site_settings',
            'settings' => SiteSetting::orderBy('group')->orderBy('key')->paginate(50),
        ]);
    }

    public function create()
    {
        return view('admin.site-settings.form', [
            'title' => 'app.pages.site_setting_create',
            'setting' => new SiteSetting(['group' => 'general', 'type' => 'text']),
        ]);
    }

    public function store(Request $request)
    {
        SiteSetting::create($this->validated($request));

        return redirect()->route('admin.site-settings.index')->with('success', '膼茫 t岷 c岷 h矛nh.');
    }

    public function edit(SiteSetting $siteSetting)
    {
        return view('admin.site-settings.form', [
            'title' => 'app.pages.site_setting_edit',
            'setting' => $siteSetting,
        ]);
    }

    public function update(Request $request, SiteSetting $siteSetting)
    {
        $siteSetting->update($this->validated($request, $siteSetting->id));

        return redirect()->route('admin.site-settings.index')->with('success', '膼茫 c岷璸 nh岷璽 c岷 h矛nh.');
    }

    public function destroy(SiteSetting $siteSetting)
    {
        $siteSetting->delete();

        return redirect()->route('admin.site-settings.index')->with('success', '膼茫 x贸a c岷 h矛nh.');
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
