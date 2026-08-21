<?php
session_start();
// si no existe usuario_id es que no se ha logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: panel/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagina Principal</title>
    <link rel="stylesheet" href="css/panel.css">
</head>
<body>
    <div class="panel">
        <div class="header">
            <h2>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></h2>
            <a href="panel/login.php?action=logout" class="btn-logout">Cerrar Sesión</a>
        </div>
        
        <p>Prueba de incio de Sesion.</p>
    </div>
</body>
</html>