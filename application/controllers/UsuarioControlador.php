<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuarioControlador extends UTP_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('UsuarioModelo', 'usuariom');
        $this->load->model('TareaModelo', 'tareamod');
        $this->load->model('ActividadExternaModelo', 'actexmod');
        $this->load->model('CRUD_Modelo', 'crudm');
        date_default_timezone_set('America/lima');
    }

    public function actualizar_perfil_personal()
    {
        $msg_error = "";
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $nombre = trim($this->input->post("usuario_nombre"));
        $apellidos = trim($this->input->post("usuario_apellidos"));
        $celular = $this->input->post("usuario_celular");
        $fec_nac = $this->input->post("usuario_fecnac");
        $carrera = $this->input->post("usuario_carrera");
        $ciclo = $this->input->post("usuario_ciclo");



        $where_data_a = array("fk_usuario" => $idUser);
        $data_alumno = array('alumno_nombre' => $nombre, 'alumno_apellidos' => $apellidos, 'alumno_carrera' => $carrera, 'alumno_ciclo' => $ciclo, 'alumno_celular' => $celular, 'alumno_fecnac' => $fec_nac);
        if ($this->input->post("usuario_newpass")) {
            $new_pass = $this->input->post("usuario_newpass");
            $where_data_u = array("pk_usuario" => $idUser);
            $data_user = array('usuario_password' => password_hash($new_pass, PASSWORD_DEFAULT));
            if (strlen($new_pass) >= 8) {
                $this->crudm->actualizar_data($where_data_u, $data_user, 'usuario');
            } else {
                $msg_error = "ERROR_PASS_SHORT";
            }
        }
        $actualizar_alumno = $this->crudm->actualizar_data($where_data_a, $data_alumno, 'alumno');
        if ($msg_error == "") {
            switch ($actualizar_alumno) {
                case true:
                    $msg_error = "OK_SUCCESS";
                    break;
                case false:
                    $msg_error = "ERROR_NO_CHANGES";
                    break;
            }
        }
        echo $msg_error;
    }

    public function pagina_principal()
    {
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $data["tareas"] = $this->tareamod->listarCursos($idUser);
        $data["actividades"] = $this->actexmod->listarActividades($idUser);
        $data_header['title_page'] = 'Página principal';
        $this->cabecera_pagina($data_header);
        $this->load->view('dashboard', $data);
        $this->pie_pagina();
    }

    public function perfil_usuario()
    {
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $lst_data_usuario = $this->usuariom->inicio_sesion($idUser, "pk_usuario")[0];
        $carrera_usuario = $lst_data_usuario->alumno_carrera;
        $data["info_usuario"] = $lst_data_usuario;
        $data['lst_carreras'] = $this->llenar_select($this->crudm->listar_tabla('carrera'), $carrera_usuario);
        $data_header['title_page'] = 'Perfil de usuario';
        $this->cabecera_pagina($data_header);
        $this->load->view('usuario/perfil_usuario', $data);
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
		$this->pie_pagina();
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
        $this->load->view('base/head', $data_header);
        $this->load->view('usuario/recuperar_password');
        $this->load->view('base/js');
    }
}
