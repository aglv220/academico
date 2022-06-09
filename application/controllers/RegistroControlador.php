<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistroControlador extends UTP_Controller {

    function __construct() {
		parent::__construct();
        $this->load->library('session');		
        $this->load->model('UsuarioModelo','usuariom');
        $this->load->model('CRUD_Modelo','crudm');
        date_default_timezone_set('America/lima');
	}

    public function index()
	{
        $this->is_loged_on();
        $this->load->view('base/head');
		$this->load->view('register');
		$this->load->view('base/js');
	}

    public function v_datos_personales()
    {
        $this->is_loged_on();
        if($this->input->get('datoalumn')){
            $correo_alumno = base64_decode($this->input->get('datoalumn'));
            $campos = [ ["campo" => "correo", "valor"=> $correo_alumno] ];
            $usuario_id = $this->crudm->listar_campo_tabla_xcond('usuario','ID',$campos);
            $data_usuario['ID_USUARIO'] = base64_encode($usuario_id);
        }
        
        $this->load->view('base/head');
		$this->load->view('register2',$data_usuario);
		$this->load->view('base/js');
    }

    public function validar_registro()
    {
        $this->usuariom->correo = $this->input->post("usuario_correo");
        $this->usuariom->password = $this->input->post("usuario_clave");
        $correo = $this->usuariom->correo;
        $pass = $this->usuariom->password;

        $registrar_usuario = $this->usuariom->registrar_usuario($correo,$pass);        
        echo $registrar_usuario;
    }

    public function registrar_datos_personales()
    {
        $user = base64_decode($this->input->post("u_user"));
        $noms = $this->input->post("u_nombres");
        $apes = $this->input->post("u_apellidos");
        $carr = $this->input->post("u_carrera");
        $ciclo = $this->input->post("u_ciclo");
        $cod = $this->input->post("u_codigo");
        $celu = $this->input->post("u_celular");
        $fnac = $this->input->post("u_fecnac");

        $registrar_alumno = $this->usuariom->registrar_alumno($user,$noms,$apes,$carr,$ciclo,$cod,$celu,$fnac);
        echo $registrar_alumno;
    }
}