<?php

class mensajesMod
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function enviarMensaje($datosMensaje)
    {
        $this->db->query('INSERT INTO mensajes (usuarios_idusuario , usuarioMando , contenido) VALUES (:iduserRecibe , :iduserMando , :contenido )');
        $this->db->bind(':iduserRecibe' , $datosMensaje['enviar']);
        $this->db->bind(':iduserMando' , $datosMensaje['idusermando']);
        $this->db->bind(':contenido' , $datosMensaje['mensaje']);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMensajes($id)
    {
        $this->db->query('SELECT U.usuario , P.fotoPerfil , M.contenido , M.fechaMensaje , M.idmensaje FROM mensajes M 
        INNER JOIN usuarios U ON U.idusuario = M.usuarioMando 
        INNER JOIN perfil P ON P.idUsuario = M.usuarioMando 
        WHERE M.usuarios_idusuario = :id');
        $this->db->bind(':id' , $id);
        return $this->db->registers();
    }

    public function eliminarMensaje($id)
    {
        $this->db->query('DELETE FROM mensajes WHERE idmensaje = :id');
        $this->db->bind(':id' , $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}