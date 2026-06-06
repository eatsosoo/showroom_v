<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        SiteSetting::create($this->prepareData($request));

        return redirect()->route('admin.site-settings.index')->with('success', __('app.messages.create_success'));
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
        $siteSetting->update($this->prepareData($request, $siteSetting));

        return redirect()->route('admin.site-settings.index')->with('success', __('app.messages.update_success'));
    }

    public function destroy(SiteSetting $siteSetting)
    {
        if ($siteSetting->type === 'image') {
            $this->deleteStoredImage($siteSetting->value);
        }

        $siteSetting->delete();

        return redirect()->route('admin.site-settings.index')->with('success', __('app.messages.delete_success'));
    }

    private function prepareData(Request $request, ?SiteSetting $setting = null): array
    {
        $data = $this->validated($request, $setting?->id);

        if ($data['type'] === 'image' && $request->hasFile('image_file')) {
            if ($setting?->type === 'image') {
                $this->deleteStoredImage($setting->value);
            }

            $data['value'] = $request->file('image_file')->store('site-settings', 'public');
        }

        unset($data['image_file']);

        return $data;
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate(
            [
                'group' => ['required', 'string', 'max:191'],
                'key' => ['required', 'string', 'max:191', 'unique:site_settings,key,'.($id ?? 'NULL')],
                'value' => ['nullable', 'string'],
                'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
                'type' => ['required', 'in:text,textarea,image,url,phone,email'],
                'label' => ['nullable', 'string', 'max:191'],
            ],
            [
                'image_file.uploaded' => __('app.validation.image_upload_php_limit'),
                'image_file.image' => __('app.validation.image_file_invalid'),
                'image_file.mimes' => __('app.validation.image_file_mimes'),
                'image_file.max' => __('app.validation.image_file_max'),
            ]
        );
    }

    private function deleteStoredImage(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['http://', 'https://', '/'])) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
