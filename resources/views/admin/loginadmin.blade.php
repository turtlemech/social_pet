<!DOCTYPE html>
<html lang="es">
<head>
    <title>Admin Panel · Social Pet</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- Tailwind CSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
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
        
        @keyframes subtlePulse {
            0% { opacity: 0.7; transform: scale(1);}
            100% { opacity: 1; transform: scale(1.05);}
        }
        
        .animate-card-glow {
            animation: cardGlow 0.55s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        .animate-subtle-pulse {
            animation: subtlePulse 2s infinite alternate;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center min-h-screen p-5 relative">
    
    <!-- Elementos decorativos de fondo con Tailwind -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-[10%] w-64 h-64 bg-orange-500/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-[5%] w-80 h-80 bg-amber-500/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <!-- Grid overlay con Tailwind -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    </div>
    
    <!-- Contenedor principal centrado -->
    <div class="w-full max-w-md mx-auto z-10 relative animate-card-glow">
        <div class="bg-gray-900/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-orange-900/20 border border-gray-800 overflow-hidden transition-all duration-300 hover:shadow-orange-900/30">
            
            <!-- Header decorativo -->
            <div class="relative px-7 pt-8 pb-2 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-orange-500 to-amber-700 shadow-lg shadow-orange-500/30 mb-4">
                    <i class="fas fa-shield-alt text-white text-3xl animate-subtle-pulse"></i>
                </div>
                <h2 class="text-3xl font-extrabold bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent tracking-tight">
                    Social Pet
                </h2>
                <div class="mt-2 inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-orange-300 bg-gray-800/70 backdrop-blur-sm border border-orange-500/30 border-l-4 border-l-orange-500">
                    <i class="fas fa-lock text-[11px]"></i> 
                    <span>Panel de inicio sesion</span>
                    <i class="fas fa-crown text-[11px] text-amber-400"></i>
                </div>
            </div>
            
            <!-- Contenido del formulario -->
            <div class="px-7 pb-8 pt-2 md:px-8">
                <!-- Mensajes de error -->
                @if($errors->any())
                    <div class="mb-6 p-3.5 rounded-xl backdrop-blur-sm bg-red-500/10 border-l-4 border-red-500 text-red-200 text-sm flex items-start gap-3 shadow-sm">
                        <i class="fas fa-exclamation-triangle mt-0.5 text-red-400"></i>
                        <span class="font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif
                
                <!-- Formulario -->
                <form method="POST" action="{{ url('/admin/login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Campo Correo Electrónico -->
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-2 tracking-wide flex items-center gap-2">
                            <i class="fas fa-envelope text-orange-400 text-sm"></i> 
                            Correo Electrónico
                        </label>
                        <div class="relative group">
                            <input type="email" name="email" value="admin@admin.com" required autofocus
                                   class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-900/90 border border-gray-700 text-gray-100 placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:scale-[1.01] transition-all duration-250 hover:border-orange-500/70">
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
                        <div class="relative group">
                            <input type="password" name="password" value="12345678" required
                                   class="w-full pl-11 pr-10 py-3 rounded-xl bg-gray-900/90 border border-gray-700 text-gray-100 placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:scale-[1.01] transition-all duration-250 hover:border-orange-500/70">
                            <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-orange-400/70 text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- Botón de Acceso -->
                    <button type="submit" 
                            class="relative w-full py-3.5 rounded-xl text-white font-bold text-base flex items-center justify-center gap-3 transition-all duration-300 cursor-pointer group overflow-hidden bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 hover:-translate-y-1 active:translate-y-0 shadow-lg shadow-orange-500/40 hover:shadow-orange-500/60">
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                        <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                        Ingresar al Panel Admin
                        <i class="fas fa-arrow-right text-xs opacity-80 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
                
                <!-- Enlace de regreso -->
                <div class="mt-8 pt-5 text-center border-t border-gray-800">
                    <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-400 text-sm font-medium transition-all duration-200 hover:-translate-x-1">
                        <i class="fas fa-arrow-left text-xs"></i> Volver al login de usuarios
                    </a>
                </div>
                
                <!-- Decoración extra -->
                <div class="mt-4 flex justify-center gap-1 text-gray-600 text-[11px]">
                    <i class="fas fa-paw text-orange-500/30 text-xs"></i>
                    <span>Acceso exclusivo · Equipo Social Pet</span>
                    <i class="fas fa-paw text-orange-500/30 text-xs"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tooltip de credenciales demo -->
    <div id="demoTooltip" class="fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-gray-800/80 backdrop-blur-md text-orange-300 text-xs px-4 py-2 rounded-full z-50 transition-all duration-300 opacity-0 pointer-events-none font-mono">
        🔑 Panel de administración · credenciales demo
    </div>
    
    <script>
        // Mejorar la experiencia visual con Tailwind
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const submitBtn = form?.querySelector('button[type="submit"]');
            
            // Efecto de clic en el botón
            if (submitBtn) {
                submitBtn.addEventListener('click', (e) => {
                    submitBtn.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        if (submitBtn) submitBtn.style.transform = '';
                    }, 150);
                });
            }
            
            // Efecto de foco en inputs
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement?.classList.add('ring-2', 'ring-orange-500/20', 'rounded-xl');
                });
                input.addEventListener('blur', function() {
                    this.parentElement?.classList.remove('ring-2', 'ring-orange-500/20', 'rounded-xl');
                });
            });
        });
        
        // Envío con Enter
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
        
        // Mostrar tooltip
        const tooltip = document.getElementById('demoTooltip');
        if (tooltip) {
            setTimeout(() => {
                tooltip.style.opacity = '0.7';
                setTimeout(() => {
                    tooltip.style.opacity = '0';
                }, 3200);
            }, 600);
        }
    </script>
</body>
</html>