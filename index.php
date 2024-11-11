<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondHand - Artículos en Venta</title>
    <link rel="stylesheet" href="css/index.css">
    <script>
        // Array de ejemplo de productos
        const peliculas = [
            { titulo: 'Bicicleta de montaña', precio: 150, descripcion: 'Bicicleta de montaña en excelente estado.', imagen: 'img/bici.jpg', enlace: 'producto1.html' },
            { titulo: 'Cámara fotográfica', precio: 300, descripcion: 'Cámara réflex digital con lente 18-55mm.', imagen: 'img/camara.jpg' },
            { titulo: 'Teléfono móvil', precio: 200, descripcion: 'Teléfono móvil nuevo con accesorios.', imagen: 'img/telefono.jpg' },
            { titulo: 'Patinete eléctrico', precio: 250, descripcion: 'Patinete eléctrico plegable, batería de larga duración.', imagen: 'img/patinete.jpg' },
            { titulo: 'Ordenador portátil', precio: 600, descripcion: 'Portátil con 16GB de RAM y 512GB de SSD, ideal para trabajo o estudio.', imagen: 'img/portatil.jpg' },
            { titulo: 'Auriculares Bluetooth', precio: 50, descripcion: 'Auriculares inalámbricos con cancelación de ruido.', imagen: 'img/auriculares.jpg' },
            { titulo: 'Consola de videojuegos', precio: 400, descripcion: 'Consola de última generación con dos mandos incluidos.', imagen: 'img/consola.jpg' },
            { titulo: 'Reloj inteligente', precio: 120, descripcion: 'Reloj inteligente con monitorización de frecuencia cardíaca.', imagen: 'img/reloj.jpg' },
            { titulo: 'Guitarra eléctrica', precio: 350, descripcion: 'Guitarra eléctrica Fender, perfecta para iniciarse en la música.', imagen: 'img/guitarra.jpg' },
            { titulo: 'Smart TV 4K', precio: 800, descripcion: 'Televisor 4K de 55 pulgadas con HDR y aplicaciones preinstaladas.', imagen: 'img/tv.jpg' }
        ];

        // Función de búsqueda
        function searchMovies(query) {
            const filteredMovies = peliculas.filter(movie =>
                movie.titulo.toLowerCase().includes(query.toLowerCase())
            );
            displayMovies(filteredMovies);
        }

        // Función para mostrar los productos filtrados
        function displayMovies(movies) {
            const container = document.querySelector('.product-container');
            container.innerHTML = ''; // Limpiar el contenedor antes de mostrar resultados

            if (movies.length === 0) {
                container.innerHTML = '<p>No se encontraron productos.</p>';
                return;
            }

            movies.forEach(movie => {
                const productCard = `
                    <div class="product-card">
                        <a href="${movie.enlace ? movie.enlace : '#'}" class="product-link">
                            <img src="${movie.imagen}" alt="${movie.titulo}" class="product-image">
                            <div class="product-info">
                                <h3 class="product-title">${movie.titulo}</h3>
                                <p class="product-price">€${movie.precio}</p>
                                <p class="product-description">${movie.descripcion}</p>
                            </div>
                        </a>
                    </div>`;
                container.innerHTML += productCard;
            });
        }

        // Escuchar el evento de entrada en el campo de búsqueda
        window.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('.search-input');
            searchInput.addEventListener('input', (e) => {
                searchMovies(e.target.value); // Llamar a la función de búsqueda en tiempo real
            });

            // Mostrar productos al cargar la página
            displayMovies(peliculas); // Mostrar todos los productos al inicio
        });
    </script>
</head>

<body>
    <div class="form-container">
        <!-- Barra de navegación -->
        <nav class="navbar">
            <div class="logo">SecondHand</div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
        </nav>

        <!-- Banner de búsqueda -->
        <div class="search-banner">
            <input type="text" class="search-input" placeholder="Buscar artículos...">
        </div>

        <!-- Sección de productos -->
        <div class="product-container">
            <!-- Aquí se mostrarán los productos filtrados por la búsqueda -->
        </div>

        <!-- Pie de página -->
        <footer class="footer">
            <p>&copy; 2024 SecondHand. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>
