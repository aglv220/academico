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

    function crear_txt($contenido, $tipo)
    {
        $ruta_file = 'credentials/' . $tipo . '.txt';
        if (file_exists($ruta_file)) {
            unlink($ruta_file);
        }
        $archivo = fopen($ruta_file, 'a');
        $encript_content = $this->encript_value($contenido);
        fputs($archivo, $encript_content);
        fclose($archivo);
    }

    function delete_txt($tipo)
    {
        $ruta_file = 'credentials/' . $tipo . '.txt';
        if (file_exists($ruta_file)) {
            unlink($ruta_file);
        }
    }

    function web_scrapping()
    {
        if ($this->session->userdata('SESSION_CORREO')) {
            $correo = $this->session->userdata('SESSION_CORREO');
            $iduser = $this->encript_data($this->session->userdata('SESSION_ID'));
            $new_pass_get = $this->input->get("clave");
        } else {
            $correo = $this->input->get("correo");
            $iduser = $this->input->get("iduser");
            $pass = $this->input->get("clave");
            $new_pass_get = $this->decript_data($pass);
        }
        $fase = $this->input->get("fase");
        //$token = $this->input->get("token");

        $this->crear_txt($new_pass_get, "password");
        $this->crear_txt($correo, "email");

        //llamar al script de python
        $respuesta = $this->runScript();
        if ($respuesta == "ok") {
            switch ($fase) {
                case 'VALIDACION':
                    $registrar_usuario = $this->usuariom->registrar_usuario($correo, $new_pass_get, true);
                    if ($registrar_usuario == "EXIST") {
                        echo "EXIST";
                    } else {
                        echo $this->encript_data($registrar_usuario);
                    }
                    break;
                case 'REGISTRO':
                    //ELIMINAR TXT DE USUARIO Y PASSWORD DESPUES DE VALIDAR
                    $this->delete_txt("password");
                    $this->delete_txt("email");
                    $idusu_decript = $this->decript_data($iduser);
                    $data = @file_get_contents('canvas/canvas.json');
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

                    $id_curso = [];

                    foreach ($curso as $cur) {
                        $insert_curso = $this->cursom->guardar_curso($cur);
                        $insert_curso_user = $this->cursom->guardar_usuario_curso($insert_curso, $idusu_decript);
                        array_push($id_curso, $insert_curso_user);
                    }
                    $datos_unique = array_unique($items);
                    $contenido = str_replace($curso, $id_curso, $datos_unique);

                    foreach ($contenido as $value) {
                        $partes = explode(";", $value);
                        array_push($cursos_id, $partes[0]);
                        //acceder al detalle y a la fecha
                        $partes2 = explode(",", $partes[1]);

                        $actividad = explode("-", $partes2[0]);
                        $nombre = $actividad[0];
                        $detalle = array_key_exists(1, $actividad) == 1 ?  $actividad[1] : "";

                        $fechaI = array_key_exists(2, $partes2) == 1 ?  $partes2[2] : $partes2[1];
                        $fecha = explode(" ", $fechaI);
                        // $fecha = explode(" ", $partes2[2]);
                        foreach ($array as $key) {
                            if (stristr($fecha[3], $key["mes"])) {
                                $mes = str_replace($key["mes"], $key["dia"], $fecha[3]);
                            }
                        }
                        //generar dataTime
                        $dia = $fecha[1];
                        $año = $fecha[5];
                        $hora = explode(".", $fecha[6]);
                        $dateTime = $año . "-" . $mes . "-" . $dia . " " . $hora[0] . ":00";

                        $IDcurso = $partes[0];

                        //INSERTAR ACTIVIDAD
                        $insert_actividad = $this->taream->guardar_actividad($idusu_decript, $nombre, $detalle, $dateTime);
                        //$this->taream->guardar_actividad($idusu_decript, $nombre, $detalle, $dateTime, $partes[0]);

                        //INSERTAR ACTIVIDAD USUARIO
                        $insert_actividad_user = $this->taream->guardar_actividad_usuario($insert_actividad, $partes[0]);
                        $msg_return = $insert_actividad_user;
                    }

                    if ($msg_return != false && $msg_return != 0) {
                        echo true;
                    } else {
                        echo false;
                    }
                    break;
            }
        } else {
            $this->delete_txt("password");
            $this->delete_txt("email");
            echo false;
        }
    }
    function runScript()
    {
        $command = escapeshellcmd('C:/Users/Yuri/AppData/Local/Programs/Python/Python310/python.exe c:/laragon/www/academico/loginScrapp.py');
        $output = shell_exec($command);
        if (!empty($output)) {
            return "ok";
        } else {
            return "error";
        }
    }
}
