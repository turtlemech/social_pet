<!DOCTYPE html>
<html>
<head>
    <title>Feed - Social Pet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: #f5f5f5;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .nav-links a, .nav-links button {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">🐾 Social Pet</div>
        <div class="nav-links">
            <a href="/dashboard">Dashboard</a>
            <a href="/feed">Feed</a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <h1>Feed de la Red Social</h1>
            <p>Aquí verás las publicaciones de tus amigos...</p>
        </div>
    </div>
</body>
</html>