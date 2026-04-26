<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil del usuario
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Actualizar información del perfil
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,ema_us,' . Auth::id() . ',id',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->nom_us = $request->name;
        $user->ema_us = $request->email;
        $user->tel_us = $request->phone;
        $user->ciu_us = $request->city;
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Actualizar contraseña del usuario
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail(Auth::id());

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->pas_us)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        // Actualizar contraseña
        $user->pas_us = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Actualizar avatar del usuario
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $user = User::findOrFail(Auth::id());

        // Eliminar avatar anterior si existe
        if ($user->ava_us && Storage::disk('public')->exists($user->ava_us)) {
            Storage::disk('public')->delete($user->ava_us);
        }

        // Guardar nuevo avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->ava_us = $path;
        $user->save();

        return back()->with('success', 'Avatar actualizado correctamente');
    }

    /**
     * Desactivar cuenta del usuario
     */
    public function destroy(Request $request)
    {
        try {
            $validated = $request->validate([
                'password' => 'required|string'
            ]);

            DB::beginTransaction();

            $user = User::findOrFail(Auth::id());

            // Verificar contraseña
            if (!Hash::check($validated['password'], $user->pas_us)) {
                return back()->withErrors([
                    'password' => 'Contraseña incorrecta'
                ]);
            }

            // Desactivar usuario (cambiar estado a inactivo)
            $user->deactivate();

            DB::commit();

            // Cerrar sesión
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Tu cuenta ha sido desactivada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al desactivar la cuenta: ' . $e->getMessage());
        }
    }
}