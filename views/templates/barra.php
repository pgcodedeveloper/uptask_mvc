<div class="barra-mobile">
    <h1>UpTask</h1>

    <div class="menu">
        <img src="build/img/menu-mobile.webp" id="mobile-menu" alt="imagen menu">
    </div>
</div>

<div class="barra">
    <p>Hola: <span><?php echo $_SESSION['nombre']; ?></span></p>
    <button href class="cerrar-sesion">Cerrar Sesión</button>
</div>

<?php
    $script="
    <script src='build/js/app.js'></script>
    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    ";
?>