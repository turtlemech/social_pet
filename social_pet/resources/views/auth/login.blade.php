<!DOCTYPE html>
<html>
<head>
    <title>Login - Social Pet</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        
        h2 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .admin-link {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .admin-link a {
            color: #888;
            text-decoration: none;
            font-size: 13px;
        }
        
        .admin-link a:hover {
            color: #ff9800;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>🐾 Social Pet</h2>
            <div class="subtitle">Tu red social de mascotas</div>
            
            @if($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group">
                    <label>📧 Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@email.com" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>🔒 Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
            
            <div class="admin-link">
                <a href="{{ url('/admin/login') }}">¿Eres administrador? Accede aquí</a>
            </div>
        </div>
    </div>

   



</body>
</html>