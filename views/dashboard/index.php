<?php include_once __DIR__ . '/header_dash.php'; ?>

<?php if(count($proyectos) === 0){ ?>
    <p class="no-proyecto">No Hay Proyectos Aún</p>
<?php } else {?>
    <ul class="listado-proyectos">
        <?php foreach($proyectos as $proyecto){ ?>
            <li class="proyecto">
                <a href="/proyecto?url=<?php echo $proyecto->url; ?>">
                    <?php echo $proyecto->proyecto; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<?php include_once __DIR__ . '/footer_dash.php'; ?>
