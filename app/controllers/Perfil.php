<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


class Perfil extends Controller
{
    public function __construct()
    {
        $this->perfil = $this->model('perfilUsuario');
        $this->usuario = $this->model('usuario');
        $this->publicaciones = $this->model('publicar');
    }

    public function index($user)
    {
        if(isset($_SESSION['logueado'])) {
            

            $datosUsuario = $this->usuario->getUsuario($user);
            if (!$datosUsuario) {
                // Manejar el caso cuando el usuario no existe
                $_SESSION['error'] = 'Usuario no encontrado';
                redirection('/home');
                return;
            }




            $datosPerfil = $this->usuario->getPerfil($datosUsuario->idusuario);
            // En lugar de obtener todas las publicaciones, filtra por el usuario logueado
            $datosPublicaciones = $this->publicaciones->getPublicacionesUsuario($datosUsuario->idusuario);
            $verificarLike = $this->publicaciones->mislikes($_SESSION['logueado']);
            $comentarios = $this->publicaciones->getComentarios();
            $informacionComentarios = $this->publicaciones->getInformacionComentarios($comentarios);
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);

            $misMensajes2 = $this->publicaciones->getMensajes($_SESSION['logueado']);


            $misSeguimientos = $this->publicaciones->rowSeguidor($_SESSION['logueado']);

            
            $estaSiguiendo = $this->publicaciones->rowSeguidor([
                'idusuario' => $_SESSION['logueado'],
                'idusuarioPublico' => $datosUsuario->idusuario
            ]);

            $totalSeguidores = $this->publicaciones->contarSeguidores($datosUsuario->idusuario);
            $totalSiguiendo = $this->publicaciones->contarSiguiendo($datosUsuario->idusuario);

            
            /* $datosPefil = $this->perfil->getInformation($_SESSION['logueado']); */

            $datos = [
                'perfil' => $datosPerfil,
                'usuario' => $datosUsuario,

                'publicaciones' => $datosPublicaciones,
                'misLikes' => $verificarLike,
                'comentarios' => $informacionComentarios,

                'misNotificaciones' => $misNotificaciones,

                'misMensajes2' => $misMensajes2,

                'misSeguimientos' => $misSeguimientos,  // Añadir misSeguimientos aquí

                'estaSiguiendo' => $estaSiguiendo > 0,

                'totalSeguidores' => $totalSeguidores,
                'totalSiguiendo' => $totalSiguiendo

            ];

            $this->view('pages/perfil/perfil' , $datos);

        }
    }

    
    public function cambiarImagen()
    {

        $carpeta = 'C:/xampp/htdocs/red-social/public/img/imagenesPerfil/';

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            opendir($carpeta);
            $rutaImagen = 'img/imagenesPerfil/' . $_FILES['imagen']['name'];
            $ruta = $carpeta . $_FILES['imagen']['name'];
            copy($_FILES['imagen']['tmp_name'] , $ruta);

        } else {
            // Si no hay imagen, asignar una ruta o indicador adecuado
            $rutaImagen = 'sin imagen';  // Aquí podrías usar una ruta de imagen por defecto o texto para indicar que no hay imagen
        }


        $datos = [
            'idusuario' => trim($_POST['id_user']),
            'ruta' => $rutaImagen
        ];

        $imagenActual = $this->usuario->getPerfil($datos['idusuario']);

        unlink('C:/xampp/htdocs/red-social/public/' . $imagenActual->fotoPerfil);

        if ($this->perfil->editarFoto($datos)) {
            redirection('/home');
        } else {
            echo 'No se han guardado los cambios';
        }
    }





    // controllers/Perfil.php

    public function seguir($usuarioNombre)
    {
        $idusuario = $_SESSION['logueado'];
        $usuarioPublico = $this->usuario->getUsuario($usuarioNombre);
        if (!$usuarioPublico) {
            $_SESSION['error'] = 'Usuario no encontrado';
            redirection('/home');
            return;
        }
    
        $datos = [
            'idusuario' => $idusuario,
            'idusuarioPublico' => $usuarioPublico->idusuario
        ];
    
        if ($this->publicaciones->rowSeguidor($datos)) {
            if ($this->publicaciones->eliminarSeguidor($datos)) {
                $_SESSION['mensaje'] = 'Has dejado de seguir al usuario.';
            } else {
                $_SESSION['error'] = 'Hubo un error al dejar de seguir al usuario.';
            }
        } else {
            if ($this->publicaciones->agregarSeguidor($datos)) {
                $_SESSION['mensaje'] = 'Ahora estás siguiendo al usuario.';

                // Agregar notificación
                $datosNotificacion = [
                    'idUsuario' => $usuarioPublico->idusuario,
                    'usuarioAccion' => $idusuario,
                    'tipoNotificacion' => 4 // Nuevo tipo de notificación para seguidores
                ];
                $this->publicaciones->addNotificacionSeguidor($datosNotificacion);

            } else {
                $_SESSION['error'] = 'Hubo un error al seguir al usuario.';
            }
        }
        redirection('/perfil/' . $usuarioNombre);
    }





    public function megusta($idpublicacion, $idusuario, $idusuarioPropietario)
    {
        $datos = [
        'idpublicacion' => $idpublicacion,
        'idusuario' => $idusuario,
        'idusuarioPropietario' => $idusuarioPropietario
    ];

    $datosPublicacion = $this->publicaciones->getPublicacion($idpublicacion);

    if ($this->publicaciones->rowLikes($datos)) {
        if ($this->publicaciones->eliminarLike($datos)) {
            $this->publicaciones->deleteLikeCount($datosPublicacion);
        }
    } else {
        if ($this->publicaciones->agregarLike($datos)) {
            $this->publicaciones->addLikeCount($datosPublicacion);
            $this->publicaciones->addNotificacionLike($datos);
        }
    }

    // Obtener el nombre de usuario del propietario de la publicación
    $usuarioPropietario = $this->usuario->getUsuarioPorId($idusuarioPropietario);
    
    // Redirigir al perfil del usuario propietario de la publicación
    redirection('/perfil/' . $usuarioPropietario->usuario);
}




}
