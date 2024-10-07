<?php
require_once 'php/eliminar.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Productos</title>
    <link rel="stylesheet" href="css/producto.css"> <!-- Cambia la ruta según la ubicación de tu CSS -->
</head>

<body>
    <!-- Mostrar los productos -->
    <?php if (!empty($productos)): ?>
        <ul>
            <?php foreach ($productos as $producto): ?>
                <li>
                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <p>Precio: <?php echo htmlspecialchars($producto['precio']); ?>€</p>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="100">

                    <!-- Formulario para eliminar el producto -->
                    <form method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                        <input type="hidden" name="delete_id" value="<?php echo $producto['id']; ?>">
                        <button type="submit">🗑️ Eliminar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay productos para mostrar.</p>
        <a href="perfil.php">Volver</a>
    <?php endif; ?>
</body>

</html>
