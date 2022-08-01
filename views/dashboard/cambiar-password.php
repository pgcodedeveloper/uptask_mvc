<?php include_once __DIR__ . '/header_dash.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver al Perfil</a>

    <form action="/cambiar-password" class="formulario" method="POST">
        <div class="campo">
            <label for="password-actual">Password Actual</label>
            <input type="password" id="password-actual" name="password_actual" placeholder="Tu Password Actual">
        </div>

        <div class="campo">
            <label for="password">Password Nuevo</label>
            <input type="password" id="password" name="password_nuevo" placeholder="Repetir Password">
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer_dash.php'; ?>