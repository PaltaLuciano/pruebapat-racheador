<?php
session_start();
require_once "includes/conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $clave = trim($_POST["clave"]);

    if ($nombre && $email && $clave) {
        // Encriptar la clave
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, clave) VALUES (:n, :e, :c)");
        try {
            $stmt->execute(['n' => $nombre, 'e' => $email, 'c' => $hash]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "⚠️ Ese correo ya está registrado.";
        }
    } else {
        $mensaje = "Completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Racheador</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>🧍 Crear cuenta</h1>
    <?php if ($mensaje): ?><p style="color:red;"><?= $mensaje ?></p><?php endif; ?>

    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="clave" required><br><br>

        <button type="submit" class="boton">Registrarme</button>
        <a href="login.php" class="boton-rojo">Ya tengo cuenta</a>
    </form>
</body>
</html>
