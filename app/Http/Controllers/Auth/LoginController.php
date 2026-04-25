<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Buscar usuario por email
        $user = User::where('ema_us', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Usuario no encontrado']);
        }

        if (!password_verify($password, $user->pas_us)) {
            return back()->withErrors(['email' => 'Contraseña incorrecta']);
        }

        if ($user->is_admin) {
            return back()->withErrors(['email' => 'Usa el login de administrador']);
        }

        // Login usando ID (porque getAuthIdentifierName ahora devuelve 'id')
        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}