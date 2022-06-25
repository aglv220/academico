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
        $query = "SELECT curso_nombre as nombreCurso, a.nombre_actividad as descpCurso FROM usuario_curso uc
        INNER JOIN curso c on uc.fk_curso = c.pk_curso
        INNER JOIN usuario_actividad ua on ua.fk_curso = c.pk_curso
        INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad
        WHERE uc.fk_usuario = $idUser and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 0 ORDER BY a.fecdisp_actividad DESC LIMIT 3;" ;

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function listarTareasalCalendario($idUser){
        $query = "SELECT  a.descripcion_actividad as title, a.fecdisp_actividad as start,'bg-warning' as className FROM usuario_curso uc
        INNER JOIN curso c on uc.fk_curso = c.pk_curso
        INNER JOIN usuario_actividad ua on ua.fk_curso = c.pk_curso
        INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad
        WHERE uc.fk_usuario = $idUser and a.fk_tipo_actividad = 1 ";

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }


    public function listarActividadXtipo(){
        $query = "SELECT * FROM tipo_actividad where pk_tipo_actividad in(2,3,4,5,6)" ;
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
}
?>