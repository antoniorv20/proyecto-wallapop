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
            <form action="" method="GET"> <!-- Cambia la acción a la misma página -->
                <input type="text" class="search-input" name="query" placeholder="Buscar artículos..." required>
                <button type="submit" class="search-btn">Buscar</button>
            </form>
        </div>

        <!-- Sección de artículos -->
        <div class="product-container">
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

            // Obtener el término de búsqueda
            $query = isset($_GET['query']) ? trim($_GET['query']) : '';

            // Consultar productos en la base de datos
            if ($query) {
                $stmt = $pdo->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?");
                $searchTerm = "%" . $query . "%"; // Busca coincidencias en nombre y descripción
                $stmt->execute([$searchTerm, $searchTerm]);
            } else {
                $stmt = $pdo->query("SELECT * FROM productos");
            }

            // Mostrar productos
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="product-card">';
                echo '<img src="' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" class="product-image">';
                echo '<div class="product-info">';
                echo '<h3 class="product-title">' . htmlspecialchars($row['nombre']) . '</h3>';
                echo '<p class="product-price">€' . htmlspecialchars($row['precio']) . '</p>';
                echo '<p class="product-description">' . htmlspecialchars($row['descripcion']) . '</p>';
                echo '</div></div>'; // Cierra divs de producto
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
