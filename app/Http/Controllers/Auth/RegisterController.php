<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'cod_us' => 'required|string|max:8|unique:usuarios',
            'nom_us' => 'required|string|max:100',
            'ema_us' => 'required|string|email|max:150|unique:usuarios',
            'tel_us' => 'nullable|string|max:20',
            'ciu_us' => 'nullable|string|max:100',
            'pas_us' => 'required|string|min:6|confirmed',
        ], [
            'cod_us.unique' => 'El código de usuario ya está en uso',
            'ema_us.unique' => 'El correo electrónico ya está registrado',
            'pas_us.min' => 'La contraseña debe tener al menos 6 caracteres',
            'pas_us.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Insertar usuario
        DB::table('usuarios')->insert([
            'cod_us' => $request->cod_us,
            'nom_us' => $request->nom_us,
            'ema_us' => $request->ema_us,
            'tel_us' => $request->tel_us,
            'ciu_us' => $request->ciu_us,
            'pas_us' => Hash::make($request->pas_us),
            'is_admin' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
    }
}