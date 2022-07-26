<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TareaControlador extends UTP_Controller
{
  public $modsis = 2;

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
    //$this->notifim->insertar_notificacion($id, $estado, 0);
    switch ($estado) {
      case "0":
        $cadena = "en pausa";
        break;
      case "1":
        $cadena = "en progreso";
        break;
      case "2":
        $cadena = "finalizado";
    }
    $asunto = "Se cambio el estado de su Actividad";
    $msg = "Se cambio el estado de su Actividad => " . $cadena;
    $cfg_en = $this->valide_email_notification($this->get_SESSID(), "emailnotify_board_update", $asunto, $msg);

    $nombre = "Se cambio el estado de su Actividad";
    $registrar_notificacion = $this->notifim->publicar_notificacion($this->get_SESSID(), $id, $nombre);

    /*ACCIONES: 1 => INSERTAR | 2 => ACTUALIZAR | 3 => ELIMINAR | 4 => INICIAR SESION |  5 => CERRAR SESION | 6 => RECUPERACION*/
    $where_vnf = [["campo" => "pk_actividad", "valor" => $id]];
    $value_notify = $this->crudm->listar_campo_tabla_xcond("actividad", "nombre_actividad", $where_vnf);
    $titulo_notify = "Actualización de pizarra";
    $detalle_notify = "Cambio de estado a '".$cadena."' en la pizarra, actividad: " . $value_notify;
    $this->audmod->registrar_evento_auditoria($this->modsis, $this->get_SESSID(), 2, $titulo_notify, $detalle_notify);
  }
}
