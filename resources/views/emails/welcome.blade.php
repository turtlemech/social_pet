<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a SocialPet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0fdf4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #0d9488, #115e59);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-text {
            font-size: 24px;
            color: #0d9488;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #0d9488;
            padding: 15px;
            margin: 20px 0;
            border-radius: 10px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #0d9488, #115e59);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            margin: 20px 0;
        }
        .footer {
            background: #f7fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐾 {{ config('app.name') }}</h1>
        </div>
        
        <div class="content">
            <div class="welcome-text">
                ¡Hola {{ $user->nom_us }}! 👋
            </div>
            
            <p>¡Bienvenido a <strong>{{ config('app.name') }}</strong>! Estamos muy felices de tenerte en nuestra comunidad.</p>
            
            <div class="info-box">
                <strong>📋 Tus datos de acceso:</strong><br>
                📧 Email: {{ $user->ema_us }}<br>
                🆔 Código: {{ $cod_us }}<br>
                📅 Registro: {{ $user->created_at->format('d/m/Y H:i') }}
            </div>
            
            <p>En {{ config('app.name') }} podrás:</p>
            <ul>
                <li>✨ Compartir momentos de tus mascotas</li>
                <li>💬 Conectar con otros amantes de animales</li>
                <li>🛒 Comprar y vender en el marketplace</li>
                <li>❤️ Encontrar el match perfecto</li>
            </ul>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">
                    🚀 Comenzar ahora
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            <p>¿Preguntas? Contáctanos en soporte@socialpet.com</p>
        </div>
    </div>
</body>
</html>