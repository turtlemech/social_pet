<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            {{-- Logo personalizado --}}
            <a href="/" class="flex justify-center items-center space-x-2">
                <img src="{{ asset('storage/imgages/social_petpng.png') }}" 
                     alt="Social Pet" 
                     class="h-12 w-auto">
                <span class="text-xl font-bold bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent">
                    SocialPet
                </span>
            </a>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('success'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            {{-- Nombre (nom_us) --}}
            <div>
                <x-label for="nom_us" value="{{ __('Nombre') }}" />
                <x-input id="nom_us" 
                    class="block mt-1 w-full" 
                    type="text" 
                    name="nom_us" 
                    :value="old('nom_us')" 
                    required 
                    autofocus 
                    maxlength="100" 
                    placeholder="Ej: Juan"
                    oninput="validateField(this)" />
                <div class="text-xs mt-1 flex items-center gap-2">
                    <span id="nom_us_error" class="text-red-500 hidden">❌ Mínimo 2 caracteres</span>
                    <span id="nom_us_valid" class="text-green-500 hidden">✅ Válido</span>
                    <span class="text-gray-400 ml-auto"><span id="nom_us_count">0</span>/100</span>
                </div>
            </div>

            {{-- Apellido (ape_us) --}}
            <div class="mt-4">
                <x-label for="ape_us" value="{{ __('Apellido') }}" />
                <x-input id="ape_us" 
                    class="block mt-1 w-full" 
                    type="text" 
                    name="ape_us" 
                    :value="old('ape_us')" 
                    required 
                    maxlength="100" 
                    placeholder="Ej: Pérez"
                    oninput="validateField(this)" />
                <div class="text-xs mt-1 flex items-center gap-2">
                    <span id="ape_us_error" class="text-red-500 hidden">❌ Mínimo 2 caracteres</span>
                    <span id="ape_us_valid" class="text-green-500 hidden">✅ Válido</span>
                    <span class="text-gray-400 ml-auto"><span id="ape_us_count">0</span>/100</span>
                </div>
            </div>

            {{-- Email (ema_us) --}}
            <div class="mt-4">
                <x-label for="ema_us" value="{{ __('Correo electrónico') }}" />
                <x-input id="ema_us" 
                    class="block mt-1 w-full" 
                    type="email" 
                    name="ema_us" 
                    :value="old('ema_us')" 
                    required 
                    maxlength="150" 
                    autocomplete="username" 
                    placeholder="ejemplo@correo.com"
                    oninput="validateField(this)" />
                <div class="text-xs mt-1 flex items-center gap-2">
                    <span id="ema_us_error" class="text-red-500 hidden">❌ Email inválido</span>
                    <span id="ema_us_valid" class="text-green-500 hidden">✅ Válido</span>
                </div>
            </div>

            {{-- Teléfono (tel_us) - Solo números --}}
            <div class="mt-4">
                <x-label for="tel_us" value="{{ __('Teléfono (opcional)') }}" />
                <x-input id="tel_us" 
                    class="block mt-1 w-full" 
                    type="tel" 
                    name="tel_us" 
                    :value="old('tel_us')" 
                    maxlength="20" 
                    placeholder="Ej: 77777777"
                    oninput="validatePhone(this)" />
                <div class="text-xs mt-1 flex items-center gap-2">
                    <span id="tel_us_error" class="text-red-500 hidden">❌ Solo números (8-15 dígitos)</span>
                    <span id="tel_us_valid" class="text-green-500 hidden">✅ Válido</span>
                    <span class="text-gray-400 ml-auto"><span id="tel_us_count">0</span>/20</span>
                </div>
            </div>

            {{-- Ciudad (ciu_us) --}}
            <div class="mt-4">
                <x-label for="ciu_us" value="{{ __('Ciudad (opcional)') }}" />
                <x-input id="ciu_us" 
                    class="block mt-1 w-full" 
                    type="text" 
                    name="ciu_us" 
                    :value="old('ciu_us')" 
                    maxlength="100" 
                    placeholder="Ej: Lima"
                    oninput="validateField(this)" />
                <div class="text-xs mt-1 flex items-center gap-2">
                    <span id="ciu_us_error" class="text-red-500 hidden">❌ Mínimo 2 caracteres</span>
                    <span id="ciu_us_valid" class="text-green-500 hidden">✅ Válido</span>
                    <span class="text-gray-400 ml-auto"><span id="ciu_us_count">0</span>/100</span>
                </div>
            </div>

            {{-- Contraseña (pas_us) --}}
            <div class="mt-4">
                <x-label for="pas_us" value="{{ __('Contraseña') }}" />
                <x-input id="pas_us" 
                    class="block mt-1 w-full" 
                    type="password" 
                    name="pas_us" 
                    required
                    oninput="validatePassword()" />
                <div class="text-xs mt-2 space-y-1">
                    <div class="flex items-center gap-2">
                        <span id="pass_length" class="text-gray-400">🔘</span>
                        <span class="text-gray-500">Mínimo 8 caracteres</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="pass_number" class="text-gray-400">🔘</span>
                        <span class="text-gray-500">Al menos un número</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="pass_letter" class="text-gray-400">🔘</span>
                        <span class="text-gray-500">Al menos una letra</span>
                    </div>
                </div>
            </div>

            {{-- Confirmar contraseña --}}
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
                <x-input id="password_confirmation" 
                    class="block mt-1 w-full" 
                    type="password" 
                    name="password_confirmation" 
                    required
                    oninput="validatePasswordMatch()" />
                <div class="text-xs mt-1">
                    <span id="pass_match_error" class="text-red-500 hidden">❌ Las contraseñas no coinciden</span>
                    <span id="pass_match_valid" class="text-green-500 hidden">✅ Las contraseñas coinciden</span>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

                <x-button id="submitBtn" class="ms-4 bg-gradient-to-r from-teal-500 to-teal-700 hover:from-teal-600 hover:to-teal-800 opacity-50 cursor-not-allowed" disabled>
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script>
// Contadores de caracteres
function updateCounter(input, counterId) {
    const counter = document.getElementById(counterId);
    if (counter) {
        counter.textContent = input.value.length;
    }
}

// Validación de teléfono (solo números)
function validatePhone(input) {
    // Solo permitir números
    input.value = input.value.replace(/[^0-9]/g, '');
    
    const errorSpan = document.getElementById('tel_us_error');
    const validSpan = document.getElementById('tel_us_valid');
    const value = input.value;
    
    if (value.length > 0 && (value.length < 8 || value.length > 15)) {
        errorSpan.classList.remove('hidden');
        validSpan.classList.add('hidden');
        input.classList.add('border-red-500');
        input.classList.remove('border-green-500');
        return false;
    } else if (value.length >= 8 && value.length <= 15) {
        errorSpan.classList.add('hidden');
        validSpan.classList.remove('hidden');
        input.classList.add('border-green-500');
        input.classList.remove('border-red-500');
        return true;
    } else {
        errorSpan.classList.add('hidden');
        validSpan.classList.add('hidden');
        input.classList.remove('border-green-500', 'border-red-500');
        return true;
    }
    
    updateCounter(input, 'tel_us_count');
    validateForm();
}

// Validación general de campos
function validateField(input) {
    const id = input.id;
    const value = input.value.trim();
    const errorSpan = document.getElementById(`${id}_error`);
    const validSpan = document.getElementById(`${id}_valid`);
    let isValid = false;
    
    // Actualizar contador
    if (document.getElementById(`${id}_count`)) {
        updateCounter(input, `${id}_count`);
    }
    
    switch(id) {
        case 'nom_us':
        case 'ape_us':
            isValid = value.length >= 2;
            break;
        case 'ema_us':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(value);
            break;
        case 'ciu_us':
            isValid = value.length === 0 || value.length >= 2;
            break;
        default:
            isValid = true;
    }
    
    if (isValid && value.length > 0) {
        if (errorSpan) errorSpan.classList.add('hidden');
        if (validSpan) validSpan.classList.remove('hidden');
        input.classList.add('border-green-500');
        input.classList.remove('border-red-500');
    } else if (!isValid && value.length > 0) {
        if (errorSpan) errorSpan.classList.remove('hidden');
        if (validSpan) validSpan.classList.add('hidden');
        input.classList.add('border-red-500');
        input.classList.remove('border-green-500');
    } else {
        if (errorSpan) errorSpan.classList.add('hidden');
        if (validSpan) validSpan.classList.add('hidden');
        input.classList.remove('border-green-500', 'border-red-500');
    }
    
    validateForm();
    return isValid;
}

// Validación de contraseña con requisitos
function validatePassword() {
    const password = document.getElementById('pas_us').value;
    const lengthValid = password.length >= 8;
    const numberValid = /[0-9]/.test(password);
    const letterValid = /[a-zA-Z]/.test(password);
    
    updateRequirement('pass_length', lengthValid);
    updateRequirement('pass_number', numberValid);
    updateRequirement('pass_letter', letterValid);
    
    validatePasswordMatch();
    validateForm();
    
    return lengthValid && numberValid && letterValid;
}

function updateRequirement(elementId, isValid) {
    const element = document.getElementById(elementId);
    if (element) {
        if (isValid) {
            element.innerHTML = '✅';
            element.classList.remove('text-gray-400');
            element.classList.add('text-green-500');
        } else {
            element.innerHTML = '🔘';
            element.classList.remove('text-green-500');
            element.classList.add('text-gray-400');
        }
    }
}

function validatePasswordMatch() {
    const password = document.getElementById('pas_us').value;
    const confirm = document.getElementById('password_confirmation').value;
    const errorSpan = document.getElementById('pass_match_error');
    const validSpan = document.getElementById('pass_match_valid');
    const confirmInput = document.getElementById('password_confirmation');
    
    if (confirm.length > 0) {
        if (password === confirm) {
            if (errorSpan) errorSpan.classList.add('hidden');
            if (validSpan) validSpan.classList.remove('hidden');
            confirmInput.classList.add('border-green-500');
            confirmInput.classList.remove('border-red-500');
            return true;
        } else {
            if (errorSpan) errorSpan.classList.remove('hidden');
            if (validSpan) validSpan.classList.add('hidden');
            confirmInput.classList.add('border-red-500');
            confirmInput.classList.remove('border-green-500');
            return false;
        }
    } else {
        if (errorSpan) errorSpan.classList.add('hidden');
        if (validSpan) validSpan.classList.add('hidden');
        confirmInput.classList.remove('border-green-500', 'border-red-500');
        return false;
    }
}

// Validar todo el formulario antes de habilitar botón
function validateForm() {
    const nom_us = document.getElementById('nom_us').value.trim();
    const ape_us = document.getElementById('ape_us').value.trim();
    const ema_us = document.getElementById('ema_us').value.trim();
    const password = document.getElementById('pas_us').value;
    const confirm = document.getElementById('password_confirmation').value;
    const tel_us = document.getElementById('tel_us').value;
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    let isTelValid = true;
    if (tel_us.length > 0) {
        isTelValid = tel_us.length >= 8 && tel_us.length <= 15;
    }
    
    const isNomValid = nom_us.length >= 2;
    const isApeValid = ape_us.length >= 2;
    const isEmailValid = emailRegex.test(ema_us);
    const isPasswordValid = password.length >= 8 && /[0-9]/.test(password) && /[a-zA-Z]/.test(password);
    const isConfirmValid = password === confirm && confirm.length > 0;
    
    const isFormValid = isNomValid && isApeValid && isEmailValid && isPasswordValid && isConfirmValid && isTelValid;
    
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        if (isFormValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.classList.add('opacity-100', 'cursor-pointer');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.classList.remove('opacity-100', 'cursor-pointer');
        }
    }
}

// Event listeners para validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['nom_us', 'ape_us', 'tel_us', 'ciu_us'];
    fields.forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            updateCounter(input, `${field}_count`);
        }
    });
    
    const emailInput = document.getElementById('ema_us');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            validateField(this);
        });
    }
});
</script>

<style>
    input:focus {
        outline: none;
        ring: 2px solid #0d9488;
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
</style>



