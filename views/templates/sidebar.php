<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>UpTask</h2>
        
        <div class="cerrar-menu">
            <img src="build/img/cerrar.webp" id="cerrar-menu" alt="imagen cerrar menu">
        </div>
    </div>
    

    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>" href="/proyectos">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear Proyectos') ? 'activo' : ''; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <button class="cerrar-sesion">Cerrar Sesión</button>
    </div>
</aside>