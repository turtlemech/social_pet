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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Estilos de la burbuja -->
    <style>
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
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- SOLO UN NAVBAR --}}
        @livewire('navigation-menu')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

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

    <!-- Script de la burbuja con SweetAlert -->
    <script>
        // Horario de atención (Lunes a Viernes, 9:00 - 18:00)
        function isWithinBusinessHours() {
            const now = new Date();
            const day = now.getDay(); // 0 = Domingo, 1 = Lunes, ..., 6 = Sábado
            const hour = now.getHours();
            const minutes = now.getMinutes();
            const currentTime = hour + minutes / 60;
            
            // Verificar si es día hábil (Lunes a Viernes)
            if (day === 0 || day === 6) {
                return false;
            }
            
            // Verificar si está dentro del horario (9:00 - 18:00)
            return currentTime >= 9 && currentTime < 18;
        }
        
        function toggleSupportMenu() {
            const menu = document.getElementById('supportMenu');
            menu.classList.toggle('active');
        }
        
        function openSupport() {
            const menu = document.getElementById('supportMenu');
            menu.classList.remove('active');
            
            if (isWithinBusinessHours()) {
                // Horario de atención: redirigir a soporte
                window.location.href = "{{ route('soporte.index') }}";
            } else {
                // Fuera de horario: mostrar mensaje y dejar ticket en cola
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
                            <p class="text-sm text-teal-600 mt-2">Mientras tanto, puedes dejar tu ticket y te responderemos pronto.</p>
                        </div>
                    `,
                    confirmButtonText: '📝 Dejar Ticket',
                    confirmButtonColor: '#0d9488',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    cancelButtonColor: '#6b7280',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de soporte para dejar ticket
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
                            <div class="flex items-center space-x-2 p-2 bg-teal-50 rounded">
                                <span>💬</span>
                                <span><strong>WhatsApp:</strong> +54 9 11 1234-5678</span>
                            </div>
                        </div>
                        <hr class="my-3">
                        <p class="text-sm text-gray-500 text-center">Horario: Lun a Vie 9:00 - 18:00</p>
                    </div>
                `,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#0d9488',
                showCancelButton: true,
                cancelButtonText: '📝 Crear Ticket',
                cancelButtonColor: '#f59e0b'
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "{{ route('soporte.index') }}";
                }
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