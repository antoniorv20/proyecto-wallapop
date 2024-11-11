<?php
require_once 'conexion.php';



// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Validar datos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($contraseña)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    // Hashear la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Manejar la carga de la foto de perfil
    $foto_perfil = 'default.jpg'; // Ruta por defecto
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == UPLOAD_ERR_OK) {
        $foto_perfil = 'fotos/' . basename($_FILES['foto_perfil']['name']);
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
    }

    // Insertar el nuevo usuario en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, contraseña, foto_perfil) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $email, $contraseña_hash, $foto_perfil]);

        echo "Registro exitoso. Puedes <a href='inicio-sesion.php'>iniciar sesión aquí</a>.";
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }
}
?>
