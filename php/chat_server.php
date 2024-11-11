<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$chatFile = __DIR__ . '/mensajes.txt';

// Asegurarse de que el archivo de chat existe
if (!file_exists($chatFile)) {
    file_put_contents($chatFile, "");
}

// Función para registrar mensajes de depuración
function debug_log($message) {
    file_put_contents(__DIR__ . '/debug.log', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar nuevos mensajes
    $message = trim($_POST['message'] ?? ''); // Eliminar espacios en blanco
    if (!empty($message)) {
        $username = $_SESSION['username'] ?? 'Comprador';
        $newMessage = date('Y-m-d H:i:s') . " - $username: " . htmlspecialchars($message) . "\n";
        $result = file_put_contents($chatFile, $newMessage, FILE_APPEND | LOCK_EX); // Bloqueo de archivo para evitar colisiones
        if ($result === false) {
            debug_log("Error al escribir en el archivo: $chatFile");
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo guardar el mensaje']);
        } else {
            echo json_encode(['success' => true]);
        }
    } else {
        debug_log("Intento de enviar mensaje vacío");
        http_response_code(400);
        echo json_encode(['error' => 'El mensaje está vacío']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Long polling para obtener nuevos mensajes
    $lastModified = isset($_GET['timestamp']) ? (int)$_GET['timestamp'] : 0;
    $currentModified = filemtime($chatFile);

    // Esperar hasta que haya nuevos mensajes o hasta que pasen 30 segundos
    $timeout = 5; // Aumentar el timeout para reducir el número de peticiones
    $start = time();
    while ($currentModified <= $lastModified) {
        usleep(100000); // Esperar 0.1 segundos
        clearstatcache();
        $currentModified = filemtime($chatFile);
        if ((time() - $start) > $timeout) {
            break;
        }
    }

    // Enviar nuevos mensajes si el archivo fue modificado
    if ($currentModified > $lastModified) {
        $messages = file_get_contents($chatFile);
        echo json_encode([
            'messages' => $messages,
            'timestamp' => $currentModified
        ]);
    } else {
        // No hay nuevos mensajes dentro del timeout
        http_response_code(204); // Sin contenido
        echo json_encode(['timestamp' => $currentModified]);
    }
}
