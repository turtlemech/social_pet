<!DOCTYPE html>
<html>
<head>
    <title>Login - Social Pet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            position: relative;
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
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
        
        .success {
            background: #e8f5e9;
            color: #4caf50;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #4caf50;
        }
        
        .register-link {
            margin-top: 20px;
            text-align: center;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        /* Burbuja de soporte/admins */
        .support-bubble {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        .bubble-button {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff9800, #f57c00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .bubble-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        
        .bubble-button span {
            font-size: 28px;
        }
        
        /* Menu de soporte */
        .support-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .support-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .support-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: background 0.2s ease;
            border-radius: 15px;
        }
        
        .support-menu a:first-child {
            border-radius: 15px 15px 0 0;
        }
        
        .support-menu a:last-child {
            border-radius: 0 0 15px 15px;
        }
        
        .support-menu a:hover {
            background: #f5f5f5;
        }
        
        .support-menu span {
            margin-right: 10px;
            font-size: 18px;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 152, 0, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 152, 0, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 152, 0, 0);
            }
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-box {
                padding: 30px 20px;
            }
            
            .support-bubble {
                bottom: 20px;
                right: 20px;
            }
            
            .bubble-button {
                width: 50px;
                height: 50px;
            }
            
            .bubble-button span {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>🐾 Social Pet</h2>
            <div class="subtitle">Tu red social de mascotas</div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="error">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <!-- Formulario de Login -->
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>📧 Correo Electrónico</label>
                    <input type="email" name="ema_us" placeholder="tu@email.com" value="<?php echo e(old('ema_us')); ?>" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>🔒 Contraseña</label>
                    <input type="password" name="pas_us" placeholder="••••••••" required>
                </div>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
            
            <!-- Enlace a registro -->
            <div class="register-link">
                <a href="<?php echo e(route('register')); ?>">
                    ¿No tienes cuenta? 📝 Regístrate aquí
                </a>
            </div>
        </div>
    </div>
    
    <!-- Burbuja de soporte/administradores -->
    <div class="support-bubble">
        <div class="bubble-button" onclick="toggleSupportMenu()">
            <span>💬</span>
        </div>
        <div class="support-menu" id="supportMenu">
            <a href="<?php echo e(url('/admin/login')); ?>">
                <span>👑</span> Administrador
            </a>
            <a href="#" onclick="showSupportAlert()">
                <span>❓</span> Ayuda/Soporte
            </a>
            <a href="#" onclick="showContactModal()">
                <span>📧</span> Contacto
            </a>
        </div>
    </div>
    
    <!-- Modal de contacto (opcional) -->
    <div id="contactModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
        <div style="background: white; padding: 30px; border-radius: 20px; max-width: 400px; margin: 20px;">
            <h3 style="margin-bottom: 20px;">Contactar Soporte</h3>
            <p style="margin-bottom: 20px;">Envía un correo a:</p>
            <p style="margin-bottom: 20px; color: #667eea;">📧 soporte@socialpet.com</p>
            <button onclick="closeContactModal()" style="width: auto; padding: 10px 20px;">Cerrar</button>
        </div>
    </div>

    <script>
        function toggleSupportMenu() {
            const menu = document.getElementById('supportMenu');
            menu.classList.toggle('active');
        }
        
        function showSupportAlert() {
            alert('📞 Soporte Social Pet\n\nHorario: Lunes a Viernes 9:00 - 18:00\nEmail: soporte@socialpet.com\nTeléfono: (01) 234-5678');
            document.getElementById('supportMenu').classList.remove('active');
        }
        
        function showContactModal() {
            document.getElementById('contactModal').style.display = 'flex';
            document.getElementById('supportMenu').classList.remove('active');
        }
        
        function closeContactModal() {
            document.getElementById('contactModal').style.display = 'none';
        }
        
        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', function(event) {
            const bubble = document.querySelector('.support-bubble');
            const menu = document.getElementById('supportMenu');
            
            if (!bubble.contains(event.target) && menu.classList.contains('active')) {
                menu.classList.remove('active');
            }
        });
        
        // Enter key navigation
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement && activeElement.tagName === 'INPUT') {
                    const form = activeElement.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            }
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\social_pet\resources\views/auth/login.blade.php ENDPATH**/ ?>