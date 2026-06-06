@php
    $user = auth()->user();
    $avatarUrl = $user?->avatarUrl();
@endphp

<div>
    <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border border-gray-200 bg-brand-50 text-2xl font-semibold text-brand-600 dark:border-gray-800 dark:bg-brand-500/10 dark:text-brand-300">
                    @if ($avatarUrl)
                        <img class="h-full w-full object-cover" src="{{ $avatarUrl }}" alt="{{ $user->name }}" />
                    @else
                        {{ $user?->initials() }}
                    @endif
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                        {{ $user?->name }}
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user?->bio ?: 'Chưa cập nhật chức danh' }}
                        </p>
                        <div class="hidden h-3.5 w-px bg-gray-300 xl:block dark:bg-gray-700"></div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user?->email }}
                        </p>
                    </div>
                </div>
            </div>

            <button @click="$dispatch('open-profile-info-modal')"
                class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                        fill="" />
                </svg>
                Edit
            </button>
        </div>
    </div>

    <x-ui.modal @open-profile-info-modal.window="open = true" :isOpen="false" class="max-w-[700px]">
        <div
            class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Edit Profile
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Cập nhật thông tin cá nhân và ảnh đại diện.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="flex flex-col">
                @csrf
                @method('PUT')

                <div class="custom-scrollbar max-h-[520px] overflow-y-auto p-2">
                    <div class="mb-6 flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-full bg-brand-50 text-xl font-semibold text-brand-600 dark:bg-brand-500/10 dark:text-brand-300">
                            @if ($avatarUrl)
                                <img class="h-full w-full object-cover" src="{{ $avatarUrl }}" alt="{{ $user->name }}" />
                            @else
                                {{ $user?->initials() }}
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Avatar
                            </label>
                            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp"
                                class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-white hover:file:bg-brand-600 dark:text-gray-300" />
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG hoặc WEBP, tối đa 2MB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                        <div class="col-span-2 lg:col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Name
                            </label>
                            <input name="name" type="text" value="{{ old('name', $user?->name) }}" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>

                        <div class="col-span-2 lg:col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <input name="email" type="email" value="{{ old('email', $user?->email) }}" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>

                        <div class="col-span-2 lg:col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Phone
                            </label>
                            <input name="phone" type="text" value="{{ old('phone', $user?->phone) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>

                        <div class="col-span-2 lg:col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Bio
                            </label>
                            <input name="bio" type="text" value="{{ old('bio', $user?->bio) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3 px-2 lg:justify-end">
                    <button @click="open = false" type="button"
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                        Close
                    </button>
                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>
</div>
