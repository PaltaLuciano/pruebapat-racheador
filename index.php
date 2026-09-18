<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
require_once "includes/conexion.php";
require_once "includes/funciones.php";

// Obtener el usuario de la sesión
$usuario_id = $_SESSION["usuario_id"];

// Consultar las rachas del usuario
$stmt = $pdo->prepare("SELECT * FROM rachas WHERE usuario_id = :uid ORDER BY id DESC");
$stmt->execute(['uid' => $usuario_id]);
$rachas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Racheador 🕓</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <p>👋 Hola, <?= htmlspecialchars($_SESSION["usuario_nombre"]) ?> |
       <a href="logout.php">Cerrar sesión</a></p>
    
    <h1>🔥 Racheador</h1>
    <p>Seguimiento de tus hábitos y desafíos diarios.</p>
    <a href="nueva_racha.php" class="boton">➕ Nueva racha</a>
    
    <div class="contenedor">
        <?php if (count($rachas) > 0): ?>
            <?php foreach ($rachas as $r): ?>
                <?php $dias = dias_en_racha($r['fecha_inicio'], $r['fecha_ultimo_reset']); ?>
                <div class="tarjeta">
                    <h2><?= htmlspecialchars($r['titulo']) ?></h2>
                    <p><?= htmlspecialchars($r['descripcion']) ?></p>
                    <p><strong>Inicio:</strong> <?= formatear_fecha($r['fecha_inicio']) ?></p>
                    <p>🔥 <strong><?= $dias ?></strong> días seguidos</p>
                    <div class="botones">
                        <a href="registrar_log.php?id=<?= $r['id'] ?>" class="boton verde">Registrar día ✅</a>
                        <a href="reiniciar_racha.php?id=<?= $r['id'] ?>" class="boton rojo">Reiniciar 🔁</a>
                        <a href="eliminar_racha.php?id=<?= $r['id'] ?>" class="boton gris"
                           onclick="return confirm('¿Seguro que querés eliminar esta racha? 😢');">
                            Eliminar 🗑️
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: white; text-align: center; grid-column: 1/-1;">No tenés rachas todavía. ¡Crea tu primera!</p>
        <?php endif; ?>
    </div>
</body>
</html>