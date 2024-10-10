<?php
// Conexión a la base de datos
$host = 'localhost';
$db = 'tiendap';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

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

    try {
        $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$nombre, $precio, $descripcion, $id]);

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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre']); ?></title>
    <link rel="stylesheet" href="css/producto.css"> <!-- Vincula tu archivo CSS -->
    <style>
        .edit-form {
            display: none; /* Oculto inicialmente */
            margin-top: 20px;
        }
        .edit-icon {
            cursor: pointer;
            font-size: 24px;
            color: #4CAF50;
        }
    </style>
    <script>
        function toggleEditForm() {
            var form = document.getElementById('edit-form');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="producto-container">
        <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
        <p>Precio: €<?php echo htmlspecialchars($producto['precio']); ?></p>
        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="300">

        <!-- Ícono del lápiz para abrir el formulario de edición -->
        <span class="edit-icon" onclick="toggleEditForm()">&#9998; Editar</span>

        <!-- Formulario para editar el producto, oculto inicialmente -->
        <div class="edit-form" id="edit-form">
            <h3>Editar Producto</h3>
            <form method="POST" action="">
                <input type="hidden" name="edit_id" value="<?php echo $producto['id']; ?>">
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                <input type="number" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                <input type="submit" value="Actualizar Producto">
            </form>
        </div>

        <!-- Formulario para eliminar el producto -->
        <div class="delete-form">
            <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                <input type="hidden" name="delete_id" value="<?php echo $producto['id']; ?>">
                <button type="submit">🗑️ Eliminar Producto</button>
            </form>
        </div>

        <a href="perfil.php">Volver a Perfil</a>
    </div>
</body>
</html>

<?php
    else:
        echo "Producto no encontrado.";
    endif;
} else {
    echo "ID de producto no especificado.";
}
?>
