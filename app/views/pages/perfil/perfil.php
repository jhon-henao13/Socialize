<?php



include_once URL_APP . '/views/custom/header.php';
include_once URL_APP . '/views/custom/navbar.php';
?>

<div class="perfil-container-usuario">
    <div class="imagen-header-perfil-usuario">
        <img src="<?php echo URL_PROJECT ?>/img/imagenesPerfil/imagenes-portada-perfil/cover-img.jpg" class="imagen-portada-perfil" alt="">        
    </div>
    <div class="container-header-usuario">
        <div class="container">
            <div class="row">
                <div class="col-md-4-perfil">
                    <div class="datos-perfil-usuario">
                        <?php if (isset($datos['perfil']) && !empty($datos['perfil']->fotoPerfil)) : ?>
                            

                            <div class="container-foto-usuario-perfil-cambiar">

                                <?php if (isset($datos['usuario']) && $datos['usuario']->idusuario == $_SESSION['logueado']) : ?>
                                    <div class="camara-cambiar">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                <?php endif; ?>

                                    
                                <img src="<?php echo URL_PROJECT . '/' . $datos['perfil']->fotoPerfil ?>" class="imagen-perfil-usuario" alt="">
                            </div>


                        <?php else : ?>
                            <img src="<?php echo URL_PROJECT ?>/img/default-profile.png" class="imagen-perfil-usuario" alt="Default Profile">
                        <?php endif; ?>

                        <?php if (isset($datos['usuario']) && $datos['usuario']->idusuario == $_SESSION['logueado']) : ?>
                            <div class="imagen-perfil-cambiar">
                                <form action="<?php echo URL_PROJECT ?>/perfil/cambiarImagen" method="POST" enctype="multipart/form-data">


                                    
                                    <div class="input-file">
                                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['logueado']; ?>">
                                        <input class="input-cambiar-foto" type="file" name="imagen" id="imagen">
                                    </div>
                                    <div class="editar-perfil">
                                        <button class="btn-change-image" type="submit">Editar</button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>

                        <div class="datos-personales-usuario">
                            <?php if (isset($datos['usuario']) && $datos['usuario']): ?>
                                <h3><?php echo ucwords($datos['usuario']->usuario) ?></h3>
                            <?php else : ?>
                                <h3>Usuario no encontrado</h3>
                            <?php endif; ?>
                            <div class="descripcion-usuario">
                                <?php if (isset($datos['perfil']->nombreCompleto)) : ?>
                                    <span style="font-size: 30px;"><?php echo $datos['perfil']->nombreCompleto ?></span>
                                <?php else : ?>
                                    <span>Nombre no disponible</span>
                                <?php endif; ?>




                                <?php if ($datos['usuario']->idusuario != $_SESSION['logueado']): ?>
                                    <div class="acciones-usuario-seguir mt-2">
                                        <a href="<?php echo URL_PROJECT ?>/perfil/seguir/<?php echo $datos['usuario']->usuario ?>" class="<?php echo $datos['estaSiguiendo'] ? 'seguir-active' : ''; ?>">
                                            <i class="fas fa-user-plus mr-1"></i>
                                            <span><?php echo $datos['estaSiguiendo'] ? 'Dejar de seguir' : 'Seguir'; ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="estadisticas-usuario">
                                    <span>Seguidores: <?php echo $datos['totalSeguidores']->totalSeguidores; ?></span>
                                    <hr width="90%">
                                    <span>Siguiendo: <?php echo $datos['totalSiguiendo']->totalSiguiendo; ?></span>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6-perfil">
                    <div class="container-principal-informacion-usuario">
                        <div class="container-style-main-perfil">
                            <?php if (isset($datos['usuario']) && $datos['usuario']->idusuario == $_SESSION['logueado']) : ?>
                                <div class="container-usuario-publicar">
                                    <a href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datos['usuario']->usuario ?>">
                                        <?php if (isset($datos['perfil']->fotoPerfil)) : ?>
                                            <img src="<?php echo URL_PROJECT . '/' . $datos['perfil']->fotoPerfil ?>" class="image-border" alt="">
                                        <?php else : ?>
                                            <img src="<?php echo URL_PROJECT ?>/img/default-profile.png" class="image-border" alt="Default Profile">
                                        <?php endif; ?>
                                    </a>
                                    <form action="<?php echo URL_PROJECT ?>/publicaciones/publicar/<?php echo $_SESSION['logueado']; ?>" class="form-publicar ml-2" method="POST" enctype="multipart/form-data">
                                        <textarea name="contenido" id="" class="published mb-0" placeholder="Escribe aquí tu publicación..." required></textarea>
                                        <div class="image-upload-file">
                                            <div class="upload-photo">
                                                <img src="<?php echo URL_PROJECT ?>/img/image.png" alt="" class="image-public">
                                                <div class="input-file">
                                                    <input type="file" name="imagen" id="imagen">
                                                </div>
                                                <span class="ml-l">Subir foto</span>
                                            </div>


                                            <!-- VIDEO -->
                                            <label for="video" class="custom-file-upload">
                                            <img src="<?php echo URL_PROJECT ?>/img/video.png" alt="img-video" class="video-public">
                                                <span class="ml-l">Subir video</span>
                                            </label>
                                            <input type="file" name="video" id="video" class="input-file-hidden">


                                            <button class="btn-publi" type="submit">Publicar</button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>



                            <div class="reverb-publicaciones">

                           


                            <?php foreach ($datos['publicaciones'] as $datosPublicacion) : ?>
                    

                            <div class="container-usuarios-publicaciones">


                                <div class="usuarios-publicaciones-top">
                                    <img src="<?php echo URL_PROJECT . '/' . $datosPublicacion->fotoPerfil ?>" alt="" class="image-border">
                                    <div class="informacion-usuario-publico">
                                        <h6 class="mb-0"><a class="user-a" href="<?php echo URL_PROJECT ?>/perfil/<?php echo $datosPublicacion->usuario ?>"><?php echo ucwords($datosPublicacion->usuario) ?></a></h6>
                                        <span><?php echo $datosPublicacion->fechaPublicacion ?></span>
                                    </div>

                                    <?php if($datosPublicacion->idusuario == $_SESSION['logueado']): ?>
                                        <div class="acciones-publicacion-usuario">
                                            <a href="<?php echo URL_PROJECT ?>/publicaciones/eliminar/<?php echo $datosPublicacion->idpublicacion ?>"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                    <?php endif ?>
                                </div>


                                <div class="contenido-publicacion-usuario-perfil">
                                        <p class="mb-1" style="font-size: 1.3rem;" ><?php echo $datosPublicacion->contenidoPublicacion ?></p>
                                        <img src="<?php echo URL_PROJECT . '/' . $datosPublicacion->fotoPublicacion ?>" alt="" class="imagen-publicacion-usuario-perfil">



                                        <?php if($datosPublicacion->videoPublicacion != 'sin video'): ?>
                                            <video src="<?php echo URL_PROJECT . '/' . $datosPublicacion->videoPublicacion ?>" alt="" class="imagen-publicacion-usuario"></video>
                                        <?php endif ?>

                                        <?php if($datosPublicacion->videoPublicacion == 'sin video'): ?>
                                            <video style="display: none;" src="" alt="" class="imagen-publicacion-usuario"></video>
                                        <?php endif ?>

                                    </div>

                                    <hr>

                                <div class="acciones-usuario-publicar mt-2">
                                    <a href="<?php echo URL_PROJECT ?>/perfil/megusta/<?php echo $datosPublicacion->idpublicacion . '/' . $_SESSION['logueado'] . '/' 
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
                            <?php endforeach; ?>

                        </div>
                <?php endforeach ?>
                

                </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="container-usuario-contact">
                        <a href="<?php echo URL_PROJECT ?>/mensajes" class="btn-message">
                            <span class="big"><i class="far fa-envelope"></i></span>Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include_once URL_APP . '/views/custom/footer.php';

?>



