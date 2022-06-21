<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class TestApiControlador extends UTP_Controller{

        function index(){
            $this->pie_pagina();
            $this->load->view('ApiView');
        }

        function action(){
            if($this->input->post('data_action')){
                $data_action = $this->input->post('data_action');

                if($data_action == 'fetch_all'){
                    $api_url = "http://localhost/academico/ApiControlador";

                    $client = curl_init($api_url);

                    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                    $reponse = curl_exec($client);
                    curl_close($client);

                    $result = json_decode($reponse);
                    $output = '';

                    if(count($result) > 0){
                        $indice = 1;
                        foreach($result as $row){
                            $output .= '
                                <tr>
                                    <td>'.$indice.'</td>
                                    <td>'.$row->nombres.'</td>
                                    <td>'.$row->apellidos.'</td>
                                    <td>'.$row->carrera.'</td>
                                </tr>
                            ';
                            $indice++;
                        }
                    }else{
                        $output .= '
                        <tr>
                            <td>Error</td>
                        </tr> 
                        ';
                    }
                    echo $output;
                }
            }
        }
    }

?>