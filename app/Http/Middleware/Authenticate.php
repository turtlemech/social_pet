<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Mostrar formulario login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        // Validación
        $request->validate([
            'ema_us' => 'required|email',
            'pas_us' => 'required|string',
        ]);

        $email = $request->ema_us;
        $password = $request->pas_us;

        // Buscar usuario
        $user = User::where('ema_us', $email)->first();

        // Usuario no encontrado
        if (!$user) {
            return back()
                ->withErrors([
                    'ema_us' => 'Usuario no encontrado'
                ])
                ->onlyInput('ema_us');
        }

        // Usuario inactivo o baneado
        if ($user->est_us !== 'activo') {
            return back()
                ->withErrors([
                    'ema_us' => 'Tu cuenta está inactiva o baneada'
                ])
                ->onlyInput('ema_us');
        }

        // Verificar contraseña
        if (!password_verify($password, $user->pas_us)) {
            return back()
                ->withErrors([
                    'ema_us' => 'Contraseña incorrecta'
                ])
                ->onlyInput('ema_us');
        }

        // Bloquear admins en login normal
        if ($user->is_admin) {
            return back()
                ->withErrors([
                    'ema_us' => 'Usa el login de administrador'
                ])
                ->onlyInput('ema_us');
        }

        // Iniciar sesión
        Auth::guard('web')->login($user);

        // Regenerar sesión
        $request->session()->regenerate();

        // Redirigir al feed
        return redirect()->route('feed');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}