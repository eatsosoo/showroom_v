@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $title }}" />
    @include('admin.partials.flash')

    <x-common.component-card title="{{ $title }}">
        <form method="POST" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" class="grid gap-5">
            @csrf
            @if ($post->exists) @method('PUT') @endif
            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">Tiêu đề
                    <input name="title" value="{{ old('title', $post->title) }}" class="rounded-lg border border-gray-300 px-4 py-2" required>
                </label>
                <label class="grid gap-2 text-sm font-medium">Slug
                    <input name="slug" value="{{ old('slug', $post->slug) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Danh mục
                    <select name="post_category_id" class="rounded-lg border border-gray-300 px-4 py-2">
                        <option value="">Chưa phân loại</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('post_category_id', $post->post_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-medium">Loại
                    <select name="type" class="rounded-lg border border-gray-300 px-4 py-2">
                        @foreach (['news' => 'Tin tức', 'promotion' => 'Khuyến mãi', 'price' => 'Bảng giá', 'service' => 'Dịch vụ', 'page' => 'Trang tĩnh'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('type', $post->type) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-medium">Ảnh đại diện
                    <input name="thumbnail" value="{{ old('thumbnail', $post->thumbnail) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Ngày đăng
                    <input name="published_at" type="datetime-local" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
            </div>
            <label class="grid gap-2 text-sm font-medium">Tóm tắt
                <textarea name="excerpt" rows="3" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('excerpt', $post->excerpt) }}</textarea>
            </label>
            <label class="grid gap-2 text-sm font-medium">Nội dung
                <textarea name="content" rows="10" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('content', $post->content) }}</textarea>
            </label>
            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-medium">Meta title
                    <input name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
                <label class="grid gap-2 text-sm font-medium">Thứ tự
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $post->sort_order ?? 0) }}" class="rounded-lg border border-gray-300 px-4 py-2">
                </label>
            </div>
            <label class="grid gap-2 text-sm font-medium">Meta description
                <textarea name="meta_description" rows="3" class="rounded-lg border border-gray-300 px-4 py-2">{{ old('meta_description', $post->meta_description) }}</textarea>
            </label>
            <div class="flex flex-wrap gap-5">
                <label class="flex items-center gap-2 text-sm font-medium"><input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $post->is_featured))> Nổi bật</label>
                <label class="flex items-center gap-2 text-sm font-medium"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $post->is_active))> Hiển thị</label>
            </div>
            <div class="flex gap-3">
                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Lưu</button>
                <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Hủy</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
