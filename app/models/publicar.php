<?php

class publicar
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function publicar($datos)
    {
        $this->db->query('INSERT INTO publicaciones (idUserPublico , contenidoPublicacion , fotoPublicacion, videoPublicacion) VALUES (:iduser , :contenido , :foto, :video)');
        $this->db->bind(':iduser' , $datos['iduser']);
        $this->db->bind(':contenido' , $datos['contenido']);
        $this->db->bind(':foto' , $datos['foto']);
        $this->db->bind(':video' , $datos['video']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPublicaciones()
    {
        $this->db->query('SELECT P.idpublicacion , P.contenidoPublicacion , P.fotoPublicacion , P.videoPublicacion , P.fechaPublicacion , P.num_likes , U.usuario , U.idusuario , Per.fotoPerfil FROM publicaciones P
        INNER JOIN usuarios U ON U.idusuario = P.idUserPublico 
        INNER JOIN perfil Per ON Per.idUsuario = P.idUserPublico');
        return $this->db->registers();
    }


    public function getPublicacionesUsuario($idUsuario)
    {
        // Unir las tablas usuarios y perfil para obtener la información completa
        $this->db->query('SELECT P.idpublicacion, P.contenidoPublicacion, P.fotoPublicacion, P.videoPublicacion, P.fechaPublicacion, P.num_likes, U.usuario, U.idusuario, Per.fotoPerfil 
        FROM publicaciones P 
        INNER JOIN usuarios U ON U.idusuario = P.idUserPublico 
        INNER JOIN perfil Per ON Per.idUsuario = P.idUserPublico 
        WHERE P.idUserPublico = :idUserPublico');
        $this->db->bind(':idUserPublico', $idUsuario);
        return $this->db->registers();
}



    public function getPublicacion($id)
    {
        $this->db->query('SELECT * FROM publicaciones WHERE idpublicacion = :id ');
        $this->db->bind(':id' , $id);
        return $this->db->register();

    }


    public function eliminarPublicacion($publicacion)
    {
        $this->db->query('DELETE FROM publicaciones WHERE idpublicacion = :id');
        $this->db->bind(':id' , $publicacion->idpublicacion);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function rowLikes($datos)
    {
        $this->db->query('SELECT * FROM likes WHERE idPublicacion = :publicacion AND idUser = :iduser ');
        $this->db->bind(':publicacion' , $datos['idpublicacion']);
        $this->db->bind(':iduser' , $datos['idusuario']);
        $this->db->execute();
        return $this->db->rowCount();

    }

    public function agregarLike($datos)
    {
        $this->db->query('INSERT INTO likes (idPublicacion , idUser) VALUES (:publicacion , :iduser)');
        $this->db->bind(':publicacion' , $datos['idpublicacion']);
        $this->db->bind(':iduser' , $datos['idusuario']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarLike($datos)
    {
        $this->db->query('DELETE FROM likes WHERE idPublicacion = :publicacion AND idUser = :iduser ');
        $this->db->bind(':publicacion' , $datos['idpublicacion']);
        $this->db->bind(':iduser' , $datos['idusuario']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function addLikeCount($datos)
    {
        $this->db->query('UPDATE publicaciones SET num_likes = :countLike WHERE idpublicacion = :idPublicacion');
        $this->db->bind(':countLike' , ($datos->num_likes + 1));
        $this->db->bind(':idPublicacion' , $datos->idpublicacion);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    

    public function deleteLikeCount($datos)
    {
        $this->db->query('UPDATE publicaciones SET num_likes = :countLike WHERE idpublicacion = :idPublicacion');
        $this->db->bind(':countLike' , ($datos->num_likes - 1));
        $this->db->bind(':idPublicacion' , $datos->idpublicacion);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function misLikes($user)
    {
        $this->db->query('SELECT * FROM likes WHERE idUser = :id');
        $this->db->bind(':id' , $user);
        return $this->db->registers();
    }






    public function publicarComentario($datos)
    {
        $this->db->query('INSERT INTO comentarios (idPublicacion , idUser , contenidoComentario) VALUES (:idpubli , :iduser , :comentario)');
        $this->db->bind(':idpubli' , $datos['idpublicacion']);
        $this->db->bind(':iduser' , $datos['iduser']);
        $this->db->bind(':comentario' , $datos['comentario']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getComentarios()
    {
        $this->db->query('SELECT * FROM comentarios');
        return $this->db->registers();
    }

    public function getInformacionComentarios($comentarios)
    {
        $this->db->query('SELECT C.idPublicacion , C.iduser , C.idcomentario , C.contenidoComentario , C.fechaComentario , P.fotoPerfil , U.usuario FROM comentarios C 
        INNER JOIN perfil P ON P.idUsuario = C.idUser 
        INNER JOIN usuarios U ON U.idusuario = C.idUser');
        return $this->db->registers();

    }

    public function eliminarComentarioUsuario($id)
    {
        $this->db->query('DELETE FROM comentarios WHERE idcomentario = :id');
        $this->db->bind(':id' , $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function addNotificacionLike($datos)
    {
        $this->db->query('INSERT INTO notificaciones (idUsuario , usuarioAccion , tipoNotificacion) VALUES (:idusuario , :usuarioAccion , :tipo)');
        $this->db->bind(':idusuario' , $datos['idusuarioPropietario']);
        $this->db->bind(':usuarioAccion' , $datos['idusuario']);
        $this->db->bind(':tipo' , 1);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function addNotificacionComentario($datos)
    {
        $this->db->query('INSERT INTO notificaciones (idUsuario , usuarioAccion , tipoNotificacion) VALUES (:idusuario , :usuarioAccion , :tipo)');
        $this->db->bind(':idusuario' , $datos['iduserPropietario']);
        $this->db->bind(':usuarioAccion' , $datos['iduser']);
        $this->db->bind(':tipo' , 2);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }



    public function addNotificacionMensaje($datos)
    {
        $this->db->query('INSERT INTO notificaciones (idUsuario , usuarioAccion , tipoNotificacion) VALUES (:idusuario , :usuarioAccion , :tipo)');
        $this->db->bind(':idusuario' , $datos['iduserPropietario']);
        $this->db->bind(':usuarioAccion' , $datos['iduser']);
        $this->db->bind(':tipo' , 3);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }






    public function getNotificaciones($id)
    {
        $this->db->query('SELECT idnotificacion FROM notificaciones WHERE idUsuario = :id');
        $this->db->bind(':id' , $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    
    public function getMensajes($id)
    {
        $this->db->query('SELECT idmensaje FROM mensajes WHERE usuarios_idusuario = :id');
        $this->db->bind(':id' , $id);
        $this->db->execute();
        return $this->db->rowCount();
    }



    
    public function totalLikesRecibidos($userId)
    {
        $this->db->query('
        SELECT COUNT(l.idlike) as totalLikes 
        FROM likes l
        INNER JOIN publicaciones p ON l.idPublicacion = p.idpublicacion
        WHERE p.idUserPublico = :id
        ');
        $this->db->bind(':id', $userId);
        return $this->db->register();
    }
    

    public function totalPublicaciones($userId)
    {
        $this->db->query('SELECT COUNT(*) as total FROM publicaciones WHERE idUserPublico = :id');
        $this->db->bind(':id', $userId);
        return $this->db->register();
    }
    




    // public function seguirUsuario($datos)
    // {
    //     $this->db->query('INSERT INTO seguidores (idUser, idUserPublico) VALUES (:idUser, :idUserPublico)');
    //     $this->db->bind(':idUser', $datos['idUsuario']); // Usuario que sigue
    //     $this->db->bind(':idUserPublico', $datos['idusuario']); // Usuario que está siendo seguido
    //     if ($this->db->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    // public function dejarSeguir($datos)
    // {
    //     $this->db->query('DELETE FROM seguidores WHERE idUser = :idUser AND idUserPublico = :iduser ');
    //     $this->db->bind(':idUser' , $datos['idUsuario']);
    //     $this->db->bind(':idUserPublico' , $datos['idusuario']);
    //     if ($this->db->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }




    // public function addSeguirCount($datos)
    // {
    //     $this->db->query('UPDATE publicaciones SET num_likes = :countLike WHERE idpublicacion = :idPublicacion');
    //     $this->db->bind(':countLike' , ($datos->num_likes + 1));
    //     $this->db->bind(':idPublicacion' , $datos->idpublicacion);
    //     if ($this->db->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    

    // public function deleteSeguirCount($datos)
    // {
    //     $this->db->query('UPDATE publicaciones SET num_likes = :countLike WHERE idpublicacion = :idPublicacion');
    //     $this->db->bind(':countLike' , ($datos->num_likes - 1));
    //     $this->db->bind(':idPublicacion' , $datos->idpublicacion);
    //     if ($this->db->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }

    // }











    // public function contarSeguidores($idUserPublico)
    // {
    //     $this->db->query('SELECT COUNT(*) as totalSeguidores FROM seguidores WHERE idUserPublico = :idUserPublico');
    //     $this->db->bind(':idUserPublico', $idUserPublico); // Usuario que está siendo seguido
    //     return $this->db->register();
    // }


    // public function estaSiguiendo($idUser, $idUserPublico)
    // {
    //     $this->db->query('SELECT * FROM seguidores WHERE idUser = :idUser AND idUserPublico = :idUserPublico');
    //     $this->db->bind(':idUser', $idUser);
    //     $this->db->bind(':idUserPublico', $idUserPublico);
    //     return $this->db->register();
    // }



    // public function rowSeguidores($datos)
    // {
    //     $this->db->query('SELECT * FROM seguidores WHERE idUser = :idUser AND idUserPublico = :idusuarioPropietario');
    //     $this->db->bind(':idUser', $datos['idUsuario']);
    //     $this->db->bind(':idusuarioPropietario', $datos['idusuarioPropietario']);
    //     return $this->db->register();
    // }




    // BlackBox AI:

    public function rowSeguidor($datos)
    {
        if (is_array($datos)) {
            $this->db->query('SELECT * FROM seguidores WHERE idUser = :iduser AND idUserPublico = :iduserpublico');
            $this->db->bind(':iduser', $datos['idusuario']);
            $this->db->bind(':iduserpublico', $datos['idusuarioPublico']);
        } else {
            $this->db->query('SELECT * FROM seguidores WHERE idUser = :iduser');
            $this->db->bind(':iduser', $datos);
        }
        $this->db->execute();
        return $this->db->rowCount();
    }



    
    public function agregarSeguidor($datos)
    {
        $this->db->query('INSERT INTO seguidores (idUser , idUserPublico) VALUES (:iduser, :iduserpublico)');
        $this->db->bind(':iduser', $datos['idusuario']);
        $this->db->bind(':iduserpublico', $datos['idusuarioPublico']);
        return $this->db->execute();
    }
    
    public function eliminarSeguidor($datos)
    {
        $this->db->query('DELETE FROM seguidores WHERE idUser  = :iduser AND idUserPublico = :iduserpublico');
        $this->db->bind(':iduser', $datos['idusuario']);
        $this->db->bind(':iduserpublico', $datos['idusuarioPublico']);
        return $this->db->execute();
    }

    public function contarSeguidores($idUserPublico)
    {
        $this->db->query('SELECT COUNT(*) as totalSeguidores FROM seguidores WHERE idUserPublico = :idUserPublico');
        $this->db->bind(':idUserPublico', $idUserPublico);
        return $this->db->register();
    }



    public function contarSiguiendo($idUser)
    {
        $this->db->query('SELECT COUNT(*) as totalSiguiendo FROM seguidores WHERE idUser = :idUser');
        $this->db->bind(':idUser', $idUser);
        return $this->db->register();
    }


    public function addNotificacionSeguidor($datos)
    {
        $this->db->query('INSERT INTO notificaciones (idUsuario, usuarioAccion, tipoNotificacion) VALUES (:idUsuario, :usuarioAccion, :tipo)');
        $this->db->bind(':idUsuario', $datos['idUsuario']);
        $this->db->bind(':usuarioAccion', $datos['usuarioAccion']);
        $this->db->bind(':tipo', $datos['tipoNotificacion']);
        return $this->db->execute();
    }





} 