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
            redirect('iniciar_sesion');
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

    public function pie_pagina()
    {
        $this->load->view('base/footer');
        $this->load->view('base/js');
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
