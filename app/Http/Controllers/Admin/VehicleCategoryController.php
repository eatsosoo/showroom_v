<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleCategoryController extends Controller
{
    public function index()
    {
        return view('admin.vehicle-categories.index', [
            'title' => 'app.pages.vehicle_categories',
            'categories' => VehicleCategory::with('parent')->orderBy('sort_order')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.vehicle-categories.form', [
            'title' => 'app.pages.vehicle_category_create',
            'category' => new VehicleCategory(['is_active' => true]),
            'categories' => VehicleCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        VehicleCategory::create($this->validated($request));

        return redirect()->route('admin.vehicle-categories.index')->with('success', __('app.messages.create_success'));
    }

    public function edit(VehicleCategory $vehicleCategory)
    {
        return view('admin.vehicle-categories.form', [
            'title' => 'app.pages.vehicle_category_edit',
            'category' => $vehicleCategory,
            'categories' => VehicleCategory::whereKeyNot($vehicleCategory->id)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->update($this->validated($request, $vehicleCategory->id));

        return redirect()->route('admin.vehicle-categories.index')->with('success', __('app.messages.update_success'));
    }

    public function destroy(VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->delete();

        return redirect()->route('admin.vehicle-categories.index')->with('success', __('app.messages.delete_success'));
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'parent_id' => ['nullable', 'exists:vehicle_categories,id'],
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:vehicle_categories,slug,'.($id ?? 'NULL')],
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
