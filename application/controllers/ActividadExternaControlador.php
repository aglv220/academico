<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActividadExternaControlador extends UTP_Controller
{
    public $modsis = 2;

    function __construct()
    {
        parent::__construct();
        $this->load->model('ActividadExternaModelo', 'actextmodelo');
        $this->load->model('TareaModelo', 'tareamodelo');
        $this->load->model('NotificacionModelo', 'notifim');
        $this->load->model('CRUD_Modelo', 'crudm');
        date_default_timezone_set('America/lima');
    }

    public function agregarCalendario()
    {
        $id = $this->input->post("id");
        $fecha = $this->input->post("fecha");

        //matriz de meses
        $array = array(
            0 => array('mes' => 'Jan', 'dia' => '01'), 1 => array('mes' => 'Feb', 'dia' => '02'), 2 => array('mes' => 'Mar', 'dia' => '03'), 3 => array('mes' => 'Apr', 'dia' => '04'), 4 => array('mes' => 'May', 'dia' => '05'), 5 => array('mes' => 'Jun', 'dia' => '06'), 6 => array('mes' => 'Jul', 'dia' => '07'), 7 => array('mes' => 'Aug', 'dia' => '08'),
            8 => array('mes' => 'Sep', 'dia' => '09'), 9 => array('mes' => 'Oct', 'dia' => '10'), 10 => array('mes' => 'Nov', 'dia' => '11'),
            11 => array('mes' => 'Dec', 'dia' => '12')
        );

        //armar la fecha en el formato de la bd
        foreach ($array as $key) {
            if (stristr($fecha, $key["mes"])) {
                $valor = explode($key['mes'], $fecha);
                //quitar espacios en blanco
                $mesNombre = explode(" ", $valor[0]);
                $numero = $key["dia"];
            }
        }
        //obtner dia 
        $dia = substr($fecha, 8, 2);
        $dia = $dia + 1;
        //obtener año
        $año = substr($fecha, 11, 4);
        //obtener la hora 
        $hora = substr($fecha, 15, 9);

        $fechaFormateada = $año . "-" . $numero . "-" . $dia . " " . $hora;

        //cambiar el estado en pizzarra
        $this->actextmodelo->asignarActividadCalendario($id);

        //consultar id de la actividad 
        $idActvidad = $this->actextmodelo->consultarIdActividad($id);
        foreach ($idActvidad as $key) {
            $idActvidad = $key["fk_actividad"];
            $nombre = $key["nombre_actividad"];
        }

        $estado = 0;
        $this->notifim->insertar_notificacion($idActvidad, $nombre, $estado);
        //asignar fecha
        $this->actextmodelo->asignarfechaActividad($idActvidad, $fechaFormateada);
    }

    public function llenarCalendario()
    {
        $idUser = $this->session->userdata('SESSION_ID');
        $dataActividad = $this->actextmodelo->listarActividadesalCalendario($idUser);
        $dataTareas = $this->tareamodelo->listarTareasalCalendario($idUser);
        $data = array_merge($dataActividad, $dataTareas);
        echo json_encode($data);
    }

    public function crearActividad()
    {
        $idUser = $this->session->userdata('SESSION_ID');
        //crear Actividad 
        $nombre = $this->input->post("nombre");
        $tipo = $this->input->post("tipoActividad");
        $fecha = $this->input->post("fecha");
        $hora = $this->input->post("hora");
        $descrip = $this->input->post("descrip");
        $estado = $this->input->post("estado");
        $fechaDisp = $fecha . " " . $hora;
        $idTabla = $this->actextmodelo->crearActividad($tipo, $idUser, $nombre, $descrip, $fechaDisp);
        $insert_activ = $this->actextmodelo->insertarUsuarioActividadExterna($idTabla, $estado);

        if ($insert_activ > 0 && $insert_activ != null) {
            if ($tipo == 4 || $tipo == "4") {
                $asunto = "Nueva actividad externa";
                $msg = "Se ha agregado una nueva actividad externa en la pizarra";
                $cfg_name = "emailnotify_board_new";
            } else {
                $asunto = "Nueva actividad";
                $msg = "Se ha agregado una nueva actividad en el calendario";
                $cfg_name = "emailnotify_calendar_new";
            }
            $cfg_en = $this->valide_email_notification($this->get_SESSID(), $cfg_name, $asunto, $msg);
            $this->notifim->insertar_notificacion($idTabla, "Nueva actividad: " . $nombre, 0);
        }
    }

    public function get_modal_externa($pkActividad = null)
    {
        $post = $this->input->post();
        $pkActividad = ($pkActividad == null) ? $post['pkActividad'] : $pkActividad;
        $data["actividad"] = $this->actextmodelo->get_Actividad($pkActividad);
        $data["subtarea"] = $this->actextmodelo->get_subTareas($pkActividad);
        $this->load->view('modales/modalSubtarea', $data);
    }

    public function get_modal_edit_externa($pkActividad = null)
    {
        $post = $this->input->post();
        $pkActividad = ($pkActividad == null) ? $post['pkActividad'] : $pkActividad;
        $data["estado"] = $this->actextmodelo->estadoPizarra($pkActividad);
        $this->load->view('modales/modalEditActividad', $data);
    }

    public function get_tareas_pausa()
    {
        //listar actividades en pausa
        $data["actPausa"] = $this->actextmodelo->listarActividadesPausa($this->session->userdata('SESSION_ID'));
        //listar actividades en pausa
        $data["tareaPausa"] = $this->tareamodelo->listarTareasPausa($this->session->userdata('SESSION_ID'));

        $data = array_merge($data["actPausa"], $data["tareaPausa"]);
        echo json_encode($data);
    }

    public function get_tareas_proceso()
    {
        //listar actividades en pausa
        $data["actProc"] = $this->actextmodelo->listarActividadesProceso($this->session->userdata('SESSION_ID'));
        //listar actividades en pausa
        $data["tareaProc"] = $this->tareamodelo->listarTareasProceso($this->session->userdata('SESSION_ID'));

        $data = array_merge($data["actProc"], $data["tareaProc"]);
        echo json_encode($data);
    }

    public function get_tareas_fin()
    {
        //listar actividades en pausa
        $data["actFin"] = $this->actextmodelo->listarActividadesFinalizada($this->session->userdata('SESSION_ID'));
        //listar actividades en pausa
        $data["tareaFin"] = $this->tareamodelo->listarTareasFinalizada($this->session->userdata('SESSION_ID'));

        $data = array_merge($data["actFin"], $data["tareaFin"]);
        echo json_encode($data);
    }
    public function guardar_estado_pizarra()
    {
        $id = $this->input->post("id");
        $estado = $this->input->post("estado");
        //$this->notifim->insertar_notificacion($id, $estado, 0);
        $this->actextmodelo->guardar_estado_pizarra($id, $estado);
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
        $msg = "Se cambio el estado de su Actividad" . $cadena;
        $cfg_en = $this->valide_email_notification($this->get_SESSID(), "emailnotify_board_update", $asunto, $msg);

        $where_c = [["campo" => "pk_usuario_actividad_externa", "valor" => $id]];
        $id_actividad = $this->crudm->listar_campo_tabla_xcond("usuario_actividad_externa", "fk_actividad", $where_c);
        $actividad = "Se cambio el estado de su Actividad";
        $nombre = "Se cambio el estado de su Actividad";
        $registrar_notificacion = $this->notifim->publicar_notificacion($this->get_SESSID(), $id_actividad, $nombre);

        /*ACCIONES: 1 => INSERTAR | 2 => PIZARRA | 3 => CONFIGURACION | 4 => REPORTES | 5 => USUARIO*/
        $where_vnf = [["campo" => "pk_actividad", "valor" => $id_actividad]];
        $value_notify = $this->crudm->listar_campo_tabla_xcond("actividad", "nombre_actividad", $where_vnf);
        $titulo_notify = "Actualización de pizarra";
        $detalle_notify = "Cambio de estado a '" . $cadena . "' en la pizarra, actividad: " . $value_notify;
        $this->audmod->registrar_evento_auditoria($this->modsis, $this->get_SESSID(), 1, $titulo_notify, $detalle_notify);
    }

    public function save_subtareas()
    {
        $id = $this->input->post("id");
        $nombre = $this->input->post("nombre");
        $this->actextmodelo->save_subtarea($id, $nombre);
        $where_c1 = [["campo" => "fk_actividad", "valor" => $id]];
        $id_actext = $this->crudm->listar_campo_tabla_xcond("usuario_actividad_externa", "pk_usuario_actividad_externa", $where_c1);
        //OBTENER LISTADO ACTUALIZADO DE SUBTAREAS DE LA ACTIVIDAD
        $return = ["subtareas" => "ERROR"];
        $subtareas = $this->actextmodelo->get_subTareas($id_actext);
        if (count($subtareas) > 0) {
            $contador = 0;
            $html_subtareas = "";
            foreach ($subtareas as $key) {
                $estado = $key["estado_subtarea"] == "0" ? '' : 'checked';
                $class_chk = ".chkdel_st";
                $html_subtareas .= '<li id="' . $key['pk_subtarea'] . '">' .
                    '<label>' .
                    '<input class="checkbox" type="checkbox" ' . $estado . '  name="campo[' . $contador . ']" value="' . $key["pk_subtarea"] . "," . $key["estado_subtarea"] . '"><i></i>' .
                    '<span>' . ucfirst($key["nombre_subtarea"]) . " - " . $key["detalle_subtarea"] . '</span>' .
                    '<a onclick="eliminar(' . $key['pk_subtarea'] . ')" class="ti-close"></a>' .
                    '</label>' .
                    '</li>';
                $contador++;
            } //onchange="select_st(' . $class_chk . ')"
            $return = ["subtareas" => $html_subtareas];

            /*ACCIONES: 1 => INSERTAR | 2 => ACTUALIZAR | 3 => ELIMINAR | 4 => INICIAR SESION |  5 => CERRAR SESION | 6 => RECUPERACION*/
            $titulo_notify = "Registro de subtarea";
            $detalle_notify = "Se ha registrado una nueva subtarea: " . $nombre;
            $this->audmod->registrar_evento_auditoria($this->modsis, $this->get_SESSID(), 1, $titulo_notify, $detalle_notify);
        }
        echo json_encode($return);
    }
    public function guardar_estado_subtarea()
    {
        $id = $this->input->post("id");
        $campo = $this->input->post("campo");
        $array = array();
        foreach ($campo as $i => $value) {
            $cadena = explode(",", $value);
            array_push($cadena, $id);
            array_push($array, $cadena);
        }
        foreach ($array as $i => $value) {
            $datos = $value[0] . "-" . $value[1] . "-" . $value[2];
            echo $this->actextmodelo->cambiar_estado_subtarea($value[0]);
        }
        /*ACCIONES: 1 => INSERTAR | 2 => ACTUALIZAR | 3 => ELIMINAR | 4 => INICIAR SESION |  5 => CERRAR SESION | 6 => RECUPERACION*/
        $id_activ = $this->crudm->listar_campo_tabla_xcond("subtarea", "fk_actividad", [["campo" => "pk_subtarea", "valor" => $id]]);
        $value_notify = $this->crudm->listar_campo_tabla_xcond("actividad", "nombre_actividad", [["campo" => "pk_actividad", "valor" => $id_activ]]);
        $titulo_notify = "Actualización de subtareas";
        $detalle_notify = "Actualización de estados de subtareas, actividad: " . $value_notify;
        $this->audmod->registrar_evento_auditoria($this->modsis, $this->get_SESSID(), 2, $titulo_notify, $detalle_notify);
    }
    public function delete_subtareas()
    {
        $id = $this->input->post("id");
        /*ACCIONES: 1 => INSERTAR | 2 => ACTUALIZAR | 3 => ELIMINAR | 4 => INICIAR SESION |  5 => CERRAR SESION | 6 => RECUPERACION*/
        $where_vnf = [["campo" => "pk_subtarea", "valor" => $id]];
        $value_notify = $this->crudm->listar_campo_tabla_xcond("subtarea", "nombre_subtarea", $where_vnf);
        $titulo_notify = "Eliminación de subtarea";
        $detalle_notify = "Se ha eliminado la subtarea: " . $value_notify;
        $this->audmod->registrar_evento_auditoria($this->modsis, $this->get_SESSID(), 3, $titulo_notify, $detalle_notify);
        $this->actextmodelo->delete_subtareas($id);
    }
}
