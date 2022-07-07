<?php

class CursoModelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function guardar_curso($curso_nom)
    {
        $data_c = ["curso_nombre" => $curso_nom];
        return $this->crudm->ingresar_data($data_c,"curso");
    }

    public function guardar_usuario_curso($id_curso,$id_usuario)
    {
        $data_uc = ["fk_curso" => $id_curso, "fk_usuario" => $id_usuario];
        return $this->crudm->ingresar_data($data_uc,"usuario_curso");
    }
}