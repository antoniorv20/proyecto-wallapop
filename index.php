<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallapop - Artículos en Venta</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="form-container">
        <!-- Barra de navegación -->
        <nav class="navbar">
            <div class="logo">Wallapop</div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="inicio-sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Banner de búsqueda -->
        <div class="search-banner">
            <form action="" method="GET"> 
                <input type="text" class="search-input" name="query" placeholder="Buscar artículos..." required>
                <button type="submit" class="search-btn">Buscar</button>
            </form>
        </div>

        <!-- Sección de artículos -->
        <div class="product-container">
            <?php
            require_once 'php/conexion.php';

            // Obtener el término de búsqueda
            $query = isset($_GET['query']) ? trim($_GET['query']) : '';

            // Consultar productos en la base de datos
            if ($query) {
                $stmt = $pdo->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?");
                $searchTerm = "%" . $query . "%"; // Busca coincidencias en nombre y descripción
                $stmt->execute([$searchTerm, $searchTerm]);

                // Mostrar productos encontrados
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="product-card">';
                    echo '<img src="' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" class="product-image">';
                    echo '<div class="product-info">';
                    echo '<h3 class="product-title">' . htmlspecialchars($row['nombre']) . '</h3>';
                    echo '<p class="product-price">€' . htmlspecialchars($row['precio']) . '</p>';
                    echo '<p class="product-description">' . htmlspecialchars($row['descripcion']) . '</p>';
                    echo '</div></div>'; // Cierra divs de producto
                }

                // Si no hay resultados, mostrar productos de ejemplo
                if ($stmt->rowCount() == 0) {
                    mostrarProductosEjemplo();
                }
            } else {
                // Mostrar productos de ejemplo cuando no hay búsqueda
                mostrarProductosEjemplo();
            }

            function mostrarProductosEjemplo() {
                $productosEjemplo = [
                    [
                        'nombre' => 'Bicicleta de montaña',
                        'precio' => 150.00,
                        'descripcion' => 'Bicicleta de montaña en excelente estado, ideal para senderismo.',
                        'imagen' => 'img/bici.jpg',
                        'enlace' => 'producto1.html' 

                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                    [
                        'nombre' => 'Cámara fotográfica',
                        'precio' => 300.00,
                        'descripcion' => 'Cámara réflex digital con lente 18-55mm. Muy poco uso.',
                        'imagen' => 'img/camara.jpg',
                        'enlace' => 'producto1.html'
                    ],
                ];


                    foreach ($productosEjemplo as $producto) {
                        echo '<div class="product-card">';
                        echo '<a href="' . htmlspecialchars($producto['enlace']) . '" class="product-link">'; // Enlace a la página de detalles
                        echo '<img src="' . htmlspecialchars($producto['imagen']) . '" alt="' . htmlspecialchars($producto['nombre']) . '" class="product-image">';
                        echo '<div class="product-info">';
                        echo '<h3 class="product-title">' . htmlspecialchars($producto['nombre']) . '</h3>';
                        echo '<p class="product-price">€' . htmlspecialchars($producto['precio']) . '</p>';
                        echo '<p class="product-description">' . htmlspecialchars($producto['descripcion']) . '</p>';
                        echo '</div></a>'; // Cierra el enlace y la tarjeta del producto
                        echo '</div>'; // Cierra divs de producto
                    }
                }
            


           
            ?>
        </div>

        <!-- Pie de página -->
        <footer class="footer">
            <p>&copy; 2024 Wallapop Clone. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>
