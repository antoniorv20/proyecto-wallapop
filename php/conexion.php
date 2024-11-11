<?php
// Configuración de la conexión a la base de datos
$host = 'PMYSQL177.dns-servicio.com:3306'; // Cambia esto si tu servidor es diferente
$db = '10598321_wallapop';     // Nombre de tu base de datos
$user = 'antonioftp';      // Nombre de usuario de la base de datos
$pass = 'd031#6cPz';          // Contraseña de la base de datos (déjalo vacío si no tienes)

// Intentar establecer la conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
