<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\SugerenciaController;
use App\Http\Controllers\AdopcionController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ComunidadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\SolicitudAdopcionController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SeguimientoMascotaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HistoriaDestacadaController;

// ========== PÁGINA PRINCIPAL ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== LOGIN Y REGISTRO ==========
// Registro separado (sin middleware)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/registro-usuario', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/registro-usuario', [RegisterController::class, 'register'])->name('user.register.submit');
Route::get('/registro', function () {
    return redirect()->route('register');
});

// Login con middleware guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ========== RUTAS PROTEGIDAS ==========
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ================= POSTS =================
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/like/{post}', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/posts/{post}/comment', [ComentarioController::class, 'store'])->name('posts.comment');

    // ================= PERFIL =================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/ubicacion/actualizar', [ProfileController::class, 'actualizarUbicacion'])->name('ubicacion.actualizar');
    Route::post('/ubicacion/desactivar', [ProfileController::class, 'desactivarUbicacion'])->name('ubicacion.desactivar');
    Route::get('/configuracion', [ProfileController::class, 'index'])->name('configuracion');
    Route::put('/configuracion', [ProfileController::class, 'update'])->name('configuracion.update');
    Route::put('/configuracion/password', [ProfileController::class, 'updatePassword'])->name('configuracion.password');
    Route::post('/configuracion/avatar', [ProfileController::class, 'updateAvatar'])->name('configuracion.avatar');
    Route::delete('/configuracion', [ProfileController::class, 'destroy'])->name('configuracion.destroy');

    // ================= OTRAS RUTAS =================
    Route::view('/feed', 'feed')->name('feed');
    Route::get('/my-pets', [ProfileController::class, 'myPets'])->name('my-pets');

    // ================= MENSAJES =================
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/adopcion/start/{userId}/{adopcionId}', [MessageController::class, 'startAdopcion'])->name('messages.startAdopcion');
    Route::get('/messages/adopciones', [MessageController::class, 'adopciones'])->name('messages.adopciones');
    Route::get('/messages/marketplace', [MessageController::class, 'marketplace'])->name('messages.marketplace');
    Route::post('/messages/marketplace/start/{userId}/{productoId}', [MessageController::class, 'startMarketplace'])->name('messages.startMarketplace');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/start/{user}', [MessageController::class, 'start'])->name('messages.start');
    Route::post('/messages/send/{id}', [MessageController::class, 'send'])->name('messages.send');

    Route::view('/settings', 'settings')->name('settings');
    Route::view('/explore', 'explore')->name('explore');
    Route::view('/search', 'search')->name('search');
    Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');
    Route::view('/notifications', 'notifications')->name('notifications');
    Route::post('/notifications/read', function () {
        \App\Models\Notificacion::where('usuario_id', auth()->id())
            ->where('lei_not', false)
            ->update([
                'lei_not' => true,
                'fch_lei_not' => now()
            ]);
        return response()->json(['success' => true]);
    })->name('notifications.read');

    Route::get('/prueba', fn() => 'ESTA ES UNA PÁGINA DE PRUEBA - REDIRECCIÓN FUNCIONA!')->name('prueba');
    Route::get('/spotify/authorize', [SpotifyController::class, 'authorize'])->name('spotify.authorize');
    Route::get('/spotify/callback', [SpotifyController::class, 'callback'])->name('spotify.callback');
    Route::get('/music', [SpotifyController::class, 'music']);
    Route::get('/music/search', [SpotifyController::class, 'search']);

    // ================= HISTORIAS =================
    Route::prefix('historias')->name('historias.')->group(function () {
        Route::get('/crear', [HistoriaController::class, 'crear'])->name('crear');
        Route::post('/editor', [HistoriaController::class, 'editor'])->name('editor');
        Route::post('/guardar-final', [HistoriaController::class, 'guardarFinal'])->name('guardarFinal');
        Route::get('/ver/{usuario}', [HistoriaController::class, 'ver'])->name('ver');
        Route::post('/historias-destacadas', [HistoriaDestacadaController::class, 'store'])->name('destacadas.store');
        Route::get('/historias-destacadas/{destacada}', [HistoriaDestacadaController::class, 'show'])->name('destacadas.show');
        Route::delete('/historias-destacadas/{destacada}', [HistoriaDestacadaController::class, 'destroy'])->name('destacadas.destroy');
        Route::get('/seleccionar-destacadas', [HistoriaController::class, 'seleccionarDestacadas'])->name('destacadas.seleccionar');
        Route::post('/guardar-destacada', [HistoriaDestacadaController::class, 'store'])->name('destacadas.guardar');
    });

    // BUSCADOR DE USUARIOS PARA MENCIONES
    Route::get('/usuarios/buscar', [UserProfileController::class, 'buscar'])->name('usuarios.buscar');

    // ================= PERFIL SOCIAL =================
    Route::get('/usuario/{user}', [UserProfileController::class, 'show'])->name('usuario.profile');
    Route::post('/seguir/{user}', [FollowController::class, 'toggle'])->name('seguir.toggle');

    // ================= SEGUIR MASCOTAS =================
    Route::post('/mascotas/{mascota}/seguir', [SeguimientoMascotaController::class, 'toggle'])->name('mascotas.seguir');

    // ========== SOPORTE USUARIO ==========
    Route::prefix('soporte')->name('soporte.')->group(function () {
        Route::get('/dashboard', [SoporteController::class, 'dashboard'])->name('dashboard');
        Route::get('/mis-tickets', [SoporteController::class, 'myTickets'])->name('mis-tickets');
        Route::get('/ver-ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])->name('ver-ticket');
    });

    // ========== MASCOTAS ==========
    Route::prefix('pets')->name('pets.')->group(function () {
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::view('/create', 'pets.create')->name('create');
        Route::post('/', [PetController::class, 'store'])->name('store');
        Route::get('/{id}', [PetController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PetController::class, 'update'])->name('update');
        Route::delete('/{id}', [PetController::class, 'destroy'])->name('destroy');
    });

    // ========== MARKETPLACE ==========
    Route::prefix('marketplace')->name('marketplace.')->group(function () {
        Route::get('/', [MarketplaceController::class, 'index'])->name('index');
        Route::get('/create', [MarketplaceController::class, 'create'])->name('create');
        Route::post('/', [MarketplaceController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MarketplaceController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [MarketplaceController::class, 'destroy'])->name('destroy');
        Route::put('/{id}', [MarketplaceController::class, 'update'])->name('update');
    });

    // ========== MASCOTAS SUGERIDAS ==========
    Route::get('/sugerencias', [SugerenciaController::class, 'index'])->name('sugerencias.index');

    // ========== ADOPCIONES ==========
    Route::get('/adopciones', [AdopcionController::class, 'index'])->name('adopciones.index');
    Route::get('/adopciones/create', [AdopcionController::class, 'create'])->name('adopciones.create');
    Route::post('/adopciones', [AdopcionController::class, 'store'])->name('adopciones.store');
    Route::patch('/adopciones/{id}/adoptada', [AdopcionController::class, 'marcarAdoptada'])->name('adopciones.adoptada');
    Route::patch('/adopciones/{id}/cancelar', [AdopcionController::class, 'cancelar'])->name('adopciones.cancelar');
    Route::get('/adopciones/{id}/solicitar', [SolicitudAdopcionController::class, 'create'])->name('adopciones.solicitar');
    Route::get('/adopciones/solicitudes', [SolicitudAdopcionController::class, 'misSolicitudes'])->name('adopciones.solicitudes');
    Route::patch('/solicitudes/{id}/aprobar', [SolicitudAdopcionController::class, 'aprobar'])->name('adopciones.aprobarSolicitud');
    Route::patch('/solicitudes/{id}/rechazar', [SolicitudAdopcionController::class, 'rechazar'])->name('adopciones.rechazarSolicitud');
    Route::post('/adopciones/{id}/solicitar', [SolicitudAdopcionController::class, 'store'])->name('adopciones.solicitar.store');

    // ========== MATCHES ==========
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');

    // ========== COMUNIDADES ==========
    Route::get('/comunidades', [ComunidadController::class, 'index'])->name('comunidades.index');
    Route::get('/comunidades/create', [ComunidadController::class, 'create'])->name('comunidades.create');
    Route::post('/comunidades', [ComunidadController::class, 'store'])->name('comunidades.store');
    Route::post('/comunidades/{cod_com}/unirse', [ComunidadController::class, 'unirse'])->name('comunidades.unirse');
    Route::post('/comunidades/{cod_com}/salir', [ComunidadController::class, 'salir'])->name('comunidades.salir');
    Route::get('/comunidades/{cod_com}', [ComunidadController::class, 'show'])->name('comunidades.show');
    Route::post('/comunidades/{cod_com}/publicar', [ComunidadController::class, 'publicar'])->name('comunidades.publicar');
    Route::post('/publicaciones/{id}/like', [ComunidadController::class, 'like'])->name('comunidades.like');
    Route::post('/publicaciones/{id}/comentar', [ComunidadController::class, 'comentar'])->name('comunidades.comentar');

    // ========== MULTIMEDIA ==========
    Route::get('/multimedia', [MultimediaController::class, 'index'])->name('multimedia.index');
    Route::get('/multimedia/create', [MultimediaController::class, 'create'])->name('multimedia.create');
    Route::post('/multimedia', [MultimediaController::class, 'store'])->name('multimedia.store');

    // ================= EVENTOS =================
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::post('/eventos/{evento}/join', [EventoController::class, 'join'])->name('eventos.join');
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    Route::get('/mis-eventos', [EventoController::class, 'misEventos'])->name('eventos.mis-eventos');
    Route::get('/eventos-participando', [EventoController::class, 'participando'])->name('eventos.participando');
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    Route::patch('/eventos/{evento}/reactivar', [EventoController::class, 'reactivar'])->name('eventos.reactivar');
    Route::patch('/eventos/{evento}/finalizar', [EventoController::class, 'finalizar'])->name('eventos.finalizar');
});

// ========== SOPORTE PÚBLICO ==========
Route::prefix('soporte')->name('soporte.')->group(function () {
    Route::get('/', [SoporteController::class, 'index'])->name('index');
    Route::post('/submit', [SoporteController::class, 'submitTicket'])->name('submit');
    Route::get('/estado', [SoporteController::class, 'estadoForm'])->name('estado.form');
    Route::post('/estado', [SoporteController::class, 'consultarEstado'])->name('consultar.estado');
    Route::get('/ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])->name('ticket.publico');
});

// ========== ADMIN ==========
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ========== USUARIOS ==========
        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [AdminController::class, 'usuarios'])->name('index');
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('delete');
            Route::post('/{id}/cambiar-estado', [AdminController::class, 'cambiarEstado'])->name('cambiar-estado');
            Route::post('/{id}/restablecer-contrasena', [AdminController::class, 'restablecerContrasena'])->name('restablecer-contrasena');
            Route::get('/{id}/generar-contrasena', [AdminController::class, 'generarContrasenaSugerida'])->name('generar-contrasena');
            Route::get('/exportar/csv', [AdminController::class, 'exportUsers'])->name('exportar');
        });

        // ========== MASCOTAS ==========
        Route::prefix('mascotas')->name('mascotas.')->group(function () {
            Route::get('/', [AdminController::class, 'mascotas'])->name('index');
            Route::get('/{id}', [AdminController::class, 'showMascota'])->name('show');
            Route::get('/{id}/edit', [AdminController::class, 'editMascota'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateMascota'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'deleteMascota'])->name('destroy');
        });

        // ========== PUBLICACIONES ==========
        Route::prefix('publicaciones')->name('publicaciones.')->group(function () {
            Route::get('/', [AdminController::class, 'publicaciones'])->name('index');
            Route::get('/{id}', [AdminController::class, 'showPublicacion'])->name('show');
            Route::post('/{id}/cambiar-estado', [AdminController::class, 'cambiarEstadoPublicacion'])->name('cambiar-estado');
            Route::delete('/{id}', [AdminController::class, 'deletePublicacion'])->name('delete');
            Route::get('/exportar/csv', [AdminController::class, 'exportPublicaciones'])->name('exportar');
        });

        // ========== REPORTES ==========
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::view('/', 'admin.reports.index')->name('index');
            Route::view('/users', 'admin.reports.users')->name('users');
            Route::view('/posts', 'admin.reports.posts')->name('posts');
        });

        // ========== SOPORTE / TICKETS ADMIN (CORREGIDO) ==========
        Route::prefix('soporte')->name('soporte.')->group(function () {
            Route::get('/', [AdminController::class, 'soporteIndex'])->name('index');
            Route::get('/dashboard', [AdminController::class, 'soporteDashboard'])->name('dashboard');
            Route::get('/estadisticas', [AdminController::class, 'getChartData'])->name('estadisticas');
            Route::get('/{id}', [AdminController::class, 'showTicket'])->name('show');
            Route::post('/{id}/responder', [AdminController::class, 'responderTicket'])->name('responder');
            Route::post('/{id}/cambiar-estado', [AdminController::class, 'cambiarEstadoTicket'])->name('cambiar-estado');
            Route::delete('/{id}', [AdminController::class, 'deleteTicket'])->name('destroy');
            Route::get('/exportar/csv', [AdminController::class, 'exportarTickets'])->name('exportar');
        });
    });
});

// ========== AGENTES/MODERADORES ==========
Route::middleware(['auth'])
    ->prefix('soporte')
    ->name('soporte.')
    ->group(function () {
        Route::get('/agente/dashboard', [SoporteController::class, 'agenteDashboard'])
            ->name('agente.dashboard')
            ->middleware('can:verSoporte');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/soporte/dashsoporte', function () {
        return view('soporte.dashsoporte');
    })->name('soporte.dashsoporte');

    Route::get('/soporte/panel', function () {
        return view('soporte.dashsoporte');
    })->name('soporte.panel');
});

// Fallback
Route::fallback(fn() => view('errors.404'));