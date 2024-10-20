<?php

include_once URL_APP . '/views/custom/header.php';

include_once URL_APP . '/views/custom/navbar.php';

// var_dump($datos['notificaciones']);
?>

<div class="container-mensajes mt-3">
    <div class="container-notificaciones-usuario">
        <h6>Mensajes - DM</h6>
        <hr>
        <div class="row">
            <div class="col-md-6-mensajes-enviar">
                <p>Enviar mensaje</p>
                <form action="<?php echo URL_PROJECT ?>/mensajes" method="POST">
                <input type="hidden" name="idusermando" value="<?php echo $_SESSION['logueado'] ?>">
                    <div class="form-group">
                        <label for="enviar">Enviar a:</label>
                        <select name="enviar" id="enviar" class="form-control" required>
                            <option value="">Usuarios</option>
                            <?php foreach ($datos['usuarios'] as $allUsuarios) : ?>
                                <option value="<?php echo $allUsuarios->idusuario ?>"><?php echo $allUsuarios->usuario ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje:</label>
                        <textarea name="mensaje" id="mensaje" rows="5" class="form-control" required></textarea>
                    </div>
                    <button class="btn-green btn-block">Enviar</button>
                </form>
            </div>
            <div class="col-md-6-mensajes-recibidos">
                <p>Mensajes recibidos</p>
                <hr>
                <?php foreach ($datos['misMensajes'] as $datosMensajes) : ?>
                    <div class="container-contenido-comentarios">
                        <img src="<?php echo URL_PROJECT . '/' . $datosMensajes->fotoPerfil ?>" alt="" class="image-border">
                        <div class="contenido-comentario-usuario">

                            
                            
                            <div class="info-comentar-accion">

                                <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datosMensajes->usuario ?>" class="black"><?php echo $datosMensajes->usuario ?></a>

                                <div class="acciones-publicacion-usuario">
                                    <a href="<?php echo URL_PROJECT ?>/mensajes/eliminarMensaje/<?php echo $datosMensajes->idmensaje ?>" class="float-right"><i class="far 
                                    fa-trash-alt"></i></a>
                                </div>

                            </div>

                            <p class="black"><?php echo $datosMensajes->contenido ?></p>

                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<?php

include_once URL_APP . '/views/custom/footer.php';

?>