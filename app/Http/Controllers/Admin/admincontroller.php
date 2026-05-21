<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Especie;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('est_us', 'activo')->count();
        $adminCount = User::where('is_admin', true)->count();
        $totalPets = Mascota::count();

        $recentUsers = User::latest()->take(5)->get();
        $recentPets = Mascota::with('usuario', 'especie')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'adminCount',
            'totalPets',
            'recentUsers',
            'recentPets'
        ));
    }


    public function usuarios(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nom_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('app_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('apm_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('ema_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('tel_us', 'LIKE', "%{$request->search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        $totalUsers = User::count();
        $activeUsers = User::where('est_us', 'activo')->count();
        $adminCount = User::where('is_admin', true)->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();

        return view('admin.usuarios', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'adminCount',
            'newUsersThisMonth'
        ));
    }


    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'nom_us' => $user->nom_us,
            'app_us' => $user->app_us,
            'apm_us' => $user->apm_us,
            'ema_us' => $user->ema_us,
            'tel_us' => $user->tel_us,
            'is_admin' => $user->is_admin,
            'est_us' => $user->est_us,
        ]);
    }


    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nom_us' => 'required|string|max:100',
            'app_us' => 'required|string|max:100',
            'apm_us' => 'required|string|max:100',
            'ema_us' => 'required|email|max:150|unique:usuarios,ema_us,' . $id,
            'tel_us' => 'nullable|string|max:20',
        ]);

        $user->update([
            'nom_us' => $request->nom_us,
            'app_us' => $request->app_us,
            'apm_us' => $request->apm_us,
            'ema_us' => $request->ema_us,
            'tel_us' => $request->tel_us,
            'is_admin' => $request->is_admin ?? false,
        ]);

        return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta']);
        }
        
        if ($user->mascotas()->exists()) {
            $user->mascotas()->delete();
        }
        
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente']);
    }


    public function toggleBlockUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->est_us === 'activo') {
            $user->est_us = 'inactivo';
            $message = 'Usuario bloqueado correctamente';
        } else {
            $user->est_us = 'activo';
            $message = 'Usuario activado correctamente';
        }
        $user->save();

        return response()->json(['success' => true, 'message' => $message]);
    }


    public function mascotas(Request $request)
    {
        $query = Mascota::with('usuario', 'especie');
        
        // Búsqueda por nombre
        if ($request->has('search') && $request->search) {
            $query->where('nom_mas', 'LIKE', "%{$request->search}%");
        }
        
        // Filtro por especie
        if ($request->has('especie') && $request->especie && $request->especie != '') {
            $query->whereHas('especie', function($q) use ($request) {
                $q->where('nom_esp', $request->especie);
            });
        }
        
        $mascotas = $query->latest()->paginate(12);
        
        $totalPets = Mascota::count();
        
        // Contar perros y gatos usando la relación con especie
        $dogsCount = Mascota::whereHas('especie', function($q) {
            $q->where('nom_esp', 'Perro');
        })->count();
        
        $catsCount = Mascota::whereHas('especie', function($q) {
            $q->where('nom_esp', 'Gato');
        })->count();
        
        $usersWithPets = Mascota::distinct('usuario_id')->count('usuario_id');
        $owners = User::whereHas('mascotas')->get(['id', 'nom_us', 'app_us', 'apm_us']);
        
        // Obtener todas las especies para el filtro
        $especies = Especie::all();
        
        return view('admin.mascotas', compact(
            'mascotas',
            'totalPets',
            'dogsCount',
            'catsCount',
            'usersWithPets',
            'owners',
            'especies'
        ));
    }


    public function showMascota($id)
    {
        $mascota = Mascota::with('usuario', 'especie')->findOrFail($id);

        return response()->json([
            'id' => $mascota->id,
            'nombre' => $mascota->nom_mas,
            'especie' => $mascota->especie->nom_esp ?? 'No especificada',
            'especie_id' => $mascota->especie_id,
            'sexo' => $mascota->sex_mas,
            'descripcion' => $mascota->des_mas,
            'foto' => $mascota->fot_mas ? asset('storage/' . $mascota->fot_mas) : null,
            'usuario' => [
                'id' => $mascota->usuario->id ?? null,
                'nom_us' => $mascota->usuario->nom_us ?? null,
                'app_us' => $mascota->usuario->app_us ?? null,
                'apm_us' => $mascota->usuario->apm_us ?? null,
                'email' => $mascota->usuario->ema_us ?? null,
            ],
            'created_at' => $mascota->created_at->toISOString(),
        ]);
    }


    public function editMascota($id)
    {
        $mascota = Mascota::with('especie')->findOrFail($id);

        return response()->json([
            'id' => $mascota->id,
            'nombre' => $mascota->nom_mas,
            'especie_id' => $mascota->especie_id,
            'sexo' => $mascota->sex_mas,
            'descripcion' => $mascota->des_mas,
        ]);
    }


    public function updateMascota(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);

        $request->validate([
            'nom_mas' => 'required|string|max:100',
            'especie_id' => 'required|exists:especies,id',
            'sex_mas' => 'nullable|in:macho,hembra',
            'des_mas' => 'nullable|string',
        ]);

        $mascota->update([
            'nom_mas' => $request->nom_mas,
            'especie_id' => $request->especie_id,
            'sex_mas' => $request->sex_mas,
            'des_mas' => $request->des_mas,
        ]);

        return response()->json(['success' => true, 'message' => 'Mascota actualizada correctamente']);
    }


    public function deleteMascota($id)
    {
        $mascota = Mascota::findOrFail($id);
        
        if ($mascota->fot_mas && Storage::disk('public')->exists($mascota->fot_mas)) {
            Storage::disk('public')->delete($mascota->fot_mas);
        }
        
        $mascota->delete();

        return response()->json(['success' => true, 'message' => 'Mascota eliminada correctamente']);
    }
}








