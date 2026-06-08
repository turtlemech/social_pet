<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    private function generateUserCode()
{
    // Obtener el último código generado ordenando por cod_us DESC
    $lastUser = User::orderBy('cod_us', 'desc')->first();
    
    if (!$lastUser) {
        return 'USR001';
    }
    
    $lastCode = $lastUser->cod_us;
    // Extraer el número usando expresión regular más robusta
    if (preg_match('/USR(\d+)/', $lastCode, $matches)) {
        $number = (int) $matches[1];
        $newNumber = $number + 1;
        return 'USR' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
    
    // Fallback seguro
    return 'USR001';
}

    public function register(Request $request)
    {
        $codigoAutomatico = $this->generateUserCode();
        
        $request->validate([
            'nom_us' => ['required', 'string', 'min:2', 'max:100'],
            'app_us' => ['required', 'string', 'min:2', 'max:100'],  // Apellido paterno
            'apm_us' => ['required', 'string', 'min:2', 'max:100'],  // Apellido materno (¡NUEVO!)
            'ema_us' => ['required', 'string', 'email', 'max:150', 'unique:usuarios,ema_us'],
            'tel_us' => ['nullable', 'string', 'regex:/^[0-9]{8,15}$/', 'max:20'],
            'ubi_us' => ['nullable', 'string', 'min:2', 'max:100'],  // Cambiado de ciu_us a ubi_us
            'pas_us' => ['required', 'confirmed', Rules\Password::min(8)
                ->letters()
                ->numbers()],
        ], [
            'nom_us.required' => 'El nombre es obligatorio',
            'nom_us.min' => 'El nombre debe tener al menos 2 caracteres',
            'app_us.required' => 'El apellido paterno es obligatorio',
            'app_us.min' => 'El apellido paterno debe tener al menos 2 caracteres',
            'apm_us.required' => 'El apellido materno es obligatorio',
            'apm_us.min' => 'El apellido materno debe tener al menos 2 caracteres',
            'ema_us.required' => 'El correo electrónico es obligatorio',
            'ema_us.email' => 'Ingrese un correo electrónico válido',
            'ema_us.unique' => 'Este correo ya está registrado',
            'tel_us.regex' => 'El teléfono debe contener solo números (8-15 dígitos)',
            'ubi_us.min' => 'La ubicación debe tener al menos 2 caracteres',
            'pas_us.required' => 'La contraseña es obligatoria',
            'pas_us.min' => 'La contraseña debe tener al menos 8 caracteres',
            'pas_us.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $user = User::create([
            'cod_us' => $codigoAutomatico,
            'nom_us' => $request->nom_us,
            'app_us' => $request->app_us,    // Apellido paterno
            'apm_us' => $request->apm_us,    // Apellido materno (¡NUEVO!)
            'ema_us' => $request->ema_us,
            'tel_us' => $request->tel_us,
            'ubi_us' => $request->ubi_us,     // Cambiado de ciu_us a ubi_us
            'pas_us' => Hash::make($request->pas_us),
            'tip_us' => 'usuario',            // Por defecto: usuario normal
            'est_us' => 'activo',             // Estado activo por defecto
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->intended(route('dashboard'))->with('success', '¡Bienvenido ' . $user->nom_us . ' ' . $user->app_us . '!');
    }
}