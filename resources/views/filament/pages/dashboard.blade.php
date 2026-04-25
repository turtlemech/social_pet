<x-filament-panels::page>
    <!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Social Pet Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>🐾 Panel de Administración</h1>
        <p>Bienvenido, {{ auth()->user()->nom_us }}</p>
        <form method="POST" action="/admin/logout" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Cerrar Sesión</button>
        </form>
    </div>
    
    <div class="card">
        <h2>Dashboard</h2>
        <p>Aquí irá el contenido del panel de administración.</p>
    </div>
</body>
</html>
    {{-- Page content --}}
</x-filament-panels::page>
