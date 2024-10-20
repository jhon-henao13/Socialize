<?php

include_once URL_APP . '/views/custom/header.php';

include_once URL_APP . '/views/custom/navbar.php';

// var_dump($datos['notificaciones']);

?>

<div class="container-notificacion mt-2">
    <div class="container-notificaciones-usuario">
        <div class="contenido-notificaciones-usuario">
            <h3 class="text-center" >Tienes <?php echo $datos['misNotificaciones'] ?> Notificaciones</h3>
            <hr>
        </div>
        <div class="container-notificaciones-usuario-revisar">
            <?php foreach($datos['notificaciones'] as $datosNotificacion): ?>
                
                <a href="<?php echo URL_PROJECT ?>/notificaciones/eliminar/<?php echo $datosNotificacion->idnotificacion ?>" class="links"><div class="alert alert-success"><?php echo $datosNotificacion->usuario . ' ' . $datosNotificacion->mensajeNotificacion ?></div></a>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?php

include_once URL_APP . '/views/custom/footer.php';

?>