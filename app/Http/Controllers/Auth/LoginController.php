<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Maneja la solicitud de inicio de sesión
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Buscar usuario por email
        $user = User::where('ema_us', $email)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return back()->withErrors(['email' => 'Usuario no encontrado'])->onlyInput('email');
        }

        // Verificar si el usuario está inactivo
        if (!$user->isActive()) {
            return back()->withErrors([
                'email' => 'Esta cuenta ha sido desactivada. Contacta al administrador para reactivarla.'
            ])->onlyInput('email');
        }

        // Verificar la contraseña
        if (!password_verify($password, $user->pas_us)) {
            return back()->withErrors(['email' => 'Contraseña incorrecta'])->onlyInput('email');
        }

        // Verificar si es administrador
        if ($user->is_admin) {
            return back()->withErrors([
                'email' => 'Usa el login de administrador'
            ])->onlyInput('email');
        }

        // Iniciar sesión
        Auth::loginUsingId($user->id);
        
        // Regenerar la sesión para seguridad
        $request->session()->regenerate();

        // Redirigir al dashboard
        return redirect()->intended('/dashboard');
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}