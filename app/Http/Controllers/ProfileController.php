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
            'nom_us' => 'required|string|min:2|max:100',
            'ape_us' => 'required|string|min:2|max:100',
            'ema_us' => 'required|email|unique:usuarios,ema_us,' . Auth::id() . ',id',
            'tel_us' => 'nullable|string|regex:/^[0-9]{8,15}$/|max:20',
            'ciu_us' => 'nullable|string|min:2|max:100',
        ], [
            'nom_us.required' => 'El nombre es obligatorio',
            'nom_us.min' => 'El nombre debe tener al menos 2 caracteres',
            'ape_us.required' => 'El apellido es obligatorio',
            'ape_us.min' => 'El apellido debe tener al menos 2 caracteres',
            'ema_us.required' => 'El correo es obligatorio',
            'ema_us.email' => 'Ingrese un correo válido',
            'ema_us.unique' => 'Este correo ya está registrado',
            'tel_us.regex' => 'El teléfono debe contener solo números (8-15 dígitos)',
            'ciu_us.min' => 'La ciudad debe tener al menos 2 caracteres',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->nom_us = $request->nom_us;
        $user->ape_us = $request->ape_us;
        $user->ema_us = $request->ema_us;
        $user->tel_us = $request->tel_us;
        $user->ciu_us = $request->ciu_us;
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
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[0-9]/', 'regex:/[a-zA-Z]/'],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'password.required' => 'La nueva contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener al menos una letra y un número',
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
        ], [
            'avatar.required' => 'Debes seleccionar una imagen',
            'avatar.image' => 'El archivo debe ser una imagen',
            'avatar.mimes' => 'Formatos permitidos: JPG, JPEG, PNG, GIF',
            'avatar.max' => 'La imagen no debe superar los 2MB',
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
            ], [
                'password.required' => 'Debes ingresar tu contraseña para desactivar la cuenta',
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