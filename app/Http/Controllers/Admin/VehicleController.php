<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    public function index()
    {
        return view('admin.vehicles.index', [
            'title' => 'Sản phẩm xe',
            'vehicles' => Vehicle::with('category')->orderBy('sort_order')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.vehicles.form', [
            'title' => 'Thêm xe',
            'vehicle' => new Vehicle(['is_active' => true]),
            'categories' => VehicleCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Vehicle::create($this->validated($request));

        return redirect()->route('admin.vehicles.index')->with('success', 'Đã tạo sản phẩm xe.');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.form', [
            'title' => 'Sửa xe',
            'vehicle' => $vehicle,
            'categories' => VehicleCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->update($this->validated($request, $vehicle->id));

        return redirect()->route('admin.vehicles.index')->with('success', 'Đã cập nhật sản phẩm xe.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Đã xóa sản phẩm xe.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'vehicle_category_id' => ['nullable', 'exists:vehicle_categories,id'],
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:vehicles,slug,'.($id ?? 'NULL')],
            'subtitle' => ['nullable', 'string', 'max:191'],
            'seat_count' => ['nullable', 'integer', 'min:1', 'max:99'],
            'price' => ['nullable', 'integer', 'min:0'],
            'price_text' => ['nullable', 'string', 'max:191'],
            'thumbnail' => ['nullable', 'string', 'max:191'],
            'gallery' => ['nullable', 'string'],
            'colors' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['gallery'] = $this->linesToArray($data['gallery'] ?? null);
        $data['colors'] = $this->linesToArray($data['colors'] ?? null);
        $data['highlights'] = $this->linesToArray($data['highlights'] ?? null);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function linesToArray(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
