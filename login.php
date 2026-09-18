<?php
session_start();
require_once "includes/conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $clave = trim($_POST["clave"]);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :e");
    $stmt->execute(['e' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario["clave"])) {
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nombre"] = $usuario["nombre"];
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "❌ Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Racheador</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>🔐 Iniciar sesión</h1>
    <?php if ($mensaje): ?><p style="color:red;"><?= $mensaje ?></p><?php endif; ?>

    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="clave" required><br><br>

        <button type="submit" class="boton">Entrar</button>
        <a href="registro.php" class="boton-rojo">Crear cuenta</a>
    </form>
</body>
</html>
