<!DOCTYPE html>
<html lang="es">
<head>
    <title>Social Pet · Inicia Sesión</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- Tailwind CSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- Tailwind custom config (opcional) -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Fondo del carrusel - capa oscura superpuesta para legibilidad */
        .carousel-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            object-fit: cover;
            transition: opacity 1.2s ease-in-out;
        }
        
        .carousel-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 10%, rgba(0,0,0,0.55), rgba(0,0,0,0.75));
            z-index: -1;
            backdrop-filter: blur(2px);
        }
        
        /* Animaciones de entrada para el login card */
        @keyframes fadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-animated {
            animation: fadeSlideUp 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        /* Efectos de foco y transiciones suaves */
        .input-fancy {
            transition: all 0.25s ease;
            background-color: rgba(255,255,255,0.9);
            border: 1px solid #e2e8f0;
        }
        
        .input-fancy:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.2);
            background-color: white;
            transform: scale(1.01);
        }
        
        .btn-gradient {
            background: linear-gradient(105deg, #f97316 0%, #ea580c 100%);
            transition: all 0.3s ease;
            box-shadow: 0 8px 18px rgba(234,88,12,0.25);
        }
        
        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 28px -8px rgba(234,88,12,0.45);
            background: linear-gradient(105deg, #fb923c, #ea580c);
        }
        
        .btn-gradient:active {
            transform: translateY(1px);
        }
        
        /* burbuja soporte refinada */
        .support-bubble-new {
            transition: all 0.2s ease;
        }
        
        .support-menu-new {
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.3);
        }
        
        .support-menu-new a {
            transition: all 0.2s;
        }
        
        .support-menu-new a:hover {
            background: rgba(249,115,22,0.12);
            padding-left: 1.75rem;
        }
        
        /* personalización modal contacto */
        .modal-glass {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(6px);
        }
        
        /* scroll suave */
        html {
            scroll-behavior: smooth;
        }
        
        /* ocultar flechas en number input opcionales */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="overflow-x-hidden">

    <!-- IMAGENES CARRUSEL DE ANIMALITOS (alta calidad y adorables) -->
    <img id="carouselImg" class="carousel-bg" src="https://images.pexels.com/photos/1805164/pexels-photo-1805164.jpeg?auto=compress&cs=tinysrgb&w=1600" alt="animal background">
    <div class="carousel-overlay"></div>

    <!-- Contenido principal: Login -->
    <div class="relative min-h-screen flex items-center justify-center p-5">
        <div class="w-full max-w-md mx-auto card-animated">
            <!-- Tarjeta principal con vidrio/glassmorphism -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl overflow-hidden border border-white/40 transition-all duration-300 hover:shadow-3xl">
                <div class="px-7 pt-8 pb-6 md:px-8">
                    <!-- Header con icono y nombre -->
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-tr from-orange-400 to-amber-600 shadow-lg mb-3">
                            <i class="fas fa-paw text-white text-3xl"></i>
                        </div>
                        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-orange-600 to-amber-700 bg-clip-text text-transparent">Social Pet</h1>
                        <p class="text-gray-600 text-sm mt-1 font-medium">🐕 Conecta con el mundo animal 🐈</p>
                    </div>

                    <!-- Mensajes de error / éxito (misma lógica original) -->
                    @if($errors->any())
                        <div class="mb-5 p-3 rounded-xl bg-red-50 border-l-4 border-red-500 text-red-700 text-sm flex items-start gap-2 animate-pulse">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="mb-5 p-3 rounded-xl bg-green-50 border-l-4 border-green-500 text-green-700 text-sm flex items-start gap-2">
                            <i class="fas fa-check-circle mt-0.5"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Formulario de login (misma ruta y campos, sin modificar lógica) -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2 tracking-wide">
                                <i class="far fa-envelope text-orange-500 mr-1"></i> Correo Electrónico
                            </label>
                            <div class="relative">
                                <input type="email" name="ema_us" value="{{ old('ema_us') }}" required autofocus
                                    class="input-fancy w-full pl-11 pr-4 py-3 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none"
                                    placeholder="tu@email.com">
                                <i class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 fas fa-envelope"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2 tracking-wide">
                                <i class="fas fa-lock text-orange-500 mr-1"></i> Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" name="pas_us" required
                                    class="input-fancy w-full pl-11 pr-4 py-3 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none"
                                    placeholder="••••••••">
                                <i class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 fas fa-key"></i>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-gradient w-full py-3.5 rounded-xl text-white font-bold text-lg flex items-center justify-center gap-2 transition-all">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </button>
                    </form>

                    <!-- Enlace registro -->
                    <div class="mt-6 text-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1 text-orange-600 hover:text-orange-800 font-medium transition text-sm group">
                            <i class="fas fa-paw group-hover:rotate-12 transition"></i> ¿No tienes cuenta? 📝 Regístrate aquí
                        </a>
                    </div>
                </div>
                <!-- pie decorativo -->
                <div class="bg-gradient-to-r from-orange-100 to-amber-100 py-2 text-center text-xs text-gray-600">
                    <i class="fas fa-heart text-red-400"></i> Comunidad pet lover 
                </div>
            </div>
        </div>
    </div>

    <!-- Burbuja de soporte/administradores (funcionalidad completa, mismo comportamiento visual renovado) -->
    <div class="support-bubble fixed bottom-6 right-6 z-50">
        <div class="relative">
            <button onclick="toggleSupportMenu()" id="bubbleBtn" class="support-bubble-new w-14 h-14 md:w-16 md:h-16 rounded-full bg-gradient-to-br from-amber-400 to-orange-600 shadow-2xl flex items-center justify-center hover:scale-110 transition-transform duration-300 focus:outline-none focus:ring-4 focus:ring-orange-300">
                <i class="fas fa-comment-dots text-white text-2xl md:text-3xl"></i>
            </button>
            <div id="supportMenuNew" class="support-menu-new absolute bottom-20 right-0 md:right-0 min-w-[220px] bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl opacity-0 invisible transition-all duration-300 transform translate-y-4 origin-bottom-right z-50 border border-white/50">
                <a href="{{ url('/admin/login') }}" class="flex items-center gap-3 px-5 py-3 rounded-t-2xl text-gray-800 font-medium hover:bg-orange-50 transition-all">
                    <i class="fas fa-crown text-amber-500 text-lg"></i>
                    <span>Panel Administrador</span>
                </a>
                <a href="#" onclick="showSupportAlertNew(event)" class="flex items-center gap-3 px-5 py-3 text-gray-800 font-medium hover:bg-orange-50 transition-all">
                    <i class="fas fa-headset text-sky-500 text-lg"></i>
                    <span>Ayuda / Soporte</span>
                </a>
                <a href="#" onclick="showContactModalNew(event)" class="flex items-center gap-3 px-5 py-3 rounded-b-2xl text-gray-800 font-medium hover:bg-orange-50 transition-all">
                    <i class="fas fa-envelope-open-text text-indigo-500 text-lg"></i>
                    <span>Contacto</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal de contacto mejorado -->
    <div id="contactModalNew" style="display: none;" class="fixed inset-0 z-[100] modal-glass flex items-center justify-center p-5 transition-all duration-300">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform transition-all scale-95 animate-fade-in-up overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white text-xl font-bold flex items-center gap-2"><i class="fas fa-paw"></i> Soporte Social Pet</h3>
                <button onclick="closeContactModalNew()" class="text-white hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 text-center space-y-4">
                <i class="fas fa-envelope text-5xl text-orange-400"></i>
                <p class="text-gray-700 text-base">Escríbenos a nuestro centro de ayuda:</p>
                <div class="bg-orange-50 rounded-xl p-3 border border-orange-200">
                    <p class="font-mono text-orange-700 font-bold text-lg">soporte@socialpet.com</p>
                </div>
                <div class="flex justify-center gap-3 text-sm text-gray-500">
                    <span><i class="fas fa-phone-alt"></i> +56 (2) 3456 789</span>
                    <span><i class="fas fa-clock"></i> 9am - 6pm</span>
                </div>
                <button onclick="closeContactModalNew()" class="mt-2 w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold transition">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        // ========== CARRUSEL DE ANIMALITOS (fondo dinámico cada 6 segundos) ==========
        const images = [
            "https://images.pexels.com/photos/1805164/pexels-photo-1805164.jpeg?auto=compress&cs=tinysrgb&w=1600",   // perro y gato
            "https://images.pexels.com/photos/4587959/pexels-photo-4587959.jpeg?auto=compress&cs=tinysrgb&w=1600", // conejito adorable
            "https://images.pexels.com/photos/1170986/pexels-photo-1170986.jpeg?auto=compress&cs=tinysrgb&w=1600", // hámster o hurón
            "https://images.pexels.com/photos/127028/pexels-photo-127028.jpeg?auto=compress&cs=tinysrgb&w=1600",    // perrito golden
            "https://images.pexels.com/photos/208984/pexels-photo-208984.jpeg?auto=compress&cs=tinysrgb&w=1600",   // gato naranja relajado
            "https://images.pexels.com/photos/326012/pexels-photo-326012.jpeg?auto=compress&cs=tinysrgb&w=1600",   // caballo y pradera (también animal)
            "https://images.pexels.com/photos/1458925/pexels-photo-1458925.jpeg?auto=compress&cs=tinysrgb&w=1600"    // patitos lindos
        ];
        
        let currentIdx = 0;
        const imgElement = document.getElementById('carouselImg');
        
        function changeBackgroundImage() {
            currentIdx = (currentIdx + 1) % images.length;
            // preload con transición suave
            const nextImage = new Image();
            nextImage.src = images[currentIdx];
            nextImage.onload = () => {
                imgElement.style.opacity = '0';
                setTimeout(() => {
                    imgElement.src = images[currentIdx];
                    imgElement.style.opacity = '1';
                }, 100);
            };
        }
        
        // Cambio cada 6 segundos
        setInterval(changeBackgroundImage, 6000);
        
        // Transición inicial de opacidad
        imgElement.style.transition = 'opacity 1.2s ease-in-out';
        imgElement.style.opacity = '1';
        
        // ========== SOPORTE Y MENÚ (misma lógica original + mejoras UI) ==========
        function toggleSupportMenu() {
            const menu = document.getElementById('supportMenuNew');
            if (menu.classList.contains('opacity-0')) {
                menu.classList.remove('opacity-0', 'invisible', 'translate-y-4');
                menu.classList.add('opacity-100', 'visible', 'translate-y-0');
            } else {
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        }
        
        function showSupportAlertNew(event) {
            if(event) event.preventDefault();
            // Alerta elegante simulando notificación nativa pero más atractiva
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-5 left-1/2 transform -translate-x-1/2 bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 z-[200] border-l-8 border-orange-500 animate-bounce-in max-w-sm w-full';
            alertDiv.innerHTML = `
                <div class="bg-orange-100 p-2 rounded-full"><i class="fas fa-life-ring text-orange-600 text-xl"></i></div>
                <div><p class="font-bold text-gray-800">🐾 Soporte Social Pet</p>
                <p class="text-sm text-gray-600">📞 +56 (2) 3456 789 &nbsp;| ✉️ soporte@socialpet.com<br>Horario: Lun-Vie 9:00 - 18:00 hrs</p></div>
                <button class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => { if(alertDiv && alertDiv.remove) alertDiv.remove(); }, 5000);
            
            // cierra menú
            const menu = document.getElementById('supportMenuNew');
            menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
        }
        
        function showContactModalNew(event) {
            if(event) event.preventDefault();
            const modal = document.getElementById('contactModalNew');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // cerrar menú flotante
            const menu = document.getElementById('supportMenuNew');
            if(menu) {
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        }
        
        function closeContactModalNew() {
            const modal = document.getElementById('contactModalNew');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Cerrar menú al hacer clic fuera (comportamiento original mejorado)
        document.addEventListener('click', function(event) {
            const bubbleWrapper = document.querySelector('.support-bubble');
            const menu = document.getElementById('supportMenuNew');
            if (!bubbleWrapper || !menu) return;
            if (!bubbleWrapper.contains(event.target) && menu.classList.contains('opacity-100')) {
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        });
        
        // Enter key navigation: envía el formulario si el foco está dentro del mismo (comportamiento original)
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement && activeElement.tagName === 'INPUT') {
                    const form = activeElement.closest('form');
                    if (form) {
                        e.preventDefault();
                        form.submit();
                    }
                }
            }
        });
        
        // pequeño extra: agregar clase de animación a botón y efectos hover
        // también se puede pre-cargar las imágenes del carrusel para evitar parpadeos
        (function preloadCarouselImages() {
            images.forEach(src => {
                const img = new Image();
                img.src = src;
            });
        })();
    </script>

    <!-- Ajuste de transiciones para el modal y algunas animaciones adicionales -->
    <style>
        .animate-bounce-in {
            animation: bounceIn 0.4s cubic-bezier(0.34, 1.2, 0.64, 1);
        }
        @keyframes bounceIn {
            0% { opacity: 0; transform: translateX(-50%) scale(0.95); }
            60% { opacity: 1; transform: translateX(-50%) scale(1.02); }
            100% { opacity: 1; transform: translateX(-50%) scale(1); }
        }
        .support-menu-new {
            transition: opacity 0.2s ease, transform 0.25s ease, visibility 0.2s;
        }
        /* efecto extra para el botón de soporte */
        .support-bubble-new:active {
            transform: scale(0.95);
        }
        .card-animated {
            animation: fadeSlideUp 0.6s ease-out;
        }
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* hover intenso en inputs */
        .input-fancy:hover {
            border-color: #fdba74;
            background-color: white;
        }
        /* estilo para la tarjeta de vidrio mejorada */
        .bg-white\/90 {
            background: rgba(255, 255, 255, 0.88);
        }
        /* mejor sombra al focus del botón */
        button:focus-visible {
            outline: 2px solid #f97316;
            outline-offset: 2px;
        }
        /* scroll del modal */
        body.modal-open {
            overflow: hidden;
        }
    </style>
    <!-- script para manejar el overflow del modal si se necesita -->
    <script>
        // control de apertura modal para no perder el overflow
        const originalModalOpen = showContactModalNew;
        window.showContactModalNew = function(e) {
            if(e) e.preventDefault();
            document.body.style.overflow = 'hidden';
            const modal = document.getElementById('contactModalNew');
            if(modal) modal.style.display = 'flex';
            const menu = document.getElementById('supportMenuNew');
            if(menu) {
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        };
        window.closeContactModalNew = function() {
            const modal = document.getElementById('contactModalNew');
            if(modal) modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        };
        
        if(typeof showSupportAlertNew !== 'undefined'){
            // ya existe
        } else {
            window.showSupportAlertNew = function(e){
                if(e) e.preventDefault();
                alert('📞 Soporte Social Pet\n\nHorario: Lunes a Viernes 9:00 - 18:00\nEmail: soporte@socialpet.com\nTeléfono: (01) 234-5678');
                const menu = document.getElementById('supportMenuNew');
                if(menu){
                    menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const adminLink = document.querySelector('.support-menu-new a[href*="/admin/login"]');
            const helpLink = document.querySelector('.support-menu-new a[onclick*="showSupportAlertNew"]');
            const contactLink = document.querySelector('.support-menu-new a[onclick*="showContactModalNew"]');
            
        });
    </script>
</body>
</html>