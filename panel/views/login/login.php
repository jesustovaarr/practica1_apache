<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="contenedor-login">
        <h2>Iniciar Sesión</h2>
        
        <!-- mostrar error -->
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php?action=login" method="POST">
            <div class="form">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" required placeholder="nombre@correo.com">
            </div>
            <div class="form">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required placeholder="********">
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>
    </div>
</body>
</html>
