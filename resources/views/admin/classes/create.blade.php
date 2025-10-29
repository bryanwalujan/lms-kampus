{{-- resources/views/admin/classes/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Buat Kelas Baru - LMS Lokasi')

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
                <a href="{{ route('admin.classes.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Kelas</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500">Buat Kelas</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">📚 Buat Kelas Baru</h1>
                        <p class="mt-2 text-sm text-gray-600">Isi detail kelas pembelajaran untuk sistem absensi GPS</p>
                    </div>
                    <a href="{{ route('admin.classes.index') }}" 
                       class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3">
                        ← Kembali ke Daftar Kelas
                    </a>
                </div>
            </div>

            <!-- Create Form -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <form method="POST" action="{{ route('admin.classes.store') }}" class="p-8">
                    @csrf
                    
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Informasi Dasar
                            </h3>
                            
                            <!-- Name -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Nama Kelas <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       required
                                       placeholder="Contoh: Pemrograman Web Lanjutan"
                                       class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-lg placeholder-gray-500 @error('name') border-red-300 bg-red-50 @enderror">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Kode Kelas <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       name="code" 
                                       value="{{ old('code') }}"
                                       placeholder="Contoh: PW-2024-A"
                                       maxlength="20"
                                       class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-lg placeholder-gray-500 @error('code') border-red-300 bg-red-50 @enderror">
                                @error('code')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">Kode unik untuk kelas (max 20 karakter)</p>
                            </div>
                        </div>

                        <!-- Location & Dosen -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Lokasi & Dosen
                            </h3>

                            <!-- Location -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Lokasi Pembelajaran <span class="text-red-500">*</span></label>
                                <select name="location_id" 
                                        required
                                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-lg @error('location_id') border-red-300 bg-red-50 @enderror">
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            📍 {{ $location->name }} ({{ $location->type }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Dosen -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Dosen Pengajar <span class="text-red-500">*</span></label>
                                <select name="dosen_id" 
                                        required
                                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-lg @error('dosen_id') border-red-300 bg-red-50 @enderror">
                                    <option value="">Pilih Dosen</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                            👨‍🏫 {{ $dosen->name }}
                                            @if($dosen->profile?->nim_nidn)
                                                ({{ $dosen->profile->nim_nidn }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Deskripsi Kelas</label>
                        <textarea name="description" 
                                  rows="4"
                                  placeholder="Jelaskan mata kuliah ini secara singkat..."
                                  class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-vertical @error('description') border-red-300 bg-red-50 @enderror">{{ old('description') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Opsional - Gunakan untuk memberikan informasi tambahan tentang kelas</p>
                    </div>

                    <!-- Capacity & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Kapasitas Mahasiswa <span class="text-red-500">*</span></label>
                            <input type="number" 
                                   name="max_students" 
                                   value="{{ old('max_students', 30) }}"
                                   min="1" max="1000"
                                   required
                                   class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all text-lg @error('max_students') border-red-300 bg-red-50 @enderror">
                            @error('max_students')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Status Kelas <span class="text-red-500">*</span></label>
                            <select name="status" 
                                    required
                                    class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all text-lg">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>⌛ Draft</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ Aktif</option>
                                <option value="finished" {{ old('status') == 'finished' ? 'selected' : '' }}>🏁 Selesai</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-8 rounded-xl hover:from-green-600 hover:to-emerald-700 font-semibold shadow-lg transform hover:-translate-y-1 transition-all text-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Kelas Baru
                        </button>
                        <a href="{{ route('admin.classes.index') }}" 
                           class="flex-1 bg-white border border-gray-300 text-gray-700 py-4 px-8 rounded-xl hover:bg-gray-50 font-semibold shadow-sm transition-all text-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection