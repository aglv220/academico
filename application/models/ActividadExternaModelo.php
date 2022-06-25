<?php

class ActividadExternaModelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function asignarActividadCalendario($idActividad)
    {
        $query = "UPDATE usuario_actividad_externa set estado_calendario = 1 where pk_usuario_actividad_externa = $idActividad";
        $this->db->query($query);
    }

    public function listarActividadesalCalendario($idUser){
        $query = "SELECT  ac.nombre_actividad as title, ac.fecdisp_actividad as start ,'bg-info' as className FROM actividad ac
        INNER JOIN tipo_actividad ta on ta.pk_tipo_actividad = ac.fk_tipo_actividad
        INNER JOIN usuario_actividad_externa uce on uce.fk_actividad = ac.pk_actividad
        where fk_usuario = $idUser and fk_tipo_actividad != 1 and uce.estado_calendario = 1";

        $resultado = $this->db->query($query);
        return $resultado->result_array();//fecha_disponible = '".$fecha."'
    }
    public function listarCursosFueraCalendario($idUser){
        $query = "SELECT uce.pk_usuario_actividad_externa as ID, ta.nombre_tipo_actividad as nombreCurso,ac.nombre_actividad as descpCurso from actividad ac
        INNER JOIN tipo_actividad ta on ta.pk_tipo_actividad = ac.fk_tipo_actividad
        INNER JOIN usuario_actividad_externa uce on uce.fk_actividad = ac.pk_actividad
        where fk_usuario = $idUser and fk_tipo_actividad != 1 and uce.estado_calendario = 0 ORDER BY ac.fecdisp_actividad DESC LIMIT 3" ;

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function insertarUsuarioActividadExterna($idTabla,$estado){
        $this->db->insert("usuario_actividad_externa", [
			"fk_actividad" => $idTabla,
			"estado_calendario" => $estado,
            "estado_pizarra" => 0
		]);
		return $this->db->insert_id();
    }

    public function crearActividad($tipo,$idUser,$nombre,$descrip,$fechaDisp){
        $this->db->insert("actividad", [
			"fk_tipo_actividad" => $tipo,
			"fk_usuario" => $idUser,
            "nombre_actividad" => $nombre,
            "descripcion_actividad" => $descrip,
            "fecdisp_actividad" => $fechaDisp,
		]);
        return $this->db->insert_id();
    }
    public function listarActividades($idUser){
        $query = "SELECT  ta.nombre_tipo_actividad as nombreCurso,ac.nombre_actividad as descpCurso from actividad ac
        INNER JOIN tipo_actividad ta on ta.pk_tipo_actividad = ac.fk_tipo_actividad
        INNER JOIN usuario_actividad_externa uce on uce.fk_actividad = ac.pk_actividad
        where fk_usuario = $idUser and fk_tipo_actividad != 1 and uce.estado_pizarra = 0 ORDER BY ac.fecdisp_actividad DESC LIMIT 3" ;

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function consultarIdActividad($id){
        $query = "SELECT fk_actividad from usuario_actividad_externa where pk_usuario_actividad_externa = $id";

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function asignarfechaActividad($id, $fecha){
        $query = "UPDATE actividad set fecdisp_actividad = '".$fecha."' where pk_actividad = $id";
        $this->db->query($query);
    }
}
?>