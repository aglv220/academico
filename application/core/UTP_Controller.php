<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UTP_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function get_token(){
        return base64_encode("UTP2022_INTEGRADOR2");
    }

    public function is_loged_off()
    {
        if (!$this->session->userdata('SESSION_CORREO')) {
            redirect('/Logincontrolador');
        }
    }

    public function is_loged_on()
    {
        if ($this->session->userdata('SESSION_CORREO')) {
            redirect('/Usuariocontrolador/pagina_principal');
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