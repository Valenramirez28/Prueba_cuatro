<?php
$host = 'localhost'; // Cambia esto a la dirección de tu servidor de base de datos
$dbname = 'impuestos';
$username = 'root'; // Cambia esto al nombre de usuario de tu base de datos
$password = ''; // Cambia esto a la contraseña de tu base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>