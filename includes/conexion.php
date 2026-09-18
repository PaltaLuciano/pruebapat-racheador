<?php
// Archivo: includes/conexion.php

$host = "localhost";      // o 127.0.0.1
$dbname = "racheador";    // nombre de tu base de datos
$usuario = "admin";        // usuario de MySQL (por defecto root)
$clave = "200225";              // tu contraseña (vacía si estás en XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Conexión exitosa";
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
    exit;
}
?>
