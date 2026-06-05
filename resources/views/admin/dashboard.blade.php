@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Admin Dashboard" />
    @include('admin.partials.flash')

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ([
            'Sản phẩm xe' => $stats['vehicles'],
            'Dòng xe' => $stats['vehicleCategories'],
            'Bài viết' => $stats['posts'],
            'Banner' => $stats['banners'],
            'Lead mới' => $stats['newLeads'],
        ] as $label => $value)
            <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $value }}</p>
            </div>
        @endforeach
    </div>
@endsection
