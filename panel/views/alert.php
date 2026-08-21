<?php if (isset($alerta)): ?>
    <div class="alert alert-<?php echo $alerta['tipo']; ?>">
        <?php echo $alerta['mensaje']; ?>
    </div>
<?php endif; ?>
