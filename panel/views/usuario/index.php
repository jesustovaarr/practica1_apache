<div class="header-crud">
    <h3>Administración de Usuarios</h3>
    <a href="usuario.php?action=create" class="btn-nuevo">Nuevo Usuario</a>
</div>

<div style="overflow-x: auto;">
    <table class="tabla-crud">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $u): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo $u['nombre']; ?></td>
                    <td><?php echo $u['correo']; ?></td>
                    <td><?php echo $u['fecha_registro']; ?></td>
                    <td class="actions" style="white-space: nowrap;">
                        <a href="usuario.php?action=update&id=<?php echo $u['id']; ?>" class="btn-edit">Editar</a>
                        <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                            <a href="usuario.php?action=delete&id=<?php echo $u['id']; ?>" class="btn-delete" onclick="return confirm('¿Seguro que deseas eliminar a <?php echo $u['nombre']; ?>?');">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
