<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DashboardController as ControllersDashboardController;
use Illuminate\Support\Facades\Route;

// ========== PÁGINA PRINCIPAL ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== LOGIN Y REGISTRO PARA USUARIOS NORMALES ==========
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registro
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// RUTAS PROTEGIDAS PARA USUARIOS NORMALES 
Route::middleware(['auth'])->group(function () {

    // Perfil de usuario - Con el controlador correcto
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');


    // Dashboard principal
    Route::get('/dashboard', [ControllersDashboardController::class, 'index'])->name('dashboard');

    // Feed de la red social
    Route::get('/feed', function () {
        return view('feed');
    })->name('feed');

    // Perfil de usuario
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Mis Mascotas
    Route::get('/my-pets', function () {
        return view('my-pets');
    })->name('my-pets');

    // Mensajes
    Route::get('/messages', function () {
        return view('messages');
    })->name('messages');

    // Configuración
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    // Explorar
    Route::get('/explore', function () {
        return view('explore');
    })->name('explore');

    // Búsqueda
    Route::get('/search', function () {
        return view('search');
    })->name('search');

    // Notificaciones
    Route::get('/notifications', function () {
        return view('notifications');
    })->name('notifications');

    // Página de prueba
    Route::get('/prueba', function () {
        return 'ESTA ES UNA PÁGINA DE PRUEBA - REDIRECCIÓN FUNCIONA!';
    })->name('prueba');
});

// RUTAS PARA MASCOTAS 
Route::middleware(['auth'])->prefix('pets')->name('pets.')->group(function () {
    Route::get('/', function () {
        return view('pets.index');
    })->name('index');

    Route::get('/create', function () {
        return view('pets.create');
    })->name('create');

    Route::post('/', function () {
        return redirect()->back()->with('success', 'Mascota creada exitosamente');
    })->name('store');

    Route::get('/{id}', function ($id) {
        return view('pets.show', compact('id'));
    })->name('show');

    Route::get('/{id}/edit', function ($id) {
        return view('pets.edit', compact('id'));
    })->name('edit');

    Route::put('/{id}', function ($id) {
        return redirect()->back()->with('success', 'Mascota actualizada exitosamente');
    })->name('update');

    Route::delete('/{id}', function ($id) {
        return redirect()->back()->with('success', 'Mascota eliminada exitosamente');
    })->name('destroy');
});

// RUTAS PARA MENSAJES 
Route::middleware(['auth'])->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', function () {
        return view('messages.index');
    })->name('index');

    Route::get('/{id}', function ($id) {
        return view('messages.show', compact('id'));
    })->name('show');

    Route::post('/send', function () {
        return redirect()->back()->with('success', 'Mensaje enviado');
    })->name('send');
});

// RUTAS PARA SEGUIDORES 
Route::middleware(['auth'])->prefix('follow')->name('follow.')->group(function () {
    Route::post('/{id}', function ($id) {
        return redirect()->back()->with('success', 'Ahora sigues a este usuario');
    })->name('store');

    Route::delete('/{id}', function ($id) {
        return redirect()->back()->with('success', 'Dejaste de seguir a este usuario');
    })->name('destroy');
});

//  RUTAS PARA LIKES 
Route::middleware(['auth'])->post('/posts/{id}/like', function ($id) {
    return response()->json(['liked' => true, 'count' => 10]);
})->name('posts.like');

//  RUTAS PARA COMENTARIOS 
Route::middleware(['auth'])->prefix('comments')->name('comments.')->group(function () {
    Route::post('/', function () {
        return redirect()->back()->with('success', 'Comentario agregado');
    })->name('store');

    Route::delete('/{id}', function ($id) {
        return redirect()->back()->with('success', 'Comentario eliminado');
    })->name('destroy');
});

//  LOGIN PARA ADMINISTRADORES 
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Gestión de usuarios
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', function () {
                return view('admin.users.index');
            })->name('index');

            Route::get('/{id}', function ($id) {
                return view('admin.users.show', compact('id'));
            })->name('show');

            Route::put('/{id}/block', function ($id) {
                return redirect()->back()->with('success', 'Usuario bloqueado');
            })->name('block');

            Route::delete('/{id}', function ($id) {
                return redirect()->back()->with('success', 'Usuario eliminado');
            })->name('destroy');
        });

        // Gestión de publicaciones
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', function () {
                return view('admin.posts.index');
            })->name('index');

            Route::delete('/{id}', function ($id) {
                return redirect()->back()->with('success', 'Publicación eliminada');
            })->name('destroy');
        });

        // Reportes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', function () {
                return view('admin.reports.index');
            })->name('index');

            Route::get('/users', function () {
                return view('admin.reports.users');
            })->name('users');

            Route::get('/posts', function () {
                return view('admin.reports.posts');
            })->name('posts');
        });
    });
});

// ========== RUTA POR DEFECTO PARA ERROR 404 ==========
Route::fallback(function () {
    return view('errors.404');
});
