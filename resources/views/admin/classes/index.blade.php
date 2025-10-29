{{-- resources/views/admin/classes/index.blade.php - ✅ FIXED --}}
@extends('layouts.app')

@section('title', 'Manajemen Kelas - LMS Lokasi')

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
                <span class="ml-1 text-sm font-medium text-gray-500">Kelas</span>
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
                    <h1 class="text-3xl font-bold text-gray-900">🏫 Manajemen Kelas</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola kelas pembelajaran dan jadwal</p>
                </div>
                <a href="{{ route('admin.classes.create') }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg transform hover:-translate-y-1 transition-all font-semibold">
                    + Buat Kelas Baru
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <form method="GET" action="{{ route('admin.classes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Cari Kelas</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nama atau kode kelas..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">📍 Lokasi</label>
                        <select name="location_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Lokasi</option>
                            @foreach(\App\Models\Location::where('is_active', true)->get() as $location)
                                <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">👨‍🏫 Dosen</label>
                        <select name="dosen_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Dosen</option>
                            @foreach(\App\Models\User::role('dosen')->get() as $dosen)
                                <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 font-semibold">🔍 Filter</button>
                        <a href="{{ route('admin.classes.index') }}" class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 font-semibold">🔄 Reset</a>
                    </div>
                </form>
            </div>

            <!-- Classes Table -->
            @if($classes->count() > 0)
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">📋 Daftar Kelas ({{ $classes->total() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Nama Kelas</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Dosen</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($classes as $class)
                            <tr class="hover:bg-gray-50 {{ $class->status != 'active' ? 'bg-amber-50 border-l-4 border-amber-200' : '' }}">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold 
                                        bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                        {{ $class->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold">
                                            {{ substr($class->code, 0, 2) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $class->name }}</div>
                                            @if($class->description)
                                            <div class="text-sm text-gray-500 truncate">{{ Str::limit($class->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($class->location)
                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-xs font-semibold 
                                        bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $class->location->name }}
                                    </span>
                                    @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($class->dosen)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($class->dosen->name, 0, 2) }}
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900 truncate max-w-[150px]">{{ $class->dosen->name }}</span>
                                    </div>
                                    @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'active' => ['bg-green-100', 'text-green-800', '✅'],
                                            'draft' => ['bg-yellow-100', 'text-yellow-800', '⌛'],
                                            'finished' => ['bg-blue-100', 'text-blue-800', '🏁'],
                                            'cancelled' => ['bg-red-100', 'text-red-800', '❌']
                                        ];
                                        $status = $statusConfig[$class->status] ?? $statusConfig['draft'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-xs font-semibold {{ $status[0] }} {{ $status[1] }} border">
                                        {{ $status[2] }} {{ ucfirst($class->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $class->members_count ?? 0 }} / {{ $class->max_students ?? '—' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.classes.show', $class) }}" 
                                       class="inline-flex items-center px-3 py-2 text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-all text-xs">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $class) }}" 
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
                {{ $classes->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada kelas</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat kelas pembelajaran pertama Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.classes.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg transform hover:-translate-y-1 transition-all font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Kelas Pertama
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection