<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/perfil.css"> <!-- Vincula tu archivo CSS -->

</head>

<body>
    <div class="form-container">
        <!-- Barra de navegación -->
        <nav class="navbar">
            <div class="logo">Wallapop</div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
        </nav>

        <h2 class="profile-title">Mi Perfil</h2>

        <!-- Sección de productos subidos -->
        <div class="uploaded-products">
            <h3>Productos Subidos</h3>
            <div class="product-list">

                <?php
                require_once 'php/mostrar.php';
                require_once 'php/subir-productos.php';
                ?>

            </div>
        </div>

        <!-- Sección para subir nuevos productos -->
        <div class="upload-product">
            <h3>Subir Nuevo Producto</h3>
            <form class="upload-form" action="php/subir-productos.php" method="POST" enctype="multipart/form-data">
                <input type="text" class="input" name="nombre" placeholder="Nombre del producto" required>
                <input type="number" class="input" name="precio" placeholder="Precio" required>
                <textarea class="input" name="descripcion" placeholder="Descripción" required></textarea>
                <input type="file" class="input" name="imagen" accept="image/*" required>
                <button type="submit" class="form-btn">Subir Producto</button>
            </form>
        </div>





        <!-- Pie de página -->
        <footer class="footer">
            <p>&copy; 2024 Wallapop Clone. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>