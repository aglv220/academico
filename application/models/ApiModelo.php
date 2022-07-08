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

    public function get_credentials()
    {
        $msg_rtn = [];
        $listar_config_sis = $this->crudm->listar_tabla("configuracion_sistema");
        if (count($listar_config_sis) > 0) {
            $bd_user = $listar_config_sis[1]->config_value;
            $bd_pass = $listar_config_sis[2]->config_value;
            array_push($msg_rtn, $bd_user, $bd_pass);
        }
        return json_encode($msg_rtn);
    }

    public function validate_credentials($user, $pass, $update, $passhash = false)
    {
        $msg_rtn = false;
        $listar_config_sis = $this->crudm->listar_tabla("configuracion_sistema");
        if (count($listar_config_sis) > 0) {
            $bd_user = $listar_config_sis[1]->config_value;
            $bd_pass = $listar_config_sis[2]->config_value;
            if ($passhash) {
                if (strcmp($bd_user, $user) == 0 && strcmp($pass, $bd_pass) == 0) {
                    $msg_rtn = true;
                }
            } else {
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

    function web_scrapping($correo, $password, $fase, $token, $iduser = false)
    {
        //$correo = $this->input->post("usuario_correo");
        //$pass = $this->input->post("usuario_clave");
        //$token = $this->input->get("token");
        $url_ws = "http://web-scrapping.empiresoftgroup.online/?token=" . $token;

        $data_ws = json_decode(file_get_contents($url_ws), true);
        print_r($data_ws);
        switch ($fase) {
            case 'VALIDACION':
                foreach ($data_ws as $key => $value) {
                    $user_api = $value["username"];
                    $pass_api = $value["password"];
                    if (strcmp($pass_api, $password) == 0 && strcmp($correo, $user_api) == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
                break;
            case 'REGISTRO':
                //print_r($data_ws);
                foreach ($data_ws as $key => $value) {
                    foreach ($value["courses"] as $kc => $vc) {
                        $nombre_curso = $kc;
                        //INSERTAR CURSO
                        $insert_curso = $this->cursom->guardar_curso($nombre_curso);
                        if ($insert_curso > 0) {
                            //INSERTAR CURSO USUARIO
                            $insert_curso_user = $this->cursom->guardar_usuario_curso($insert_curso, $iduser);
                            if ($insert_curso_user > 0) {
                                foreach ($vc as $ka => $va) {
                                    $nom_act = $va["actividad"];
                                    $des_act = $va["des_actividad"];
                                    $fec_act = $va["fecha"];
                                    //INSERTAR ACTIVIDAD
                                    $insert_actividad = $this->taream->guardar_actividad($iduser, $nom_act, $des_act, $fec_act);
                                    //INSERTAR ACTIVIDAD USUARIO
                                    $insert_actividad_user = $this->taream->guardar_actividad_usuario($insert_actividad, $insert_curso);
                                }
                            }
                        }
                    }
                    //echo $data_ws; 
                }
                break;
        }
    }
}
