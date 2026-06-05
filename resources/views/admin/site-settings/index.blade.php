@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Cấu hình website" />
    @include('admin.partials.flash')

    <x-common.component-card title="Cấu hình website">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.site-settings.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Thêm cấu hình</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Nhóm</th>
                        <th class="px-4 py-3">Key</th>
                        <th class="px-4 py-3">Nhãn</th>
                        <th class="px-4 py-3">Giá trị</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($settings as $setting)
                        <tr>
                            <td class="px-4 py-3">{{ $setting->group }}</td>
                            <td class="px-4 py-3 font-medium">{{ $setting->key }}</td>
                            <td class="px-4 py-3">{{ $setting->label ?: '-' }}</td>
                            <td class="max-w-md truncate px-4 py-3">{{ $setting->value ?: '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.site-settings.edit', $setting) }}">Sửa</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.site-settings.destroy', $setting) }}" onsubmit="return confirm('Xóa cấu hình này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Xóa</button>
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
