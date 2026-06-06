@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Phân quyền" />
    @include('admin.partials.flash')

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6">
            <x-common.component-card title="Tạo role mới">
                <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tên role</label>
                        <input name="name" value="{{ old('name') }}" required
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Slug</label>
                        <input name="slug" value="{{ old('slug') }}" placeholder="writer"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    </div>
                    <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Tạo role</button>
                </form>
            </x-common.component-card>

            <x-common.component-card title="Tạo permission mới">
                <form method="POST" action="{{ route('admin.permissions.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tên permission</label>
                        <input name="name" value="{{ old('permission_name') }}" required
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Slug</label>
                        <input name="slug" placeholder="posts.manage"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nhóm</label>
                        <input name="group" placeholder="content"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    </div>
                    <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Tạo permission</button>
                </form>
            </x-common.component-card>
        </div>

        <div class="xl:col-span-2">
            <x-common.component-card title="Phân quyền theo role">
                <div class="space-y-6">
                    @foreach ($roles as $role)
                        <form method="POST" action="{{ route('admin.roles.permissions.update', $role) }}"
                            class="rounded-lg border border-gray-200 p-4 dark:border-gray-800">
                            @csrf
                            @method('PUT')
                            <div class="mb-4 flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-white/90">{{ $role->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $role->slug }}</p>
                                </div>
                                <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white">Lưu quyền</button>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                @foreach ($permissions as $group => $groupPermissions)
                                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-white/[0.03]">
                                        <h4 class="mb-3 text-sm font-semibold uppercase text-gray-500">
                                            {{ $group ?: 'Khác' }}
                                        </h4>
                                        <div class="space-y-2">
                                            @foreach ($groupPermissions as $permission)
                                                <label class="flex items-start gap-3 text-sm text-gray-700 dark:text-gray-300">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                        @checked($role->permissions->contains($permission))
                                                        class="mt-1 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                                                    <span>
                                                        <span class="block font-medium">{{ $permission->name }}</span>
                                                        <span class="text-xs text-gray-500">{{ $permission->slug }}</span>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    @endforeach
                </div>
            </x-common.component-card>
        </div>
    </div>
@endsection
