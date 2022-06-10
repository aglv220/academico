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

}