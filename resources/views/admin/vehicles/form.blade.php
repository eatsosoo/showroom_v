@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $title }}">
        <form method="POST" action="{{ $vehicle->exists ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}" class="grid gap-5">
            @csrf
            @if ($vehicle->exists) @method('PUT') @endif
            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">Tên xe
                    <input name="name" value="{{ old('name', $vehicle->name) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>
                <label class="grid gap-2 text-sm font-medium">Slug
                    <input name="slug" value="{{ old('slug', $vehicle->slug) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Dòng xe
                    <select name="vehicle_category_id" class="rounded-lg border border-gray-300 px-4 py-2">
                        <option value="">Chưa phân loại</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('vehicle_category_id', $vehicle->vehicle_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-medium">Mô tả ngắn
                    <input name="subtitle" value="{{ old('subtitle', $vehicle->subtitle) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Số chỗ
                    <input name="seat_count" type="number" min="1" value="{{ old('seat_count', $vehicle->seat_count) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Giá số
                    <input name="price" type="number" min="0" value="{{ old('price', $vehicle->price) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Giá hiển thị
                    <input name="price_text" value="{{ old('price_text', $vehicle->price_text) }}" placeholder="Liên hệ để có giá tốt" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Ảnh đại diện
                    <input name="thumbnail" value="{{ old('thumbnail', $vehicle->thumbnail) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
            </div>
            <label class="grid gap-2 text-sm font-medium">Gallery, mỗi dòng một URL
                <textarea name="gallery" rows="3" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('gallery', implode("\n", $vehicle->gallery ?? [])) }}</textarea>
            </label>
            <label class="grid gap-2 text-sm font-medium">Màu sắc, mỗi dòng một giá trị
                <textarea name="colors" rows="3" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('colors', implode("\n", $vehicle->colors ?? [])) }}</textarea>
            </label>
            <label class="grid gap-2 text-sm font-medium">Điểm nổi bật, mỗi dòng một ý
                <textarea name="highlights" rows="4" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('highlights', implode("\n", $vehicle->highlights ?? [])) }}</textarea>
            </label>
            <label class="grid gap-2 text-sm font-medium">Mô tả
                <textarea name="description" rows="4" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('description', $vehicle->description) }}</textarea>
            </label>
            <label class="grid gap-2 text-sm font-medium">Nội dung chi tiết
                <textarea name="content" rows="8" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('content', $vehicle->content) }}</textarea>
            </label>
            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">Meta title
                    <input name="meta_title" value="{{ old('meta_title', $vehicle->meta_title) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Thứ tự
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $vehicle->sort_order ?? 0) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
            </div>
            <label class="grid gap-2 text-sm font-medium">Meta description
                <textarea name="meta_description" rows="3" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('meta_description', $vehicle->meta_description) }}</textarea>
            </label>
            <div class="flex flex-wrap gap-5">
                <label class="flex items-center gap-2 text-sm font-medium"><input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $vehicle->is_featured))> Nổi bật</label>
                <label class="flex items-center gap-2 text-sm font-medium"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $vehicle->is_active))> Hiển thị</label>
            </div>
            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Lưu</button>
                <a href="{{ route('admin.vehicles.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Hủy</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
