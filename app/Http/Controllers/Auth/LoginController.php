<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     * Maneja la solicitud de inicio de sesión MANUAL
     */
    public function login(Request $request)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'ema_us' => 'required|email',
            'pas_us' => 'required|string',
        ], [
            'ema_us.required' => 'El correo electrónico es obligatorio',
            'ema_us.email' => 'Ingresa un correo electrónico válido',
            'pas_us.required' => 'La contraseña es obligatoria',
        ]);

        // 2. Buscar usuario por email
        $user = User::where('ema_us', $request->ema_us)->first();

        // 3. Verificar si el usuario existe
        if (!$user) {
            return back()->withErrors(['ema_us' => '❌ Usuario no encontrado'])->onlyInput('ema_us');
        }

        // 4. Verificar que NO sea administrador
        if ($user->is_admin == 1 || $user->is_admin === true) {
            return back()->withErrors([
                'ema_us' => '⚠️ Esta cuenta es de administrador. Usa el panel de administración.'
            ])->onlyInput('ema_us');
        }

        // 5. Verificar que NO sea soporte
        if ($user->tip_us === 'soporte') {
            return back()->withErrors([
                'ema_us' => '🛠️ Esta cuenta es de soporte. Usa el portal de soporte.'
            ])->onlyInput('ema_us');
        }

        // 6. Verificar si el usuario está activo
        if ($user->est_us !== 'activo') {
            $mensaje = $user->est_us === 'baneado' 
                ? '🚫 Esta cuenta ha sido baneada. Contacta al administrador.'
                : '⚠️ Esta cuenta está inactiva. Contacta al administrador.';
            
            return back()->withErrors(['ema_us' => $mensaje])->onlyInput('ema_us');
        }

        // 7. Verificar la contraseña MANUALMENTE
        if (!Hash::check($request->pas_us, $user->pas_us)) {
            return back()->withErrors(['ema_us' => '❌ Contraseña incorrecta'])->onlyInput('ema_us');
        }

        // 8. Iniciar sesión MANUALMENTE
        Auth::loginUsingId($user->id);
        
        // 9. Regenerar la sesión para seguridad
        $request->session()->regenerate();

        // 10. Redirigir al dashboard
        return redirect()->route('dashboard');
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