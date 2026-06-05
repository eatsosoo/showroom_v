@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Dòng xe" />
    @include('admin.partials.flash')

    <x-common.component-card title="Dòng xe">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.vehicle-categories.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Thêm dòng xe</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Cha</th>
                        <th class="px-4 py-3">Thứ tự</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                            <td class="px-4 py-3">{{ $category->slug }}</td>
                            <td class="px-4 py-3">{{ $category->parent?->name ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $category->sort_order }}</td>
                            <td class="px-4 py-3">{{ $category->is_active ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.vehicle-categories.edit', $category) }}">Sửa</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.vehicle-categories.destroy', $category) }}" onsubmit="return confirm('Xóa dòng xe này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}
    </x-common.component-card>
@endsection
