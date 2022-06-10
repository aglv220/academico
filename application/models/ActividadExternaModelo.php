<?php

class ActividadExternaModelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function asignarActividadCalendario($idActividad, $fecha)
    {
        $query = "UPDATE actividad set estado = 1, fecha_disponible = '".$fecha."' where ID = $idActividad";
        $this->db->query($query);
    }

    public function listarActividadesalCalendario($idUser){
        $query = 'SELECT  ac.nombre as title, ac.fecha_disponible as start ,"bg-dark" as className FROM curso_alumno ca
        INNER JOIN curso c ON c.ID = ca.curso_ID
        INNER JOIN actividad ac on ac.curso_ID = ca.curso_ID
        INNER JOIN actividad_tipo atp on atp.ID = ac.tipo_actividad
        where usuario_ID = '.$idUser.' and estado = 1';

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function insertarCursoAlumno($idUser){
        $this->db->insert("curso_alumno", [
			"usuario_ID" => $idUser,
			"curso_ID" => 1,
		]);
		return $this->db->insert_id();
    }

    public function crearActividad($idTabla,$tipo,$nombre,$descrip,$fechaDisp){
        $this->db->insert("actividad", [
			"curso_ID" => $idTabla,
			"tipo_actividad" => $tipo,
            "nombre" => $nombre,
            "descripcion" => $descrip,
            "fecha_disponible" => $fechaDisp,
            "estado" => 0
		]);
    }
    public function listarActividades($idUser){
        $query = "SELECT ac.ID, c.nombre as nombreCurso, ac.nombre as descpCurso FROM curso_alumno ca
        INNER JOIN curso c ON c.ID = ca.curso_ID
        INNER JOIN actividad ac on ac.curso_ID = ca.curso_ID
        INNER JOIN actividad_tipo atp on atp.ID = ac.tipo_actividad
        where usuario_ID = $idUser and estado = 0 and c.nombre like '%Actividad%' ORDER BY fecha_disponible" ;

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
}
?>