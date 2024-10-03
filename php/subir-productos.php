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
    echo "Formulario enviado. <br>"; // Agrega esta línea para verificar

    // Recoger y sanitizar datos
    $nombre = trim($_POST['nombre']);
    $precio = trim($_POST['precio']);
    $descripcion = trim($_POST['descripcion']);

    // Validar datos
    if (empty($nombre) || empty($precio) || empty($descripcion)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    // Validar y sanitizar el precio
    if (!is_numeric($precio) || $precio <= 0) {
        echo "El precio debe ser un número positivo.";
        exit;
    }

    // Manejar la carga de la imagen del producto
    $imagen = 'default.jpg'; // Ruta por defecto
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen = 'img/' . basename($_FILES['imagen']['name']);
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            echo "Imagen subida exitosamente. <br>"; // Agrega esta línea para verificar
        } else {
            echo "Error al subir la imagen. <br>"; // Agrega esta línea para verificar
        }
    }

    // Insertar el nuevo producto en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $descripcion, $imagen]);

        echo "Producto creado exitosamente. Puedes <a href='../perfil.php'>ver tu perfil aquí</a>.";
    } catch (PDOException $e) {
        echo "Error al crear el producto: " . $e->getMessage();
    }
}
?>

<!-- Asegúrate de tener un formulario adecuado para enviar los datos -->
<form method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>
    
    <label for="precio">Precio:</label>
    <input type="text" name="precio" id="precio" required>
    
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" required></textarea>
    
    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen" id="imagen" accept="image/*">

    <input type="submit" value="Crear Artículo">
</form>
