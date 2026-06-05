@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Sản phẩm xe" />
    @include('admin.partials.flash')

    <x-common.component-card title="Sản phẩm xe">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.vehicles.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Thêm xe</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Tên xe</th>
                        <th class="px-4 py-3">Dòng xe</th>
                        <th class="px-4 py-3">Số chỗ</th>
                        <th class="px-4 py-3">Giá</th>
                        <th class="px-4 py-3">Nổi bật</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $vehicle->name }}</td>
                            <td class="px-4 py-3">{{ $vehicle->category?->name ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $vehicle->seat_count ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $vehicle->price_text ?: ($vehicle->price ? number_format($vehicle->price, 0, ',', '.').' đ' : 'Liên hệ') }}</td>
                            <td class="px-4 py-3">{{ $vehicle->is_featured ? 'Có' : 'Không' }}</td>
                            <td class="px-4 py-3">{{ $vehicle->is_active ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.vehicles.edit', $vehicle) }}">Sửa</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Xóa xe này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $vehicles->links() }}
    </x-common.component-card>
@endsection
