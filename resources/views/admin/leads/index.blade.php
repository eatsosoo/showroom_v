@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Lead khách hàng" />
    @include('admin.partials.flash')

    <x-common.component-card title="Lead khách hàng">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Khách hàng</th>
                        <th class="px-4 py-3">Điện thoại</th>
                        <th class="px-4 py-3">Nhu cầu</th>
                        <th class="px-4 py-3">Xe quan tâm</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Ngày gửi</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($leads as $lead)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $lead->name }}</td>
                            <td class="px-4 py-3">{{ $lead->phone }}</td>
                            <td class="px-4 py-3">{{ $lead->type }}</td>
                            <td class="px-4 py-3">{{ $lead->vehicle?->name ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $lead->status }}</td>
                            <td class="px-4 py-3">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.leads.show', $lead) }}">Xem</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Xóa lead này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $leads->links() }}
    </x-common.component-card>
@endsection
