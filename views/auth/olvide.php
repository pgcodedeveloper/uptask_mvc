<div class="contenedor olvide">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Restablecer tu Acceso a UpTask</p>
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <form action="/olvide" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu E-Mail" name="email">
            </div>
            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Obtén una</a>
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
        </div>
    </div>
</div>