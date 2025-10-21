{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail User - LMS Lokasi')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.users.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Users</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500">{{ $user->name }}</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <img class="w-24 h-24 rounded-full object-cover ring-4 ring-white shadow-lg" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=256" 
                             alt="{{ $user->name }}">
                        @if(!$user->is_active)
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 border-2 border-white rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-bold">⏸️</span>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                        @php
                            $roleColors = [
                                'admin' => ['bg-red-100', 'text-red-800', '👨‍💼'],
                                'dosen' => ['bg-green-100', 'text-green-800', '👨‍🏫'],
                                'mahasiswa' => ['bg-blue-100', 'text-blue-800', '👨‍🎓']
                            ];
                            $roleColor = $roleColors[$user->role] ?? ['bg-gray-100', 'text-gray-800', '👤'];
                        @endphp
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $roleColor[0] }} {{ $roleColor[1] }} border">
                                {{ $roleColor[2] }} {{ ucfirst($user->role) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} border">
                                {{ $user->is_active ? '✅ Aktif' : '⏸️ Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold">
                        ✏️ Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-semibold">
                        ← Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Info -->
                    <div class="bg-white shadow-xl rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-2">👤 Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Terdaftar</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    @if($user->profile)
                    <div class="bg-white shadow-xl rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-2">📋 Profil Akademik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($user->profile->nim_nidn)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $user->role == 'mahasiswa' ? 'NIM' : 'NIDN' }}
                                </label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->profile->nim_nidn }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Classes -->
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">📚 Kelas {{ $user->role == 'dosen' ? 'Diajar' : 'Diikuti' }} ({{ $user->classesAsDosen->count() + $user->classMemberships->count() }})</h3>
                        </div>
                        @if($user->classesAsDosen->count() > 0 || $user->classMemberships->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kelas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->classesAsDosen as $class)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                                {{ $class->code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $class->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $class->location->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                👨‍🏫 Dosen
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach($user->classMemberships as $membership)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                {{ $membership->class->code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $membership->class->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $membership->class->location->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                                👨‍🎓 Anggota
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-gray-900">Belum ada kelas</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $user->role == 'dosen' ? 'Belum mengajar kelas' : 'Belum mengikuti kelas' }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar Stats -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-indigo-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Statistik</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">Terdaftar</span>
                                <span class="font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">Terakhir Login</span>
                                <span class="font-semibold text-gray-900">{{ $user->last_login ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">Total Kelas</span>
                                <span class="font-semibold text-indigo-600">{{ $user->classesAsDosen->count() + $user->classMemberships->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="w-full block px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 text-blue-700 font-medium text-sm">
                                ✏️ Edit Informasi
                            </a>
                            @if($user->is_active)
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full block px-4 py-3 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 text-red-700 font-medium text-sm">
                                    ⏸️ Nonaktifkan
                                </button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full block px-4 py-3 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 text-green-700 font-medium text-sm">
                                    ✅ Aktifkan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection