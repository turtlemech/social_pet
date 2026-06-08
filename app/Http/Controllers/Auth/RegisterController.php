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
        $lastUser = User::orderBy('id', 'desc')->first();
        
        if (!$lastUser) {
            return 'USR001';
        }
        
        $lastCode = $lastUser->cod_us;
        $number = (int) substr($lastCode, 3);
        $newNumber = $number + 1;
        return 'USR' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function register(Request $request)
    {
        $codigoAutomatico = $this->generateUserCode();
        
        $request->validate([
            'nom_us' => ['required', 'string', 'min:2', 'max:100'],
            'ape_us' => ['required', 'string', 'min:2', 'max:100'],
            'ema_us' => ['required', 'string', 'email', 'max:150', 'unique:usuarios,ema_us'],
            'tel_us' => ['nullable', 'string', 'regex:/^[0-9]{8,15}$/', 'max:20'],
            'ciu_us' => ['nullable', 'string', 'min:2', 'max:100'],
            'pas_us' => ['required', 'confirmed', Rules\Password::min(8)
                ->letters()
                ->numbers()],
        ], [
            'nom_us.required' => 'El nombre es obligatorio',
            'nom_us.min' => 'El nombre debe tener al menos 2 caracteres',
            'ape_us.required' => 'El apellido es obligatorio',
            'ape_us.min' => 'El apellido debe tener al menos 2 caracteres',
            'ema_us.required' => 'El correo electrónico es obligatorio',
            'ema_us.email' => 'Ingrese un correo electrónico válido',
            'ema_us.unique' => 'Este correo ya está registrado',
            'tel_us.regex' => 'El teléfono debe contener solo números (8-15 dígitos)',
            'ciu_us.min' => 'La ciudad debe tener al menos 2 caracteres',
            'pas_us.required' => 'La contraseña es obligatoria',
            'pas_us.min' => 'La contraseña debe tener al menos 8 caracteres',
            'pas_us.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $user = User::create([
            'cod_us' => $codigoAutomatico,
            'nom_us' => $request->nom_us,
            'ape_us' => $request->ape_us,
            'ema_us' => $request->ema_us,
            'tel_us' => $request->tel_us,  // El mutator limpiará automáticamente
            'ciu_us' => $request->ciu_us,  // El mutator capitalizará automáticamente
            'pas_us' => Hash::make($request->pas_us),
            'estado' => 'activo',
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->intended(route('dashboard'))->with('success', '¡Bienvenido ' . $user->full_name . '!');
    }
}