<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class ApiControlador extends UTP_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->load->model('ApiModelo');
        }

        function index(){
           $data = $this->ApiModelo->fetch_all();
           echo json_encode($data);
        }
    }