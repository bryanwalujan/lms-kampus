{{-- resources/views/admin/locations/index.blade.php - ✅ FIXED COUNTS --}}
@extends('layouts.app')

@section('title', 'Manajemen Lokasi - LMS Lokasi')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📍 Manajemen Lokasi</h1>
                <p class="mt-2 text-sm text-gray-600">Kelola lokasi pembelajaran dan titik check-in GPS</p>
            </div>
            <a href="{{ route('admin.locations.create') }}" 
               class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl hover:from-green-600 hover:to-green-700 shadow-lg transform hover:-translate-y-1 transition-all font-semibold">
                + Tambah Lokasi Baru
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
            <form method="GET" action="{{ route('admin.locations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Cari Lokasi</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama lokasi atau alamat..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">📊 Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                    </select>
                </div>
                
                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🏷️ Tipe Lokasi</label>
                    <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                        <option value="">Semua Tipe</option>
                        <option value="campus" {{ request('type') == 'campus' ? 'selected' : '' }}>🏫 Kampus</option>
                        <option value="lab" {{ request('type') == 'lab' ? 'selected' : '' }}>🔬 Lab</option>
                        <option value="field" {{ request('type') == 'field' ? 'selected' : '' }}>🌳 Lapangan</option>
                        <option value="library" {{ request('type') == 'library' ? 'selected' : '' }}>📚 Perpustakaan</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>📍 Lainnya</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit" 
                            class="flex-1 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 font-semibold">
                        🔍 Filter
                    </button>
                    <a href="{{ route('admin.locations.index') }}" 
                       class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 font-semibold">
                        🔄 Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-green-100">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Lokasi</p>
                        <p class="text-3xl font-bold text-green-600">{{ $locations->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-lg border border-blue-100">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Lokasi Aktif</p>
                        <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Location::where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-lg border border-purple-100">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalClasses ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Locations Table -->
        @if($locations->count() > 0)
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">📋 Daftar Lokasi ({{ $locations->total() }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Koordinat</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Radius</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($locations as $location)
                        <tr class="hover:bg-gray-50 {{ !$location->is_active ? 'bg-red-50 border-l-4 border-red-200' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $location->name }}</div>
                                        <div class="text-sm text-gray-500 truncate max-w-[200px]">{{ Str::limit($location->address, 40) }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-5">
                                @php
                                    $typeColors = [
                                        'campus' => ['bg-blue-100', 'text-blue-800'],
                                        'lab' => ['bg-green-100', 'text-green-800'],
                                        'field' => ['bg-orange-100', 'text-orange-800'],
                                        'library' => ['bg-purple-100', 'text-purple-800'],
                                        'other' => ['bg-gray-100', 'text-gray-800']
                                    ];
                                    $colors = $typeColors[$location->type] ?? $typeColors['other'];
                                @endphp
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $colors[0] }} {{ $colors[1] }}">
                                    {{ ucfirst($location->type) }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-5 text-sm text-gray-900">
                                <div class="text-xs text-gray-500 mb-1">🌐 {{ number_format($location->latitude, 6) }}</div>
                                <div class="text-xs text-gray-500">📍 {{ number_format($location->longitude, 6) }}</div>
                            </td>
                            
                            <td class="px-6 py-5">
                                <div class="inline-flex items-center px-3 py-2 rounded-full text-xs font-semibold 
                                    bg-gradient-to-r from-green-100 via-green-200 to-emerald-100 text-green-800 border border-green-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    {{ $location->radius }}m
                                </div>
                            </td>
                            
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                    bg-blue-100 text-blue-800">
                                    {{ $location->classes_count ?? 0 }} kelas
                                </span>
                            </td>
                            
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold 
                                    {{ $location->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                    {{ $location->is_active ? '✅ Aktif' : '⏸️ Nonaktif' }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.locations.show', $location) }}" 
                                   class="inline-flex items-center px-3 py-2 text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors text-xs">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('admin.locations.edit', $location) }}" 
                                   class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors text-xs">
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

        <!-- Pagination -->
        <div class="mt-8">
            {{ $locations->appends(request()->query())->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada lokasi</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan lokasi pembelajaran pertama Anda.</p>
            <div class="mt-6">
                <a href="{{ route('admin.locations.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 shadow-lg transform hover:-translate-y-1 transition-all font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Lokasi Pertama
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection