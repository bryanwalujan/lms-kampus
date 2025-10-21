{{-- resources/views/admin/classes/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Kelas - LMS Lokasi')

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
                <span class="ml-1 text-sm font-medium text-gray-500">Edit {{ $class->name }}</span>
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
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">✏️ Edit Kelas</h1>
                    <p class="mt-2 text-sm text-gray-600">Perbarui informasi kelas {{ $class->name }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.classes.show', $class) }}" 
                       class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-semibold">
                        👁️ Lihat Kelas
                    </a>
                    <a href="{{ route('admin.classes.index') }}" 
                       class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-semibold">
                        ← Kembali
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <form method="POST" action="{{ route('admin.classes.update', $class) }}">
                    @csrf
                    @method('PUT')
                    <div class="p-8">
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Ada kesalahan!</h3>
                                        <ul class="mt-2 text-sm text-red-700">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Info -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">📋 Informasi Dasar</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Kelas <span class="text-red-500">*</span></label>
                                <input type="text" name="code" value="{{ old('code', $class->code) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror"
                                       placeholder="Contoh: IF101" maxlength="20" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $class->name) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                       placeholder="Pemrograman Web Lanjutan" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">📍 Lokasi <span class="text-red-500">*</span></label>
                                <select name="location_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('location_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id', $class->location_id) == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }} ({{ $location->type }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">👨‍🏫 Dosen <span class="text-red-500">*</span></label>
                                <select name="dosen_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('dosen_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_id', $class->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Mahasiswa <span class="text-red-500">*</span></label>
                                <input type="number" name="max_students" value="{{ old('max_students', $class->max_students) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('max_students') border-red-500 @enderror"
                                       min="1" max="1000" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                                    <option value="active" {{ old('status', $class->status) == 'active' ? 'selected' : '' }}>✅ Aktif</option>
                                    <option value="draft" {{ old('status', $class->status) == 'draft' ? 'selected' : '' }}>⌛ Draft</option>
                                    <option value="finished" {{ old('status', $class->status) == 'finished' ? 'selected' : '' }}>🏁 Selesai</option>
                                    <option value="cancelled" {{ old('status', $class->status) == 'cancelled' ? 'selected' : '' }}>❌ Dibatal</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="description" rows="4" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                          placeholder="Deskripsi singkat tentang kelas ini...">{{ old('description', $class->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.classes.show', $class) }}" 
                               class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-semibold">
                                ← Batal
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 font-semibold shadow-lg transform hover:-translate-y-0.5 transition-all">
                                💾 Update Kelas
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection