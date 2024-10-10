<?php
require_once 'conexion.php';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Obtener productos de la base de datos
$stmt = $pdo->query("SELECT * FROM productos");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="product-card" onclick="window.location.href=\'producto.php?id=' . $row['id'] . '\'">';
    echo '<img src="' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" class="product-image">';
    echo '<div class="product-info">';
    echo '<h4 class="product-title">' . htmlspecialchars($row['nombre']) . '</h4>';
    echo '<p class="product-price">€' . htmlspecialchars($row['precio']) . '</p>';
    echo '<p class="product-description">' . htmlspecialchars($row['descripcion']) . '</p>';
    echo '</div></div>'; // Cierra divs de producto
}



