{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit User - LMS Lokasi')

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
                <span class="ml-1 text-sm font-medium text-gray-500">Edit {{ $user->name }}</span>
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
                    <h1 class="text-3xl font-bold text-gray-900">✏️ Edit User</h1>
                    <p class="mt-2 text-sm text-gray-600">Perbarui informasi user {{ $user->name }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-semibold">
                        👁️ Lihat User
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-semibold">
                        ← Kembali
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
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
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">👤 Informasi Dasar</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                                       placeholder="user@example.com" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                                <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('role') border-red-500 @enderror" required>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>👨‍💼 Admin</option>
                                    <option value="dosen" {{ old('role', $user->role) == 'dosen' ? 'selected' : '' }}>👨‍🏫 Dosen</option>
                                    <option value="mahasiswa" {{ old('role', $user->role) == 'mahasiswa' ? 'selected' : '' }}>👨‍🎓 Mahasiswa</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <!-- Password (Optional) -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">🔐 Ubah Password (Opsional)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                        <input type="password" name="password" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                                               placeholder="Kosongkan jika tidak ingin ubah">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">📋 Profil Akademik</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ old('role', $user->role) == 'mahasiswa' ? 'NIM' : 'NIDN' }} 
                                    @if(old('role', $user->role) != 'admin')
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="text" name="nim_nidn" value="{{ old('nim_nidn', $user->profile->nim_nidn ?? '') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('nim_nidn') border-red-500 @enderror"
                                       placeholder="Masukkan NIM/NIDN"
                                       {{ old('role', $user->role) == 'admin' ? '' : 'required' }}>
                            </div>

                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">✅ Aktifkan user ini</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-semibold">
                                ← Batal
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold shadow-lg transform hover:-translate-y-0.5 transition-all">
                                💾 Update User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection