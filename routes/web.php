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

use App\Http\Controllers\FollowController;

use App\Http\Controllers\SeguimientoMascotaController;

use App\Http\Controllers\MessageController;

// ========== PÁGINA PRINCIPAL ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== LOGIN Y REGISTRO ==========
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// ========== RUTAS PROTEGIDAS ==========
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ================= POSTS =================

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    // ❤️ LIKE
    Route::post('/like/{post}', [LikeController::class, 'toggle'])
        ->name('like.toggle');

    // 💬 COMENTARIOS
    Route::post('/posts/{post}/comment', [ComentarioController::class, 'store'])

    ->name('posts.comment');

    // ================= PERFIL =================

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])
        ->name('profile.avatar');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
        Route::get('/configuracion', [ProfileController::class, 'index'])
    ->name('configuracion');

Route::put('/configuracion', [ProfileController::class, 'update'])
    ->name('configuracion.update');

Route::put('/configuracion/password', [ProfileController::class, 'updatePassword'])
    ->name('configuracion.password');

Route::post('/configuracion/avatar', [ProfileController::class, 'updateAvatar'])
    ->name('configuracion.avatar');

Route::delete('/configuracion', [ProfileController::class, 'destroy'])
    ->name('configuracion.destroy');

    // ================= OTRAS RUTAS =================

    Route::view('/feed', 'feed')->name('feed');
    Route::get('/my-pets', [ProfileController::class, 'myPets'])
    ->name('my-pets');
    Route::get('/messages', [MessageController::class, 'index'])
    ->name('messages.index');

Route::get('/messages/{id}', [MessageController::class, 'show'])
    ->name('messages.show');

Route::post('/messages/start/{user}', [MessageController::class, 'start'])
    ->name('messages.start');
    Route::get('/search/live', [SearchController::class, 'live'])
    ->name('search.live');

Route::post('/messages/send/{id}', [MessageController::class, 'send'])
    ->name('messages.send');
    Route::view('/settings', 'settings')->name('settings');
    Route::view('/explore', 'explore')->name('explore');
    Route::view('/search', 'search')->name('search');
    Route::view('/notifications', 'notifications')->name('notifications');
    Route::post('/notifications/read', function () {

    \App\Models\Notificacion::where('usuario_id', auth()->id())
        ->where('lei_not', false)
        ->update([
            'lei_not' => true,
            'fch_lei_not' => now()
        ]);

    return response()->json([
        'success' => true
    ]);
})->name('notifications.read');

    Route::get('/prueba', fn() => 'ESTA ES UNA PÁGINA DE PRUEBA - REDIRECCIÓN FUNCIONA!')
        ->name('prueba');
// ================= PERFIL SOCIAL =================

Route::get('/usuario/{user}', [UserProfileController::class, 'show'])
    ->name('usuario.profile');

Route::post('/seguir/{user}', [FollowController::class, 'toggle'])
    ->name('seguir.toggle');

// ================= SEGUIR MASCOTAS =================

Route::post('/mascotas/{mascota}/seguir', [SeguimientoMascotaController::class, 'toggle'])
    ->name('mascotas.seguir');
    // ========== SOPORTE USUARIO ==========

    Route::prefix('soporte')->name('soporte.')->group(function () {

        Route::get('/dashboard', [SoporteController::class, 'dashboard'])
            ->name('dashboard');



        Route::get('/mis-tickets', [SoporteController::class, 'myTickets'])
            ->name('mis-tickets');

        Route::get('/ver-ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])
            ->name('ver-ticket');
    });
});

// ========== SOPORTE PÚBLICO ==========

Route::prefix('soporte')->name('soporte.')->group(function () {

    Route::get('/', [SoporteController::class, 'index'])
        ->name('index');

    Route::post('/submit', [SoporteController::class, 'submitTicket'])
        ->name('submit');

    Route::get('/estado', [SoporteController::class, 'estadoForm'])
        ->name('estado.form');

    Route::post('/estado', [SoporteController::class, 'consultarEstado'])
        ->name('consultar.estado');

    Route::get('/ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])
        ->name('ticket.publico');
});

// ========== ADMIN ==========

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {

        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('logout');

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // ========== USUARIOS ==========
        Route::prefix('usuarios')->name('usuarios.')->group(function () {

            // Lista de usuarios
            Route::get('/', [AdminController::class, 'usuarios'])
                ->name('index');

            // Editar usuario (JSON)
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])
                ->name('edit');

            // Actualizar usuario
            Route::put('/{id}', [AdminController::class, 'updateUser'])
                ->name('update');

            // Eliminar usuario
            // En routes/api.php o web.php
            Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->middleware('auth');

            // Bloquear/Activar usuario
            Route::post('/{id}/toggle-block', [AdminController::class, 'toggleBlockUser'])
                ->name('toggle-block');
                Route::post('/{id}/restablecer-contrasena', [AdminController::class, 'restablecerContrasena'])

    ->name('restablecer-contrasena');

Route::get('/{id}/generar-contrasena', [AdminController::class, 'generarContrasenaSugerida'])

    ->name('generar-contrasena');
        });

        // ========== MASCOTAS ==========
        Route::prefix('mascotas')->name('mascotas.')->group(function () {

            // Lista de mascotas
            Route::get('/', [AdminController::class, 'mascotas'])
                ->name('index');

            // Ver detalles de mascota (JSON)
            Route::get('/{id}', [AdminController::class, 'showMascota'])
                ->name('show');

            // Editar mascota (JSON)
            Route::get('/{id}/edit', [AdminController::class, 'editMascota'])
                ->name('edit');

            // Actualizar mascota
            Route::put('/{id}', [AdminController::class, 'updateMascota'])
                ->name('update');

            // Eliminar mascota
            Route::delete('/{id}', [AdminController::class, 'deleteMascota'])
                ->name('destroy');
        });

        // ========== PUBLICACIONES ==========
        Route::prefix('publicaciones')->name('publicaciones.')->group(function () {

            // Lista de publicaciones
            Route::get('/', [AdminController::class, 'publicaciones'])
                ->name('index');

            // Activar/Desactivar publicación
            Route::post('/{id}/toggle', [AdminController::class, 'togglePublicacion'])
                ->name('toggle');

            // Eliminar publicación
            Route::delete('/{id}', [AdminController::class, 'deletePublicacion'])
                ->name('destroy');
        });

        // ========== REPORTES ==========
        Route::prefix('reports')->name('reports.')->group(function () {

            Route::view('/', 'admin.reports.index')->name('index');
            Route::view('/users', 'admin.reports.users')->name('users');
            Route::view('/posts', 'admin.reports.posts')->name('posts');
        });

        // ========== SOPORTE ADMIN ==========
        Route::prefix('soporte')->name('soporte.')->group(function () {

            //  Ruta AGREGADA para listado principal de tickets (admin)
            Route::get('/', [SoporteController::class, 'index'])->name('index');

            Route::get('/dashboard', [SoporteController::class, 'adminDashboard'])
                ->name('dashboard');

            Route::get('/estadisticas', [SoporteController::class, 'estadisticas'])
                ->name('estadisticas');

            Route::put('/ticket/{id}', [SoporteController::class, 'updateTicket'])
                ->name('update');

            Route::post('/asignar/{id}', [SoporteController::class, 'asignarTicket'])
                ->name('asignar');
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


// ========== MASCOTAS ==========

Route::middleware(['auth'])
    ->prefix('pets')
    ->name('pets.')
    ->group(function () {

        // Mostrar mascotas
        Route::get('/', [PetController::class, 'index'])
            ->name('index');

        // Formulario crear mascota
        Route::view('/create', 'pets.create')
            ->name('create');

        // Guardar mascota
        Route::post('/', [PetController::class, 'store'])
            ->name('store');
            Route::get('/{id}', [PetController::class, 'show'])

    ->name('show');

Route::get('/{id}/edit', [PetController::class, 'edit'])

    ->name('edit');
    Route::put('/{id}', [PetController::class, 'update'])
    ->name('update');

Route::delete('/{id}', [PetController::class, 'destroy'])

    ->name('destroy');

    });
// ========== MARKETPLACE ==========

Route::middleware(['auth'])
    ->prefix('marketplace')
    ->name('marketplace.')
    ->group(function () {

        // Lista de productos
        Route::get('/', [MarketplaceController::class, 'index'])
            ->name('index');

        // Formulario crear producto
        Route::get('/create', [MarketplaceController::class, 'create'])
            ->name('create');

        // Guardar producto
        Route::post('/', [MarketplaceController::class, 'store'])
            ->name('store');

    });
    // ========== MASCOTAS SUGERIDAS ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/sugerencias', [SugerenciaController::class, 'index'])
        ->name('sugerencias.index');
});
Route::middleware(['auth'])->group(function () {
// ========== ADOPCIONES ==========

Route::middleware(['auth'])->group(function () {

    Route::get('/adopciones', [AdopcionController::class, 'index'])
        ->name('adopciones.index');

    Route::get('/adopciones/create', [AdopcionController::class, 'create'])
        ->name('adopciones.create');

    Route::post('/adopciones', [AdopcionController::class, 'store'])
        ->name('adopciones.store');

});
// ========== MATCHES ==========

Route::middleware(['auth'])->group(function () {

    Route::get('/matches', [MatchController::class, 'index'])
        ->name('matches.index');

});
// ========== COMUNIDADES ==========

Route::middleware(['auth'])->group(function () {

    Route::get('/comunidades', [ComunidadController::class, 'index'])
        ->name('comunidades.index');

    Route::get('/comunidades/create', [ComunidadController::class, 'create'])
        ->name('comunidades.create');

    Route::post('/comunidades', [ComunidadController::class, 'store'])
        ->name('comunidades.store');

    Route::post('/comunidades/{cod_com}/unirse', [ComunidadController::class, 'unirse'])
        ->name('comunidades.unirse');

});
    // ================= EVENTOS =================

    Route::get('/eventos', [EventoController::class, 'index'])
        ->name('eventos.index');

    Route::get('/eventos/{evento}', [EventoController::class, 'show'])
        ->name('eventos.show');

    Route::post('/eventos', [EventoController::class, 'store'])
        ->name('eventos.store');

    Route::post('/eventos/{evento}/join', [EventoController::class, 'join'])
        ->name('eventos.join');

    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])
        ->name('eventos.destroy');

    Route::get('/mis-eventos', [EventoController::class, 'misEventos'])
        ->name('eventos.mis-eventos');

    Route::get('/eventos-participando', [EventoController::class, 'participando'])
        ->name('eventos.participando');

    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])
        ->name('eventos.edit');

    Route::put('/eventos/{evento}', [EventoController::class, 'update'])
        ->name('eventos.update');

    Route::patch('/eventos/{evento}/reactivar', [EventoController::class, 'reactivar'])
    ->name('eventos.reactivar');

Route::patch('/eventos/{evento}/finalizar', [EventoController::class, 'finalizar'])
    ->name('eventos.finalizar');
    
});

// Fallback
Route::fallback(fn() => view('errors.404'));
