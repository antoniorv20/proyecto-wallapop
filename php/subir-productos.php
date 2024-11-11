<?php
// Conexión a la base de datos
require_once 'conexion.php';

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $precio = htmlspecialchars($_POST['precio']);
    $descripcion = htmlspecialchars($_POST['descripcion']);

    // Manejo de la imagen
    $target_dir = "../uploads/"; // Directorio donde se guardarán las imágenes
    $target_file = "uploads/" . basename($_FILES["imagen"]["name"]); // Guardar como ruta relativa
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si la imagen es real o un fraude
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check === false) {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Verifica si el archivo ya existe
    if (file_exists($target_dir . basename($_FILES["imagen"]["name"]))) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verifica el tamaño del archivo
    if ($_FILES["imagen"]["size"] > 500000) { // Limitar a 500 KB
        echo "Lo siento, el archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Solo permite ciertos formatos de imagen
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verifica si se puede subir el archivo
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no ha sido subido.";
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_dir . basename($_FILES["imagen"]["name"]))) {
            // Guardar la información del producto en la base de datos
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $precio, $descripcion, $target_file]);
            echo "El producto ha sido subido exitosamente.";
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
   