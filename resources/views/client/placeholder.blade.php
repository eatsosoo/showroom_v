<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'VinFast Hải Phòng' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">
    <main class="mx-auto flex min-h-screen max-w-4xl flex-col justify-center px-6">
        <p class="mb-3 text-sm font-medium uppercase tracking-wide text-brand-600">Client UI pending</p>
        <h1 class="text-3xl font-semibold">VinFast Hải Phòng</h1>
        <p class="mt-4 max-w-2xl text-gray-600">
            Phần giao diện khách hàng sẽ triển khai sau khi chốt thiết kế. Khu vực quản trị hiện nằm tại
            <a class="font-medium text-brand-600 underline" href="{{ route('admin.dashboard') }}">/admin</a>.
        </p>
    </main>
</body>
</html>
