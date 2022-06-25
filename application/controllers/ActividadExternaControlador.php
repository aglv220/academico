<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActividadExternaControlador extends UTP_Controller {

    function __construct() {
		parent::__construct();
        $this->load->model('ActividadExternaModelo','actextmodelo');
        $this->load->model('TareaModelo','tareamodelo');
        date_default_timezone_set('America/lima');
    }
    
    public function agregarCalendario(){
        $id = $this->input->post("id");
        $fecha = $this->input->post("fecha");
        
        //matriz de meses
        $array = array(0 => array('mes' => 'Jan','dia' => '01'),1 => array('mes' => 'Feb','dia' => '02'),2 => array('mes' => 'Mar','dia' => '03'),3 => array('mes' => 'Apr','dia' => '04'),4 => array('mes' => 'May','dia' => '05'),5 => array('mes' => 'Jun','dia' => '06'),6 => array('mes' => 'Jul','dia' => '07'),7 => array('mes' => 'Aug','dia' => '08'),
        8 => array('mes' => 'Sep','dia' => '09'),9 => array('mes' => 'Oct','dia' => '10'),10 => array('mes' => 'Nov','dia' => '11'),
        11 => array('mes' => 'Dec','dia' => '12'));
        
        //armar la fecha en el formato de la bd
        foreach($array as $key){
            if(stristr($fecha, $key["mes"])){
                $valor = explode($key['mes'],$fecha);
                //quitar espacios en blanco
                $mesNombre = explode(" ",$valor[0]);
                $numero = $key["dia"];
            }
        }
        //obtner dia 
        $dia = substr($fecha,8,2);
        $dia = $dia + 1;
        //obtener año
        $año = substr($fecha,11,4);
        //obtener la hora 
        $hora = substr($fecha,15,9);

        $fechaFormateada = $año."-".$numero."-".$dia." ".$hora;

        //cambiar el estado en pizzarra
        $this->actextmodelo->asignarActividadCalendario($id);

        //consultar id de la actividad 
        $idActvidad = $this->actextmodelo->consultarIdActividad($id);
        
        foreach($idActvidad as $key){
            $idActvidad = $key["fk_actividad"];
        }
        
        //asignar fecha
        $this->actextmodelo->asignarfechaActividad($idActvidad,$fechaFormateada);
    }

    public function llenarCalendario(){
        $idUser = $this->session->userdata('SESSION_ID');
        $dataActividad = $this->actextmodelo->listarActividadesalCalendario($idUser);
        $dataTareas = $this->tareamodelo->listarTareasalCalendario($idUser);
        $data = array_merge($dataActividad,$dataTareas);
        echo json_encode($data);
    }

    public function crearActividad(){
        $idUser = $this->session->userdata('SESSION_ID');

        //crear Actividad 
        $nombre = $this->input->post("nombre");
        $tipo = $this->input->post("tipoActividad");
        $fecha = $this->input->post("fecha");
        $hora = $this->input->post("hora");
        $descrip = $this->input->post("descrip");
        $estado = $this->input->post("estado");
        $fechaDisp = $fecha." ".$hora;  
        $idTabla = $this->actextmodelo->crearActividad($tipo,$idUser,$nombre,$descrip,$fechaDisp);
        $this->actextmodelo->insertarUsuarioActividadExterna($idTabla, $estado);
    }
}