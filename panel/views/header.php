<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Principal</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>
    <div class="panel">
        <div class="header">
            <h2>Bienvenido <?php echo $_SESSION['usuario_nombre'] ?? ''; ?>!</h2>
            <a href="login.php?action=logout" class="btn-logout">Cerrar Sesión</a>
        </div>
