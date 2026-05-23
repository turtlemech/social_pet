<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soporte;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoporteController extends Controller
{
    /**
     * Muestra el panel de administración de soporte
     */
    public function index(Request $request)
    {
        $query = Soporte::with(['usuario', 'administrador']);
        
        // Filtros
        if ($request->filled('estado')) {
            $query->where('est_sop', $request->estado);
        }
        
        if ($request->filled('prioridad')) {
            $query->where('pri_sop', $request->prioridad);
        }
        
        if ($request->filled('categoria')) {
            $query->where('cat_sop', $request->categoria);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cod_sop', 'LIKE', "%{$search}%")
                  ->orWhere('asu_sop', 'LIKE', "%{$search}%")
                  ->orWhere('men_sop', 'LIKE', "%{$search}%")
                  ->orWhereHas('usuario', function($sub) use ($search) {
                      $sub->where('nom_us', 'LIKE', "%{$search}%")
                          ->orWhere('app_us', 'LIKE', "%{$search}%")
                          ->orWhere('cod_us', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $tickets = $query->orderByRaw("
            CASE est_sop 
                WHEN 'abierto' THEN 1 
                WHEN 'en_proceso' THEN 2 
                WHEN 'resuelto' THEN 3 
                WHEN 'cerrado' THEN 4 
            END
        ")->orderBy('created_at', 'desc')->paginate(15);
        
        $estadisticas = [
            'total' => Soporte::count(),
            'abiertos' => Soporte::where('est_sop', 'abierto')->count(),
            'en_proceso' => Soporte::where('est_sop', 'en_proceso')->count(),
            'resueltos' => Soporte::where('est_sop', 'resuelto')->count(),
            'cerrados' => Soporte::where('est_sop', 'cerrado')->count(),
            'urgentes' => Soporte::where('pri_sop', 'urgente')->whereIn('est_sop', ['abierto', 'en_proceso'])->count(),
            'por_categoria' => Soporte::select('cat_sop', DB::raw('count(*) as total'))
                ->groupBy('cat_sop')
                ->pluck('total', 'cat_sop')
                ->toArray(),
        ];
        
        return view('admin.soporte', compact('tickets', 'estadisticas'));
    }
    
    /**
     * Muestra los detalles de un ticket
     */
    public function show($id)
    {
        $ticket = Soporte::with(['usuario', 'administrador'])->findOrFail($id);
        
        // Marcar como leído si está en proceso y el admin lo ve
        if ($ticket->est_sop == 'abierto') {
            $ticket->est_sop = 'en_proceso';
            $ticket->save();
        }
        
        // Obtener tickets relacionados del mismo usuario
        $ticketsRelacionados = Soporte::where('cod_us', $ticket->cod_us)
            ->where('id', '!=', $ticket->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return response()->json([
            'success' => true,
            'ticket' => $ticket,
            'tickets_relacionados' => $ticketsRelacionados
        ]);
    }
    
    /**
     * Responde a un ticket
     */
    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|min:5',
            'estado' => 'required|in:abierto,en_proceso,resuelto,cerrado'
        ]);
        
        $ticket = Soporte::findOrFail($id);
        $admin = auth()->user();
        
        $ticket->res_sop = $request->respuesta;
        $ticket->est_sop = $request->estado;
        $ticket->cod_admin = $admin->cod_us;
        
        if ($request->estado == 'resuelto' && !$ticket->fec_resuelto) {
            $ticket->fec_resuelto = now();
        }
        
        $ticket->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Respuesta enviada correctamente',
            'ticket' => $ticket
        ]);
    }
    
    /**
     * Cambia el estado de un ticket
     */
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:abierto,en_proceso,resuelto,cerrado'
        ]);
        
        $ticket = Soporte::findOrFail($id);
        $ticket->est_sop = $request->estado;
        
        if ($request->estado == 'resuelto' && !$ticket->fec_resuelto) {
            $ticket->fec_resuelto = now();
            $ticket->cod_admin = auth()->user()->cod_us;
        }
        
        if ($request->estado == 'abierto') {
            $ticket->fec_resuelto = null;
            $ticket->res_sop = null;
        }
        
        $ticket->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }
    
    /**
     * Elimina un ticket
     */
    public function destroy($id)
    {
        $ticket = Soporte::findOrFail($id);
        $ticket->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Ticket eliminado correctamente'
        ]);
    }
}