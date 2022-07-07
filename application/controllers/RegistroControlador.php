<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistroControlador extends UTP_Controller {

    function __construct() {
		parent::__construct();
        $this->load->library('session');		
        $this->load->model('UsuarioModelo','usuariom');
        $this->load->model('AlumnoModelo','alumnom');
        $this->load->model('CRUD_Modelo','crudm');
        date_default_timezone_set('America/lima');
	}

    public function index()
	{
        $this->is_loged_on();
        $this->load->view('base/head');
		$this->load->view('usuario/registro_validacion');
		$this->include_js();
	}

    public function v_datos_personales()
    {
        $this->is_loged_on();
        if($this->input->get('datoalumn')){
            $correo_alumno = base64_decode($this->input->get('datoalumn'));
            $campos = [ ["campo" => "usuario_correo", "valor"=> $correo_alumno] ];
            $usuario_id = $this->crudm->listar_campo_tabla_xcond('usuario','pk_usuario',$campos);
            $data_usuario['ID_USUARIO'] = base64_encode($usuario_id);
            $data_usuario['LST_CARRERAS'] = $this->llenar_select($this->crudm->listar_tabla('carrera'));            
        }
        
        $this->load->view('base/head');
		$this->load->view('usuario/registro_datos',$data_usuario);
		$this->include_js();
    }

    public function validar_registro() //PARTE 1 DEL REGISTRO
    {
        $this->usuariom->correo = $this->input->post("usuario_correo");
        $this->usuariom->password = $this->input->post("usuario_clave");
        $correo = $this->usuariom->correo;
        $pass = $this->usuariom->password;

        //AQUI SE HARÍA LA VALIDACIÓN DE CREDENCIALES CON WEB SCRAPPING

        //LUEGO SE PROCEDERÍA CON EL REGISTRO DEL ALUMNO
        $registrar_usuario = $this->usuariom->registrar_usuario($correo,$pass);        
        echo $registrar_usuario;
    }

    public function registrar_datos_personales()
    {
        $user_id = base64_decode($this->input->post("u_user"));
        $noms = trim($this->input->post("u_nombres"));
        $apes = trim($this->input->post("u_apellidos"));
        $carr = $this->input->post("u_carrera");
        $ciclo = $this->input->post("u_ciclo");
        $cod = trim($this->input->post("u_codigo"));
        $celu = $this->input->post("u_celular");
        $fnac = $this->input->post("u_fecnac");

        $registrar_alumno = $this->alumnom->registrar_alumno($user_id,$noms,$apes,$carr,$ciclo,"u".$cod,$celu,$fnac);
        if($registrar_alumno == "OK"){ //SI NO OCURRIO ERRORES AL REGISTRAR EL ALUMNO
            $lstuserxid = $this->usuariom->inicio_sesion($user_id,"pk_usuario");
            if (count($lstuserxid) > 0) {
                $where_data = array("pk_usuario" => $user_id);
                $data_user = array('usuario_regcomp' => 1);                
                $this->crudm->actualizar_data($where_data,$data_user,'usuario');
                foreach ($lstuserxid as $row) {
                    $ROWDATA['SESSION_CORREO'] = $row->usuario_correo;
                    $ROWDATA['SESSION_NOMBRES'] = $row->alumno_nombre;
                    $ROWDATA['SESSION_APELLIDOS'] = $row->alumno_apellidos;
                    $ROWDATA['SESSION_ID'] = $row->ID;
                    $this->session->set_userdata($ROWDATA);
                    //REGISTRAR INFORMACIÓN DE DATOS PERSONALES DEL USUARIO
                    $this->usuariom->establecer_configuracion($row->ID);
                }
            }
        }
        echo $registrar_alumno;             
    }
}