@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="app.pages.site_settings" />
    @include('admin.partials.flash')

    <x-common.component-card title="app.pages.site_settings">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.site-settings.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">
                {{ __('app.pages.site_setting_create') }}
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">{{ __('app.fields.group') }}</th>
                        <th class="px-4 py-3">Key</th>
                        <th class="px-4 py-3">{{ __('app.fields.label') }}</th>
                        <th class="px-4 py-3">{{ __('app.fields.value') }}</th>
                        <th class="px-4 py-3 text-right">{{ __('app.fields.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($settings as $setting)
                        @php
                            $imageUrl = $setting->type === 'image' && $setting->value
                                ? (\Illuminate\Support\Str::startsWith($setting->value, ['http://', 'https://', '/']) ? $setting->value : asset('storage/'.$setting->value))
                                : null;
                        @endphp
                        <tr>
                            <td class="px-4 py-3">{{ $setting->group }}</td>
                            <td class="px-4 py-3 font-medium">{{ $setting->key }}</td>
                            <td class="px-4 py-3">{{ $setting->label ?: '-' }}</td>
                            <td class="max-w-md px-4 py-3">
                                @if ($imageUrl)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $imageUrl }}" alt="{{ $setting->label ?: $setting->key }}" class="h-12 w-16 rounded-lg object-cover">
                                        <span class="truncate text-gray-500">{{ $setting->value }}</span>
                                    </div>
                                @else
                                    <span class="block truncate">{{ $setting->value ?: '-' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.site-settings.edit', $setting) }}">{{ __('app.actions.edit') }}</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.site-settings.destroy', $setting) }}" onsubmit="return confirm('Xóa cấu hình này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">{{ __('app.actions.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $settings->links() }}
    </x-common.component-card>
@endsection
