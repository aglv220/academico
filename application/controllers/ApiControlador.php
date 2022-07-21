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

        //CREDENCIALES VIENEN ENCRIPTADAS
        $encripted_login = $this->input->get("encriptedlogin") == null ? 0 : $this->input->get("encriptedlogin");
        //SEGURIDAD EN EL TOKEN
        $securetoken = $this->input->get("securetoken") == null ? 0 : $this->input->get("securetoken");

        if ($encripted_login == 1) {
            $usuario = $this->decript_data($this->input->get("usuario"));
            $password = $this->decript_data($this->input->get("password"));
        } else {
            $usuario = $this->input->get("usuario");
            $password = $this->input->get("password");
        }

        if ($usuario != null && $password != null) {
            //LA VARIABLE passhashed ES CUANDO PASS DE LA API ESTA PASANDO HASHEADA
            $hashedpass = $this->input->get("passhashed") == null ? 0 : $this->input->get("passhashed");
            //$pass_hash = $encode == true ? true : false;

            $validar_credenciales = $this->apim->validate_credentials($usuario, $password, false, $hashedpass); //PASHHASH ESTABA EN TRUE
            if ($validar_credenciales) {
                $where_v = [["campo" => "config_name", "valor" => "api_token"]];
                $token = $this->crudm->listar_campo_tabla_xcond("configuracion_sistema", "config_value", $where_v);
                if ($securetoken == 1) {
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
        //$decode = $this->input->get("decode") == null ? false : $this->input->get("decode");
        $correo = $this->input->get("correo");
        $pass = $this->input->get("clave");
        /*if($decode){
            $token = $this->decript_data($this->input->get("token"));
        } else {
            $token = $this->input->get("token");
        }*/
        $token = $this->input->get("token");

        $fase = $this->input->get("fase");
        $iduser = $this->input->get("iduser");

        //llamar al script de python
        $respuesta = $this->runScript();
        if ($respuesta == "ok") {
            switch ($fase) {
                case 'VALIDACION':
                    $new_pass_get = $this->decript_data($pass);
                    $registrar_usuario = $this->usuariom->registrar_usuario($correo, $new_pass_get, true);
                    if ($registrar_usuario == "EXIST") {
                        echo "EXIST";
                    } else {
                        echo $this->encript_data($registrar_usuario);
                    }
                    break;
                case 'REGISTRO':
                    $idusu_decript = $this->decript_data($iduser);

                    $data = @file_get_contents('canvas.json');
                    $items = json_decode($data, true);

                    $curso = array();
                    $detalle = array();
                    $fecha = array();
                    $cursos_id = array();

                    $array = array(
                        0 => array('mes' => 'enero', 'dia' => '01'), 1 => array('mes' => 'febrero', 'dia' => '02'), 2 => array('mes' => 'marzo', 'dia' => '03'), 3 => array('mes' => 'abril', 'dia' => '04'), 4 => array('mes' => 'mayo', 'dia' => '05'), 5 => array('mes' => 'junio', 'dia' => '06'), 6 => array('mes' => 'julio', 'dia' => '07'), 7 => array('mes' => 'agosto', 'dia' => '08'),
                        8 => array('mes' => 'setiembre', 'dia' => '09'), 9 => array('mes' => 'octubre', 'dia' => '10'), 10 => array('mes' => 'noviembre', 'dia' => '11'),
                        11 => array('mes' => 'diciembre', 'dia' => '12')
                    );

                    foreach ($items as $key) {
                        //acceder a los cursos
                        $partes = explode(";", $key);
                        //crear array de cursos
                        array_push($curso, $partes[0]);
                    }
                    $curso = array_unique($curso);

                    foreach($curso as $cur){
                        $insert_curso = $this->cursom->guardar_curso($cur);
                        array_push($id_curso,$insert_curso);
                    }

                    $contenido = str_replace($curso, $id_curso, $items);

                    foreach ($contenido as $value) {
                        $partes = explode(";", $value);
                        array_push($cursos_id, $partes[0]);
                        //acceder al detalle y a la fecha
                        $partes2 = explode(",", $partes[1]);
                        //crear array de detalle de tarea
                        array_push($detalle, $partes2[0]);

                        //array_push($fecha, $partes2[2]);
                        $fecha = explode(" ", $partes2[2]);
                        foreach ($array as $key) {
                            if (stristr($fecha[3], $key["mes"])) {
                                $mes = str_replace($key["mes"], $key["dia"], $fecha[3]);
                            }
                        }
                        //generar dataTime
                        $dia = $fecha[1];
                        $año = $fecha[5];
                        $hora = explode(".", $fecha[6]);
                        $dateTime = $año . "-" . $mes . "-" . $dia . " " . $hora[0];
                    }


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
                    if ($msg_return != false && $msg_return != 0) {
                        echo true;
                    } else {
                        echo false;
                    }
                    break;
            }
        }

        //$url_ws = "http://web-scrapping.empiresoftgroup.online/?token=" . $token;
        //$url_ws = "http://localhost/api-ws-canvas/?token=" . $token;

        /*$data_ws = json_decode(file_get_contents($url_ws), true);
        switch ($fase) {
            case 'VALIDACION':
                foreach ($data_ws as $key => $value) {
                    $user_api = $value["username"];
                    $pass_api = $value["password"];
                    /*$new_pass_get = $pass;
                    if($decode){
                        $new_pass_get = $this->decript_data($pass);
                    } else {
                        $new_pass_get = $pass;
                    }
                    $new_pass_get = $this->decript_data($pass);
                    if (strcmp($pass_api, $new_pass_get) == 0 && strcmp($correo, $user_api) == 0) { /* password_verify($new_pass_get, $pass_api) 
                        $registrar_usuario = $this->usuariom->registrar_usuario($correo, $pass, true);
                        if ($registrar_usuario == "EXIST") {
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
                if ($msg_return != false && $msg_return != 0) {
                    echo true;
                } else {
                    echo false;
                }
                break;
        }*/
    }
    function runScript()
    {
        $command = escapeshellcmd('python loginScrapp.py');
        $output = shell_exec($command);
        return $output;
    }
}
