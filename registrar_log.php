<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require_once "includes/conexion.php";

// Validar que haya un ID de racha
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$racha_id = (int) $_GET["id"];
$usuario_id = $_SESSION["usuario_id"];
$fecha_hoy = date("Y-m-d");

// Verificar que la racha pertenezca al usuario
$stmt = $pdo->prepare("SELECT id FROM rachas WHERE id = :rid AND usuario_id = :uid");
$stmt->execute(['rid' => $racha_id, 'uid' => $usuario_id]);
$racha = $stmt->fetch();

if (!$racha) {
    // La racha no existe o no pertenece al usuario
    header("Location: index.php");
    exit;
}

// Verificar si ya se registró un log hoy para esta racha
$stmt = $pdo->prepare("SELECT id FROM racha_logs WHERE racha_id = :rid AND fecha = :hoy");
$stmt->execute(['rid' => $racha_id, 'hoy' => $fecha_hoy]);
$existe = $stmt->fetch();

if (!$existe) {
    // Registrar un nuevo log para hoy
    $stmt = $pdo->prepare("INSERT INTO racha_logs (racha_id, fecha) VALUES (:rid, :hoy)");
    $stmt->execute(['rid' => $racha_id, 'hoy' => $fecha_hoy]);
}

// Redirigir al inicio
header("Location: index.php");
exit;
?>