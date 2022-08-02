<?php include_once __DIR__ . '/header_dash.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-atras">
        <a href="/proyectos" class="boton-atras">Volver</a>
    </div>
    <div class="contenedor-nueva-tarea">
        <button type="button" class="eliminar-proyecto" id="eliminar-proyecto">Eliminar Proyecto</button>
        <button type="button" class="agregar-tarea" id="agregar-tarea">
            Nueva Tarea &#43;
        </button>
    </div>


    <div class="filtros" id="filtros">
        <div class="filtros-inputs">
            <h2>Filtros: </h2>
            <div class="campo">
                <label for="todas">Todas</label>
                <input type="radio" id="todas" name="filtro" value="" checked>
            </div>

            <div class="campo">
                <label for="completas">Completas</label>
                <input type="radio" id="completas" name="filtro" value="1">
            </div>

            <div class="campo">
                <label for="pendientes">Pendientes</label>
                <input type="radio" id="pendientes" name="filtro" value="0">
            </div>
        </div>
    </div>
    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>

<?php include_once __DIR__ . '/footer_dash.php'; ?>

<?php 

$script = "
    <script src='/build/js/tareas.js'></script>
    <script src='/build/js/proyecto.js'></script>
    <script src='build/js/app.js'></script>
    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
";

?>