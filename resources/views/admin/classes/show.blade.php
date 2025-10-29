{{-- resources/views/admin/classes/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Kelas - LMS Lokasi')

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
                <a href="{{ route('admin.classes.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Kelas</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500">{{ $class->name }}</span>
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
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $class->name }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                            bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                            {{ $class->code }}
                        </span>
                        @php
                            $statusConfig = [
                                'active' => ['bg-green-100', 'text-green-800', '✅ Aktif'],
                                'draft' => ['bg-yellow-100', 'text-yellow-800', '⌛ Draft'],
                                'finished' => ['bg-blue-100', 'text-blue-800', '🏁 Selesai'],
                                'cancelled' => ['bg-red-100', 'text-red-800', '❌ Dibatal']
                            ];
                            $status = $statusConfig[$class->status] ?? $statusConfig['draft'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $status[0] }} {{ $status[1] }}">
                            {{ $status[2] }}
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.classes.edit', $class) }}" 
                       class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold">
                        ✏️ Edit Kelas
                    </a>
                    <a href="{{ route('admin.classes.index') }}" 
                       class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-semibold">
                        ← Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Location & Dosen -->
                    <div class="bg-white shadow-xl rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-2">📍 Informasi Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">📍 Lokasi</label>
                                @if($class->location)
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $class->location->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $class->location->type }}</p>
                                    </div>
                                </div>
                                @else
                                <span class="px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 rounded-full">Belum ditentukan</span>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">👨‍🏫 Dosen</label>
                                @if($class->dosen)
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($class->dosen->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $class->dosen->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $class->dosen->email }}</p>
                                    </div>
                                </div>
                                @else
                                <span class="px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 rounded-full">Belum ditentukan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($class->description)
                    <div class="bg-white shadow-xl rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">📝 Deskripsi</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $class->description }}</p>
                    </div>
                    @endif

                    <!-- Members Table -->
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">👥 Anggota Kelas ({{ $class->members->count() }} / {{ $class->max_students }})</h3>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    {{ $class->members->count() }} terdaftar
                                </span>
                            </div>
                        </div>
                        @if($class->members->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($class->members as $member)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <img class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200" 
                                                     src="https://ui-avatars.com/api/?name={{ urlencode($member->user->name) }}&background=6366f1&color=fff&size=128" 
                                                     alt="{{ $member->user->name }}">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $member->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $member->user->profile->nim_nidn ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $member->user->email }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                ✅ Terdaftar
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-gray-900">Belum ada anggota</h3>
                            <p class="text-sm text-gray-500 mt-1">Mahasiswa dapat mendaftar ke kelas ini.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar Stats -->
                <div class="space-y-6">
                    <!-- Capacity -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-blue-100">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-xl">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Kapasitas</p>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ $class->members->count() }} / {{ $class->max_students }}
                                </p>
                                <p class="text-sm text-blue-600">{{ $class->members->count() / $class->max_students * 100 }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.classes.edit', $class) }}" 
                               class="w-full block px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 text-blue-700 font-medium text-sm">
                                ✏️ Edit Informasi Kelas
                            </a>
                            <a href="#" 
                               class="w-full block px-4 py-3 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 text-green-700 font-medium text-sm">
                                ➕ Tambah Anggota
                            </a>
                            <a href="#" 
                               class="w-full block px-4 py-3 bg-purple-50 border border-purple-200 rounded-xl hover:bg-purple-100 text-purple-700 font-medium text-sm">
                                📅 Kelola Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection