<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioControlador extends UTP_Controller {

    function __construct() {
		parent::__construct();
        $this->load->library('session');		
        $this->load->model('UsuarioModelo','usuariom');
        $this->load->model('TareaModelo','tareamod');
        $this->load->model('ActividadExternaModelo','actexmod');
        date_default_timezone_set('America/lima');
	}

    public function pagina_principal()
    {        
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $data["tareas"] = $this->tareamod->listarCursos($idUser);
        $data["actividades"] = $this->actexmod->listarActividades($idUser);
        $data_header['title_page'] = 'Página principal';
        $this->cabecera_pagina($data_header);
        $this->load->view('dashboard',$data);
		$this->pie_pagina();
    }

    public function calendario()
    {        
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $data["tareas"] = $this->actexmod->listarCursosFueraCalendario($idUser);
        $data["tipos_actividades"] = $this->tareamod->listarActividadXtipo();
        
        $data_header['title_page'] = 'Calendario de Actividades';
        $this->cabecera_pagina($data_header);
        $this->load->view('actividades/calendar',$data);
		$this->load->view('base/footer'); 
    }

    public function pizarra()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Pizarra de Tareas';
        $this->cabecera_pagina($data_header);
        $this->load->view('tareas/board');
		$this->pie_pagina();
    }

    public function reporte_actividades()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Reporte de Actividades';
        $this->cabecera_pagina($data_header);
        $this->load->view('reportes/reporteActividades');
		$this->pie_pagina();
    }

    public function reporte_tareas()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Reporte de Tareas';
        $this->cabecera_pagina($data_header);
        $this->load->view('reportes/reporteTareas');
		$this->pie_pagina();
    }

    public function recuperar_password()
	{
        $this->is_loged_on();
        $data_header['title_page'] = 'Recuperar contraseña';
        $this->load->view('base/head',$data_header);
		$this->load->view('usuario/recuperar_password');
		$this->load->view('base/js');
	}
}