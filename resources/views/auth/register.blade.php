<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - MiMascota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        .transition-all-200 {
            transition: all 0.2s ease;
        }
        input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        input.border-red-400 {
            border-color: #f87171;
        }
        .error-message {
            display: none;
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.25rem;
        }
        .error-message.show {
            display: block;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-600 via-purple-500 to-indigo-600 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="w-full max-w-2xl animate-fade-in">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 px-8 pt-12 pb-10 text-center">
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl backdrop-blur-sm mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Crear Cuenta</h1>
                    <p class="text-indigo-100">Regístrate para acceder a todos los servicios de MiMascota</p>
                </div>
            </div>

            <div class="px-8 py-8">
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-slide-up">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-green-800">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-slide-up">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-red-800">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.register.submit') }}" class="space-y-5" id="registerForm">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="nom_us" class="block text-sm font-semibold text-gray-700">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nom_us" 
                                   name="nom_us" 
                                   value="{{ old('nom_us') }}"
                                   class="w-full px-4 py-3 border-2 {{ $errors->has('nom_us') ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-gray-300' }} rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                                   placeholder="Tu nombre"
                                   required>
                            <div class="error-message" id="nom_us_error"></div>
                            @error('nom_us')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="app_us" class="block text-sm font-semibold text-gray-700">
                                Apellido Paterno <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="app_us" 
                                   name="app_us" 
                                   value="{{ old('app_us') }}"
                                   class="w-full px-4 py-3 border-2 {{ $errors->has('app_us') ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-gray-300' }} rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                                   placeholder="Apellido paterno"
                                   required>
                            <div class="error-message" id="app_us_error"></div>
                            @error('app_us')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="apm_us" class="block text-sm font-semibold text-gray-700">
                                Apellido Materno
                            </label>
                            <input type="text" 
                                   id="apm_us" 
                                   name="apm_us" 
                                   value="{{ old('apm_us') }}"
                                   class="w-full px-4 py-3 border-2 {{ $errors->has('apm_us') ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-gray-300' }} rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                                   placeholder="Apellido materno">
                            <div class="error-message" id="apm_us_error"></div>
                            @error('apm_us')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="tel_us" class="block text-sm font-semibold text-gray-700">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="tel_us" 
                                   name="tel_us" 
                                   value="{{ old('tel_us') }}"
                                   class="w-full px-4 py-3 border-2 {{ $errors->has('tel_us') ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-gray-300' }} rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                                   placeholder="Ej: 71234567"
                                   required>
                            <div class="error-message" id="tel_us_error"></div>
                            <p class="text-xs text-gray-500 mt-1">Formato: 7XXXXXXXX o 6XXXXXXXX (8 dígitos)</p>
                            @error('tel_us')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="ema_us" class="block text-sm font-semibold text-gray-700">
                            Correo electrónico <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="ema_us" 
                               name="ema_us" 
                               value="{{ old('ema_us') }}"
                               class="w-full px-4 py-3 border-2 {{ $errors->has('ema_us') ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-gray-300' }} rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                               placeholder="tu@email.com"
                               required>
                        <div class="error-message" id="ema_us_error"></div>
                        @error('ema_us')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="pas_us" class="block text-sm font-semibold text-gray-700">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="pas_us" 
                                   name="pas_us"
                                   class="w-full px-4 py-3 border-2 {{ $errors->has('pas_us') ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-gray-300' }} rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                                   placeholder="Mínimo 6 caracteres"
                                   required>
                            <div class="text-xs text-gray-600 mt-2 space-y-1">
                                <p id="length-check" class="flex items-center text-gray-400"><span class="mr-1">○</span> Mínimo 6 caracteres</p>
                                <p id="uppercase-check" class="flex items-center text-gray-400"><span class="mr-1">○</span> Al menos una mayúscula</p>
                                <p id="lowercase-check" class="flex items-center text-gray-400"><span class="mr-1">○</span> Al menos una minúscula</p>
                                <p id="number-check" class="flex items-center text-gray-400"><span class="mr-1">○</span> Al menos un número</p>
                                <p id="special-check" class="flex items-center text-gray-400"><span class="mr-1">○</span> Al menos un carácter especial (@$!%*#?&)</p>
                            </div>
                            <div class="error-message" id="pas_us_error"></div>
                            @error('pas_us')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="pas_us_confirmation" class="block text-sm font-semibold text-gray-700">
                                Confirmar contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="pas_us_confirmation" 
                                   name="pas_us_confirmation"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all-200"
                                   placeholder="Repite tu contraseña"
                                   required>
                            <div class="error-message" id="pas_us_confirmation_error"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" 
                                   id="terms" 
                                   name="terms" 
                                   value="1"
                                   {{ old('terms') ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                   required>
                            <label for="terms" class="text-sm text-gray-700 leading-relaxed">
                                Acepto los <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold underline">términos y condiciones</a> y la 
                                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold underline">política de privacidad</a>
                            </label>
                        </div>
                        <div class="error-message" id="terms_error"></div>
                        @error('terms')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl transition-all-200 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-indigo-300 shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Registrarse
                        </span>
                    </button>

                    <div class="text-center pt-6 border-t border-gray-200">
                        <p class="text-gray-600">
                            ¿Ya tienes cuenta? 
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold hover:underline transition-all-200">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-6 text-indigo-200 text-sm">
            <p>© 2024 MiMascota. Todos los derechos reservados.</p>
        </div>
    </div>

    <script>
    // Solo validaciones VISUALES, NO impiden el envío del formulario
    function soloLetras(texto) {
        return /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/.test(texto);
    }

    function validarTelefonoBoliviano(telefono) {
        return /^[67]\d{7}$/.test(telefono);
    }

    function validarPassword(password) {
        return {
            valida: /[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password) && /[@$!%*#?&]/.test(password) && password.length >= 6,
            mayuscula: /[A-Z]/.test(password),
            minuscula: /[a-z]/.test(password),
            numero: /\d/.test(password),
            especial: /[@$!%*#?&]/.test(password),
            longitud: password.length >= 6
        };
    }

    // Actualizar indicadores visuales de contraseña (solo feedback visual)
    function actualizarIndicadoresPassword() {
        const password = document.getElementById('pas_us').value;
        const validacion = validarPassword(password);
        
        const checks = {
            'length-check': validacion.longitud,
            'uppercase-check': validacion.mayuscula,
            'lowercase-check': validacion.minuscula,
            'number-check': validacion.numero,
            'special-check': validacion.especial
        };
        
        for (const [id, isValid] of Object.entries(checks)) {
            const elemento = document.getElementById(id);
            if (elemento) {
                if (isValid) {
                    elemento.style.color = '#10b981';
                    elemento.innerHTML = '<span class="mr-1 text-green-500">✓</span> ' + elemento.innerText.substring(2);
                } else {
                    elemento.style.color = '#9ca3af';
                    elemento.innerHTML = '<span class="mr-1 text-gray-400">○</span> ' + elemento.innerText.substring(2);
                }
            }
        }
    }

    // Validación VISUAL (no bloquea el envío)
    function mostrarErrorVisual(campo, mensaje) {
        const errorDiv = document.getElementById(`${campo.id}_error`);
        if (errorDiv) {
            if (mensaje) {
                errorDiv.textContent = mensaje;
                errorDiv.classList.add('show');
                campo.classList.add('border-red-400');
            } else {
                errorDiv.classList.remove('show');
                campo.classList.remove('border-red-400');
            }
        }
    }

    // Validar campos individualmente (solo feedback visual)
    function validarCampoVisual(campo) {
        const id = campo.id;
        const valor = campo.value.trim();
        let error = '';
        
        switch(id) {
            case 'nom_us':
                if (!valor) error = 'El nombre es obligatorio';
                else if (!soloLetras(valor)) error = 'El nombre solo debe contener letras';
                else if (valor.length < 2) error = 'El nombre debe tener al menos 2 caracteres';
                break;
            case 'app_us':
                if (!valor) error = 'El apellido paterno es obligatorio';
                else if (!soloLetras(valor)) error = 'El apellido solo debe contener letras';
                else if (valor.length < 2) error = 'El apellido debe tener al menos 2 caracteres';
                break;
            case 'apm_us':
                if (valor && !soloLetras(valor)) error = 'El apellido materno solo debe contener letras';
                break;
            case 'tel_us':
                if (!valor) error = 'El teléfono es obligatorio';
                else if (!validarTelefonoBoliviano(valor)) error = 'Ingrese un número de teléfono boliviano válido (8 dígitos, comenzando con 6 o 7)';
                break;
            case 'ema_us':
                if (!valor) error = 'El correo electrónico es obligatorio';
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) error = 'Ingrese un correo electrónico válido';
                break;
            case 'pas_us':
                const validacion = validarPassword(valor);
                if (!valor) error = 'La contraseña es obligatoria';
                else if (!validacion.valida) error = 'La contraseña debe cumplir con todos los requisitos de seguridad';
                break;
        }
        
        mostrarErrorVisual(campo, error);
        return !error;
    }

    function validarConfirmacionVisual() {
        const password = document.getElementById('pas_us').value;
        const confirmacion = document.getElementById('pas_us_confirmation').value;
        const confirmacionField = document.getElementById('pas_us_confirmation');
        
        if (!confirmacion) {
            mostrarErrorVisual(confirmacionField, 'Debe confirmar su contraseña');
            return false;
        } else if (password !== confirmacion) {
            mostrarErrorVisual(confirmacionField, 'Las contraseñas no coinciden');
            return false;
        } else {
            mostrarErrorVisual(confirmacionField, '');
            return true;
        }
    }

    function validarTerminosVisual() {
        const terms = document.getElementById('terms');
        const errorDiv = document.getElementById('terms_error');
        
        if (!terms.checked) {
            errorDiv.textContent = 'Debe aceptar los términos y condiciones';
            errorDiv.classList.add('show');
            return false;
        } else {
            errorDiv.classList.remove('show');
            return true;
        }
    }

    // Event Listeners - SOLO para feedback visual
    document.addEventListener('DOMContentLoaded', function() {
        // Validación visual en tiempo real
        const campos = ['nom_us', 'app_us', 'apm_us', 'tel_us', 'ema_us', 'ubi_us', 'pas_us'];
        campos.forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.addEventListener('input', () => validarCampoVisual(campo));
                campo.addEventListener('blur', () => validarCampoVisual(campo));
            }
        });
        
        const passwordInput = document.getElementById('pas_us');
        if (passwordInput) {
            passwordInput.addEventListener('input', () => {
                actualizarIndicadoresPassword();
                validarCampoVisual(passwordInput);
                if (document.getElementById('pas_us_confirmation').value) {
                    validarConfirmacionVisual();
                }
            });
        }
        
        const confirmacionInput = document.getElementById('pas_us_confirmation');
        if (confirmacionInput) {
            confirmacionInput.addEventListener('input', validarConfirmacionVisual);
            confirmacionInput.addEventListener('blur', validarConfirmacionVisual);
        }
        
        const termsCheckbox = document.getElementById('terms');
        if (termsCheckbox) {
            termsCheckbox.addEventListener('change', validarTerminosVisual);
        }
        
        actualizarIndicadoresPassword();
    });
    </script>
</body>
</html>