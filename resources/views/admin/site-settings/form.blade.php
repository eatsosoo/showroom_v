@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $title }}">
        <form method="POST" action="{{ $setting->exists ? route('admin.site-settings.update', $setting) : route('admin.site-settings.store') }}" class="grid gap-5">
            @csrf
            @if ($setting->exists) @method('PUT') @endif
            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">Nhóm
                    <input name="group" value="{{ old('group', $setting->group) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>
                <label class="grid gap-2 text-sm font-medium">Key
                    <input name="key" value="{{ old('key', $setting->key) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>
                <label class="grid gap-2 text-sm font-medium">Nhãn hiển thị
                    <input name="label" value="{{ old('label', $setting->label) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Kiểu dữ liệu
                    <select name="type" class="rounded-lg border border-gray-300 px-4 py-2">
                        @foreach (['text', 'textarea', 'image', 'url', 'phone', 'email'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $setting->type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <label class="grid gap-2 text-sm font-medium">Giá trị
                <textarea name="value" rows="5" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('value', $setting->value) }}</textarea>
            </label>
            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Lưu</button>
                <a href="{{ route('admin.site-settings.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Hủy</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
