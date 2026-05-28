<!DOCTYPE html>
<html lang="es">
<head>
    <title>Admin Panel · Social Pet</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- Tailwind CSS + Font Awesome + Google Fonts (moderno) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <!-- Personalización adicional para más detalles y efectos -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Fondo oscuro con patrón dinámico y animación sutil */
        body {
            background: radial-gradient(circle at 10% 20%, #0B1120, #0a0f1c);
            position: relative;
        }
        
        /* Overlay con efecto grid sutil */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }
        
        /* Animación de entrada para la tarjeta principal */
        @keyframes cardGlow {
            0% {
                opacity: 0;
                transform: scale(0.96) translateY(20px);
                filter: blur(2px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: blur(0);
            }
        }
        
        .card-admin {
            animation: cardGlow 0.55s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            backdrop-filter: blur(2px);
        }
        
        /* Inputs con estilo glow y neon suave */
        .input-admin {
            transition: all 0.25s ease;
            background-color: rgba(17, 24, 39, 0.9);
            border: 1px solid #2d3748;
            color: #f1f5f9;
        }
        
        .input-admin:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.2), 0 0 0 2px rgba(249, 115, 22, 0.4);
            background-color: #0f172a;
            transform: scale(1.01);
        }
        
        .input-admin:hover {
            border-color: #f97316aa;
        }
        
        /* Botón premium con gradiente y efecto brillo */
        .btn-admin-glow {
            background: linear-gradient(105deg, #f97316 0%, #ea580c 100%);
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px -6px rgba(249, 115, 22, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .btn-admin-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 30px -8px rgba(249, 115, 22, 0.6);
            background: linear-gradient(105deg, #fb923c, #ea580c);
        }
        
        .btn-admin-glow:active {
            transform: translateY(1px);
        }
        
        /* Efecto de brillo sutil en hover del botón */
        .btn-admin-glow::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0) 80%);
            opacity: 0;
            transition: opacity 0.4s;
            pointer-events: none;
        }
        
        .btn-admin-glow:hover::after {
            opacity: 1;
        }
        
        /* Enlaces elegantes */
        .back-link-admin {
            transition: all 0.2s ease;
        }
        
        .back-link-admin:hover {
            color: #f97316;
            transform: translateX(-4px);
        }
        
        /* Badge de administración con decoración */
        .admin-badge-new {
            background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(234,88,12,0.05));
            border-left: 3px solid #f97316;
        }
        
        /* Mensajes de error / éxito con glassmorphism */
        .alert-glass {
            backdrop-filter: blur(8px);
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        /* efecto de foco en inputs placeholder */
        .input-admin::placeholder {
            color: #4b5563;
            font-weight: 400;
        }
        
        /* animación para la estrella / icono sutil */
        @keyframes subtlePulse {
            0% { opacity: 0.7; transform: scale(1);}
            100% { opacity: 1; transform: scale(1.05);}
        }
        
        .admin-icon-pulse {
            animation: subtlePulse 2s infinite alternate;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-5 relative">
    
    <!-- Contenedor principal centrado (misma estructura lógica) -->
    <div class="w-full max-w-md mx-auto z-10 relative card-admin">
        <div class="bg-gray-900/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-orange-900/20 border border-gray-800 overflow-hidden transition-all duration-300 hover:shadow-orange-900/30">
            
            <!-- Header decorativo con icono y gradiente -->
            <div class="relative px-7 pt-8 pb-2 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-orange-500 to-amber-700 shadow-lg shadow-orange-500/30 mb-4">
                    <i class="fas fa-shield-alt text-white text-3xl admin-icon-pulse"></i>
                </div>
                <h2 class="text-3xl font-extrabold bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent tracking-tight">
                    Social Pet
                </h2>
                <div class="admin-badge-new mt-2 inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-orange-300 bg-gray-800/70 backdrop-blur-sm border border-orange-500/30">
                    <i class="fas fa-lock text-[11px]"></i> 
                    <span>Panel de inicio sesion</span>
                    <i class="fas fa-crown text-[11px] text-amber-400"></i>
                </div>
            </div>
            
            <!-- Contenido del formulario (respetando los names y action originales) -->
            <div class="px-7 pb-8 pt-2 md:px-8">
                <!-- Muestra de errores: misma lógica pero con estilo mejorado -->
                @if($errors->any())
                    <div class="mb-6 p-3.5 rounded-xl alert-glass border-l-4 border-red-500 text-red-200 text-sm flex items-start gap-3 backdrop-blur-sm shadow-sm">
                        <i class="fas fa-exclamation-triangle mt-0.5 text-red-400"></i>
                        <span class="font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif
                
                <!-- Formulario (mismo action, method, csrf, nombre de campos) -->
                <form method="POST" action="{{ url('/admin/login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Campo Correo Electrónico -->
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-2 tracking-wide flex items-center gap-2">
                            <i class="fas fa-envelope text-orange-400 text-sm"></i> 
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <input type="email" name="email" value="admin@admin.com" required autofocus
                                   class="input-admin w-full pl-11 pr-4 py-3 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none transition-all">
                            <i class="fas fa-user-shield absolute left-3 top-1/2 -translate-y-1/2 text-orange-400/70 text-sm"></i>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-1 ml-1">Acceso restringido · credenciales de administrador</p>
                    </div>
                    
                    <!-- Campo Contraseña -->
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-2 tracking-wide flex items-center gap-2">
                            <i class="fas fa-key text-orange-400 text-sm"></i> 
                            Contraseña
                        </label>
                        <div class="relative">
                            <input type="password" name="password" value="12345678" required
                                   class="input-admin w-full pl-11 pr-10 py-3 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none">
                            <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-orange-400/70 text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- Botón de Acceso -->
                    <button type="submit" class="btn-admin-glow w-full py-3.5 rounded-xl text-white font-bold text-base flex items-center justify-center gap-3 transition-all cursor-pointer group">
                        <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                        Ingresar al Panel Admin
                        <i class="fas fa-arrow-right text-xs opacity-80 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
                
                <!-- Enlace de regreso (misma funcionalidad, diseño coherente) -->
                <div class="mt-8 pt-5 text-center border-t border-gray-800">
                    <a href="{{ url('/login') }}" class="back-link-admin inline-flex items-center gap-2 text-gray-400 hover:text-orange-400 text-sm font-medium transition-all duration-200">
                        <i class="fas fa-arrow-left text-xs"></i> Volver al login de usuarios
                    </a>
                </div>
                
                <!-- Decoración extra: mini pata / huella animada -->
                <div class="mt-4 flex justify-center gap-1 text-gray-700 text-[11px]">
                    <i class="fas fa-paw text-orange-600/30 text-xs"></i>
                    <span class="text-gray-600">Acceso exclusivo · Equipo Social Pet</span>
                    <i class="fas fa-paw text-orange-600/30 text-xs"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Efecto de partículas sutiles (solo visual) - un añadido estético que no interfiere con la lógica -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-20 left-[10%] w-64 h-64 bg-orange-500/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-[5%] w-80 h-80 bg-amber-500/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Script para mejorar la experiencia visual sin tocar la lógica POST -->
    <script>
        // Pequeño detalle: agregar efecto de "clic" al botón manteniendo el envío natural
        // También se puede mejorar el manejo del enter igual que siempre, pero conservamos el comportamiento original
        document.addEventListener('DOMContentLoaded', () => {
            // solo efectos visuales extra, no interferimos en validaciones ni envíos
            const form = document.querySelector('form');
            const submitBtn = form?.querySelector('button[type="submit"]');
            
            if (submitBtn) {
                submitBtn.addEventListener('click', (e) => {
                    // micro animación de brillo (puramente estético)
                    submitBtn.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        if (submitBtn) submitBtn.style.transform = '';
                    }, 150);
                });
            }
            
            // efecto de foco elegante en inputs (ya está css, pero agregamos un pequeño plus)
            const inputs = document.querySelectorAll('.input-admin');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement?.classList.add('ring-1', 'ring-orange-500/30', 'rounded-xl');
                });
                input.addEventListener('blur', () => {
                    input.parentElement?.classList.remove('ring-1', 'ring-orange-500/30', 'rounded-xl');
                });
            });
        });
        
        // Conservar el comportamiento de envío con Enter (exactamente igual)
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement && activeElement.tagName === 'INPUT') {
                    const form = activeElement.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            }
        });
        
        // Añadir un efecto de "copiado suave" al texto de credenciales visual (sin modificar campos ni valores reales)
        // solo un detalle de UI para mostrar que el panel es admin, no interfiere con la lógica de login.
        const tooltipElement = document.createElement('div');
        tooltipElement.className = 'fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-gray-800/80 backdrop-blur-md text-orange-300 text-xs px-4 py-2 rounded-full z-50 transition-all duration-300 opacity-0 pointer-events-none font-mono';
        tooltipElement.innerText = '🔑 Panel de administración · credenciales demo';
        document.body.appendChild(tooltipElement);
        
        // Mostrar un pequeño tooltip elegante solo para referencia (no afecta el login)
        setTimeout(() => {
            tooltipElement.style.opacity = '0.7';
            setTimeout(() => {
                tooltipElement.style.opacity = '0';
            }, 3200);
        }, 600);
    </script>
    
    <!-- Estilos adicionales para mejorar la experiencia en móvil y focus visible -->
    <style>
        /* Mejora de focus visible para accesibilidad */
        button:focus-visible, a:focus-visible, input:focus-visible {
            outline: 2px solid #f97316;
            outline-offset: 2px;
        }
        
        /* Efecto de brillo en la tarjeta */
        .bg-gray-900\/80 {
            background: rgba(15, 23, 42, 0.85);
        }
        
        /* animación de glow adicional al cargar */
        @keyframes softGlow {
            0% { box-shadow: 0 0 0 0 rgba(249,115,22,0.2); }
            100% { box-shadow: 0 0 0 8px rgba(249,115,22,0); }
        }
        
        .card-admin .bg-gray-900\/80 {
            transition: box-shadow 0.3s;
        }
        
        .card-admin:hover .bg-gray-900\/80 {
            box-shadow: 0 20px 35px -12px rgba(249,115,22,0.3);
        }
        
        /* Personalización de la barra de scroll (sutil) */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 8px;
        }
        
        /* Cambiar color del texto autocompletado para que se vea bien en inputs oscuros */
        input:-webkit-autofill,
        input:-webkit-autofill:focus {
            transition: background-color 600000s 0s, color 600000s 0s;
            -webkit-text-fill-color: #f1f5f9;
            caret-color: #f97316;
        }
        
        /* Ajuste para Tailwind conflicto hover */
        .btn-admin-glow {
            background: linear-gradient(105deg, #f97316 0%, #ea580c 100%);
        }
    </style>
    
</body>
</html>