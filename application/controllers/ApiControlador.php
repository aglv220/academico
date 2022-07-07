<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ApiControlador extends UTP_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiModelo', 'apim');
        $this->load->model('CursoModelo', 'cursom');
        $this->load->model('TareaModelo', 'taream');
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    function index()
    {
        $data = $this->apim->fetch_all();
        echo json_encode($data);
    }

    function obtener_token()
    {
        $result = ["token" => "ERROR"];
        $usuario = $this->input->get("usuario");
        $password = $this->input->get("password");
        if ($usuario != null && $password != null) {
            $validar_credenciales = $this->apim->validate_credentials($usuario, $password, false);
            if ($validar_credenciales) {
                $where_v = [["campo" => "config_name", "valor" => "api_token"]];
                $token = $this->crudm->listar_campo_tabla_xcond("configuracion_sistema", "config_value", $where_v);
                $result = ["token" => $token];
            }
        }
        echo json_encode($result);
    }

    function actualizar_token()
    {
        $msg_resp = "ERROR";
        $usuario = $this->input->get("usuario");
        $password = $this->input->get("password");
        if ($usuario != null && $password != null) {
            $validar_credenciales = $this->apim->validate_credentials($usuario, $password);
            $msg_resp = $validar_credenciales == true ? "TOKEN ACTUALIZADO" : "ERROR";
        }
        echo $msg_resp;
    }

    function web_scrapping() //$correo, $password, $fase, $token, $iduser = false
    {
        //$correo = $this->input->post("usuario_correo");
        //$pass = $this->input->post("usuario_clave");
        $token = $this->input->get("token");
        $url_ws = "http://web-scrapping.empiresoftgroup.online/?token=".$token;

        $data_ws = json_decode(file_get_contents($url_ws), true);
        print_r($data_ws);
        /*switch ($fase) {
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
        }*/
    }
}
