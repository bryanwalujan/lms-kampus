{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">👨‍💼 Admin Dashboard</h1>
                <p class="mt-2 text-sm text-gray-600">Kelola sistem LMS Lokasi secara menyeluruh</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['total_classes'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Lokasi</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $stats['total_locations'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Hari Ini Absen</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $stats['today_attendances'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">⚡ Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.classes.index') }}" class="block p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-green-900">🏫 Kelola Kelas</h4>
                                    <p class="text-sm text-green-700">Buat, edit, dan hapus kelas</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-blue-900">👥 Kelola Users</h4>
                                    <p class="text-sm text-blue-700">Admin, dosen, mahasiswa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.locations.index') }}" class="block p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-purple-900">📍 Kelola Lokasi</h4>
                                    <p class="text-sm text-purple-700">Tambah lokasi pembelajaran</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">📊 Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($recentActivities ?? [] as $activity)
                        <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-blue-600">{{ substr($activity->created_at, 11, 5) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $activity->description }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            Belum ada aktivitas terbaru
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection