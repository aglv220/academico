<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UTP_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->library('session');
        $this->load->config('email');
        $this->load->helper('url');
        $this->load->model('AuditoriaModelo', 'audmod');
        $this->load->model('NotificacionModelo', 'notifim');
        $this->load->model('UsuarioModelo', 'userm');
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function get_SESSID()
    {
        return $this->session->userdata('SESSION_ID');
    }

    public function get_token()
    {
        return base64_encode("UTP2022_INTEGRADOR2");
    }

    public function generar_codigo_recuperacion($valor)
    {
        $invertir_cod = strrev(strtolower($valor));
        $hora = date('His');
        $fecha = date_timestamp_get(date_create());
        $cadena = rand(1681, 19175) . $invertir_cod . $hora . $fecha;
        $encode_1 = base64_encode($cadena);
        return $encode_1;
    }

    public function enviar_email($destinatario, $asunto, $mensaje)
    {
        $from = $this->config->item('smtp_user');
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Sistema de Actividades académicas');
        $this->email->to($destinatario);
        $this->email->subject($asunto);
        $this->email->message($mensaje);

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function valide_email_notification($userID, $config, $asunto, $msg)
    {
        $config_user = $this->crudm->listar_tabla_xcampo('configuracion_usuario', [["campo" => "fk_usuario", "valor" => $userID]]);
        if (count($config_user) > 0) {
            if ($config_user[$config] == 1) {
                $lst_user = $this->userm->inicio_sesion($userID, "pk_usuario");
                $asunto = "";
                $msg = "";
                $send_mail = $this->enviar_email($lst_user->usuario_correo, $asunto, $msg);
                return $send_mail;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function llenar_select($lista, $slv = "none")
    {
        $options_html = "";
        foreach ($lista as $v) {
            $nom_carr = $v->carrera_nombre;
            $selected = "";
            if ($slv == $nom_carr) {
                $selected = "selected";
            }
            $options_html .= "<option value='" . $nom_carr . "' " . $selected . ">" . $nom_carr . "</option>";
        }
        return $options_html;
    }

    public function is_loged_off()
    {
        if (!$this->session->userdata('SESSION_CORREO')) {
            //$this->audmod->registrar_evento_auditoria(5, $this->session->userdata('SESSION_ID'), 5, "Cierre de sesión", "La sesión del usuario ha expirado");
            redirect('inicio-sesion');
        }
    }

    public function is_loged_on()
    {
        if ($this->session->userdata('SESSION_CORREO')) {
            $this->audmod->registrar_evento_auditoria(5, $this->session->userdata('SESSION_ID'), 4, "Inicio de sesión", "La sesión del usuario aún se encuentra activa");
            redirect('pagina_principal');
        }
    }

    function fecha_y_hora()
    {
        return date('Y-m-d H:i:s');
    }

    function fecha()
    {
        return date('Y-m-d');
    }

    public function cabecera_pagina($data_header = "")
    {
        $get_lst_notify_pending = $this->notifim->obtener_notificaciones($this->get_SESSID(), "0", false, false);
        $data_nf['data_notify'] = $get_lst_notify_pending;
        $this->load->view('base/head', $data_header);
        $this->load->view('base/header', $data_nf);
    }

    public function include_js()
    {
        $nombre_archivo = "";
        $carpeta_archivo = "";
        $is_pagina_registro = false;
        $url = explode("/", current_url());
        if (isset($url[6])) { //SI ES LA PAGINA DE REGISTO - URL PERSONALIZADA
            $is_pagina_registro = $url[6] == "v_datos_personales" ? true : false;
            if ($is_pagina_registro) { //ES PÁGINA DE REGISTRO - LLENADO DE DATOS
                $nombre_archivo = "registro";
                $carpeta_archivo = "registro/";
            }
        }
        if ($is_pagina_registro == false) {
            if (isset($url[5])) { //SI ES CUALQUIER OTRA PAGINA DEL PROYECTO
                $nombre_archivo = $url[5];
                switch ($url[5]) {
                    case 'inicio-sesion':
                        $carpeta_archivo = "usuario/";
                        break;
                    default:
                        $carpeta_archivo = $nombre_archivo . "/";
                        break;
                }
            } else { //SI ES LA PÁGINA RAIZ DEL PROYECTO
                $nombre_archivo = "inicio-sesion";
                $carpeta_archivo = "usuario/";
            }
        }
        $file_js = "funciones-" . $nombre_archivo . ".js";
        $assets_js = "assets/functions-js/";
        $ruta_file_js = base_url() . $assets_js . $carpeta_archivo . $file_js;
        //echo $ruta_file_js;
        //RUTA RELATIVA DEL ARCHIVO
        $url_sistema = explode("/", $_SERVER["REQUEST_URI"]);
        $ruta_rel_file = $_SERVER["DOCUMENT_ROOT"] . "/" . $url_sistema[1] . "/" . $assets_js .  $carpeta_archivo . $file_js;
        //VALIDAR SI ARCHIVO JS EXISTE
        $script_file = "";
        if (file_exists($ruta_rel_file)) {
            $script_file = '<script src="' . $ruta_file_js . '"></script>'; //type="module"
        }

        $data_js["footer_validar_page"] = $is_pagina_registro;
        $data_js["footer_script_file"] = $script_file;
        //CARGAR EL ARCHIVO JS
        $this->load->view('base/js', $data_js);
    }

    public function pie_pagina()
    {
        $this->load->view('base/footer');
        $this->include_js();
    }

    public function encript_data($DATA)
    {
        $fase_1 = strrev($DATA);
        $fase_2 = convert_uuencode($fase_1);
        $fase_3 = base64_encode($fase_2);
        $fase_4 = strrev($fase_3);
        return $fase_4;
    }

    public function decript_data($DATA)
    {
        $fase_1 = strrev($DATA);
        $fase_2 = base64_decode($fase_1);
        $fase_3 = convert_uudecode($fase_2);
        $fase_4 = strrev($fase_3);
        return $fase_4;
    }
}
