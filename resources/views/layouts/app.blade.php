<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocialPet') }}</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/img/logo/social_pet.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/img/logo/social_pet.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('storage/img/logo/social_et.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    
    <!-- Alpine.js - Cargar antes que cualquier script que lo use -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <style>
        [x-cloak] {
            display: none !important;
        }
        
        /* Burbuja de soporte/admins */
        .support-bubble {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        .bubble-button {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0d9488, #115e59);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .bubble-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        
        .bubble-button span {
            font-size: 28px;
        }
        
        .support-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .support-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .support-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: background 0.2s ease;
            border-radius: 15px;
            cursor: pointer;
        }
        
        .support-menu a:first-child {
            border-radius: 15px 15px 0 0;
        }
        
        .support-menu a:last-child {
            border-radius: 0 0 15px 15px;
        }
        
        .support-menu a:hover {
            background: #f0fdf4;
            color: #0d9488;
        }
        
        .support-menu span {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .support-menu .admin-link {
            border-top: 1px solid #e5e7eb;
            color: #0d9488;
        }
        
        .support-menu .admin-link:hover {
            background: #f0fdf4;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(13, 148, 136, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(13, 148, 136, 0);
            }
        }
        
        @media (max-width: 480px) {
            .support-bubble {
                bottom: 20px;
                right: 20px;
            }
            
            .bubble-button {
                width: 50px;
                height: 50px;
            }
            
            .bubble-button span {
                font-size: 24px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased overflow-x-hidden bg-gray-100">

    @livewire('navigation-menu')

    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Burbuja de soporte/administradores -->
    <div class="support-bubble">
        <div class="bubble-button" onclick="toggleSupportMenu()">
            <span>💬</span>
        </div>
        <div class="support-menu" id="supportMenu">
            <a onclick="openSupport()">
                <span>❓</span> Ayuda/Soporte
            </a>
            <a onclick="openContact()">
                <span>📧</span> Contacto
            </a>
            @auth
                @if(Auth::user()->is_admin)
                <a href="{{ route('admin.soporte.dashboard') }}" class="admin-link">
                    <span>🛠️</span> Panel de Soporte
                </a>
                @endif
            @endauth
        </div>
    </div>

    @livewireScripts

    <script>
        // Horario de atención (Lunes a Viernes, 9:00 - 18:00)
        function isWithinBusinessHours() {
            const now = new Date();
            const day = now.getDay();
            const hour = now.getHours();
            
            if (day === 0 || day === 6) return false;
            return hour >= 9 && hour < 18;
        }
        
        function toggleSupportMenu() {
            const menu = document.getElementById('supportMenu');
            menu.classList.toggle('active');
        }
        
        function openSupport() {
            const menu = document.getElementById('supportMenu');
            menu.classList.remove('active');
            
            if (isWithinBusinessHours()) {
                window.location.href = "{{ route('soporte.index') }}";
            } else {
                Swal.fire({
                    icon: 'info',
                    title: '📌 Fuera de Horario de Atención',
                    html: `
                        <div class="text-left">
                            <p class="mb-2"><strong>Horario de atención:</strong></p>
                            <p>📅 Lunes a Viernes</p>
                            <p>⏰ 9:00 AM - 6:00 PM</p>
                            <hr class="my-3">
                            <p class="text-sm text-gray-600">Tu consulta será atendida en el siguiente horario laboral.</p>
                        </div>
                    `,
                    confirmButtonText: '📝 Dejar Ticket',
                    confirmButtonColor: '#0d9488',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('soporte.index') }}";
                    }
                });
            }
        }
        
        function openContact() {
            const menu = document.getElementById('supportMenu');
            menu.classList.remove('active');
            
            Swal.fire({
                icon: 'info',
                title: '📧 Contacto',
                html: `
                    <div class="text-left">
                        <p class="mb-2"><strong>Canales de contacto:</strong></p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 p-2 bg-teal-50 rounded">
                                <span>📧</span>
                                <span><strong>Email:</strong> soporte@socialpet.com</span>
                            </div>
                            <div class="flex items-center space-x-2 p-2 bg-teal-50 rounded">
                                <span>📞</span>
                                <span><strong>Teléfono:</strong> +54 11 1234-5678</span>
                            </div>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#0d9488'
            });
        }
        
        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', function(event) {
            const bubble = document.querySelector('.support-bubble');
            const menu = document.getElementById('supportMenu');
            
            if (bubble && !bubble.contains(event.target) && menu && menu.classList.contains('active')) {
                menu.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>