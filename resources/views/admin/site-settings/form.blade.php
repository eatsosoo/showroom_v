@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $title }}">
        @php
            $currentValue = old('value', $setting->value);
            $currentImageUrl = $currentValue
                ? (\Illuminate\Support\Str::startsWith($currentValue, ['http://', 'https://', '/']) ? $currentValue : asset('storage/'.$currentValue))
                : null;
        @endphp

        <form method="POST"
            action="{{ $setting->exists ? route('admin.site-settings.update', $setting) : route('admin.site-settings.store') }}"
            enctype="multipart/form-data"
            class="grid gap-5"
            x-data="{ type: @js(old('type', $setting->type)) }">
            @csrf
            @if ($setting->exists)
                @method('PUT')
            @endif

            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">
                    {{ __('app.fields.group') }}
                    <input name="group" value="{{ old('group', $setting->group) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>

                <label class="grid gap-2 text-sm font-medium">
                    Key
                    <input name="key" value="{{ old('key', $setting->key) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>

                <label class="grid gap-2 text-sm font-medium">
                    {{ __('app.fields.label') }}
                    <input name="label" value="{{ old('label', $setting->label) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>

                <label class="grid gap-2 text-sm font-medium">
                    {{ __('app.fields.data_type') }}
                    <select name="type" x-model="type" class="rounded-lg border border-gray-300 px-4 py-2">
                        @foreach (['text', 'textarea', 'image', 'url', 'phone', 'email'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $setting->type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label class="grid gap-2 text-sm font-medium">
                {{ __('app.fields.value') }}
                <textarea name="value" rows="5" class="rounded-lg border border-gray-300 px-4 py-2">{{ $currentValue }}</textarea>
            </label>

            <div x-show="type === 'image'" class="grid gap-3 text-sm font-medium" x-cloak>
                <span>{{ __('app.actions.upload_image') }}</span>
                @if ($currentImageUrl)
                    <div class="flex items-center gap-4 rounded-lg border border-gray-200 p-3">
                        <img src="{{ $currentImageUrl }}" alt="{{ $setting->label ?: $setting->key }}" class="h-20 w-28 rounded-lg object-cover">
                        <div class="min-w-0 text-sm font-normal text-gray-500">
                            <p class="font-medium text-gray-700">Ảnh hiện tại</p>
                            <p class="truncate">{{ $currentValue }}</p>
                        </div>
                    </div>
                @endif

                <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                    class="rounded-lg border border-gray-300 px-4 py-2">
                <p class="text-xs font-normal text-gray-500">
                    {{ __('app.hints.site_setting_image') }}
                </p>
            </div>

            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">{{ __('app.actions.save') }}</button>
                <a href="{{ route('admin.site-settings.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ __('app.actions.cancel') }}</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
