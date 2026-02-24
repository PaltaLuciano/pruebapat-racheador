<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require_once "includes/conexion.php";

// Verificar que venga el ID de la racha
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$racha_id = (int) $_GET["id"];
$usuario_id = $_SESSION["usuario_id"];

// Verificar que la racha pertenezca al usuario
$stmt = $pdo->prepare("SELECT id FROM rachas WHERE id = :rid AND usuario_id = :uid");
$stmt->execute(['rid' => $racha_id, 'uid' => $usuario_id]);
$racha = $stmt->fetch();

if (!$racha) {
    // La racha no existe o no pertenece al usuario
    header("Location: index.php");
    exit;
}

// Actualizar la fecha del último reinicio
$stmt = $pdo->prepare("UPDATE rachas SET fecha_ultimo_reset = CURDATE() WHERE id = :rid");
$stmt->execute(['rid' => $racha_id]);

// (Opcional) Borrar logs anteriores si querés reiniciar el historial
$stmt = $pdo->prepare("DELETE FROM racha_logs WHERE racha_id = :rid");
$stmt->execute(['rid' => $racha_id]);

// Redirigir al inicio
header("Location: index.php");
exit;
?>