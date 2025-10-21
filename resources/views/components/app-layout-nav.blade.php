{{-- resources/views/components/app-layout-nav.blade.php --}}
<nav class="bg-white border-b border-gray-100 shadow-sm z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">📍</span>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <span class="text-xl font-bold text-gray-900 tracking-tight">LMS Lokasi</span>
                        <span class="text-xs text-green-600 font-semibold">GPS Attendance</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    👥 Users
                </a>
                <a href="{{ route('admin.classes.index') }}" 
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors {{ request()->routeIs('admin.classes.*') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    🏫 Kelas
                </a>
                <a href="{{ route('admin.locations.index') }}" 
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors {{ request()->routeIs('admin.locations.*') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    📍 Lokasi
                </a>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <!-- Role Badge -->
                @auth
                <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-gradient-to-r 
                    {{ auth()->user()->role == 'admin' ? 'from-red-500 to-pink-500' : 
                       (auth()->user()->role == 'dosen' ? 'from-green-500 to-teal-500' : 'from-blue-500 to-indigo-500') }}
                    text-white shadow-sm">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                @endauth

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    @auth
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors">
                        <img class="w-9 h-9 rounded-full ring-2 ring-gray-200" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff&size=128" 
                             alt="{{ auth()->user()->name }}">
                        <span class="hidden sm:inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                        <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl ring-1 ring-black ring-opacity-5 shadow-xl z-50 overflow-hidden"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Button -->
<div class="md:hidden">
    <div class="px-4 pt-2 pb-3 space-y-1 bg-white border-b border-gray-100">
        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-700' : 'hover:bg-gray-50' }}">Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-green-50 text-green-700' : 'hover:bg-gray-50' }}">Users</a>
        <a href="{{ route('admin.classes.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md {{ request()->routeIs('admin.classes.*') ? 'bg-green-50 text-green-700' : 'hover:bg-gray-50' }}">Kelas</a>
        <a href="{{ route('admin.locations.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md {{ request()->routeIs('admin.locations.*') ? 'bg-green-50 text-green-700' : 'hover:bg-gray-50' }}">Lokasi</a>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/@preline/highlight.js"></script>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            fontFamily: {
                'sans': ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            }
        }
    }
</script>
@endpush