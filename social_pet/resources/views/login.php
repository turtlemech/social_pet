<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    if ($user === "admin" && $pass === "1234") {
        $_SESSION["user"] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "❌ Datos incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login 🐶</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        background: url('https://images.unsplash.com/photo-1518717758536-85ae29035b6d') center/cover no-repeat;
    }
</style>

</head>

<body class="flex items-center justify-center h-screen">

<div class="bg-white/20 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-96 text-white">

    <h2 class="text-3xl font-bold text-center mb-6">🐾 Bienvenido</h2>

    <?php if($error): ?>
        <p class="text-red-300 text-sm mb-4 text-center"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <div>
            <label>🐶 Usuario</label>
            <input type="text" name="username"
                   class="w-full p-2 rounded bg-white/80 text-black"
                   required>
        </div>

        <div>
            <label>🔒 Contraseña</label>
            <input type="password" name="password"
                   class="w-full p-2 rounded bg-white/80 text-black"
                   required>
        </div>

        <button class="w-full bg-orange-500 hover:bg-orange-600 transition py-2 rounded-lg font-semibold">
            Entrar 🐾
        </button>

    </form>

    <p class="text-center text-sm mt-4">
        🐕 ¿No tienes cuenta? Próximamente...
    </p>

</div>

</body>
</html>

