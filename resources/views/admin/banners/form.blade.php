@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $title }}">
        <form method="POST" action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}" class="grid gap-5">
            @csrf
            @if ($banner->exists) @method('PUT') @endif
            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">Tiêu đề
                    <input name="title" value="{{ old('title', $banner->title) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>
                <label class="grid gap-2 text-sm font-medium">Vị trí
                    <input name="position" value="{{ old('position', $banner->position) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>
                <label class="grid gap-2 text-sm font-medium">Ảnh
                    <input name="image" value="{{ old('image', $banner->image) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Link
                    <input name="link_url" value="{{ old('link_url', $banner->link_url) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Nút CTA
                    <input name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Thứ tự
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
            </div>
            <label class="grid gap-2 text-sm font-medium">Mô tả
                <textarea name="description" rows="4" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('description', $banner->description) }}</textarea>
            </label>
            <label class="flex items-center gap-2 text-sm font-medium"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $banner->is_active))> Hiển thị</label>
            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Lưu</button>
                <a href="{{ route('admin.banners.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Hủy</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
