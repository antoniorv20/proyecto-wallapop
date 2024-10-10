<?php
// Configuración de la conexión a la base de datos
$host = 'localhost'; // Cambia esto si tu servidor es diferente
$db = 'tiendap';     // Nombre de tu base de datos
$user = 'root';      // Nombre de usuario de la base de datos
$pass = '';          // Contraseña de la base de datos (déjalo vacío si no tienes)

// Intentar establecer la conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
