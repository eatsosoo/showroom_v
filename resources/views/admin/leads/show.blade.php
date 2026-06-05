@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Chi tiết lead" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $lead->name }}">
        <dl class="grid gap-4 text-sm md:grid-cols-2">
            <div><dt class="text-gray-500">Điện thoại</dt><dd class="font-medium">{{ $lead->phone }}</dd></div>
            <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $lead->email ?: '-' }}</dd></div>
            <div><dt class="text-gray-500">Tỉnh/thành</dt><dd class="font-medium">{{ $lead->city ?: '-' }}</dd></div>
            <div><dt class="text-gray-500">Xe quan tâm</dt><dd class="font-medium">{{ $lead->vehicle?->name ?: '-' }}</dd></div>
            <div><dt class="text-gray-500">Nhu cầu</dt><dd class="font-medium">{{ $lead->type }}</dd></div>
            <div><dt class="text-gray-500">Lịch hẹn</dt><dd class="font-medium">{{ $lead->appointment_at?->format('d/m/Y H:i') ?: '-' }}</dd></div>
        </dl>
        <div class="mt-5 text-sm">
            <p class="text-gray-500">Nội dung khách gửi</p>
            <p class="mt-1 whitespace-pre-line">{{ $lead->message ?: '-' }}</p>
        </div>
        <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="mt-6 grid gap-5">
            @csrf @method('PUT')
            <label class="grid gap-2 text-sm font-medium">Trạng thái
                <select name="status" class="rounded-lg border border-gray-300 px-4 py-2">
                    @foreach (['new' => 'Mới', 'contacted' => 'Đã liên hệ', 'qualified' => 'Tiềm năng', 'closed' => 'Đã chốt', 'lost' => 'Không thành công'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $lead->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-2 text-sm font-medium">Ghi chú nội bộ
                <textarea name="admin_note" rows="5" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('admin_note', $lead->admin_note) }}</textarea>
            </label>
            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Cập nhật</button>
                <a href="{{ route('admin.leads.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Quay lại</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
