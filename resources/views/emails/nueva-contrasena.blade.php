<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Social Pet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #f97316;
        }
        .header h1 {
            color: #f97316;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .password-box {
            background-color: #fef3c7;
            border-left: 4px solid #f97316;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .password-label {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
            display: block;
        }
        .password-value {
            font-size: 24px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            color: #f97316;
            letter-spacing: 1px;
            word-break: break-all;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 12px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 14px;
            color: #856404;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #f97316;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .button:hover {
            background-color: #ea580c;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
        }
        .info {
            background-color: #e8f4f8;
            padding: 12px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 14px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
            .password-value {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐾 Social Pet</h1>
            <p>Tu comunidad de mascotas</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                <strong>Hola {{ $nombreCompleto ?? $usuario->nom_us }},</strong>
            </div>
            
            <p>Hemos recibido una solicitud para restablecer tu contraseña. Tu cuenta ha sido actualizada con una nueva contraseña generada automáticamente.</p>
            
            <div class="password-box">
                <span class="password-label">🔐 Tu nueva contraseña es:</span>
                <div class="password-value">{{ $nuevaContrasena }}</div>
            </div>
            
            <div class="warning">
                <strong>⚠️ Importante:</strong>
                <ul style="margin: 10px 0 0 20px; padding: 0;">
                    <li>Esta contraseña ha sido generada automáticamente</li>
                    <li>Te recomendamos cambiarla después de iniciar sesión</li>
                    <li>No compartas esta contraseña con nadie</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Iniciar Sesión</a>
            </div>
            
            <div class="info">
                <strong>💡 Consejos de seguridad:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    <li>Cambia tu contraseña regularmente</li>
                    <li>No uses la misma contraseña en múltiples sitios</li>
                    <li>Si no solicitaste este cambio, contacta al soporte inmediatamente</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>Este mensaje es automático, por favor no responder a este correo.</p>
            <p>© {{ date('Y') }} Social Pet - Todos los derechos reservados.</p>
            <p>Si tienes problemas para iniciar sesión, contacta a nuestro soporte: soporte@socialpet.com</p>
        </div>
    </div>
</body>
</html>
