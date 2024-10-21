<?php
session_start(); // Asegúrate de iniciar la sesión aquí
require_once 'conexion.php';


// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Validar datos
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
        header("Location: ../index.php"); // Redirigir al perfil del usuario
        exit;
    } else {
        // Credenciales inválidas
        $_SESSION['error'] = 'Email o contraseña incorrectos'; // Establecer mensaje de error en la sesión
        header("Location: ../inicio-sesion.php"); // Redirigir de nuevo a la página de inicio de sesión
        exit;
    }
}

