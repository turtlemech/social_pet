<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Social Pet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }
        .sidebar {
            width: 250px;
            background: #1a1a2e;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #ff9800;
            margin: 0;
        }
        .logout-btn {
            background: #ff9800;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .nav-link {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .nav-link:hover {
            background: #ff9800;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🐾 Social Pet</h2>
        <hr>
        <a href="/admin" class="nav-link">📊 Dashboard</a>
        <a href="/admin/usuarios" class="nav-link">👥 Usuarios</a>
        <a href="/admin/mascotas" class="nav-link">🐕 Mascotas</a>
        <a href="/admin/publicaciones" class="nav-link">📝 Publicaciones</a>
        <hr>
        <form method="POST" action="/admin/logout">
            @csrf
            <button type="submit" class="nav-link" style="width:100%; text-align:left;">🚪 Cerrar Sesión</button>
        </form>
    </div>
    
    <div class="content">
        <div class="header">
            <h1>Panel de Administración</h1>
            <p>Bienvenido, <strong>{{ auth()->user()->nom_us }}</strong></p>
        </div>
        
        <div class="card">
            <h2>📊 Dashboard</h2>
            <p>Aquí irá el contenido del panel de administración.</p>
        </div>
        
        <div class="card">
            <h2>📈 Estadísticas</h2>
            <p>Total de usuarios: {{ \App\Models\User::count() }}</p>
            <p>Administradores: {{ \App\Models\User::where('is_admin', true)->count() }}</p>
        </div>
    </div>
</body>
</html>