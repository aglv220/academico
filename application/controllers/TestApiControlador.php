<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TestApiControlador extends UTP_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    function index()
    {
        $this->pie_pagina();
        $this->load->view('ApiView');
        $this->load->library('ci_pusher');
    }

    public function prueba_pusher()
    {
        // Load the library.
        $pusher = $this->ci_pusher->get_pusher();
        // Set message
        $data['message'] = 'This message was sent at ' . date('Y-m-d H:i:s');
        // Send message
        $pusher->trigger('canal-notificaciones', 'register-n', $data);
        /*if ($event === TRUE) {
            echo 'Event triggered successfully!';
        } else {
            echo 'Ouch, something happend. Could not trigger event.';
        }*/
        $this->load->view('test/test');
        $this->load->view('base/js');
    }

    function action()
    {
        if ($this->input->post('data_action')) {
            $data_action = $this->input->post('data_action');

            if ($data_action == 'fetch_all') {
                $api_url = "http://localhost/academico/ApiControlador";

                $client = curl_init($api_url);

                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $reponse = curl_exec($client);
                curl_close($client);

                $result = json_decode($reponse);
                $output = '';

                if (count($result) > 0) {
                    $indice = 1;
                    foreach ($result as $row) {
                        $output .= '
                                <tr>
                                    <td>' . $indice . '</td>
                                    <td>' . $row->nombres . '</td>
                                    <td>' . $row->apellidos . '</td>
                                    <td>' . $row->carrera . '</td>
                                </tr>
                            ';
                        $indice++;
                    }
                } else {
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
