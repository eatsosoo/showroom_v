@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    @php
        $labelClass = 'grid gap-2 text-sm font-medium text-gray-700 dark:text-gray-300';
        $inputClass = 'rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800';
        $hintClass = 'text-xs font-normal text-gray-500 dark:text-gray-400';
    @endphp

    <x-common.component-card title="{{ $title }}">
        <form method="POST" action="{{ $vehicle->exists ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}" class="grid gap-5">
            @csrf
            @if ($vehicle->exists)
                @method('PUT')
            @endif

            <div class="grid gap-5 md:grid-cols-2">
                <label class="{{ $labelClass }}">
                    {{ __('app.fields.vehicle_name') }}
                    <input name="name" value="{{ old('name', $vehicle->name) }}" class="{{ $inputClass }}" required>
                </label>

                <label class="{{ $labelClass }}">
                    Slug
                    <input name="slug" value="{{ old('slug', $vehicle->slug) }}" class="{{ $inputClass }}">
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.vehicle_category') }}
                    <select name="vehicle_category_id" class="{{ $inputClass }}">
                        <option value="">{{ __('app.hints.vehicle_uncategorized') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('vehicle_category_id', $vehicle->vehicle_category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.subtitle') }}
                    <input name="subtitle" value="{{ old('subtitle', $vehicle->subtitle) }}" class="{{ $inputClass }}">
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.seat_count') }}
                    <input name="seat_count" type="number" min="1" value="{{ old('seat_count', $vehicle->seat_count) }}" class="{{ $inputClass }}">
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.price') }}
                    <input name="price" type="number" min="0" value="{{ old('price', $vehicle->price) }}" class="{{ $inputClass }}">
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.display_price') }}
                    <input name="price_text" value="{{ old('price_text', $vehicle->price_text) }}" placeholder="{{ __('app.hints.vehicle_price_text_placeholder') }}" class="{{ $inputClass }}">
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.thumbnail') }}
                    <input name="thumbnail" value="{{ old('thumbnail', $vehicle->thumbnail) }}" class="{{ $inputClass }}">
                </label>
            </div>

            <label class="{{ $labelClass }}">
                {{ __('app.fields.gallery') }}
                <textarea name="gallery" rows="3" class="{{ $inputClass }}">{{ old('gallery', implode("\n", $vehicle->gallery ?? [])) }}</textarea>
                <span class="{{ $hintClass }}">{{ __('app.hints.vehicle_gallery') }}</span>
            </label>

            <label class="{{ $labelClass }}">
                {{ __('app.fields.colors') }}
                <textarea name="colors" rows="3" class="{{ $inputClass }}">{{ old('colors', implode("\n", $vehicle->colors ?? [])) }}</textarea>
                <span class="{{ $hintClass }}">{{ __('app.hints.vehicle_colors') }}</span>
            </label>

            <label class="{{ $labelClass }}">
                {{ __('app.fields.highlights') }}
                <textarea name="highlights" rows="4" class="{{ $inputClass }}">{{ old('highlights', implode("\n", $vehicle->highlights ?? [])) }}</textarea>
                <span class="{{ $hintClass }}">{{ __('app.hints.vehicle_highlights') }}</span>
            </label>

            <label class="{{ $labelClass }}">
                {{ __('app.fields.description') }}
                <textarea name="description" rows="4" class="{{ $inputClass }}">{{ old('description', $vehicle->description) }}</textarea>
            </label>

            <label class="{{ $labelClass }}">
                {{ __('app.fields.content') }}
                <textarea name="content" rows="8" class="{{ $inputClass }}">{{ old('content', $vehicle->content) }}</textarea>
            </label>

            <div class="grid gap-5 md:grid-cols-2">
                <label class="{{ $labelClass }}">
                    {{ __('app.fields.meta_title') }}
                    <input name="meta_title" value="{{ old('meta_title', $vehicle->meta_title) }}" class="{{ $inputClass }}">
                </label>

                <label class="{{ $labelClass }}">
                    {{ __('app.fields.sort_order') }}
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $vehicle->sort_order ?? 0) }}" class="{{ $inputClass }}">
                </label>
            </div>

            <label class="{{ $labelClass }}">
                {{ __('app.fields.meta_description') }}
                <textarea name="meta_description" rows="3" class="{{ $inputClass }}">{{ old('meta_description', $vehicle->meta_description) }}</textarea>
            </label>

            <div class="flex flex-wrap gap-5">
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    <input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $vehicle->is_featured))
                        class="size-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900">
                    {{ __('app.fields.is_featured') }}
                </label>

                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $vehicle->is_active))
                        class="size-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900">
                    {{ __('app.fields.is_active') }}
                </label>
            </div>

            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-600">
                    {{ __('app.actions.save') }}
                </button>
                <a href="{{ route('admin.vehicles.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/[0.03]">
                    {{ __('app.actions.cancel') }}
                </a>
            </div>
        </form>
    </x-common.component-card>
@endsection
