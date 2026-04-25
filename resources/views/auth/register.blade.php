<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Código de usuario (cod_us) --}}
            <div>
                <x-label for="cod_us" value="{{ __('Código de usuario') }}" />
                <x-input id="cod_us" class="block mt-1 w-full" type="text" name="cod_us" :value="old('cod_us')" required autofocus placeholder="Ej: USR001" />
                <p class="text-xs text-gray-500 mt-1">Máximo 8 caracteres</p>
            </div>

            {{-- Nombre de usuario (nom_us) --}}
            <div class="mt-4">
                <x-label for="nom_us" value="{{ __('Nombre completo') }}" />
                <x-input id="nom_us" class="block mt-1 w-full" type="text" name="nom_us" :value="old('nom_us')" required placeholder="Ej: Juan Pérez" />
            </div>

            {{-- Email (ema_us) --}}
            <div class="mt-4">
                <x-label for="ema_us" value="{{ __('Correo electrónico') }}" />
                <x-input id="ema_us" class="block mt-1 w-full" type="email" name="ema_us" :value="old('ema_us')" required autocomplete="username" />
            </div>

            {{-- Teléfono (tel_us) - Opcional --}}
            <div class="mt-4">
                <x-label for="tel_us" value="{{ __('Teléfono (opcional)') }}" />
                <x-input id="tel_us" class="block mt-1 w-full" type="tel" name="tel_us" :value="old('tel_us')" placeholder="Ej: 123456789" />
            </div>

            {{-- Ciudad (ciu_us) - Opcional --}}
            <div class="mt-4">
                <x-label for="ciu_us" value="{{ __('Ciudad (opcional)') }}" />
                <x-input id="ciu_us" class="block mt-1 w-full" type="text" name="ciu_us" :value="old('ciu_us')" placeholder="Ej: Lima" />
            </div>

            {{-- Contraseña (pas_us) --}}
            <div class="mt-4">
                <x-label for="pas_us" value="{{ __('Contraseña') }}" />
                <x-input id="pas_us" class="block mt-1 w-full" type="password" name="pas_us" required autocomplete="new-password" />
            </div>

            {{-- Confirmar contraseña --}}
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>