<?php

class usuario
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function getUsuario($usuario)
    {
        $this->db->query('SELECT * FROM usuarios WHERE usuario = :user');
        $this->db->bind(':user', $usuario);
        return $this->db->register();
    }


    
    public function getUsuarios()
    {
        $this->db->query('SELECT idusuario , usuario FROM usuarios');
        return $this->db->registers();
    }



    public function getPerfil($idusuario)
    {
        $this->db->query('SELECT * FROM perfil WHERE idUsuario = :id');
        $this->db->bind(':id', $idusuario);
        return $this->db->register();
    }


    public function verificarContrasena($datosUsuario , $contrasena)
    {
            if (password_verify($contrasena , $datosUsuario->contrasena)) {
                return true;
            } else {
                return false;
            }
    }

    public function verificarUsuario($datosUsuario)
    {
        $this->db->query('SELECT usuario FROM usuarios WHERE usuario = :user');
        $this->db->bind(':user' , $datosUsuario['usuario']);
        $this->db->execute();
        if($this->db->rowCount()) {
            return false;
        } else {
            return true;
        }
    }

    public function register($datosUsuario)
    {
        $this->db->query('INSERT INTO usuarios (idPrivilegio , correo , usuario , contrasena) VALUES (:privilegio , :correo , :usuario , :contrasena)');
        $this->db->bind(':privilegio' , $datosUsuario['privilegio']);
        $this->db->bind(':correo' , $datosUsuario['correo']);
        $this->db->bind(':usuario' , $datosUsuario['usuario']);
        $this->db->bind(':contrasena' , $datosUsuario['contrasena']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertarPerfil($datos)
    {
        $this->db->query('INSERT INTO perfil (idUsuario , fotoPerfil , nombreCompleto) VALUES (:id , :rutaFoto , :nombre)');
        $this->db->bind(':id' , $datos['idusuario']);
        $this->db->bind(':rutaFoto' , $datos['ruta']);
        $this->db->bind(':nombre' , $datos['nombre']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getAllUsuarios()
    {
        $this->db->query('SELECT U.idusuario , U.usuario , P.fotoPerfil , P.nombreCompleto FROM usuarios U 
        INNER JOIN perfil P ON P.idUsuario = U.idusuario');
        return $this->db->registers();
    }


    public function getCantidadUsuarios()
    {
        $this->db->query('SELECT idusuario FROM usuarios');
        $this->db->execute();
        return $this->db->rowCount();
    }


    public function buscar($busqueda)
    {
        $this->db->query('SELECT U.usuario , P.fotoPerfil , P.nombreCompleto FROM usuarios U INNER JOIN perfil P ON P.idUsuario = U.idusuario
        WHERE U.usuario LIKE :buscar ');
        $this->db->bind(':buscar' , $busqueda);
        return $this->db->registers();
    }










    public function rowSeguidores($datos)
    {
        $this->db->query('SELECT * FROM seguidores WHERE idUser = :idSeguidor AND idUserPublico = :idUserPublico');
        $this->db->bind(':idSeguidor', $datos['idSeguidor']);
        $this->db->bind(':idUserPublico', $datos['idUserPublico']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function agregarSeguidor($datos)
    {
        $this->db->query('INSERT INTO seguidores (idUser, idUserPublico) VALUES (:idSeguidor, :idUserPublico)');
        $this->db->bind(':idSeguidor', $datos['idSeguidor']);
        $this->db->bind(':idUserPublico', $datos['idUserPublico']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarSeguidor($datos)
    {
        $this->db->query('DELETE FROM seguidores WHERE idUser = :idSeguidor AND idUserPublico = :idUserPublico');
        $this->db->bind(':idSeguidor', $datos['idSeguidor']);
        $this->db->bind(':idUserPublico', $datos['idUserPublico']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function addSeguidoresCount($datos)
    {
        $this->db->query('UPDATE usuarios SET num_seguidores = :countSeguidores WHERE idusuario = :idUsuario');
        $this->db->bind(':countSeguidores', ($datos->num_seguidores + 1));
        $this->db->bind(':idUsuario', $datos->idusuario);
        if ($this->db->execute()) {
            return true;
        } else {
        return false;
        }
    }

    public function deleteSeguidoresCount($datos)
    {
        $this->db->query('UPDATE usuarios SET num_seguidores = :countSeguidores WHERE idusuario = :idUsuario');
        $this->db->bind(':countSeguidores', ($datos->num_seguidores - 1));
        $this->db->bind(':idUsuario', $datos->idusuario);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function misSeguidores($user)
    {
        $this->db->query('SELECT * FROM seguidores WHERE idUser = :id');
        $this->db->bind(':id', $user);
        return $this->db->registers();
    }




    public function misSeguimientos($idUser)
    {
        $this->db->query('SELECT * FROM seguidores WHERE idSeguidor = :idUser');
        $this->db->bind(':idUser', $idUser);
        return $this->db->registers();  // Retorna los seguimientos
    }




    public function getUsuarioPorId($id)
    {
        $this->db->query('SELECT * FROM usuarios WHERE idusuario = :id');
        $this->db->bind(':id', $id);
        return $this->db->register();
    }



}