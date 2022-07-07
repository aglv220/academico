<?php

class ApiModelo extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    function fetch_all()
    {
        $query = 'select * from alumno';

        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function validate_credentials($user, $pass, $update = true)
    {
        $msg_rtn = false;
        $listar_config_sis = $this->crudm->listar_tabla("configuracion_sistema");
        if (count($listar_config_sis) > 0) {
            $bd_user = $listar_config_sis[1]->config_value;
            $bd_pass = $listar_config_sis[2]->config_value;
            if (strcmp($bd_user, $user) == 0 && password_verify($pass, $bd_pass)) {
                if ($update) { //SE ACTUALIZARÁ EL TOKEN
                    if ($this->update_token_bd()) {
                        $msg_rtn = true;
                    }
                } else { //SOLO SE REALIZA VALIDACIÓN
                    $msg_rtn = true;
                }
            }
        }
        return $msg_rtn;
    }

    public function update_token_bd()
    {
        $get_token = $this->crudm->generate_token();
        $where = ["config_name" => "api_token"];
        $data = ["config_value" => $get_token];
        $this->db->update("configuracion_sistema", $data, $where);
        return true;
    }
}
