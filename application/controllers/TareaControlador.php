<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TareaControlador extends UTP_Controller {

    function __construct() {
		parent::__construct();
        $this->load->model('TareaModelo','tarea');
        date_default_timezone_set('America/lima');
	  }

    public function listarTipoActividad(){
      $data = $this->tarea->listarActividadXtipo();
      echo json_encode($data);
    }
    public function get_modal_edit_Tarea($pkActividad = null){
      $post = $this->input->post(); 
      $pkActividad = ($pkActividad == null) ? $post['pkActividad'] : $pkActividad;
      $data["estado"] = $this->tarea->estadoPizarra($pkActividad);
      $this->load->view('modales/modalEditTarea',$data);
    }
    public function guardar_estado_pizarra(){
        $id = $this->input->post("id");
        $estado = $this->input->post("estado");
        $this->tarea->guardar_estado_pizarra($id,$estado);
     
    }
}