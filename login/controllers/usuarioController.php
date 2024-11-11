<?php
session_start();
include_once '../data/usuariobd.php';

$usuariobd = new UsuarioBD();

function redirigirConMensaje($url, $success, $mensaje)
{
    // Almacena el resultado en la sesión
    $_SESSION['success'] = $success;
    $_SESSION['message'] = $mensaje;

    // Realiza la redirección
    header("Location: $url");
    exit();

}

// Registro de usuario
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['registro'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $resultado = $usuariobd->registrarUsuario($email, $password);

    // Se asegura de que 'success' sea booleano
    $success = $resultado['success'] === "success" ? true : false;
    redirigirConMensaje('../index.php', $success, $resultado['message']);
}

// Inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $resultado = $usuariobd->inicioSesion($email, $password);

    // Configura la sesión solo si el inicio de sesión es exitoso
    if ($resultado['success'] === "success") {
        $_SESSION['success'] = true;
        $_SESSION['user_id'] = $resultado['id'];
    } else {
        $_SESSION['success'] = false;
    }

    // Redirige al usuario con el mensaje adecuado
    redirigirConMensaje('../index.php', $_SESSION['success'], $resultado['message']);
}


// Recuperación de contraseña
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['recuperar'])) {
    $email = $_POST['email'];

    $resultado = $usuariobd->recuperarPassword($email);

    // Asegura que 'success' se guarde como booleano
    $success = $resultado['success'] === "success" ? true : false;
    session_unset();
    session_destroy();
    redirigirConMensaje('../index.php', $success, $resultado['message']);

}
