{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - LMS Lokasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">📍 LMS Lokasi - Admin</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-700 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">👨‍💼 Admin Dashboard</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">👥 Total Users</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">🏫 Total Kelas</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['total_classes'] ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">📍 Total Lokasi</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_locations'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="#" class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100">
                            <h4 class="font-medium text-blue-900">👥 Kelola Users</h4>
                            <p class="text-sm text-blue-700 mt-1">Admin, Dosen, Mahasiswa</p>
                        </a>
                        <a href="#" class="block p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100">
                            <h4 class="font-medium text-green-900">🏫 Kelola Kelas</h4>
                            <p class="text-sm text-green-700 mt-1">Buat & Edit Kelas</p>
                        </a>
                        <a href="#" class="block p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100">
                            <h4 class="font-medium text-purple-900">📍 Kelola Lokasi</h4>
                            <p class="text-sm text-purple-700 mt-1">Tambah Lokasi Baru</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>