<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TareaControlador extends UTP_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('TareaModelo', 'tarea');
    $this->load->model('UsuarioModelo', 'userm');
    $this->load->model('NotificacionModelo', 'notifim');
    date_default_timezone_set('America/lima');
  }

  public function listarTipoActividad()
  {
    $data = $this->tarea->listarActividadXtipo();
    echo json_encode($data);
  }
  public function get_modal_edit_Tarea($pkActividad = null)
  {
    $post = $this->input->post();
    $pkActividad = ($pkActividad == null) ? $post['pkActividad'] : $pkActividad;
    $data["estado"] = $this->tarea->estadoPizarra($pkActividad);
    $this->load->view('modales/modalEditTarea', $data);
  }
  public function guardar_estado_pizarra()
  {
    $id = $this->input->post("id");
    $estado = $this->input->post("estado");
    $this->tarea->guardar_estado_pizarra($id, $estado);
    
    $asunto = "";
    $msg = "";
    $cfg_en = $this->valide_email_notification($this->get_SESSID(),"emailnotify_calendar_new",$asunto,$msg);
    
    $actividad = "";
    $nombre = "";
    $registrar_notificacion = $this->notifim->publicar_notificacion($this->get_SESSID(),$actividad,$nombre);
  }
}
