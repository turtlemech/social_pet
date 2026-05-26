<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;

// ========== PÁGINA PRINCIPAL ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== REGISTRO DE USUARIO ==========
// Ruta principal para registro (la que busca navigation-menu.blade.php)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Ruta alternativa en español (opcional)
Route::get('/registro-usuario', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/registro-usuario', [RegisterController::class, 'register'])->name('user.register.submit');

// Redirección de /registro a /register (opcional)
Route::get('/registro', function() {
    return redirect()->route('register');
});

// ========== LOGIN Y REGISTRO ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========== RUTAS PROTEGIDAS ==========
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ================= POSTS =================
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // ❤️ LIKE
    Route::post('/like/{post}', [LikeController::class, 'toggle'])->name('like.toggle');

    // 💬 COMENTARIOS
    Route::post('/comentarios/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

    // ================= PERFIL =================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= OTRAS RUTAS =================
    Route::view('/feed', 'feed')->name('feed');
    Route::view('/my-pets', 'my-pets')->name('my-pets');
    Route::view('/messages', 'messages')->name('messages');
    Route::view('/settings', 'settings')->name('settings');
    Route::view('/explore', 'explore')->name('explore');
    Route::view('/search', 'search')->name('search');
    Route::view('/notifications', 'notifications')->name('notifications');

    Route::get('/prueba', fn() => 'ESTA ES UNA PÁGINA DE PRUEBA - REDIRECCIÓN FUNCIONA!')->name('prueba');

    // ========== SOPORTE USUARIO ==========
    Route::prefix('soporte')->name('soporte.')->group(function () {
        Route::get('/dashboard', [SoporteController::class, 'dashboard'])->name('dashboard');
        Route::get('/mis-tickets', [SoporteController::class, 'myTickets'])->name('mis-tickets');
        Route::get('/ver-ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])->name('ver-ticket');
    });
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

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ========== USUARIOS ==========
        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [AdminController::class, 'usuarios'])->name('index');
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->middleware('auth');
            Route::post('/{id}/toggle-block', [AdminController::class, 'toggleBlockUser'])->name('toggle-block');
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
            Route::post('/{id}/toggle', [AdminController::class, 'togglePublicacion'])->name('toggle');
            Route::delete('/{id}', [AdminController::class, 'deletePublicacion'])->name('destroy');
        });

        // ========== REPORTES ==========
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::view('/', 'admin.reports.index')->name('index');
            Route::view('/users', 'admin.reports.users')->name('users');
            Route::view('/posts', 'admin.reports.posts')->name('posts');
        });

        // ========== SOPORTE ADMIN ==========
        Route::prefix('soporte')->name('soporte.')->group(function () {
            Route::get('/', [SoporteController::class, 'index'])->name('index');
            Route::get('/dashboard', [SoporteController::class, 'adminDashboard'])->name('dashboard');
            Route::get('/estadisticas', [SoporteController::class, 'estadisticas'])->name('estadisticas');
            Route::put('/ticket/{id}', [SoporteController::class, 'updateTicket'])->name('update');
            Route::post('/asignar/{id}', [SoporteController::class, 'asignarTicket'])->name('asignar');
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

// ================= NUEVAS RUTAS PARA SOPORTE CON VISTAS TAILWIND =================
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
        Route::view('/', 'pets.index')->name('index');
        Route::view('/create', 'pets.create')->name('create');
        Route::post('/', fn() => back()->with('success', 'Mascota creada'))->name('store');
        Route::view('/{id}', 'pets.show')->name('show');
        Route::view('/{id}/edit', 'pets.edit')->name('edit');
        Route::put('/{id}', fn() => back()->with('success', 'Mascota actualizada'))->name('update');
        Route::delete('/{id}', fn() => back()->with('success', 'Mascota eliminada'))->name('destroy');
    });

// ========== EVENTOS ==========
Route::middleware(['auth'])->group(function () {
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
});

// Fallback
Route::fallback(fn() => view('errors.404'));