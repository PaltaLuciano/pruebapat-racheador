<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
require_once "includes/conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    
    // Obtener el usuario de la sesión
    $usuario_id = $_SESSION["usuario_id"];
    
    if ($titulo != "") {
        $stmt = $pdo->prepare("INSERT INTO rachas (usuario_id, titulo, descripcion, fecha_inicio, fecha_ultimo_reset)
                               VALUES (:uid, :t, :d, CURDATE(), NULL)");
        $stmt->execute([
            'uid' => $usuario_id,
            't' => $titulo,
            'd' => $descripcion
        ]);
        
        // Redirigimos a la página principal
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "⚠️ El título es obligatorio.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva racha - Racheador</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>➕ Nueva racha</h1>
    <?php if ($mensaje): ?>
        <p style="color:red;"><?= $mensaje ?></p>
    <?php endif; ?>
    
    <form method="POST" action="">
        <label>Título:</label>
        <input type="text" name="titulo" required>
        
        <label>Descripción (opcional):</label>
        <textarea name="descripcion" rows="3"></textarea>
        
        <button type="submit" class="boton">Guardar</button>
        <a href="index.php" class="boton-rojo">Cancelar</a>
    </form>
</body>
</html>