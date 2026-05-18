<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Publicacione;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('estado', 'activo')->count();
        $adminCount = User::where('is_admin', true)->count();
        $totalPets = Mascota::count();
        # $totalPosts = Publicacione::count();

        $recentUsers = User::latest()->take(5)->get();
        $recentPets = Mascota::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'adminCount',
            'totalPets',
            //'totalPosts',
            'recentUsers',
            'recentPets'
        ));
    }


    public function usuarios(Request $request)
    {
        $query = User::query();

        // Búsqueda
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nom_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('ape_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('ema_us', 'LIKE', "%{$request->search}%")
                    ->orWhere('tel_us', 'LIKE', "%{$request->search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        $totalUsers = User::count();
        $activeUsers = User::where('estado', 'activo')->count();
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
            'ape_us' => $user->ape_us,
            'ema_us' => $user->ema_us,
            'tel_us' => $user->tel_us,
            'is_admin' => $user->is_admin,
        ]);
    }


    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'nom_us' => $request->nom_us,
            'ape_us' => $request->ape_us,
            'ema_us' => $request->ema_us,
            'tel_us' => $request->tel_us,
            'is_admin' => $request->is_admin ?? false,
        ]);

        return response()->json(['success' => true]);
    }


//    public function deleteUser($id)
//    {
//        $user = User::findOrFail($id);
        
//        if ($user->id === auth()->id()) {
//            return response()->json(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta']);
//        }
        
//        // Eliminar mascotas asociadas
//        $user->mascotas()->delete();
        
//        $user->delete();
 //       return response()->json(['success' => true]);
//    }


    public function toggleBlockUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->estado === 'activo') {
            $user->estado = 'inactivo';
            $message = 'Usuario bloqueado';
        } else {
            $user->estado = 'activo';
            $message = 'Usuario activado';
        }
        $user->save();

        return response()->json(['success' => true, 'message' => $message]);
    }


    public function mascotas(Request $request)
    {
        $query = Mascota::with('user');
        
        // Búsqueda por nombre
        if ($request->has('search') && $request->search) {
            $query->where('nom_mas', 'LIKE', "%{$request->search}%");
        }
        
        $mascotas = $query->latest()->paginate(12);
        
        $totalPets = Mascota::count();
        $dogsCount = Mascota::where('esp_mas', 'perro')->count();
        $catsCount = Mascota::where('esp_mas', 'gato')->count();
        $usersWithPets = Mascota::distinct('us_id')->count('us_id');
        $owners = User::whereHas('mascotas')->get(['id', 'nom_us', 'ape_us']);
        
        return view('admin.mascotas', compact(
            'mascotas',
            'totalPets',
            'dogsCount',
            'catsCount',
            'usersWithPets',
            'owners'
        ));
    }


    public function showMascota($id)
    {
        $mascota = Mascota::with('user')->findOrFail($id);

        return response()->json([
            'id' => $mascota->id,
            'nombre' => $mascota->nom_mas,
            'especie' => $mascota->esp_mas,
            'raza' => $mascota->raz_mas,
            'edad' => $mascota->ed_mas,
            'peso' => $mascota->pes_mas,
            'foto' => $mascota->fot_mas ? asset('storage/' . $mascota->fot_mas) : null,
            'user' => [
                'nom_us' => $mascota->user->nom_us ?? null,
                'ape_us' => $mascota->user->ape_us ?? null,
                'email' => $mascota->user->ema_us ?? null,
            ],
            'created_at' => $mascota->created_at->toISOString(),
        ]);
    }


    public function editMascota($id)
    {
        $mascota = Mascota::findOrFail($id);

        return response()->json([
            'id' => $mascota->id,
            'nombre' => $mascota->nom_mas,
            'especie' => $mascota->esp_mas,
            'raza' => $mascota->raz_mas,
            'edad' => $mascota->ed_mas,
            'peso' => $mascota->pes_mas,
        ]);
    }


    public function updateMascota(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);

        $request->validate([
            'nom_mas' => 'required|string|max:100',
            'esp_mas' => 'required|string|max:50',
            'raz_mas' => 'nullable|string|max:100',
            'ed_mas' => 'nullable|integer|min:0|max:50',
            'pes_mas' => 'nullable|numeric|min:0|max:999.99',
        ]);

        $mascota->update([
            'nom_mas' => $request->nom_mas,
            'esp_mas' => $request->esp_mas,
            'raz_mas' => $request->raz_mas,
            'ed_mas' => $request->ed_mas,
            'pes_mas' => $request->pes_mas,
        ]);

        return response()->json(['success' => true, 'message' => 'Mascota actualizada correctamente']);
    }


    public function deleteMascota($id)
    {
        $mascota = Mascota::findOrFail($id);
        
        // Eliminar foto si existe
        if ($mascota->fot_mas && Storage::disk('public')->exists($mascota->fot_mas)) {
            Storage::disk('public')->delete($mascota->fot_mas);
        }
        
        $mascota->delete();

        return response()->json(['success' => true, 'message' => 'Mascota eliminada correctamente']);
    }


    // public function publicaciones(Request $request)
    // {
    //     $query = Publicacione::with(['user', 'mascota']);
    // 
    //     if ($request->has('search') && $request->search) {
    //         $query->where('contenido', 'LIKE', "%{$request->search}%");
    //     }
    //     
    //     $publicaciones = $query->latest()->paginate(15);
    // 
    //     $totalPosts = Publicacione::count();
    //     $activePosts = Publicacione::where('estado', 'activo')->count();
    //     $totalLikes = Publicacione::sum('likes');
    // 
    //     return view('admin.publicaciones', compact(
    //         'publicaciones', 'totalPosts', 'activePosts', 'totalLikes'
    //     ));
    // }


    // public function togglePublicacion($id)
    // {
    //     $publicacion = Publicacione::findOrFail($id);
    // 
    //     $newEstado = $publicacion->estado === 'activo' ? 'inactivo' : 'activo';
    //     $publicacion->update(['estado' => $newEstado]);
    // 
    //     return response()->json(['success' => true]);
    // }


    // public function deletePublicacion($id)
    // {
    //     $publicacion = Publicacione::findOrFail($id);
    //     $publicacion->delete();
    // 
    //     return response()->json(['success' => true]);
    // }
}