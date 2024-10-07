<?php
// Conexión a la base de datos
$host = 'localhost'; 
$db = 'tiendap'; // Cambia por el nombre de tu base de datos
$user = 'root'; // Cambia por tu usuario de la base de datos
$pass = ''; // Cambia por tu contraseña de la base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']); // Sanitizar el ID del producto

    try {
        // Eliminar el producto de la base de datos
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);

        // Verificar si se eliminó correctamente
        if ($stmt->rowCount() > 0) {
            echo "Producto eliminado exitosamente.";
        } else {
            echo "No se encontró el producto con ese ID.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
}

// Consultar productos para mostrarlos en la interfaz
try {
    $stmt = $pdo->query("SELECT id, nombre, precio, descripcion, imagen FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los productos: " . $e->getMessage();
}
?>