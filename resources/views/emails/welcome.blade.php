<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a SocialPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 via-white to-teal-50 m-0 p-4">
    <div class="max-w-2xl mx-auto my-5 bg-white rounded-2xl overflow-hidden shadow-2xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-800 text-white py-12 px-8 text-center relative">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"%3E%3Cpath d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 13c-2.33 0-4.31-1.46-5.11-3.5h10.22c-.8 2.04-2.78 3.5-5.11 3.5z"/%3E%3C/svg%3E')] bg-repeat"></div>
            <div class="relative z-10">
                <div class="text-6xl mb-3 animate-bounce">🐾</div>
                <div class="text-3xl font-bold tracking-wider">SocialPet</div>
                <p class="mt-2 text-teal-100 font-light">La red social de las mascotas</p>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-8 md:p-10">
            <!-- Welcome Message -->
            <div class="border-b border-teal-100 pb-4 mb-6">
                <div class="text-2xl md:text-3xl text-teal-700 font-bold">
                    ¡Hola {{ $user->nom_us }}! 
                    <span class="inline-block animate-wave">👋</span>
                </div>
            </div>
            
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">
                ¡Bienvenido a <strong class="text-teal-600 font-bold">SocialPet</strong>! Nos llena de alegría que formes parte de esta gran familia de amantes de las mascotas. 🎉
            </p>
            
            <!-- Info Card -->
            <div class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-xl p-6 my-6 border-l-4 border-teal-600 shadow-sm">
                <h3 class="text-teal-700 font-bold text-lg mt-0 mb-4 flex items-center gap-2">
                    <span>✨</span> Tu cuenta ha sido creada exitosamente
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-semibold text-teal-700 min-w-[90px]">👤 Nombre completo:</span>
                        <span class="text-gray-700">{{ trim($user->nom_us . ' ' . $user->app_us . ' ' . ($user->apm_us ?? '')) }}</span>
                    </div>
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-semibold text-teal-700 min-w-[90px]">📧 Email:</span>
                        <span class="text-gray-700">{{ $user->ema_us }}</span>
                    </div>
                    @if($user->tel_us)
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-semibold text-teal-700 min-w-[90px]">📞 Teléfono:</span>
                        <span class="text-gray-700">{{ $user->tel_us }}</span>
                    </div>
                    @endif
                    @if($user->ubi_us)
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-semibold text-teal-700 min-w-[90px]">📍 Ubicación:</span>
                        <span class="text-gray-700">{{ $user->ubi_us }}</span>
                    </div>
                    @endif
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-semibold text-teal-700 min-w-[90px]">🆔 Código:</span>
                        <span class="text-gray-700 font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $cod_us }}</span>
                    </div>
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-semibold text-teal-700 min-w-[90px]">📅 Fecha registro:</span>
                        <span class="text-gray-700">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Features -->
            <h3 class="text-gray-800 font-bold text-xl mb-5 flex items-center gap-2">
                <span>🐾</span> ¿Qué puedes hacer en SocialPet?
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
                @php
                    $features = [
                        ['icon' => '🐕', 'title' => 'Registra mascotas', 'desc' => 'Crea perfiles para tus peludos amigos'],
                        ['icon' => '📸', 'title' => 'Comparte momentos', 'desc' => 'Publica fotos y videos de tus mascotas'],
                        ['icon' => '🤝', 'title' => 'Conecta con otros', 'desc' => 'Haz amigos amantes de las mascotas'],
                        ['icon' => '🏆', 'title' => 'Eventos y concursos', 'desc' => 'Participa en actividades divertidas'],
                        ['icon' => '🛒', 'title' => 'Tienda de productos', 'desc' => 'Encuentra productos para tu mascota'],
                        ['icon' => '❤️', 'title' => 'Adopciones responsables', 'desc' => 'Ayuda a encontrar un hogar'],
                    ];
                @endphp
                
                @foreach($features as $feature)
                <div class="bg-gray-50 p-4 rounded-xl text-center hover:bg-teal-50 transition-all duration-300 group cursor-pointer transform hover:scale-105">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition-transform inline-block">{{ $feature['icon'] }}</div>
                    <div class="font-bold text-gray-800 mb-1">{{ $feature['title'] }}</div>
                    <div class="text-xs text-gray-600">{{ $feature['desc'] }}</div>
                </div>
                @endforeach
            </div>
            
            <!-- CTA Button -->
            <div class="text-center my-8">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal-800 text-white px-8 py-3 rounded-full font-bold hover:from-teal-700 hover:to-teal-900 transform hover:scale-105 transition-all duration-300 shadow-lg group">
                    <span>🚀</span>
                    Comenzar ahora en SocialPet
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg my-6">
                <p class="text-sm text-gray-700">
                    💡 <strong class="text-yellow-700">Tip:</strong> Completa tu perfil agregando una foto y registrando a tus mascotas para una mejor experiencia.
                </p>
            </div>
            
            <p class="text-sm text-center text-gray-500 mt-6">
                ¿Tienes preguntas? Contáctanos a 
                <a href="mailto:soporte@socialpet.com" class="text-teal-600 hover:text-teal-700 font-semibold">soporte199120@gmail.com</a>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-900 text-white py-8 px-5 text-center">
            
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SocialPet - Donde las mascotas son la estrella</p>
            <p class="text-gray-500 text-xs mt-3">Este es un correo automático, por favor no responder.</p>
        </div>
    </div>
    
    <style>
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-20deg); }
        }
        .animate-wave {
            animation: wave 1s ease-in-out infinite;
            display: inline-block;
        }
    </style>
</body>
</html>