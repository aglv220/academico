<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UTP_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->library('session');
        $this->load->config('email');
        $this->load->helper('url');
    }

    public function get_token(){
        return base64_encode("UTP2022_INTEGRADOR2");
    }

    public function generar_codigo_recuperacion($valor){
        $invertir_cod = strrev(strtolower($valor));
        $hora = date('His');
        $fecha = date_timestamp_get(date_create());
        $cadena = rand(1681,19175) . $invertir_cod . $hora . $fecha;
        $encode_1 = base64_encode($cadena);
        return $encode_1;
    }

    function enviar_email($destinatario,$asunto,$mensaje) {     
        $from = $this->config->item('smtp_user');
        $this->email->set_newline("\r\n");
        $this->email->from($from,'Sistema de Actividades académicas');
        $this->email->to($destinatario);
        $this->email->subject($asunto);
        $this->email->message($mensaje);

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function is_loged_off()
    {
        if (!$this->session->userdata('SESSION_CORREO')) {
            redirect('/LoginControlador');
        }
    }

    public function is_loged_on()
    {
        if ($this->session->userdata('SESSION_CORREO')) {
            redirect('/UsuarioControlador/pagina_principal');
        }
    }

    function fecha_y_hora(){
        return date('Y-m-d H:i:s');
    }


    function fecha(){
        return date('Y-m-d');
    }

    public function cabecera_pagina(){
        $this->load->view('base/head');
        $this->load->view('base/header');
    }

    public function pie_pagina(){
        $this->load->view('base/footer');
        $this->load->view('base/js');
    }

}