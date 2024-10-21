<?php

require_once 'conexion.php';

// Verificar si se envía el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    try {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo "Producto eliminado exitosamente.";
            header('Location: perfil.php');
            exit;
        } else {
            echo "Error al eliminar el producto.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
}

// Verificar si se envía el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    // Manejo de la nueva imagen
    $imagen = $_POST['imagen_actual']; // Imagen actual por defecto
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Definir la ruta donde se guardará la nueva imagen
        $carpetaDestino = 'uploads/'; // Cambia a tu carpeta deseada
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaImagen = $carpetaDestino . $nombreImagen;

        // Mover la imagen a la carpeta de destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen; // Actualiza la variable con la nueva ruta
        } else {
            echo "Error al subir la imagen.";
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen = ? WHERE id = ?");
        $stmt->execute([$nombre, $precio, $descripcion, $imagen, $id]);

        if ($stmt->rowCount() > 0) {
            echo "Producto actualizado exitosamente.";
        } else {
            echo "No se pudo actualizar el producto.";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar el producto: " . $e->getMessage();
    }
}

// Obtener el ID del producto desde la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consultar los datos del producto
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto):
?>
<?
    else:
        echo "Producto no encontrado.";
    endif;
} else {
    echo "ID de producto no especificado.";
}