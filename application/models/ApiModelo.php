<?php

    class ApiModelo extends CI_Model{

        function __construct()
        {
            parent::__construct();
        }

        function fetch_all(){
            $query = 'select * from alumno';
    
            $resultado = $this->db->query($query);
            return $resultado->result_array();
        }
    }

?>