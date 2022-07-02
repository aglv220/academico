<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UTP_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->library('session');
        $this->load->config('email');
        $this->load->helper('url');
        $this->load->model('AuditoriaModelo', 'audmod');
    }

    public function get_SESSID(){
        return $this->session->userdata('SESSION_ID');
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

    public function enviar_email($destinatario,$asunto,$mensaje) {     
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

    public function llenar_select($lista,$slv="none"){
        $options_html = "";        
        foreach ($lista as $v) {
            $nom_carr = $v->carrera_nombre;
            $selected = "";
            if($slv == $nom_carr){
                $selected = "selected";
            }
            $options_html .= "<option value='".$nom_carr."' ".$selected.">".$nom_carr."</option>";
        }
        return $options_html;
    }

    public function is_loged_off()
    {
        if (!$this->session->userdata('SESSION_CORREO')) {
            //$this->audmod->registrar_evento_auditoria(5, $this->session->userdata('SESSION_ID'), 5, "Cierre de sesión", "La sesión del usuario ha expirado");
            redirect('/LoginControlador');
        }
    }

    public function is_loged_on()
    {
        if ($this->session->userdata('SESSION_CORREO')) {
            $this->audmod->registrar_evento_auditoria(5, $this->session->userdata('SESSION_ID'), 4, "Inicio de sesión", "La sesión del usuario aún se encuentra activa");
            redirect('/UsuarioControlador/pagina_principal');
        }
    }

    function fecha_y_hora(){
        return date('Y-m-d H:i:s');
    }

    function fecha(){
        return date('Y-m-d');
    }

    public function cabecera_pagina($data_header=""){
        $this->load->view('base/head',$data_header);
        $this->load->view('base/header');
    }

    public function pie_pagina(){
        $this->load->view('base/footer');
        $this->load->view('base/js');
    }

}