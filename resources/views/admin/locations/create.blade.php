{{-- resources/views/admin/locations/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">📍 Tambah Lokasi Baru</h1>
            
            <form method="POST" action="{{ route('admin.locations.store') }}" 
                  class="max-w-4xl bg-white shadow-xl rounded-2xl p-8" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">📌 Nama Lokasi</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: Gedung Lab Komputer Lt.2" required>
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">📍 Alamat Lengkap</label>
                            <textarea name="address" rows="3" 
                                      class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                      placeholder="Alamat lengkap lokasi...">{{ old('address') }}</textarea>
                            @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">🏷️ Tipe Lokasi</label>
                            <select name="type" 
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent @error('type') border-red-500 @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="campus" {{ old('type') == 'campus' ? 'selected' : '' }}>🏫 Kampus</option>
                                <option value="lab" {{ old('type') == 'lab' ? 'selected' : '' }}>🔬 Laboratorium</option>
                                <option value="field" {{ old('type') == 'field' ? 'selected' : '' }}>🌳 Lapangan</option>
                                <option value="library" {{ old('type') == 'library' ? 'selected' : '' }}>📚 Perpustakaan</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>📍 Lainnya</option>
                            </select>
                            @error('type') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">📝 Deskripsi</label>
                            <textarea name="description" rows="4" 
                                      class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                      placeholder="Deskripsi lokasi (opsional)">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Location & Map -->
                    <div class="space-y-6">
                        <!-- GPS Coordinates -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">📊 Koordinat GPS</label>
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Latitude</label>
                                    <input type="number" name="latitude" step="any" 
                                           value="{{ old('latitude') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 @error('latitude') border-red-500 @enderror"
                                           placeholder="-6.2088" required>
                                    @error('latitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Longitude</label>
                                    <input type="number" name="longitude" step="any" 
                                           value="{{ old('longitude') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 @error('longitude') border-red-500 @enderror"
                                           placeholder="106.8456" required>
                                    @error('longitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button type="button" onclick="getCurrentLocation()" 
                                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-xl hover:bg-blue-700 text-sm font-medium">
                                    📱 Ambil GPS Saya
                                </button>
                                <a href="https://www.google.com/maps" target="_blank" 
                                   class="flex-1 bg-gray-600 text-white py-2 px-4 rounded-xl hover:bg-gray-700 text-sm font-medium text-center">
                                    🗺️ Google Maps
                                </a>
                            </div>
                        </div>

                        <!-- Radius -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">📏 Radius Check-in</label>
                            <div class="relative">
                                <input type="range" name="radius" min="5" max="1000" step="5" 
                                       value="{{ old('radius', 50) }}"
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider" 
                                       oninput="updateRadiusValue(this.value)"
                                       id="radius-slider">
                                <div class="flex justify-between text-xs text-gray-500 mt-2">
                                    <span>5m</span>
                                    <span id="radius-value">{{ old('radius', 50) }}m</span>
                                    <span>1000m</span>
                                </div>
                            </div>
                            @error('radius') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">🖼️ Foto Lokasi (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} 
                                   class="w-5 h-5 text-green-600 rounded focus:ring-green-500">
                            <label class="ml-3 text-sm font-semibold text-gray-700">Aktifkan lokasi</label>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex gap-4 pt-8 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-4 rounded-xl hover:from-green-600 hover:to-green-700 font-semibold shadow-lg transform hover:-translate-y-1 transition-all">
                        💾 Simpan Lokasi
                    </button>
                    <a href="{{ route('admin.locations.index') }}" 
                       class="flex-1 bg-gray-600 text-white px-8 py-4 rounded-xl hover:bg-gray-700 font-semibold text-center">
                        ← Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.querySelector('input[name="latitude"]').value = position.coords.latitude.toFixed(8);
            document.querySelector('input[name="longitude"]').value = position.coords.longitude.toFixed(8);
            alert('GPS berhasil diambil! Koordinat: ' + position.coords.latitude + ', ' + position.coords.longitude);
        }, function(error) {
            alert('Gagal mengambil lokasi: ' + error.message);
        });
    } else {
        alert('Browser tidak mendukung geolocation');
    }
}

function updateRadiusValue(value) {
    document.getElementById('radius-value').textContent = value + 'm';
    document.querySelector('input[name="radius"]').value = value;
}

// Custom slider style
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .slider::-webkit-slider-thumb {
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #10b981;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
        }
        .slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #10b981;
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection