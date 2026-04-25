<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;  // ← Importar DB
use App\Models\User;

class ProfileController extends Controller
{
    // Eliminar cuenta CON transacciones
    public function destroy(Request $request)
    {
        try {
            $validated = $request->validate([
                'password' => 'required|string'
            ]);
            
            // Iniciar transacción
            DB::beginTransaction();
            
            $user = User::findOrFail(Auth::id());
            
            // Verificar contraseña
            if (!Hash::check($validated['password'], $user->pas_us)) {
                return back()->withErrors([
                    'password' => 'Contraseña incorrecta'
                ]);
            }
            
            // Eliminar avatar si existe
            if ($user->ava_us) {
                Storage::disk('public')->delete($user->ava_us);
            }
            
            // Guardar ID para después
            $userId = $user->id;
            
            // Cerrar sesión
            Auth::logout();
            
            // Eliminar usuario
            User::where('id', $userId)->delete();
            
            // Confirmar transacción
            DB::commit();
            
            // Invalidar sesión
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/')->with('success', 'Cuenta eliminada correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar cuenta: ' . $e->getMessage());
        }
    }
}