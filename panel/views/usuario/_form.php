<div class="contenedor-login" style="margin: 0 auto; margin-top: 20px;">
    <h2 style="text-align:center; margin-bottom: 20px;">Crear Nuevo Usuario</h2>
    
    <form action="usuario.php?action=create" method="POST">
        <div class="form-group mb-3">
            <label for="nombre" class="form-label">Nombre Completo:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" required maxlength="200">
        </div>
        <div class="form-group mb-3">
            <label for="correo" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" name="correo" id="correo" required>
        </div>
        <div class="form-group mb-3">
            <label for="contrasena" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena" id="contrasena" required minlength="6">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" id="enviar" name="enviar" value="Guardar Usuario">
        </div>
        <a href="usuario.php" class="btn-logout" style="display:block; text-align:center; padding:10px;">Cancelar</a>
    </form>
</div>
