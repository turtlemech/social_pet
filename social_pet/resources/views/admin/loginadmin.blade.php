<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Social Pet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        h2 {
            text-align: center;
            color: #ff9800;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .admin-badge {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .admin-badge::before {
            content: "🔐 ";
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #ff9800;
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 152, 0, 0.4);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #c33;
        }
        
        .back-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .back-link a {
            color: #888;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s ease;
        }
        
        .back-link a:hover {
            color: #ff9800;
        }
        
        .back-link a::before {
            content: "← ";
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>🐾 Social Pet</h2>
            <div class="admin-badge">Panel de Administración</div>
            
            @if($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ url('/admin/login') }}">
                @csrf
                <div class="form-group">
                    <label>📧 Correo Electrónico</label>
                    <input type="email" name="email" value="admin@admin.com" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>🔒 Contraseña</label>
                    <input type="password" name="password" value="12345678" required>
                </div>
                
                <button type="submit">Ingresar al Panel Admin</button>
            </form>
            
            <div class="back-link">
                <a href="{{ url('/login') }}">Volver al login de usuarios</a>
            </div>
        </div>
    </div>
</body>
</html>