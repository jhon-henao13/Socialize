<?php

include_once URL_APP . '/views/custom/header.php';

include_once URL_APP . '/views/custom/navbar.php';

// var_dump($datos['misNotificaciones']);

// echo $datos['misNotificaciones'];



?>


<div class="container mt-3">
    <meta charset="UTF-8">

    <div class="row">
        <!-- Columna perfil -->
        <div class="col-md-3">
            <div class="container-style-main">
                <div class="perfil-usuario-main">
                    <div class="background-usuario-main"></div>
                    <img src="<?php echo URL_PROJECT . '/' . $datos['perfil']->fotoPerfil ?>" alt="">
                    <div class="foto-separation"></div>

                    <?php if (isset($datos['usuario']) && isset($datos['usuario']->usuario)): ?>

                    <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>" class="links">
                    <?php else: ?>
                    <a href="#" class="links">Perfil no disponible</a>
                    <?php endif; ?>

                    <div class="text-center nombre-perfil"><?php echo $datos['perfil']->nombreCompleto ?></div></a>

                    <div class="tabla-estadisticas">
                        <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>">Seguidores<br> <?php echo $datos['totalSeguidores']; ?></a>
                        <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>">Publicaciones<br> <?php echo $datos['totalPublicaciones']; ?> </a>
                        <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>">Me gustas <br> <?php echo $datos['totalLikesRecibidos']; ?> </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Columna principal -->
        <div class="col-md-6">
            <div class="container-style-main2">
                <div class="container-usuario-publicar">
                    <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>"><img src="<?php echo URL_PROJECT . '/' . $datos['perfil']->fotoPerfil ?>" class="image-border "
                    alt=""></a>
                    <form action="<?php echo URL_PROJECT ?>/publicaciones/publicar/<?php echo $datos['usuario']->idusuario ?>" method="POST" enctype="multipart/form-data" class="form-publicar ml-2">
                        <textarea name="contenido" id="contenido" class="published mb-0" name="post" placeholder="Escribe aqui tu publicacion.." required></textarea>

                        <div class="image-upload-file">
                            <label for="imagen" class="custom-file-upload">
                                <img src="<?php echo URL_PROJECT ?>/img/image.png" alt="" class="image-public">
                                <span class="ml-l">Subir foto</span>
                            </label>
                            <input type="file" name="imagen" id="imagen" class="input-file-hidden">

                            <!-- VIDEO -->
                            <label for="video" class="custom-file-upload">
                                <img src="<?php echo URL_PROJECT ?>/img/video.png" alt="img-video" class="video-public">
                                <span class="ml-l">Subir video</span>
                            </label>
                            <input type="file" name="video" id="video" class="input-file-hidden">


                            <button class="btn-publi">Publicar</button>
                         </div>

                    </form>
                </div>

                <div class="reverb-publicaciones">

                <?php foreach ($datos['publicaciones'] as $datosPublicacion) : ?>
                    

                    <div class="container-usuarios-publicaciones">
                        <div class="usuarios-publicaciones-top">
                        <img src="<?php echo URL_PROJECT . '/' . $datosPublicacion->fotoPerfil ?>" alt="" class="image-border ">
                            <div class="informacion-usuario-publico">
                                <h6 class="mb-0"><a class="user-a" href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datosPublicacion->usuario ?>"><?php echo ucwords
                                ($datosPublicacion->usuario) ?></a></h6>
                                <span><?php echo $datosPublicacion->fechaPublicacion ?></span>

                                <?php if ($datos['usuario']->idusuario != $_SESSION['logueado']): ?>
                                    <div class="acciones-usuario-seguir mt-2">
                                        <a href="<?php echo URL_PROJECT ?>/perfil/seguir/<?php echo $datos['usuario']->usuario ?>" class="<?php echo $datos['estaSiguiendo'] ? 'seguir-active' : ''; ?>">
                                            <i class="fas fa-user-plus mr-1"></i>
                                            <span><?php echo $datos['estaSiguiendo'] ? 'Dejar de seguir' : 'Seguir'; ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                            </div>

                            <?php if($datosPublicacion->idusuario == $_SESSION['logueado'] ): ?>
                            <div class="acciones-publicacion-usuario">
                                <a href="<?php echo URL_PROJECT ?>/publicaciones/eliminar/<?php echo $datosPublicacion->idpublicacion ?>"><i class="far
                                fa-trash-alt"></i></a>
                            </div>
                            <?php endif ?>

                        </div>
                        <div class="contenido-publicacion-usuario">
                                <p class="mb-1" style="font-size: 1.3rem;" ><?php echo $datosPublicacion->contenidoPublicacion ?></p>
                                <img src="<?php echo URL_PROJECT . '/' . $datosPublicacion->fotoPublicacion ?>" alt="" class="imagen-publicacion-usuario">

                                
                                <?php if($datosPublicacion->videoPublicacion != 'sin video'): ?>
                                <video src="<?php echo URL_PROJECT . '/' . $datosPublicacion->videoPublicacion ?>" alt="" class="imagen-publicacion-usuario"></video>
                                <?php endif ?>

                                <?php if($datosPublicacion->videoPublicacion == 'sin video'): ?>
                                <video style="display: none;" src="" alt="" class="imagen-publicacion-usuario"></video>
                                <?php endif ?>
                                
                            </div>

                            <hr>

                            <div class="acciones-usuario-publicar mt-2">
                                <a href="<?php echo URL_PROJECT ?>/publicaciones/megusta/<?php echo $datosPublicacion->idpublicacion . '/' . $_SESSION['logueado'] . '/' 
                                . $datosPublicacion->idusuario?>" class="
                                            <?php foreach ($datos['misLikes'] as $misLikesUser) {
                                                if ($misLikesUser->idPublicacion == $datosPublicacion->idpublicacion) {
                                                    echo 'like-active';
                                                }
                                            } ?>
                                            "><i class="fas fa-heart mr-1"  id="fasHeart"></i><span><?php echo $datosPublicacion->num_likes ?></span></a>
                            </div>
                            <hr>
                            <div class="formulario-comentarios">
                                <img src="<?php echo URL_PROJECT . '/' . $datos['perfil']->fotoPerfil ?>" alt="" class="image-border">
                                <div class="acciones-formulario-comentario">
                                    <form action="<?php echo URL_PROJECT ?>/publicaciones/comentar" method="POST">
                                        <input type="hidden" name="iduserPropietario" value="<?php echo $datosPublicacion->idusuario ?>" >
                                        <input type="hidden" name="iduser" value="<?php echo $datos['usuario']->idusuario ?>">
                                        <input type="hidden" name="idpublicacion" value="<?php echo $datosPublicacion->idpublicacion ?>">
                                        <input type="text" name="comentario" class="form-comentario-usuario" placeholder="Escribe un comentario.." required>
                                        <div class="btn-comentario-container">
                                            <button class="btn-publi">Comentar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <?php foreach($datos['comentarios'] as $datosComentarios): ?>
                                <?php if ($datosComentarios->idPublicacion == $datosPublicacion->idpublicacion): ?>
                                    <div class="container-contenido-comentarios">
                                    <img src="<?php echo URL_PROJECT . '/' . $datosComentarios->fotoPerfil ?>" alt="" class="image-border">
                                    <div class="contenido-comentario-usuario">
                                        
                                        <div class="info-comentar-accion">
                                            <a class="black"  href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datosComentarios->usuario ?>" class="big mr-2"><?php echo 
                                            $datosComentarios->usuario ?></a>
                                            <span class="black"><?php echo $datosComentarios->fechaComentario ?></span>

                                            <?php if($datosComentarios->iduser == $_SESSION['logueado']):?>
                                                <div class="acciones-publicacion-usuario-comentario">
                                                    <a href="<?php echo URL_PROJECT ?>/publicaciones/eliminarComentario/<?php echo $datosComentarios->idcomentario?>"
                                                    class="float-right"><i class="far fa-trash-alt"></i></a>
                                                </div>
                                            <?php endif ?>
                                        </div>

                                        <p class="black" ><?php echo $datosComentarios->contenidoComentario ?></p>
                                    </div>
                                    </div>
                                <?php endif ?>    
                            <?php endforeach ?>

                        </div>
                <?php endforeach ?>

                </div>

            </div>
        </div>

    </div>
        <!-- Columna de eventos -->
        <div class="col-md-3">
            <div class="container-style-main" style="display: none;" >

            </div>            
        </div>
    </div>
</div>

<?php

include_once URL_APP . '/views/custom/footer.php';

?>