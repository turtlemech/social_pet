<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Publicacion;
use App\Models\Soporte;
use App\Models\Especie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Dashboard principal con estadísticas completas
     */
    public function dashboard()
    {
        // ========== ESTADÍSTICAS DE USUARIOS ==========
        $totalUsers = User::count();
        $activeUsers = User::where('est_us', 'activo')->count();
        $inactiveUsers = User::where('est_us', 'inactivo')->count();
        $bannedUsers = User::where('est_us', 'baneado')->count();
        $adminCount = User::where('is_admin', true)->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        
        // ========== ESTADÍSTICAS DE MASCOTAS ==========
        $totalPets = Mascota::count();
        $dogsCount = Mascota::whereHas('especie', function($q) {
            $q->where('nom_esp', 'Perro');
        })->count();
        $catsCount = Mascota::whereHas('especie', function($q) {
            $q->where('nom_esp', 'Gato');
        })->count();
        $otherPetsCount = $totalPets - ($dogsCount + $catsCount);
        $usersWithPets = Mascota::distinct('usuario_id')->count('usuario_id');
        $malePets = Mascota::where('sex_mas', 'macho')->count();
        $femalePets = Mascota::where('sex_mas', 'hembra')->count();
        
        // ========== ESTADÍSTICAS DE PUBLICACIONES ==========
        $totalPublications = Publicacion::count();
        $publicationsToday = Publicacion::whereDate('created_at', today())->count();
        $publicationsThisWeek = Publicacion::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $publicationsThisMonth = Publicacion::whereMonth('created_at', now()->month)->count();
        
        // ========== ESTADÍSTICAS DE TICKETS ==========
        $totalTickets = Soporte::count();
        $pendingTickets = Soporte::whereIn('est_sop', ['abierto', 'en_proceso'])->count();
        $openTickets = Soporte::where('est_sop', 'abierto')->count();
        $inProgressTickets = Soporte::where('est_sop', 'en_proceso')->count();
        $resolvedTickets = Soporte::where('est_sop', 'resuelto')->count();
        $closedTickets = Soporte::where('est_sop', 'cerrado')->count();
        
        // Tickets por prioridad
        $lowPriorityTickets = Soporte::where('pri_sop', 'baja')->count();
        $mediumPriorityTickets = Soporte::where('pri_sop', 'media')->count();
        $highPriorityTickets = Soporte::where('pri_sop', 'alta')->count();
        $urgentTickets = Soporte::where('pri_sop', 'urgente')->count();
        
        // Tickets activos por prioridad
        $urgentActiveTickets = Soporte::where('pri_sop', 'urgente')->whereIn('est_sop', ['abierto', 'en_proceso'])->count();
        $highActiveTickets = Soporte::where('pri_sop', 'alta')->whereIn('est_sop', ['abierto', 'en_proceso'])->count();
        
        // Tasa de resolución
        $resolutionRate = $totalTickets > 0 
            ? round((($resolvedTickets + $closedTickets) / $totalTickets) * 100) 
            : 0;
        
        // Tickets por prioridad (para gráficos)
        $ticketsByPriority = [
            'baja' => $lowPriorityTickets,
            'media' => $mediumPriorityTickets,
            'alta' => $highPriorityTickets,
            'urgente' => $urgentTickets,
        ];
        
        // Tickets por estado (para gráficos)
        $ticketsByStatus = [
            'abierto' => $openTickets,
            'en_proceso' => $inProgressTickets,
            'resuelto' => $resolvedTickets,
            'cerrado' => $closedTickets,
        ];
        
        // ========== DATOS RECIENTES ==========
        $recentUsers = User::latest()->take(5)->get();
        $recentPets = Mascota::with(['usuario', 'especie'])->latest()->take(5)->get();
        $recentTickets = Soporte::with(['usuario'])->latest()->take(5)->get();
        
        // ========== ESTADÍSTICA GENERAL ==========
        $stats = [
            'total' => $totalUsers,
            'activos' => $activeUsers,
            'inactivos' => $inactiveUsers,
            'baneados' => $bannedUsers,
            'admins' => $adminCount,
            'nuevos_mes' => $newUsersThisMonth,
            'mascotas' => $totalPets,
            'publicaciones' => $totalPublications,
            'tickets_pendientes' => $pendingTickets,
            'tasa_resolucion' => $resolutionRate,
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'bannedUsers',
            'adminCount',
            'newUsersThisMonth',
            'totalPets',
            'dogsCount',
            'catsCount',
            'otherPetsCount',
            'usersWithPets',
            'malePets',
            'femalePets',
            'totalPublications',
            'publicationsToday',
            'publicationsThisWeek',
            'publicationsThisMonth',
            'totalTickets',
            'pendingTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'lowPriorityTickets',
            'mediumPriorityTickets',
            'highPriorityTickets',
            'urgentTickets',
            'urgentActiveTickets',
            'highActiveTickets',
            'resolutionRate',
            'ticketsByPriority',
            'ticketsByStatus',
            'recentUsers',
            'recentPets',
            'recentTickets',
            'stats'
        ));
    }
    
    /**
     * Listado de usuarios con filtros y ordenamiento
     */
    public function usuarios(Request $request)
    {
        $search = $request->get('search');
        $estado = $request->get('estado');
        $rol = $request->get('rol');
        
        // Ordenamiento
        $sortField = $request->get('sort', 'codigo');
        $sortDirection = $request->get('direction', 'desc');
        
        $sortableFields = [
            'codigo' => 'cod_us',
            'nombre' => 'nom_us',
            'email' => 'ema_us',
            'telefono' => 'tel_us',
            'rol' => 'is_admin',
            'estado' => 'est_us',
            'registro' => 'created_at'
        ];
        
        $sortColumn = $sortableFields[$sortField] ?? 'cod_us';
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';
        
        $query = User::withCount(['mascotas', 'ticketsSoporte']);
        
        // Búsqueda
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom_us', 'like', "%{$search}%")
                  ->orWhere('app_us', 'like', "%{$search}%")
                  ->orWhere('apm_us', 'like', "%{$search}%")
                  ->orWhere('ema_us', 'like', "%{$search}%")
                  ->orWhere('cod_us', 'like', "%{$search}%")
                  ->orWhere('tel_us', 'like', "%{$search}%");
            });
        }
        
        // Filtros
        if ($estado && $estado !== '') {
            $query->where('est_us', $estado);
        }
        
        if ($rol === 'admin') {
            $query->where('is_admin', 1);
        } elseif ($rol === 'user') {
            $query->where('is_admin', 0);
        }
        
        // Aplicar ordenamiento
        if ($sortColumn === 'is_admin') {
            $query->orderBy('is_admin', $sortDirection);
        } else {
            $query->orderBy($sortColumn, $sortDirection);
        }
        
        $usuarios = $query->paginate(15)->appends([
            'sort' => $sortField,
            'direction' => $sortDirection,
            'search' => $search,
            'estado' => $estado,
            'rol' => $rol
        ]);
        
        $stats = [
            'total' => User::count(),
            'activos' => User::where('est_us', 'activo')->count(),
            'inactivos' => User::where('est_us', 'inactivo')->count(),
            'baneados' => User::where('est_us', 'baneado')->count(),
            'admins' => User::where('is_admin', 1)->count(),
        ];
        
        return view('admin.usuarios', compact('usuarios', 'stats', 'search', 'estado', 'rol', 'sortField', 'sortDirection'));
    }
    
    /**
     * Ver detalle de usuario (AJAX)
     */
    public function verUsuario($id)
    {
        $usuario = User::with(['mascotas', 'ticketsSoporte'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'usuario' => [
                'id' => $usuario->id,
                'codigo' => $usuario->cod_us,
                'nombre' => $usuario->nom_us,
                'apellido_paterno' => $usuario->app_us,
                'apellido_materno' => $usuario->apm_us,
                'nombre_completo' => "{$usuario->nom_us} {$usuario->app_us} {$usuario->apm_us}",
                'email' => $usuario->ema_us,
                'telefono' => $usuario->tel_us,
                'estado' => $usuario->est_us,
                'is_admin' => $usuario->is_admin,
                'mascotas_count' => $usuario->mascotas->count(),
                'tickets_count' => $usuario->ticketsSoporte->count(),
                'fecha_registro' => $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i:s') : 'N/A',
                'fecha_registro_humana' => $usuario->created_at ? $usuario->created_at->diffForHumans() : 'N/A',
            ]
        ]);
    }
    
    /**
     * Obtener usuario para edición (AJAX)
     */
    public function editUser($id)
    {
        $user = User::withCount('mascotas')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'cod_us' => $user->cod_us,
                'nom_us' => $user->nom_us,
                'app_us' => $user->app_us,
                'apm_us' => $user->apm_us,
                'ema_us' => $user->ema_us,
                'tel_us' => $user->tel_us,
                'is_admin' => $user->is_admin,
                'est_us' => $user->est_us,
                'mascotas_count' => $user->mascotas_count,
            ]
        ]);
    }
    
    /**
     * Actualizar usuario (AJAX)
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'nom_us' => 'required|string|max:100',
            'app_us' => 'required|string|max:100',
            'apm_us' => 'required|string|max:100',
            'ema_us' => 'required|email|max:150|unique:usuarios,ema_us,' . $id,
            'tel_us' => 'nullable|string|max:20',
            'est_us' => 'required|in:activo,inactivo,baneado',
            'is_admin' => 'boolean',
        ]);
        
        // No permitir desactivar el propio admin
        if ($user->id == auth()->id() && $request->est_us !== 'activo') {
            return response()->json([
                'success' => false, 
                'message' => 'No puedes cambiar el estado de tu propia cuenta'
            ]);
        }
        
        // No permitir cambiar el rol del último admin
        if ($user->is_admin && !$request->is_admin) {
            $adminCount = User::where('is_admin', true)->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes remover el rol de administrador del último admin'
                ]);
            }
        }
        
        $user->update([
            'nom_us' => $request->nom_us,
            'app_us' => $request->app_us,
            'apm_us' => $request->apm_us,
            'ema_us' => $request->ema_us,
            'tel_us' => $request->tel_us,
            'est_us' => $request->est_us,
            'is_admin' => $request->is_admin ?? false,
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Usuario actualizado correctamente'
        ]);
    }
    
    /**
     * Cambiar estado del usuario (bloquear/activar)
     */
    public function cambiarEstado(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        
        // No permitir cambiar estado de administradores
        if ($usuario->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cambiar el estado de un administrador'
            ], 403);
        }
        
        // No permitir cambiar el propio estado
        if ($usuario->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes cambiar tu propio estado'
            ], 403);
        }
        
        $nuevoEstado = $request->estado;
        $mensaje = $nuevoEstado === 'activo' ? 'Usuario activado correctamente' : 
                   ($nuevoEstado === 'baneado' ? 'Usuario baneado correctamente' : 'Estado actualizado correctamente');
        
        $usuario->est_us = $nuevoEstado;
        $usuario->save();
        
        return response()->json([
            'success' => true,
            'message' => $mensaje
        ]);
    }
    
    /**
     * Restablecer contraseña de usuario
     * Genera una nueva contraseña basada en nombre, apellido y teléfono
     */
    public function restablecerContrasena(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        
        // No permitir restablecer contraseña de administradores
        if ($usuario->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede restablecer la contraseña de un administrador'
            ], 403);
        }
        
        // Validar que se reciba la nueva contraseña
        $request->validate([
            'nueva_contrasena' => 'required|string|min:6'
        ]);
        
        $nuevaContrasena = $request->nueva_contrasena;
        
        // Hashear y guardar la nueva contraseña
        $usuario->pas_us = Hash::make($nuevaContrasena);
        $usuario->save();
        
        // Enviar email al usuario con la nueva contraseña
        $emailEnviado = $this->enviarEmailNuevaContrasena($usuario, $nuevaContrasena);
        
        $mensaje = 'Contraseña restablecida correctamente';
        if ($emailEnviado) {
            $mensaje .= ' y enviada al correo del usuario';
        } else {
            $mensaje .= ' pero no se pudo enviar el email (revise la configuración de correo)';
        }
        
        return response()->json([
            'success' => true,
            'message' => $mensaje,
            'email_enviado' => $emailEnviado
        ]);
    }
    
    /**
     * Enviar email al usuario con la nueva contraseña
     */
    private function enviarEmailNuevaContrasena($usuario, $nuevaContrasena)
    {
        try {
            // Verificar que el usuario tenga email
            if (!$usuario->ema_us) {
                Log::warning('Usuario sin email registrado', ['user_id' => $usuario->id]);
                return false;
            }
            
            // Preparar datos para la vista
            $data = [
                'usuario' => $usuario,
                'nuevaContrasena' => $nuevaContrasena,
                'nombreCompleto' => trim($usuario->nom_us . ' ' . $usuario->app_us),
                'email' => $usuario->ema_us,
                'fecha' => now()->format('d/m/Y H:i:s')
            ];
            
            // Enviar correo usando la plantilla
            Mail::send('emails.nueva-contrasena', $data, function ($message) use ($usuario) {
                $message->to($usuario->ema_us, trim($usuario->nom_us . ' ' . $usuario->app_us))
                        ->subject('🔐 Tu nueva contraseña - Social Pet')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('Email de nueva contraseña enviado', [
                'user_id' => $usuario->id,
                'email' => $usuario->ema_us
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            // Registrar error pero no detener el proceso
            Log::error('Error al enviar email de nueva contraseña: ' . $e->getMessage(), [
                'user_id' => $usuario->id,
                'email' => $usuario->ema_us,
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile()
            ]);
            return false;
        }
    }
    
    /**
     * Función interna para generar contraseña según reglas
     */
    private function generarPassword($nombre, $apellido, $telefono = null)
    {
        $contrasena = '';
        
        // Primeras 3 letras del nombre (minúsculas)
        $nombreBase = substr($nombre ?? 'usr', 0, 3);
        if (strlen($nombreBase) < 3) $nombreBase = str_pad($nombreBase, 3, 'x');
        $nombreBase = strtolower($nombreBase);
        
        // Primeras 3 letras del apellido (minúsculas)
        $apellidoBase = substr($apellido ?? 'def', 0, 3);
        if (strlen($apellidoBase) < 3) $apellidoBase = str_pad($apellidoBase, 3, 'x');
        $apellidoBase = strtolower($apellidoBase);
        
        $contrasena = $nombreBase . $apellidoBase;
        
        // Parte numérica: últimos 4 dígitos del teléfono o aleatorio
        if ($telefono && trim($telefono) !== '') {
            $digitos = preg_replace('/\D/', '', $telefono);
            if (strlen($digitos) >= 4) {
                $contrasena .= substr($digitos, -4);
            } elseif (strlen($digitos) > 0) {
                $contrasena .= str_pad($digitos, 4, '0', STR_PAD_LEFT);
            } else {
                $contrasena .= rand(1000, 9999);
            }
        } else {
            $contrasena .= rand(1000, 9999);
        }
        
        // Añadir carácter especial y letra mayúscula
        $especiales = '!@#$%';
        $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $contrasena .= $especiales[rand(0, strlen($especiales) - 1)];
        $contrasena .= $mayusculas[rand(0, strlen($mayusculas) - 1)];
        
        return $contrasena;
    }
    
    /**
     * Generar contraseña automáticamente (endpoint para obtener contraseña sugerida)
     */
    public function generarContrasenaSugerida($id)
    {
        $usuario = User::findOrFail($id);
        
        $nuevaContrasena = $this->generarPassword(
            $usuario->nom_us,
            $usuario->app_us,
            $usuario->tel_us
        );
        
        return response()->json([
            'success' => true,
            'contrasena_sugerida' => $nuevaContrasena
        ]);
    }
    
    /**
     * Desactivar usuario
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevenir desactivación de propia cuenta
        if ((string)$user->id === (string)auth()->id()) {
            return response()->json([
                'success' => false, 
                'message' => 'No puedes desactivar tu propia cuenta'
            ]);
        }
        
        // Prevenir desactivación del último admin
        if ($user->is_admin) {
            $adminCount = User::where('is_admin', true)->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false, 
                    'message' => 'No puedes desactivar al último administrador'
                ]);
            }
        }
        
        $user->est_us = 'inactivo';
        $user->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Usuario desactivado correctamente'
        ]);
    }
    
    /**
     * Listado de mascotas con filtros
     */
    public function mascotas(Request $request)
    {
        $query = Mascota::with(['usuario', 'especie']);
        
        // Búsqueda
        if ($request->filled('search')) {
            $query->where('nom_mas', 'LIKE', "%{$request->search}%");
        }
        
        // Filtro por especie
        if ($request->filled('especie') && $request->especie != '') {
            $query->whereHas('especie', function($q) use ($request) {
                $q->where('nom_esp', $request->especie);
            });
        }
        
        // Filtro por sexo
        if ($request->filled('sexo') && $request->sexo != '') {
            $query->where('sex_mas', $request->sexo);
        }
        
        // Filtro por dueño
        if ($request->filled('owner_id') && $request->owner_id != '') {
            $query->where('usuario_id', $request->owner_id);
        }
        
        $mascotas = $query->latest()->paginate(12)->withQueryString();
        
        // Estadísticas
        $totalPets = Mascota::count();
        $dogsCount = Mascota::whereHas('especie', function($q) {
            $q->where('nom_esp', 'Perro');
        })->count();
        
        $catsCount = Mascota::whereHas('especie', function($q) {
            $q->where('nom_esp', 'Gato');
        })->count();
        
        $otherPetsCount = $totalPets - ($dogsCount + $catsCount);
        $usersWithPets = Mascota::distinct('usuario_id')->count('usuario_id');
        $malePets = Mascota::where('sex_mas', 'macho')->count();
        $femalePets = Mascota::where('sex_mas', 'hembra')->count();
        
        // Dueños con mascotas para filtro
        $owners = User::whereHas('mascotas')
            ->withCount('mascotas')
            ->orderBy('nom_us')
            ->get(['id', 'nom_us', 'app_us', 'apm_us']);
        
        $especies = Especie::all();
        
        return view('admin.mascotas', compact(
            'mascotas',
            'totalPets',
            'dogsCount',
            'catsCount',
            'otherPetsCount',
            'usersWithPets',
            'malePets',
            'femalePets',
            'owners',
            'especies'
        ));
    }
    
    /**
     * Ver detalle de mascota (AJAX)
     */
    public function showMascota($id)
    {
        $mascota = Mascota::with(['usuario', 'especie'])->findOrFail($id);
        
        // Obtener publicaciones relacionadas
        $publicaciones = Publicacion::where('mascota_id', $id)
            ->latest()
            ->take(5)
            ->get();
        
        return response()->json([
            'success' => true,
            'mascota' => [
                'id' => $mascota->id,
                'nombre' => $mascota->nom_mas,
                'especie' => $mascota->especie->nom_esp ?? 'No especificada',
                'especie_id' => $mascota->especie_id,
                'sexo' => $mascota->sex_mas,
                'descripcion' => $mascota->des_mas,
                'foto' => $mascota->fot_mas ? asset('storage/' . $mascota->fot_mas) : null,
                'usuario' => [
                    'id' => $mascota->usuario->id ?? null,
                    'nombre_completo' => $mascota->usuario ? 
                        "{$mascota->usuario->nom_us} {$mascota->usuario->app_us} {$mascota->usuario->apm_us}" : null,
                    'email' => $mascota->usuario->ema_us ?? null,
                ],
                'created_at' => $mascota->created_at ? $mascota->created_at->format('d/m/Y H:i:s') : 'N/A',
                'created_at_human' => $mascota->created_at ? $mascota->created_at->diffForHumans() : 'N/A',
            ],
            'publicaciones' => $publicaciones->map(function($pub) {
                return [
                    'id' => $pub->id,
                    'contenido' => $pub->con_pub,
                    'created_at' => $pub->created_at ? $pub->created_at->diffForHumans() : 'N/A',
                ];
            })
        ]);
    }
    
    /**
     * Obtener mascota para edición (AJAX)
     */
    public function editMascota($id)
    {
        $mascota = Mascota::with('especie')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'mascota' => [
                'id' => $mascota->id,
                'nombre' => $mascota->nom_mas,
                'especie_id' => $mascota->especie_id,
                'sexo' => $mascota->sex_mas,
                'descripcion' => $mascota->des_mas,
            ]
        ]);
    }
    
    /**
     * Actualizar mascota (AJAX)
     */
    public function updateMascota(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);
        
        $request->validate([
            'nom_mas' => 'required|string|max:100',
            'especie_id' => 'required|exists:especies,id',
            'sex_mas' => 'nullable|in:macho,hembra',
            'des_mas' => 'nullable|string|max:500',
        ]);
        
        $mascota->update([
            'nom_mas' => $request->nom_mas,
            'especie_id' => $request->especie_id,
            'sex_mas' => $request->sex_mas,
            'des_mas' => $request->des_mas,
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Mascota actualizada correctamente'
        ]);
    }
    
    /**
     * Eliminar mascota (AJAX)
     */
    public function deleteMascota($id)
    {
        $mascota = Mascota::findOrFail($id);
        
        // Eliminar foto asociada
        if ($mascota->fot_mas && Storage::disk('public')->exists($mascota->fot_mas)) {
            Storage::disk('public')->delete($mascota->fot_mas);
        }
        
        // Eliminar publicaciones relacionadas
        Publicacion::where('mascota_id', $id)->delete();
        
        $mascota->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Mascota eliminada correctamente'
        ]);
    }
    
    /**
     * Exportar usuarios a CSV
     */
    public function exportUsers()
    {
        $users = User::all(['cod_us', 'nom_us', 'app_us', 'apm_us', 'ema_us', 'tel_us', 'est_us', 'created_at']);
        
        $csvFileName = 'usuarios_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$csvFileName}",
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM para caracteres especiales
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, ['Código', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Email', 'Teléfono', 'Estado', 'Fecha Registro']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->cod_us,
                    $user->nom_us,
                    $user->app_us,
                    $user->apm_us,
                    $user->ema_us,
                    $user->tel_us,
                    $user->est_us,
                    $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'N/A',
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Obtener estadísticas para gráficos (AJAX)
     */
    public function getChartData()
    {
        // Datos para gráfico de tickets por estado
        $ticketsByStatus = [
            'abierto' => Soporte::where('est_sop', 'abierto')->count(),
            'en_proceso' => Soporte::where('est_sop', 'en_proceso')->count(),
            'resuelto' => Soporte::where('est_sop', 'resuelto')->count(),
            'cerrado' => Soporte::where('est_sop', 'cerrado')->count(),
        ];
        
        // Datos para gráfico de tickets por prioridad
        $ticketsByPriority = [
            'baja' => Soporte::where('pri_sop', 'baja')->count(),
            'media' => Soporte::where('pri_sop', 'media')->count(),
            'alta' => Soporte::where('pri_sop', 'alta')->count(),
            'urgente' => Soporte::where('pri_sop', 'urgente')->count(),
        ];
        
        // Datos para gráfico de usuarios por mes (últimos 6 meses)
        $usersByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $usersByMonth[] = [
                'month' => $month->format('M Y'),
                'count' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count()
            ];
        }
        
        return response()->json([
            'success' => true,
            'tickets_by_status' => $ticketsByStatus,
            'tickets_by_priority' => $ticketsByPriority,
            'users_by_month' => $usersByMonth,
        ]);
    }
}


