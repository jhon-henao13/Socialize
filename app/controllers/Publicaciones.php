<?php

class Publicaciones extends Controller
{
    public function __construct()
    {
        $this->publicar = $this->model('publicar');
    }

    public function publicar($idUsuario)
    {
        $carpeta = 'C:/xampp/htdocs/red-social/public/img/imagenesPublicaciones/';
        $carpetaVideo = 'C:/xampp/htdocs/red-social/public/img/videosPublicaciones/';


        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            opendir($carpeta);
            $rutaImagen = 'img/imagenesPublicaciones/' . $_FILES['imagen']['name'];
            $ruta = $carpeta . $_FILES['imagen']['name'];
            copy($_FILES['imagen']['tmp_name'], $ruta);
        } else {
            // Si no hay imagen, asignar una ruta o indicador adecuado
            $rutaImagen = 'sin imagen';  // Aquí podrías usar una ruta de imagen por defecto o texto para indicar que no hay imagen
        }


        if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
            opendir($carpetaVideo);
            $rutaVideo = 'img/videosPublicaciones/' . $_FILES['video']['name'];
            $ruta2 = $carpetaVideo . $_FILES['video']['name'];
            copy($_FILES['video']['tmp_name'], $ruta2);
        } else {
            $rutaVideo = 'sin video';
        }


        

    
        $datos = [
            'iduser' => trim($idUsuario),
            'contenido' => trim($_POST['contenido']),
            'foto' => $rutaImagen,
            'video' => $rutaVideo
        ];
    
        if ($this->publicar->publicar($datos)) {
            redirection('/home');
        } else {
            echo 'algo ocurrio';
        }
    }
    


    public function eliminar($idpublicacion)
    {

        $publicacion = $this->publicar->getPublicacion($idpublicacion);

        

        if ($this->publicar->eliminarPublicacion($publicacion)) {
            unlink('C:/xampp/htdocs/red-social/public/' . $publicacion->fotoPublicacion);
            redirection('/home');
        } else {

        }
    }

    public function megusta($idpublicacion , $idusuario , $idusuarioPropietario)
    {
        $datos = [
            'idpublicacion' => $idpublicacion,
            'idusuario' => $idusuario,
            'idusuarioPropietario' => $idusuarioPropietario

        ];

        $datosPublicacion = $this->publicar->getPublicacion($idpublicacion);

        if ($this->publicar->rowLikes($datos)) {
            if ($this->publicar->eliminarLike($datos)) {
                $this->publicar->deleteLikeCount($datosPublicacion);
            }
            redirection('/home');
        } else {
            if ($this->publicar->agregarLike($datos)) {
                $this->publicar->addLikeCount($datosPublicacion);
                $this->publicar->addNotificacionLike($datos);
            }
            redirection('/home');
        }
    }

    public function comentar() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'iduserPropietario' => trim($_POST['iduserPropietario']),
                'iduser' => trim($_POST['iduser']),
                'idpublicacion' => trim($_POST['idpublicacion']),
                'comentario' => trim($_POST['comentario']),
            ];

            if ($this->publicar->publicarComentario($datos)) {
                $this->publicar->addNotificacionComentario($datos);
                redirection('/home');
            } else {
                redirection('/home');
            }
        } else {
            redirection('/home');
        }
    }






    








    public function eliminarComentario($id)
    {
        if ($this->publicar->eliminarComentarioUsuario($id)) {
            redirection('/home');
        } else {
            redirection('/home');
        }
    }
}


