<?php

class notificacion
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function obtenerNotificaciones($idusuario)
    {
        $this->db->query('SELECT N.idnotificacion , T.mensajeNotificacion , U.usuario FROM notificaciones N
        INNER JOIN usuarios U ON U.idusuario = N.usuarioAccion 
        INNER JOIN tiposnotificaciones T ON T.idtiposNotificaciones = N.tipoNotificacion
        WHERE N.idUsuario = :iduser');
        $this->db->bind(':iduser' , $idusuario);
        return $this->db->registers();
    }

    public function eliminarNotificacion($id)
    {
        $this->db->query('DELETE FROM notificaciones WHERE idnotificacion = :id');
        $this->db->bind(':id' , $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}