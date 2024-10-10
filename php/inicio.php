<?php
require_once 'conexion.php';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Validar datos
    if (empty($email) || empty($contraseña)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    // Consultar el usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        // Autenticación exitosa
        $_SESSION['usuario_id'] = $usuario['id']; // Guardar ID del usuario en la sesión
        $_SESSION['usuario_nombre'] = $usuario['nombre']; // Guardar nombre del usuario
        header("Location: perfil.php"); // Redirigir al perfil del usuario
        exit;
    } else {
        // Usuario no encontrado o contraseña incorrecta
        echo "Email o contraseña incorrectos.";
    }
}
?>
