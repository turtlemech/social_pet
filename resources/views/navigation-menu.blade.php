<nav class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('img/logo/social_pet.webp') }}"
                    alt="Social Pet"
                    class="h-10 w-auto rounded-lg"
                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=SP&background=0d9488&color=fff&bold=true&size=40';">
                <span class="text-xl font-bold bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent">
                    SocialPet
                </span>
            </a>

            <!-- Barra de búsqueda -->
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <input id="liveSearch" type="text" placeholder="Buscar mascotas o usuarios..." autocomplete="off"
                        class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 border-0 focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all duration-200">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <div id="searchResults" class="hidden absolute top-12 left-0 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50"></div>
                </div>
            </div>  

            <!-- Botones de navegación -->
            <div class="flex items-center space-x-3">
                @auth
                <a href="{{ route('dashboard') }}" class="p-2 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>

                <a href="{{ route('marketplace.index') }}" class="p-2 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14l-1 11H6L5 8zm4 0V6a3 3 0 116 0v2" />
                    </svg>
                </a>

                <!-- Notificaciones (componente Alpine separado) -->
                <div x-data="{ notificationsOpen: false, filtro: 'todas' }" class="relative">
                    <button @click="notificationsOpen = !notificationsOpen; if(notificationsOpen){ fetch('/notifications/read', { method:'POST', headers:{ 'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content, 'Accept':'application/json' } }) }"
                        class="relative p-2 rounded-lg transition"
                        :class="notificationsOpen ? 'text-teal-600 bg-teal-50' : 'text-gray-600 hover:text-teal-600 hover:bg-teal-50'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @php
                            $unreadNotifications = \App\Models\Notificacion::where('usuario_id', auth()->id())->where('lei_not', false)->count();
                        @endphp
                        @if($unreadNotifications > 0)
                        <span class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-bold">
                            {{ $unreadNotifications }}
                        </span>
                        @endif
                    </button>

                    <!-- Panel de notificaciones -->
                    <div x-show="notificationsOpen" x-cloak @click.away="notificationsOpen = false" class="fixed right-0 top-0 h-full w-full sm:w-[420px] bg-white shadow-2xl z-50 overflow-hidden flex flex-col">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800">Notificaciones</h2>
                            <button @click="notificationsOpen = false" class="text-gray-500 hover:text-black text-2xl">✕</button>
                        </div>
                        <!-- Filtros -->
                        <div class="px-6 py-4 flex gap-3 border-b border-gray-100">
                            <button @click="filtro = 'todas'" :class="filtro === 'todas' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-full text-sm font-medium transition">Todas</button>
                            <button @click="filtro = 'like'" :class="filtro === 'like' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-full text-sm font-medium transition">Likes</button>
                            <button @click="filtro = 'comentario'" :class="filtro === 'comentario' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-full text-sm font-medium transition">Comentarios</button>
                            <button @click="filtro = 'follow'" :class="filtro === 'follow' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-full text-sm font-medium transition">Seguidores</button>
                        </div>
                        <!-- Lista de notificaciones -->
                        <div class="flex-1 overflow-y-auto">
                            @php
                                $notifications = \App\Models\Notificacion::where('usuario_id', auth()->id())->latest()->take(30)->get();
                            @endphp
                            @forelse($notifications as $notification)
                            <div x-show="filtro === 'todas' || filtro === '{{ $notification->tip_not }}'">
                                <a href="{{ $notification->url_not ?? '#' }}" class="flex gap-4 px-6 py-4 hover:bg-gray-50 transition border-b border-gray-100">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-teal-500 to-emerald-500 text-white flex items-center justify-center font-bold text-lg">🔔</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 leading-6"><span class="font-semibold">{{ $notification->tit_not }}</span> {{ $notification->men_not }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if(!$notification->lei_not)
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                                    @endif
                                </a>
                            </div>
                            @empty
                            <div class="flex flex-col items-center justify-center h-full text-center px-10">
                                <div class="text-6xl mb-4">🔔</div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Sin notificaciones</h3>
                                <p class="text-gray-500">Aquí aparecerán likes, comentarios y nuevos seguidores.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Perfil con Dropdown (Alpine independiente) -->
                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 focus:outline-none group">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nom_us ?? Auth::user()->name ?? 'Usuario') }}&background=0d9488&color=fff&bold=true&length=2&size=32"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full ring-2 ring-teal-500 ring-offset-2 transition-all duration-200 group-hover:scale-105">
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 border border-gray-100 z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->nom_us ?? Auth::user()->name ?? 'Usuario' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->ema_us ?? Auth::user()->email ?? '' }}</p>
                        </div>

                        <a href="{{ route('usuario.profile', auth()->user()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Mi Perfil</span>
                            </div>
                        </a>

                        <a href="{{ route('my-pets') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>Mis Mascotas</span>
                            </div>
                        </a>

                        <a href="{{ route('messages.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>Mensajes</span>
                            </div>
                        </a>

                        <a href="{{ route('matches.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span>Matches</span>
                            </div>
                        </a>

                        <a href="{{ route('comunidades.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H11a4 4 0 00-4 4v2m10 0H7m10-8a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>Comunidades</span>
                            </div>
                        </a>

                        <a href="{{ route('adopciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 17.8L12 21l-6.879-3.196z" />
                                </svg>
                                <span>Adopciones</span>
                            </div>
                        </a>

                        <a href="{{ route('configuracion') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Configuración</span>
                            </div>
                        </a>

                        <hr class="my-1">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Cerrar Sesión</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-teal-600 transition font-medium">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-5 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-800 transition shadow-md hover:shadow-lg">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Registrarse
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
// Búsqueda en vivo
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('liveSearch');
    const results = document.getElementById('searchResults');

    if (input) {
        input.addEventListener('input', async () => {
            const q = input.value.trim();
            if (q.length < 2) {
                results.classList.add('hidden');
                results.innerHTML = '';
                return;
            }
            try {
                const response = await fetch(`/search/live?q=${encodeURIComponent(q)}`);
                const data = await response.json();
                let html = '';
                data.usuarios?.forEach(usuario => {
                    html += `<a href="${usuario.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 border-b">
                        <div class="w-10 h-10 rounded-full bg-teal-500 text-white flex items-center justify-center">👤</div>
                        <div><div class="font-medium">${usuario.nombre}</div><div class="text-xs text-gray-500">Usuario</div></div>
                    </a>`;
                });
                data.mascotas?.forEach(mascota => {
                    html += `<a href="${mascota.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 border-b">
                        <div class="w-10 h-10 rounded-full bg-pink-500 text-white flex items-center justify-center">🐾</div>
                        <div><div class="font-medium">${mascota.nombre}</div><div class="text-xs text-gray-500">Mascota</div></div>
                    </a>`;
                });
                if (!data.usuarios?.length && !data.mascotas?.length) {
                    html = `<div class="p-4 text-center text-gray-500">No se encontraron resultados</div>`;
                }
                results.innerHTML = html;
                results.classList.remove('hidden');
            } catch (error) {
                console.error(error);
            }
        });
        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.classList.add('hidden');
            }
        });
    }
});
</script>