<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- imagen logo -->
            <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2">
                <img src="<?php echo e(asset('storage/imgages/social_petpng.png')); ?>"
                    alt="Social Pet"
                    class="h-10 w-auto rounded-lg">
                <span class="text-xl font-bold bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent">
                    SocialPet
                </span>
            </a>

            <!-- barra de busqueda -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::currentRouteName() == 'dashboard' || Route::currentRouteName() == 'feed'): ?>
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <input type="text"
                        placeholder="Buscar mascotas, dueños o lugares..."
                        class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 border-0 focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all duration-200">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Botones de navegación -->
            <div class="flex items-center space-x-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <!-- Usuario autenticado -->
                <a href="<?php echo e(route('dashboard')); ?>" class="p-2 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>

                <a href="<?php echo e(route('feed')); ?>" class="p-2 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </a>

                <!-- Notificaciones -->
                <button class="relative p-2 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Perfil con Dropdown -->
                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(Auth::user()->nom_us ?? Auth::user()->name ?? 'Usuario')); ?>&background=0d9488&color=fff&bold=true&length=2&size=32"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full ring-2 ring-teal-500 ring-offset-2 transition-all duration-200 group-hover:scale-105">
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 border border-gray-100 z-50">

                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900"><?php echo e(Auth::user()->nom_us ?? Auth::user()->name ?? 'Usuario'); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e(Auth::user()->ema_us ?? Auth::user()->email ?? ''); ?></p>
                        </div>

                        <!-- ruta perfil -->
                        <a href="<?php echo e(route('profile')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Mi Perfil</span>
                            </div>
                        </a>

                        <a href="<?php echo e(route('my-pets')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>Mis Mascotas</span>
                            </div>
                        </a>

                        <!-- Enlace de Mensajes - COMENTADO TEMPORALMENTE -->

                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>Mensajes</span>
                            </div>
                        </a>


                        <a href="<?php echo e(route('settings')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Configuración</span>
                            </div>
                        </a>

                        <hr class="my-1">

                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
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
                <?php else: ?>
                <!-- Usuario no autenticado - Login y Registro -->
                <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-teal-600 transition font-medium">
                    Iniciar Sesión
                </a>
                <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-5 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-800 transition shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Registrarse
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            open: false,
            toggle() {
                this.open = !this.open
            }
        }))
    })
</script><?php /**PATH C:\laragon\www\social_pet\resources\views/navigation-menu.blade.php ENDPATH**/ ?>