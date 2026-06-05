@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $title }}">
        <form method="POST" action="{{ $category->exists ? route('admin.vehicle-categories.update', $category) : route('admin.vehicle-categories.store') }}" class="grid gap-5">
            @csrf
            @if ($category->exists) @method('PUT') @endif
            <label class="grid gap-2 text-sm font-medium">Tên
                <input name="name" value="{{ old('name', $category->name) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
            </label>
            <label class="grid gap-2 text-sm font-medium">Slug
                <input name="slug" value="{{ old('slug', $category->slug) }}" class="rounded-lg border border-gray-300 px-4 py-2">
            </label>
            <label class="grid gap-2 text-sm font-medium">Danh mục cha
                <select name="parent_id" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Không có</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" @selected(old('parent_id', $category->parent_id) == $item->id)>{{ $item->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-2 text-sm font-medium">Mô tả
                <textarea name="description" rows="4" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('description', $category->description) }}</textarea>
            </label>
            <label class="grid gap-2 text-sm font-medium">Thứ tự
                <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="rounded-lg border border-gray-300 px-4 py-2">
            </label>
            <label class="flex items-center gap-2 text-sm font-medium">
                <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->is_active))> Hiển thị
            </label>
            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Lưu</button>
                <a href="{{ route('admin.vehicle-categories.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Hủy</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
