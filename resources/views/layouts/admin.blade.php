<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Social Pet')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 w-72 h-full bg-gradient-to-br from-[#1a1a2e] to-[#16213e] text-white transition-all duration-300 z-50 overflow-y-auto">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-orange-500">🐾 Social Pet</h2>
            <p class="text-gray-400 text-sm mt-1">Panel Administrativo</p>
        </div>
        
        <hr class="border-gray-700 mx-4">
        
        <nav class="mt-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-5 py-3 mx-3 rounded-lg transition-all duration-300 hover:bg-orange-500 hover:translate-x-1 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500' : '' }}">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('admin.usuarios.index') }}" 
               class="flex items-center gap-3 px-5 py-3 mx-3 rounded-lg transition-all duration-300 hover:bg-orange-500 hover:translate-x-1 {{ request()->routeIs('admin.usuarios.*') ? 'bg-orange-500' : '' }}">
                <span>👥</span> Usuarios
            </a>
            <a href="{{ route('admin.mascotas.index') }}" 
               class="flex items-center gap-3 px-5 py-3 mx-3 rounded-lg transition-all duration-300 hover:bg-orange-500 hover:translate-x-1 {{ request()->routeIs('admin.mascotas.*') ? 'bg-orange-500' : '' }}">
                <span>🐕</span> Mascotas
            </a>
            <a href="{{ route('admin.publicaciones.index') }}" 
               class="flex items-center gap-3 px-5 py-3 mx-3 rounded-lg transition-all duration-300 hover:bg-orange-500 hover:translate-x-1 {{ request()->routeIs('admin.publicaciones.*') ? 'bg-orange-500' : '' }}">
                <span>📝</span> Publicaciones
            </a>
        </nav>
        
        <hr class="border-gray-700 mx-4 my-4">
        
        <div class="absolute bottom-0 left-0 right-0 p-6">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center gap-3 px-5 py-3 mx-3 rounded-lg transition-all duration-300 hover:bg-red-700 w-full text-left bg-red-600">
                    <span>🚪</span> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-72 min-h-screen">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
            <div class="flex justify-between items-center px-6 py-4">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->nom_us ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">Administrador</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->nom_us ?? 'A', 0, 2)) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    <!-- Mobile menu button (hidden on desktop) -->
    <button id="mobileMenuBtn" 
            class="fixed bottom-4 right-4 bg-orange-600 text-white p-3 rounded-full shadow-lg hidden z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.querySelector('aside');
        
        // Check screen size on load
        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                mobileMenuBtn.classList.remove('hidden');
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            } else {
                mobileMenuBtn.classList.add('hidden');
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            }
        }
        
        // Initial check
        checkScreenSize();
        
        // Toggle sidebar on mobile
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');
            });
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', checkScreenSize);
    </script>
    @stack('scripts')
</body>
</html>