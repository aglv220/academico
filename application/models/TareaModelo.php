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

    public function guardar_actividad($user, $nom, $des, $fec)
    {
        $where_act = [
            ["campo" => "fk_usuario", "valor" => $user],
            ["campo" => "nombre_actividad", "valor" => $nom],
            ["campo" => "descripcion_actividad", "valor" => $des],
            ["campo" => "fecdisp_actividad", "valor" => $fec]
        ];
        $lst_act_xdatos = $this->crudm->listar_tabla_xcampo("actividad", $where_act);
        if (count($lst_act_xdatos) > 0) { //SI LA ACTIVIDAD YA EXISTE
            $id_actividad = $lst_act_xdatos[0]->pk_actividad;
            return $id_actividad;
        } else { //SI NO EXISTE REGISTRO DE LA ACTIVIDAD
            $data_act = ["fk_tipo_actividad" => 1, "fk_usuario" => $user, "nombre_actividad" => $nom, "descripcion_actividad" => $des, "fecdisp_actividad" => $fec];
            return $this->crudm->ingresar_data($data_act, "actividad");
        }
    }

    public function guardar_actividad_usuario($activ_id, $curso_id)
    {
        $where_usuact = [
            ["campo" => "fk_actividad", "valor" => $activ_id],
            ["campo" => "fk_curso", "valor" => $curso_id]
        ];
        $lst_usuact_xdatos = $this->crudm->listar_tabla_xcampo("usuario_actividad", $where_usuact);
        if (count($lst_usuact_xdatos) > 0) {
            $id_usuact = $lst_usuact_xdatos[0]->pk_usuario_actividad;
            return $id_usuact;
        } else {
            $data_actu = ["fk_actividad" => $activ_id, "fk_curso" => $curso_id, "estado_usuario_actividad" => 0];
            return $this->crudm->ingresar_data($data_actu, "usuario_actividad");
        }
    }

    public function listarCursos($idUser)
    {
        // $query = "SELECT curso_nombre as nombreCurso, a.nombre_actividad as descpCurso FROM usuario_curso uc
        // INNER JOIN curso c on uc.fk_curso = c.pk_curso
        // INNER JOIN usuario_actividad ua on ua.fk_curso = c.pk_curso
        // INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad
        // WHERE uc.fk_usuario = $idUser and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 0 ORDER BY a.fecdisp_actividad DESC LIMIT 3" ;
        $query = "SELECT curso_nombre as nombreCurso, a.nombre_actividad as descpCurso, DAY(a.fecdisp_actividad) as dia_actividad, MONTH(a.fecdisp_actividad) as mes_actividad, YEAR(a.fecdisp_actividad) as year_actividad FROM actividad a INNER JOIN usuario_actividad ua ON ua.fk_actividad = a.pk_actividad INNER JOIN usuario_curso uc ON uc.fk_usuario = a.fk_usuario LEFT JOIN curso c on uc.fk_curso = c.pk_curso WHERE uc.fk_usuario = $idUser and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 0 ORDER BY a.fecdisp_actividad DESC LIMIT 3";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function listarTareasalCalendario($idUser)
    {
        // $query = "SELECT  a.descripcion_actividad as title, a.fecdisp_actividad as start,'bg-warning' as className FROM usuario_curso uc
        // INNER JOIN curso c on uc.fk_curso = c.pk_curso
        // INNER JOIN usuario_actividad ua on ua.fk_curso = c.pk_curso
        // INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad
        // WHERE uc.fk_usuario = $idUser and a.fk_tipo_actividad = 1 ";
        $query = "SELECT a.nombre_actividad as title, a.fecdisp_actividad as start,'bg-warning' as className FROM actividad a INNER JOIN usuario_actividad ua on ua.fk_actividad = a.pk_actividad WHERE a.fk_usuario = $idUser and a.fk_tipo_actividad = 1";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function listarActividadXtipo()
    {
        $query = "SELECT * FROM tipo_actividad where pk_tipo_actividad in(2,3,4,5,6)";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function listarTareasPausa($id)
    {
        // $query = "SELECT a.pk_actividad as id , c.curso_nombre as nombre_actividad, a.nombre_actividad as descripcion_actividad, a.fk_tipo_actividad as tipo 
        // FROM actividad a 
        // INNER JOIN usuario_actividad ua on ua.fk_actividad = a.pk_actividad
        // INNER JOIN usuario_curso uc on uc.fk_usuario = a.fk_usuario
        // LEFT JOIN curso c on c.pk_curso = uc.fk_curso
        // WHERE a.fk_usuario = $id and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 0  ORDER BY a.fecdisp_actividad DESC";
        $query = "SELECT ua.fk_actividad as id, c.curso_nombre as nombre_actividad, a.nombre_actividad as descripcion_actividad, a.fk_tipo_actividad as tipo FROM usuario_actividad ua INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad INNER JOIN usuario_curso uc on uc.pk_usuario_curso = ua.fk_curso LEFT JOIN curso c on uc.fk_curso = c.pk_curso WHERE a.fk_usuario = $id and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 0 ORDER BY a.fecdisp_actividad DESC";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function listarTareasProceso($id)
    {
        // $query = "SELECT a.pk_actividad as id , c.curso_nombre as nombre_actividad, a.nombre_actividad as descripcion_actividad, a.fk_tipo_actividad as tipo 
        // FROM actividad a 
        // INNER JOIN usuario_actividad ua on ua.fk_actividad = a.pk_actividad
        // INNER JOIN usuario_curso uc on uc.fk_usuario = a.fk_usuario
        // LEFT JOIN curso c on c.pk_curso = ua.fk_curso
        // WHERE a.fk_usuario = $id and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 1  ORDER BY a.fecdisp_actividad DESC;";
        $query = "SELECT ua.fk_actividad as id, c.curso_nombre as nombre_actividad, a.nombre_actividad as descripcion_actividad, a.fk_tipo_actividad as tipo FROM usuario_actividad ua INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad INNER JOIN usuario_curso uc on uc.pk_usuario_curso = ua.fk_curso LEFT JOIN curso c on uc.fk_curso = c.pk_curso WHERE a.fk_usuario = $id and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 1 ORDER BY a.fecdisp_actividad DESC";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function listarTareasFinalizada($id)
    {
        // $query = "SELECT a.pk_actividad as id , c.curso_nombre as nombre_actividad, a.nombre_actividad as descripcion_actividad, a.fk_tipo_actividad as tipo 
        // FROM actividad a 
        // INNER JOIN usuario_actividad ua on ua.fk_actividad = a.pk_actividad
        // INNER JOIN usuario_curso uc on uc.fk_usuario = a.fk_usuario
        // LEFT JOIN curso c on c.pk_curso = ua.fk_curso
        // WHERE a.fk_usuario = $id and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 2  ORDER BY a.fecdisp_actividad DESC;";
        $query = "SELECT ua.fk_actividad as id, c.curso_nombre as nombre_actividad, a.nombre_actividad as descripcion_actividad, a.fk_tipo_actividad as tipo FROM usuario_actividad ua INNER JOIN actividad a on a.pk_actividad = ua.fk_actividad INNER JOIN usuario_curso uc on uc.pk_usuario_curso = ua.fk_curso LEFT JOIN curso c on uc.fk_curso = c.pk_curso WHERE a.fk_usuario = $id and a.fk_tipo_actividad = 1 and ua.estado_usuario_actividad = 2 ORDER BY a.fecdisp_actividad DESC";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function estadoPizarra($pkActividad)
    {
        $query = "SELECT a.pk_actividad as id, CONCAT(c.curso_nombre,' - ',a.nombre_actividad) as nombre_actividad,ua.estado_usuario_actividad as estado_pizarra 
        FROM actividad a
        INNER JOIN usuario_actividad ua ON ua.fk_actividad = a.pk_actividad
		INNER JOIN usuario_curso uc ON uc.fk_usuario = a.fk_usuario
		LEFT JOIN curso c ON c.pk_curso = uc.fk_curso
        where a.pk_actividad = $pkActividad";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }
    public function guardar_estado_pizarra($id, $estado)
    {
        $query = "UPDATE usuario_actividad set estado_usuario_actividad = $estado where fk_actividad = $id";
        $this->db->query($query);
    }
}
