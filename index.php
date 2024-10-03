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
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="inicio-sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Imagen rectangular -->
        <div class="banner-image">
            <img src="img/oferta.jpg" alt="Banner" class="banner-img">
        </div>

        <!-- Banner de búsqueda -->
        <div class="search-banner">
            <input type="text" class="search-input" placeholder="Buscar artículos...">
            <button class="search-btn">Buscar</button>
        </div>

        <!-- Sección de artículos -->
        <div class="product-container">
            <div class="product-card">
                <img src="img/1.jpg" alt="Artículo 1" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Tensiometro</h3>
                    <p class="product-price">€10</p>
                    <p class="product-description">Descripción del artículo 1.</p>
                </div>
            </div>
            <div class="product-card">
                <img src="img/product2.jpg" alt="Artículo 2" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Artículo 2</h3>
                    <p class="product-price">€20</p>
                    <p class="product-description">Descripción del artículo 2.</p>
                </div>
            </div>
            <div class="product-card">
                <img src="img/product3.jpg" alt="Artículo 3" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">Artículo 3</h3>
                    <p class="product-price">€30</p>
                    <p class="product-description">Descripción del artículo 3.</p>
                </div>
            </div>
            <!-- Añade más productos según sea necesario -->
        </div>

        <!-- Pie de página -->
        <footer class="footer">
            <p>&copy; 2024 Wallapop Clone. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>
