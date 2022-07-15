<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ApiControlador extends UTP_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiModelo', 'apim');
        $this->load->model('UsuarioModelo', 'usuariom');
        $this->load->model('CursoModelo', 'cursom');
        $this->load->model('TareaModelo', 'taream');
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    function index()
    {
        $data = $this->apim->fetch_all();
        echo json_encode($data);
    }

    //OBTENER TOKEN PARA LEER EL API
    function obtener_token()
    {
        $result = ["token" => "ERROR"];
        $encode = $this->input->get("encode") == null ? false : $this->input->get("encode");
        if ($encode) {
            $usuario = $this->decript_data($this->input->get("usuario"));
            $password = $this->decript_data($this->input->get("password"));
        } else {
            $usuario = $this->input->get("usuario");
            $password = $this->input->get("password");
        }
        
        if ($usuario != null && $password != null) {
            //PASSHASH => FALSE | el password no esta pasando hasheada
            //LA VARIABLE ENCODE ES CUANDO EL USER Y PASS DE LA API ESTA PASANDO ENCRIPTADA
            $pass_hash = $encode == true ? true : false;
            $validar_credenciales = $this->apim->validate_credentials($usuario, $password, false, $pass_hash); //PASHHASH ESTABA EN TRUE
            if ($validar_credenciales) {
                $where_v = [["campo" => "config_name", "valor" => "api_token"]];
                $token = $this->crudm->listar_campo_tabla_xcond("configuracion_sistema", "config_value", $where_v);
                if ($encode) {
                    $token_final = $this->encript_data($token);
                } else {
                    $token_final = $token;
                }
                $result = ["token" => $token_final];
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
            $validar_credenciales = $this->apim->validate_credentials($usuario, $password, true);
            $msg_resp = $validar_credenciales == true ? "TOKEN ACTUALIZADO" : "ERROR";
        }
        echo $msg_resp;
    }

    function web_scrapping()
    {
        $decode = $this->input->get("decode") == null ? false : $this->input->get("decode");
        $correo = $this->input->get("correo");
        $pass = $this->input->get("clave");
        if($decode){
            $token = $this->decript_data($this->input->get("token"));
        } else {
            $token = $this->input->get("token");
        }
        $fase = $this->input->get("fase");
        $iduser = $this->input->get("iduser");

        $url_ws = "http://web-scrapping.empiresoftgroup.online/?token=" . $token;
        //GET INFO DE TOKEN - LOCALHOST
        //$url_ws = "http://localhost/api-ws-canvas/?token=" . $token;

        $data_ws = json_decode(file_get_contents($url_ws), true);
        switch ($fase) {
            case 'VALIDACION':
                foreach ($data_ws as $key => $value) {
                    $user_api = $value["username"];
                    $pass_api = $value["password"];
                    $new_pass_get = $pass;
                    if($decode){
                        $new_pass_get = $this->decript_data($pass);
                    } else {
                        $new_pass_get = $pass;
                    }
                    if (strcmp($pass_api, $new_pass_get) == 0 && strcmp($correo, $user_api) == 0) {
                        $registrar_usuario = $this->usuariom->registrar_usuario($correo, $pass, true);
                        if($registrar_usuario == "EXIST"){
                            echo "EXIST";
                        } else {
                            echo $this->encript_data($registrar_usuario);
                        }
                    } else {
                        echo false;
                    }                  
                }
                break;
            case 'REGISTRO':
                $idusu_decript = $this->decript_data($iduser);
                foreach ($data_ws as $key => $value) {
                    foreach ($value["courses"] as $kc => $vc) {
                        $nombre_curso = $kc;
                        //INSERTAR CURSO
                        $insert_curso = $this->cursom->guardar_curso($nombre_curso);
                        $msg_return = false;
                        if ($insert_curso > 0) {
                            //INSERTAR CURSO USUARIO
                            $insert_curso_user = $this->cursom->guardar_usuario_curso($insert_curso, $idusu_decript);
                            if ($insert_curso_user > 0) {
                                foreach ($vc as $ka => $va) {
                                    $nom_act = $va["actividad"];
                                    $des_act = $va["des_actividad"];
                                    $fec_act = $va["fecha"];
                                    //INSERTAR ACTIVIDAD
                                    $insert_actividad = $this->taream->guardar_actividad($idusu_decript, $nom_act, $des_act, $fec_act);
                                    //INSERTAR ACTIVIDAD USUARIO
                                    $insert_actividad_user = $this->taream->guardar_actividad_usuario($insert_actividad, $insert_curso);
                                    $msg_return = $insert_actividad_user;
                                }
                            }
                        }
                    }
                }
                if($msg_return != false && $msg_return != 0){
                    echo true;
                } else {
                    echo false;
                }
                break;
        }
    }
}
