@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fadeInUp">
                <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Conecta con <span class="text-yellow-300">amantes de mascotas</span> y comparte momentos inolvidables
                </h1>
                <p class="text-lg lg:text-xl text-teal-100 mb-8">
                    Únete a la comunidad más grande de dueños de mascotas. Comparte fotos, historias y consejos con personas que aman a sus animales tanto como tú.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-white text-teal-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg text-center">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ url('/register') }}" class="bg-white text-teal-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg text-center">
                            Comenzar gratis
                        </a>
                        <a href="{{ url('/login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-teal-600 transition text-center">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mt-12 pt-8 border-t border-teal-500">
                    <div>
                        <p class="text-2xl font-bold">10k+</p>
                        <p class="text-sm text-teal-200">Usuarios activos</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">50k+</p>
                        <p class="text-sm text-teal-200">Mascotas registradas</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">100k+</p>
                        <p class="text-sm text-teal-200">Publicaciones</p>
                    </div>
                </div>
            </div>
            
            <div class="relative animate-float">
                <img src="https://cdn-icons-png.flaticon.com/512/1998/1998629.png" alt="Pets" class="w-full max-w-md mx-auto">
                <div class="absolute -bottom-10 -left-10 bg-white rounded-full p-3 shadow-lg">
                    <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">🐕</span>
                    </div>
                </div>
                <div class="absolute -top-10 -right-10 bg-white rounded-full p-3 shadow-lg">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">🐈</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Características increíbles para ti y tu mascota
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Todo lo que necesitas para compartir y disfrutar de tu experiencia como dueño de mascota
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card-hover bg-gray-50 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Comparte fotos y videos</h3>
                <p class="text-gray-600">Sube momentos especiales de tu mascota y compártelos con la comunidad.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="card-hover bg-gray-50 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Conecta con otros dueños</h3>
                <p class="text-gray-600">Encuentra amigos que compartan tu pasión por los animales.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="card-hover bg-gray-50 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Consejos y cuidados</h3>
                <p class="text-gray-600">Aprende de expertos y comparte tus experiencias sobre el cuidado de mascotas.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section id="how-it-works" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                ¿Cómo funciona?
            </h2>
            <p class="text-lg text-gray-600">Tres pasos simples para empezar</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-teal-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Crea tu cuenta</h3>
                <p class="text-gray-600">Regístrate gratis y crea tu perfil como dueño de mascota.</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-teal-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Registra a tu mascota</h3>
                <p class="text-gray-600">Añade a tus mascotas con fotos y datos importantes.</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-teal-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Comparte y conecta</h3>
                <p class="text-gray-600">Publica contenido y conoce a otros amantes de mascotas.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="hero-gradient text-white py-16">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="text-3xl lg:text-4xl font-bold mb-4">
            Únete a la comunidad hoy
        </h2>
        <p class="text-lg text-teal-100 mb-8">
            Miles de dueños de mascotas ya están compartiendo sus momentos especiales
        </p>
        @auth
            <a href="{{ url('/dashboard') }}" class="inline-block bg-white text-teal-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                Ir al Dashboard
            </a>
        @else
            <a href="{{ url('/register') }}" class="inline-block bg-white text-teal-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                Comenzar ahora - Es gratis
            </a>
        @endauth
    </div>
</section>

<style>
    .hero-gradient {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #0d9488 100%);
    }
    
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease-out;
    }
</style>
@endsection