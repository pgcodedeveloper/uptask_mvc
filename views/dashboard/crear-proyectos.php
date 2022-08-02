<?php include_once __DIR__ . '/header_dash.php'; ?>

<div class="contenedor-atras">
    <a href="/proyectos" class="boton-atras">Volver</a>
</div>
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form action="/crear-proyecto" class="formulario" method="POST">
        
        <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
        <input type="submit" value="Crear Proyecto">
    </form>
</div>

<?php include_once __DIR__ . '/footer_dash.php'; ?>