<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


class Home extends Controller
{
    // private $fd;

    public function __construct()
    {
        $this->usuario = $this->model('usuario');
        $this->publicaciones = $this->model('publicar');
    }

    public function index()
    { 
        if (isset($_SESSION['logueado'])) {

            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);

            $datosPublicaciones = $this->publicaciones->getPublicaciones();
            
            $verificarLike = $this->publicaciones->mislikes($_SESSION['logueado']);

            $comentarios = $this->publicaciones->getComentarios();

            $informacionComentarios = $this->publicaciones->getInformacionComentarios($comentarios);

            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);

            $misMensajes2 = $this->publicaciones->getMensajes($_SESSION['logueado']);


            $totalLikesRecibidos = $this->publicaciones->totalLikesRecibidos($_SESSION['logueado']);
            $totalPublicaciones = $this->publicaciones->totalPublicaciones($_SESSION['logueado']);

            $rowSeguidor = $this->publicaciones->rowSeguidor($_SESSION['logueado']);


            $totalSeguidores = $this->publicaciones->contarSeguidores($_SESSION['logueado']);
            $totalSiguiendo = $this->publicaciones->contarSiguiendo($_SESSION['logueado']);



            $estaSiguiendo = $this->publicaciones->rowSeguidor([
                'idusuario' => $_SESSION['logueado'],
                'idusuarioPublico' => $datosUsuario->idusuario
            ]);


            if ($datosPerfil) {
                $datosRed = [
                    'usuario' => $datosUsuario,
                    'perfil' => $datosPerfil,
                    'publicaciones' => $datosPublicaciones,
                    'misLikes' => $verificarLike,
                    'comentarios' => $informacionComentarios,
                    'misNotificaciones' => $misNotificaciones,

                    'misMensajes2' => $misMensajes2,


                    'totalLikesRecibidos' => $totalLikesRecibidos->totalLikes,  // Aquí pasamos el total de likes
                    'totalPublicaciones' => $totalPublicaciones->total,  // Total de publicaciones

                    'rowSeguidor' => $rowSeguidor,

                    'totalSeguidores' => $totalSeguidores->totalSeguidores,
                    'totalSiguiendo' => $totalSiguiendo->totalSiguiendo,
                    
                    'estaSiguiendo' => $estaSiguiendo > 0
                ];
    
                $this->view('pages/home' , $datosRed);
            } else {
                $this->view('pages/perfil/completarPerfil' , $_SESSION['logueado']);
            }   
        } else {
            redirection('/home/login');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $datosLogin = [
                'usuario' => trim($_POST['usuario']),
                'contrasena' => trim($_POST['contrasena'])
            ];

            $datosUsuario = $this->usuario->getUsuario($datosLogin['usuario']);

/*            var_dump($datosUsuario); */

            if ($this->usuario->verificarContrasena($datosUsuario, $datosLogin['contrasena'])){
                $_SESSION['logueado'] = $datosUsuario->idusuario;
                $_SESSION['usuario'] = $datosUsuario->usuario;
                redirection('/home');
            } else {
                $_SESSION['errorLogin'] = 'El usuario o la contraseña son incorrectas';
                redirection('/home');
            }
        } else {
            if(isset($_SESSION['logueado'])) {
                redirection('/home');
            } else {
                $this->view('pages/login-register/login');
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datosRegistro = [
                'privilegio' => '2',
                'correo' => trim($_POST['email']),
                'usuario' => trim($_POST['usuario']),
                'contrasena' => password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT)
            ];

            if ($this->usuario->verificarUsuario($datosRegistro)) {
                if ($this->usuario->register($datosRegistro)) {
                    $_SESSION['loginComplete'] = 'Tu cuenta ha sido creada correctamente, ahora ingresa a tu cuenta!';
                    redirection('/home');
                } else { }  
            }   else { 
                $_SESSION['usuarioError'] = 'El usuario ya esta en uso, intenta con otro..';
                $this->view('pages/login-register/register');
            }
        } else {
            if(isset($_SESSION['logueado'])) {
                redirection('/home');
            } else {
                $this->view('pages/login-register/register');
            }
        }
    }
    public function insertarRegistrosPerfil()
    {
        $carpeta = 'C:/xampp/htdocs/red-social/public/img/imagenesPerfil/';
        opendir($carpeta);
        $rutaImagen = 'img/imagenesPerfil/' . $_FILES['imagen']['name'];
        $ruta = $carpeta . $_FILES['imagen']['name'];
        copy($_FILES['imagen']['tmp_name'] , $ruta);

        $datos = [
            'idusuario' => trim($_POST['id_user']),
            'nombre' => trim($_POST['nombre']),
            'ruta' => $rutaImagen
        ];

        if ($this->usuario->insertarPerfil($datos)) {
             redirection('/home');
        } else {
            echo 'No se han guardado los cambios';
        }
    }

    public function logout()
    {
        session_start();

        $_SESSION = [];

        session_destroy();

        redirection('/home');
    }


    public function usuarios()
    {
        if (isset($_SESSION['logueado'])) {

            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
            $misMensajes2 = $this->publicaciones->getMensajes($_SESSION['logueado']);
            $usuariosRegistrados = $this->usuario->getAllUsuarios();
            $cantidadUsuarios = $this->usuario->getCantidadUsuarios();

            if ($datosPerfil) {
                $datosRed = [
                    'usuario' => $datosUsuario,
                    'perfil' => $datosPerfil,
                    'misNotificaciones' => $misNotificaciones,
                    'misMensajes2' => $misMensajes2,
                    'allUsuarios' => $usuariosRegistrados,
                    'cantidadUsuarios' => $cantidadUsuarios
                ];
                $this->view('pages/usuarios/usuarios' , $datosRed);
            } else {
                redirection('/home');
            }
        }
    }

    public function buscar()
    {
        if(isset($_SESSION['logueado'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $busqueda = '%' . trim($_POST['buscar']) . '%';

                $datosBusqueda = $this->usuario->buscar($busqueda);


                $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
                $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);
                $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
                $misMensajes2 = $this->publicaciones->getMensajes($_SESSION['logueado']);


                if ($datosPerfil) {
                    $datosRed = [
                        'usuario' => $datosUsuario,
                        'perfil' => $datosPerfil,
                        'misNotificaciones' => $misNotificaciones,
                        'misMensajes2' => $misMensajes2,
                        'resultado' => $datosBusqueda
                    ];


                    if ($datosBusqueda) {
                        $this->view('pages/busqueda/buscar' , $datosRed);
                    } else {
                        redirection('/home');
                    }
                } else {
                    redirection('/home');
                }
            } else {
                redirection('/home');
            }
        }
    }








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


    
}
