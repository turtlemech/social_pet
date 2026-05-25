<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminLoginController extends Controller
{
    /**
     * Muestra la vista de login para administradores
     *
     * @return \Illuminate\View
     */
    public function showLoginForm()
    {
        return view('admin.loginadmin');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Buscar usuario por email
        $user = User::where('ema_us', $email)->first();

        // Verificar si existe
        if (!$user) {
            return back()->withErrors(['email' => 'Usuario no encontrado']);
        }

        // Verificar contraseña
        if (!password_verify($password, $user->pas_us)) {
            return back()->withErrors(['email' => 'Contraseña incorrecta']);
        }

        // Verificar si es administrador o soporte
        if ($user->tip_us !== 'admin' && $user->tip_us !== 'soporte') {
            return back()->withErrors(['email' => 'No tienes permisos de administrador o soporte']);
        }

        // Login manual
        Auth::login($user);
        $request->session()->regenerate();

        // Redirigir según el tipo de usuario
        if ($user->tip_us === 'soporte') {
            return redirect()->to('/soporte/dashsoporte');
        }

        // Si es admin, redirigir al dashboard de admin
        return redirect()->to('/admin/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}