{{-- resources/views/admin/users/index.blade.php - ✅ FIXED --}}
@extends('layouts.app')

@section('title', 'Manajemen Users - LMS Lokasi')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
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
                <span class="ml-1 text-sm font-medium text-gray-500">Users</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">👥 Manajemen Users</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola admin, dosen, dan mahasiswa</p>
                </div>
                <a href="{{ route('admin.users.create') }}" 
                   class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-indigo-600 hover:to-purple-700 shadow-lg transform hover:-translate-y-1 transition-all font-semibold">
                    + Tambah User
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Cari User</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nama, email, atau NIM..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">🎭 Role</label>
                        <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>👨‍💼 Admin</option>
                            <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>👨‍🏫 Dosen</option>
                            <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>👨‍🎓 Mahasiswa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">📊 Status</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 font-semibold">🔍 Filter</button>
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 font-semibold">🔄 Reset</a>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            @if($users->count() > 0)
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">📋 Daftar Users ({{ $users->total() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 {{ !$user->is_active ? 'bg-red-50 border-l-4 border-red-200' : '' }}">
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <img class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-200" 
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=128" 
                                                 alt="{{ $user->name }}">
                                            @if(!$user->is_active)
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 border-2 border-white rounded-full"></div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $user->name }}</div>
                                            @if($user->profile?->nim_nidn)
                                            <div class="text-xs text-gray-500 truncate">{{ $user->profile->nim_nidn }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-900 truncate max-w-[200px]">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $roleColors = [
                                            'admin' => ['bg-red-100', 'text-red-800', '👨‍💼'],
                                            'dosen' => ['bg-green-100', 'text-green-800', '👨‍🏫'],
                                            'mahasiswa' => ['bg-blue-100', 'text-blue-800', '👨‍🎓']
                                        ];
                                        $roleColor = $roleColors[$user->role] ?? ['bg-gray-100', 'text-gray-800', '👤'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $roleColor[0] }} {{ $roleColor[1] }} border">
                                        {{ $roleColor[2] }} {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold 
                                        {{ $user->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                        {{ $user->is_active ? '✅ Aktif' : '⏸️ Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="inline-flex items-center px-3 py-2 text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-all text-xs">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all text-xs">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-8">
                {{ $users->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada users</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan user pertama.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 shadow-lg transform hover:-translate-y-1 transition-all font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah User Pertama
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection