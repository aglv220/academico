<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class AcademicoApi extends UTP_Controller{

        function __construct() {
            parent::__construct();
        }

        function index(){
            $this->action();
        }

        function action(){
            if($this->input->get('data_action') && $this->input->get('token') == $this->get_token()){
                $data_action = $this->input->get('data_action');
                if($data_action == 'listar_alumnos'){
                    $api_url = "http://localhost/academico/AlumnoControlador";

                    $client = curl_init($api_url);

                    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                    $reponse = curl_exec($client);
                    curl_close($client);
                    echo $reponse;
                }
            }
        }
    }

?>