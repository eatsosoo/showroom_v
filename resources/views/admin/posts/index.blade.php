@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Bài viết" />
    @include('admin.partials.flash')

    <x-common.component-card title="Bài viết">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.posts.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Thêm bài viết</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Tiêu đề</th>
                        <th class="px-4 py-3">Danh mục</th>
                        <th class="px-4 py-3">Loại</th>
                        <th class="px-4 py-3">Ngày đăng</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($posts as $post)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $post->title }}</td>
                            <td class="px-4 py-3">{{ $post->category?->name ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $post->type }}</td>
                            <td class="px-4 py-3">{{ $post->published_at?->format('d/m/Y') ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $post->is_active ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="text-brand-600" href="{{ route('admin.posts.edit', $post) }}">Sửa</a>
                                <form class="ml-3 inline" method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Xóa bài viết này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $posts->links() }}
    </x-common.component-card>
@endsection
