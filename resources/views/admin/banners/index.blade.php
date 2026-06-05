@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Banner" />
    @include('admin.partials.flash')

    <x-common.component-card title="Banner">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.banners.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Thêm banner</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Tiêu đề</th>
                        <th class="px-4 py-3">Vị trí</th>
                        <th class="px-4 py-3">Link</th>
                        <th class="px-4 py-3">Thứ tự</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($banners as $banner)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $banner->title }}</td>
                            <td class="px-4 py-3">{{ $banner->position }}</td>
                            <td class="px-4 py-3">{{ $banner->link_url ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $banner->sort_order }}</td>
                            <td class="px-4 py-3">{{ $banner->is_active ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.banners.edit', $banner) }}">Sửa</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Xóa banner này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $banners->links() }}
    </x-common.component-card>
@endsection
