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

        // Verificar si es administrador
        if (!$user->is_admin) {
            return back()->withErrors(['email' => 'No tienes permisos de administrador']);
        }

        // Login manual
        Auth::login($user);
        $request->session()->regenerate();

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