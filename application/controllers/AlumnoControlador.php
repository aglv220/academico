<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class AlumnoControlador extends UTP_Controller{

        public function __construct()
        {
            parent::__construct();	
            $this->load->model('CRUD_Modelo','crudm');
            date_default_timezone_set('America/lima');
        }

        function index(){
           $data = $this->crudm->listar_tabla("alumno");
           echo json_encode($data);
        }
    }