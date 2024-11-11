<?php
session_start(); // Iniciar sesión
require_once 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Limpiar el email
    $contraseña = trim($_POST['contraseña']); // Limpiar la contraseña

    // Validar campos vacíos
    if (empty($email) || empty($contraseña)) {
        $_SESSION['error'] = 'Por favor completa todos los campos.';
        header("Location: ../inicio-sesion.php");
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
        header("Location: ../index.php"); // Redirigir a la página de inicio
        exit;
    } else {
        // Verificar si el email existe pero la contraseña es incorrecta
        if ($usuario) {
            $_SESSION['error'] = 'Contraseña incorrecta.'; // Contraseña incorrecta
        } else {
            $_SESSION['error'] = 'No existe ninguna cuenta registrada con este email.'; // Email no registrado
        }
        header("Location: ../inicio-sesion.php");
        exit;
    }
}
