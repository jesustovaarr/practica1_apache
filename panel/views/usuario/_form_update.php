<div class="contenedor-login" style="margin: 0 auto; margin-top: 20px;">
    <h2 style="text-align:center; margin-bottom: 20px;">Editar Usuario</h2>
    
    <form action="usuario.php?action=update&id=<?php echo $data['id']; ?>" method="POST">
        <div class="form-group mb-3">
            <label for="nombre" class="form-label">Nombre Completo:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $data['nombre'] ?? ''; ?>" required maxlength="200">
        </div>
        <div class="form-group mb-3">
            <label for="correo" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" name="correo" id="correo" value="<?php echo $data['correo'] ?? ''; ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="contrasena" class="form-label">Nueva Contraseña:</label>
            <input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Dejar en blanco para conservar" minlength="6">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" id="enviar" name="enviar" value="Actualizar Usuario" style="background:#ffc107; color:black; border:none;">
        </div>
        <a href="usuario.php" class="btn-logout" style="display:block; text-align:center; padding:10px;">Cancelar</a>
    </form>
</div>
