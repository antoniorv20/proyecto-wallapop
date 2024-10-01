<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/registro-usuario.css"> <!-- Vincula tu archivo CSS -->
</head>

<body>
    <div class="form-container">
        <p class="title">Nuevo Registro</p>
        <form class="form" action="php/registrar.php" method="POST" enctype="multipart/form-data">
            <input type="text" class="input" name="nombre" placeholder="Nombre" required>
            <input type="text" class="input" name="apellido" placeholder="Apellido" required>
            <input type="email" class="input" name="email" placeholder="Email" required>
            <input type="password" class="input" name="contraseña" placeholder="Contraseña" required>
            <div class="form-group">
                <label for="foto_perfil">Foto de Perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">
            </div>
            <button type="submit" class="form-btn">Registrar</button>
        </form>
        <p class="redirect">¿Ya tienes una cuenta? <a href="inicio-sesion.php">Inicia sesión aquí</a></p>
    </div>
</body>

</html>
