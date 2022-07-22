<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificacionControlador extends UTP_Controller
{
    public $modsis = 5;

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->library('session');
        $this->load->model('NotificacionModelo', 'notifim');
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function registrar_notificacion()
    {
        $actividad = 211;
        $nombre = 'PRUEBA - Notificación de prueba';
        $estado = 0;
        $id_user = $this->get_SESSID();
        $insertar_notificacion = $this->notifim->insertar_notificacion($actividad, $nombre, $estado);
        if ($insertar_notificacion) {
            $this->notifim->obtener_notificaciones($id_user, "0", false, true);
            return true;
        } else {
            return false;
        }
    }

    public function actualizar_estado_notificacion()
    {
        $id_user = $this->get_SESSID();
        $ID_notify = $this->decript_data($this->input->post("ID_notify"));        
        $update_notify = $this->notifim->actualizar_estado_notificacion($ID_notify, 1);
        if ($update_notify) {
            $only_update = true;
            $this->notifim->obtener_notificaciones($id_user, "0", false, true, $only_update);
        } else {
            echo "NONE";
        }
    }

    public function actualizar_estado_notificaciones()
    {
        $id_user = $this->get_SESSID();
        $status = $this->notifim->actualizar_estado_notificaciones($id_user, "1");
        if($status){
            $this->notifim->obtener_notificaciones($id_user, "0", false, true);
        }
    }

    public function listar_notificaciones_actualizadas()
    {
        $id_user = $this->get_SESSID();
        $this->notifim->obtener_notificaciones($id_user, "0", false, true);
    }
}
