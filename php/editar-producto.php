<?php
// Conexión a la base de datos
$host = 'localhost'; // Cambia si es necesario
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

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanitizar datos
    $id = trim($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $precio = trim($_POST['precio']);
    $descripcion = trim($_POST['descripcion']);
    
    // Validar datos
    if (empty($id) || empty($nombre) || empty($precio) || empty($descripcion)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    // Validar y sanitizar el precio
    if (!is_numeric($precio) || $precio <= 0) {
        echo "El precio debe ser un número positivo.";
        exit;
    }

    // Manejar la carga de la imagen del producto
    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        // Validar tipo de archivo
        $fileType = mime_content_type($_FILES['imagen']['tmp_name']);
        if (strpos($fileType, 'image/') !== 0) {
            echo "Solo se permiten imágenes.";
            exit;
        }

        // Generar un nombre único para la imagen
        $imagen = 'img/' . uniqid() . '-' . basename($_FILES['imagen']['name']); // Cambia la ruta según corresponda

        // Intentar mover el archivo
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            echo "Error al subir la imagen. <br>"; // Agrega esta línea para verificar
            exit; // Salir si hay un error en la carga
        }
    }

    // Actualizar el producto en la base de datos
    try {
        if ($imagen) {
            $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen = ? WHERE id = ?");
            $stmt->execute([$nombre, $precio, $descripcion, $imagen, $id]);
        } else {
            // Si no se subió una nueva imagen, actualizamos sin cambiar la imagen
            $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ? WHERE id = ?");
            $stmt->execute([$nombre, $precio, $descripcion, $id]);
        }

        echo "Producto actualizado exitosamente. Puedes <a href='../perfil.php'>ver tu perfil aquí</a>.";
    } catch (PDOException $e) {
        echo "Error al actualizar el producto: " . $e->getMessage();
    }
}
?>
