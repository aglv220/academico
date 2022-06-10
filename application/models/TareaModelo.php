<?php

class TareaModelo extends CI_Model
{
    public $ID;
    public $curso;
    public $decripcion;

    function __construct()
    {
        parent::__construct();
    }

    public function listarCursos($idUser)
    {
        $query = "SELECT c.nombre as nombreCurso, ac.nombre as descpCurso FROM curso_alumno ca
        INNER JOIN curso c ON c.ID = ca.curso_ID
        INNER JOIN actividad ac on ac.curso_ID = ca.curso_ID
        INNER JOIN actividad_tipo atp on atp.ID = ac.tipo_actividad
        where usuario_ID = $idUser limit 3" ;

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function listarCursosFueraCalendario($idUser){
        $query = "SELECT ac.ID, c.nombre as nombreCurso, ac.nombre as descpCurso FROM curso_alumno ca
        INNER JOIN curso c ON c.ID = ca.curso_ID
        INNER JOIN actividad ac on ac.curso_ID = ca.curso_ID
        INNER JOIN actividad_tipo atp on atp.ID = ac.tipo_actividad
        where usuario_ID = $idUser and estado = 0 ORDER BY fecha_disponible" ;

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function listarActividadXtipo(){
        $query = "SELECT * FROM actividad_tipo where ID in(2,3,4,5,6)" ;
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
}
?>