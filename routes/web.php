<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SoporteController; // 👈 AGREGAR
use Illuminate\Support\Facades\Route;

// ========== PÁGINA PRINCIPAL ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== LOGIN Y REGISTRO ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========== RUTAS PROTEGIDAS ==========
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // ❤️ LIKE (ARREGLADO)
    Route::post('/like/{post}', [LikeController::class, 'toggle'])->name('like.toggle');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Otras rutas
    Route::view('/feed', 'feed')->name('feed');
    Route::view('/my-pets', 'my-pets')->name('my-pets');
    Route::view('/messages', 'messages')->name('messages');
    Route::view('/settings', 'settings')->name('settings');
    Route::view('/explore', 'explore')->name('explore');
    Route::view('/search', 'search')->name('search');
    Route::view('/notifications', 'notifications')->name('notifications');
    Route::get('/prueba', fn() => 'ESTA ES UNA PÁGINA DE PRUEBA - REDIRECCIÓN FUNCIONA!')->name('prueba');
    
    // ========== RUTAS DE SOPORTE PARA USUARIOS AUTENTICADOS ==========
    Route::prefix('soporte')->name('soporte.')->group(function () {
        Route::get('/dashboard', [SoporteController::class, 'dashboard'])->name('dashboard');
        Route::get('/mis-tickets', [SoporteController::class, 'myTickets'])->name('mis-tickets');
        Route::get('/ver-ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])->name('ver-ticket');
    });
});

// ========== RUTAS DE SOPORTE (ACCESO LIBRE - SIN AUTENTICACIÓN) ==========
Route::prefix('soporte')->name('soporte.')->group(function () {
    Route::get('/', [SoporteController::class, 'index'])->name('index');
    Route::post('/submit', [SoporteController::class, 'submitTicket'])->name('submit');
    Route::get('/estado', [SoporteController::class, 'estadoForm'])->name('estado.form');
    Route::post('/estado', [SoporteController::class, 'consultarEstado'])->name('consultar.estado');
    Route::get('/ticket/{cod_sop}', [SoporteController::class, 'viewTicket'])->name('ticket.publico');
});

// ========== RUTAS DE ADMINISTRACIÓN DE SOPORTE ==========
Route::prefix('admin')->name('admin.')->group(function () {
    // Login de admin (existente)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });
    
    // Panel de admin con middleware (existente + soporte)
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard existente
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        
        // Gestión de usuarios (existente)
        Route::prefix('users')->name('users.')->group(function () {
            Route::view('/', 'admin.users.index')->name('index');
            Route::view('/{id}', 'admin.users.show')->name('show');
            Route::put('/{id}/block', fn() => back()->with('success', 'Usuario bloqueado'))->name('block');
            Route::delete('/{id}', fn() => back()->with('success', 'Usuario eliminado'))->name('destroy');
        });
        
        // Gestión de posts (existente)
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::view('/', 'admin.posts.index')->name('index');
            Route::delete('/{id}', fn() => back()->with('success', 'Publicación eliminada'))->name('destroy');
        });
        
        // Reportes (existente)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::view('/', 'admin.reports.index')->name('index');
            Route::view('/users', 'admin.reports.users')->name('users');
            Route::view('/posts', 'admin.reports.posts')->name('posts');
        });
        
        // ========== NUEVO: SOPORTE ADMIN ==========
        Route::prefix('soporte')->name('soporte.')->group(function () {
            Route::get('/dashboard', [SoporteController::class, 'adminDashboard'])->name('dashboard');
            Route::get('/estadisticas', [SoporteController::class, 'estadisticas'])->name('estadisticas');
            Route::put('/ticket/{id}', [SoporteController::class, 'updateTicket'])->name('update');
            Route::post('/asignar/{id}', [SoporteController::class, 'asignarTicket'])->name('asignar');
        });
    });
});

// ========== RUTAS DE AGENTES/MODERADORES (si los tienes) ==========
Route::middleware(['auth'])->prefix('soporte')->name('soporte.')->group(function () {
    // Solo para usuarios con rol especial (puedes ajustar el middleware)
    Route::get('/agente/dashboard', [SoporteController::class, 'agenteDashboard'])
        ->name('agente.dashboard')
        ->middleware('can:verSoporte'); // O usa un middleware personalizado
});

// ========== RUTAS PARA MASCOTAS ==========
Route::middleware(['auth'])->prefix('pets')->name('pets.')->group(function () {
    Route::view('/', 'pets.index')->name('index');
    Route::view('/create', 'pets.create')->name('create');
    Route::post('/', fn() => back()->with('success', 'Mascota creada'))->name('store');
    Route::view('/{id}', 'pets.show')->name('show');
    Route::view('/{id}/edit', 'pets.edit')->name('edit');
    Route::put('/{id}', fn() => back()->with('success', 'Mascota actualizada'))->name('update');
    Route::delete('/{id}', fn() => back()->with('success', 'Mascota eliminada'))->name('destroy');
});

// Fallback
Route::fallback(fn() => view('errors.404'));