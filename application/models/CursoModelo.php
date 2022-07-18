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
        $lst_curso_xnom = $this->crudm->listar_tabla_xcampo("curso", [["campo" => "curso_nombre", "valor" => $curso_nom]]);
        if (count($lst_curso_xnom) > 0) {
            $id_curso = $lst_curso_xnom[0]->pk_curso;
            return $id_curso;
        } else {
            //OBTENER EL NOMBRE DE LA SECCIÓN
            $array_value = explode("(", $curso_nom);
            $get_seccion = str_replace(")", "", $array_value[1]);
            $data_c = ["curso_nombre" => $curso_nom, "curso_seccion" => $get_seccion];
            return $this->crudm->ingresar_data($data_c, "curso");
        }
    }

    public function guardar_usuario_curso($id_curso, $id_usuario)
    {
        $data_valid = [["campo" => "fk_curso", "valor" => $id_curso], ["campo" => "fk_usuario", "valor" => $id_usuario]];
        $lst_cursousu_xcyu = $this->crudm->listar_tabla_xcampo("usuario_curso", $data_valid);
        if (count($lst_cursousu_xcyu) > 0) {
            return true;
        } else {
            $data_uc = ["fk_curso" => $id_curso, "fk_usuario" => $id_usuario];
            return $this->crudm->ingresar_data($data_uc, "usuario_curso");
        }
    }
}
