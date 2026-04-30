<?php

namespace App\Http\Controllers;

use App\Models\Soporte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoporteController extends Controller
{
    // Página principal de soporte (acceso libre)
    public function index()
    {
        return view('soporte.index');
    }

    // Formulario para consultar estado
    public function estadoForm()
    {
        return view('soporte.estado-form');
    }

    // Consultar estado de ticket
    public function consultarEstado(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ]);

        $ticket = Soporte::with('usuario')
            ->where('cod_sop', $request->codigo)
            ->first();

        if (!$ticket) {
            return back()->with('error', 'No se encontró ningún ticket con ese código');
        }

        return view('soporte.estado-ticket', compact('ticket'));
    }

    // Enviar ticket usando Eloquent
    public function submitTicket(Request $request)
    {
        $request->validate([
            'nom_contacto' => 'required|string|max:100',
            'email_contacto' => 'required|email|max:150',
            'asu_sop' => 'required|string|max:200',
            'cat_sop' => 'required|string',
            'pri_sop' => 'required|string',
            'men_sop' => 'required|string|min:10'
        ]);

        // Buscar si el usuario existe por email
        $usuario = User::where('ema_us', $request->email_contacto)->first();

        // Crear ticket
        $ticket = new Soporte();
        $ticket->cod_sop = $this->generateCodigo();
        $ticket->cod_us = $usuario ? $usuario->cod_us : null;
        $ticket->nom_contacto = $request->nom_contacto;
        $ticket->email_contacto = $request->email_contacto;
        $ticket->asu_sop = $request->asu_sop;
        $ticket->cat_sop = $request->cat_sop;
        $ticket->pri_sop = $request->pri_sop;
        $ticket->men_sop = $request->men_sop;
        $ticket->est_sop = 'abierto';
        $ticket->save();

        return back()->with('success', '✅ ¡Ticket creado exitosamente! Tu código de seguimiento es: ' . $ticket->cod_sop);
    }

    // Generar código único
    private function generateCodigo()
    {
        $fecha = Carbon::now()->format('Ymd');
        $ultimo = Soporte::whereDate('created_at', Carbon::today())->count();
        $secuencia = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        return 'SOP' . $fecha . $secuencia;
    }

    // Dashboard según rol
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Verificar si es admin
        if ($user->is_admin) {
            return redirect()->route('soporte.admin.dashboard');
        }
        
        // Usuario normal
        return redirect()->route('soporte.mis-tickets');
    }

    // Dashboard para ADMIN
    public function adminDashboard()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acceso no autorizado');
        }

        $tickets = Soporte::with('usuario')
            ->orderByRaw("FIELD(pri_sop, 'urgente', 'alta', 'media', 'baja')")
            ->orderBy('created_at', 'desc')
            ->get();

        $agentes = User::where('is_admin', true)->get();

        $stats = [
            'total' => Soporte::count(),
            'abierto' => Soporte::where('est_sop', 'abierto')->count(),
            'en_proceso' => Soporte::where('est_sop', 'en_proceso')->count(),
            'resuelto' => Soporte::where('est_sop', 'resuelto')->count(),
            'cerrado' => Soporte::where('est_sop', 'cerrado')->count(),
            'urgentes' => Soporte::where('pri_sop', 'urgente')->where('est_sop', '!=', 'cerrado')->count(),
            'sin_usuario' => Soporte::whereNull('cod_us')->count()
        ];

        return view('soporte.admin-dashboard', compact('tickets', 'stats', 'agentes'));
    }

    // Dashboard para AGENTES (si tienes campo rol_us, si no, usa el mismo de admin)
    public function agenteDashboard()
    {
        if (!Auth::check()) {
            abort(403);
        }

        $user = Auth::user();
        $userCod = $user->cod_us;

        $tickets = Soporte::with('usuario')
            ->where(function($q) use ($userCod) {
                $q->where('cod_admin', $userCod)
                  ->orWhereNull('cod_admin');
            })
            ->where('est_sop', '!=', 'cerrado')
            ->orderByRaw("FIELD(pri_sop, 'urgente', 'alta', 'media', 'baja')")
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'asignados' => $tickets->where('cod_admin', $userCod)->count(),
            'pendientes' => $tickets->whereNull('cod_admin')->count(),
            'urgentes' => $tickets->where('pri_sop', 'urgente')->count()
        ];

        return view('soporte.agente-dashboard', compact('tickets', 'stats'));
    }

    // Actualizar ticket
    public function updateTicket(Request $request, $id)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $user = Auth::user();
        $ticket = Soporte::findOrFail($id);

        // Verificar permisos
        if (!$user->is_admin && $ticket->cod_admin != $user->cod_us) {
            abort(403, 'No tienes permiso para editar este ticket');
        }

        $request->validate([
            'est_sop' => 'required|in:abierto,en_proceso,resuelto,cerrado',
            'res_sop' => 'nullable|string'
        ]);

        $ticket->est_sop = $request->est_sop;
        $ticket->res_sop = $request->res_sop;
        
        if ($request->est_sop == 'resuelto') {
            $ticket->fec_resuelto = now();
        }
        
        $ticket->save();

        return redirect()->back()->with('success', '✅ Ticket actualizado correctamente');
    }

    // Asignar ticket a un agente (solo admin)
    public function asignarTicket(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'cod_admin' => 'required|exists:usuarios,cod_us'
        ]);

        $ticket = Soporte::findOrFail($id);
        $ticket->cod_admin = $request->cod_admin;
        $ticket->est_sop = 'en_proceso';
        $ticket->save();

        return back()->with('success', '✅ Ticket asignado correctamente');
    }

    // Mis tickets (usuario normal)
    public function myTickets()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tickets = Soporte::where('cod_us', Auth::user()->cod_us)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('soporte.mis-tickets', compact('tickets'));
    }

    // Ver detalle de ticket
    public function viewTicket($cod_sop)
    {
        $ticket = Soporte::with(['usuario', 'admin'])
            ->where('cod_sop', $cod_sop)
            ->firstOrFail();

        // Verificar permisos
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->is_admin && $ticket->cod_us != $user->cod_us) {
                abort(403, 'No tienes permiso para ver este ticket');
            }
        }

        return view('soporte.ver-ticket', compact('ticket'));
    }

    // Estadísticas para admin
    public function estadisticas()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        $statsPorCategoria = Soporte::select('cat_sop', DB::raw('count(*) as total'))
            ->groupBy('cat_sop')
            ->get();

        $statsPorPrioridad = Soporte::select('pri_sop', DB::raw('count(*) as total'))
            ->groupBy('pri_sop')
            ->get();

        $ticketsPorMes = Soporte::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'), DB::raw('count(*) as total'))
            ->groupBy('mes')
            ->orderBy('mes', 'desc')
            ->limit(6)
            ->get();

        return view('soporte.estadisticas', compact('statsPorCategoria', 'statsPorPrioridad', 'ticketsPorMes'));
    }
}