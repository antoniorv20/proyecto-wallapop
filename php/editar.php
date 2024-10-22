<?php

require_once 'conexion.php';

// Verificar si se envía el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    try {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            header('Location: perfil.php');
            exit;
        } else {
            // Si falla la eliminación, puedes manejar el error aquí
            header('Location: perfil.php?error=delete');
            exit;
        }
    } catch (PDOException $e) {
        // Manejar el error si algo sale mal
        header('Location: perfil.php?error=delete');
        exit;
    }
}

// Verificar si se envía el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $precio = floatval($_POST['precio']);
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));

    // Manejo de la nueva imagen
    $imagen = $_POST['imagen_actual']; // Imagen actual por defecto
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Validar que el archivo subido sea una imagen
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array(mime_content_type($_FILES['imagen']['tmp_name']), $allowedMimeTypes)) {
            // Definir la ruta donde se guardará la nueva imagen
            $carpetaDestino = 'uploads/'; // Cambia a tu carpeta deseada
            $nombreImagen = basename($_FILES['imagen']['name']);
            $rutaImagen = $carpetaDestino . $nombreImagen;

            // Mover la imagen a la carpeta de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                $imagen = $rutaImagen; // Actualiza la variable con la nueva ruta
            } else {
                header('Location: perfil.php?error=upload');
                exit;
            }
        } else {
            header('Location: perfil.php?error=invalid_image');
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen = ? WHERE id = ?");
        $stmt->execute([$nombre, $precio, $descripcion, $imagen, $id]);

        if ($stmt->rowCount() > 0) {
            header('Location: perfil.php'); // Redirigir después de actualizar
            exit;
        } else {
            header('Location: perfil.php?error=update');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: perfil.php?error=update');
        exit;
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

<!-- Aquí colocarías el formulario para editar el producto, mostrando los datos del producto -->

<?php
    else:
        echo "Producto no encontrado.";
    endif;
} else {
    echo "ID de producto no especificado.";
}
