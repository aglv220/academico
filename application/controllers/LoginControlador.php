<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginControlador extends UTP_Controller {

    function __construct() {
		parent::__construct();
        $this->load->library('session');		
        $this->load->model('UsuarioModelo','usuariom');
        date_default_timezone_set('America/lima');
	}

    public function index()
	{
        $this->is_loged_on();
        $this->load->view('base/head');
		$this->load->view('login');
		$this->load->view('base/js');
	}

    public function iniciar_sesion()
    {
        $this->usuariom->correo = $this->input->post("usuario_correo");
        $this->usuariom->password = $this->input->post("usuario_clave");
        //$correo = $this->input->post("usuario_correo");
        //$password = $this->input->post("usuario_clave");
        $lst_login = $this->usuariom->inicio_sesion($this->usuariom->correo);
        $json_data = array();
        if (count($lst_login) > 0) {
            foreach ($lst_login as $row) {
                if (password_verify($this->usuariom->password, $row->password)){
                    $ROWDATA['SESSION_USUARIO'] = $row->correo;
                    array_push($json_data, $ROWDATA);
                    $this->session->set_userdata($ROWDATA);
                    echo json_encode(array("data" => $json_data));
                } else {
                    echo false;
                }                
            }
        } else {
            echo false;
        }
    }    

    public function cerrar_sesion()
    {
        if ($this->session->userdata('SESSION_USUARIO')) {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }
}