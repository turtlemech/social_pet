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
            'ema_us' => 'required|email',  // Cambiado de 'email' a 'ema_us'
            'pas_us' => 'required|string', // Cambiado de 'password' a 'pas_us'
        ]);

        $email = $request->ema_us;      // Cambiado de 'email' a 'ema_us'
        $password = $request->pas_us;   // Cambiado de 'password' a 'pas_us'

        // Buscar usuario por email
        $user = User::where('ema_us', $email)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return back()->withErrors(['ema_us' => 'Usuario no encontrado'])->onlyInput('ema_us');
        }

        // Verificar si el usuario está inactivo usando el método del modelo
        if (!$user->isActive()) {
            return back()->withErrors([
                'ema_us' => 'Esta cuenta ha sido desactivada. Contacta al administrador para reactivarla.'
            ])->onlyInput('ema_us');
        }

        // Verificar la contraseña
        if (!password_verify($password, $user->pas_us)) {
            return back()->withErrors(['ema_us' => 'Contraseña incorrecta'])->onlyInput('ema_us');
        }

        // Verificar si es administrador
        if ($user->is_admin) {
            return back()->withErrors([
                'ema_us' => 'Usa el login de administrador'
            ])->onlyInput('ema_us');
        }

        // Iniciar sesión
        Auth::loginUsingId($user->id);
        
        // Regenerar la sesión para seguridad
        $request->session()->regenerate();

        // Redirigir al dashboard
        return redirect()->intended(route('dashboard'));
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