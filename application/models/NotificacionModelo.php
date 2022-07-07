<?php

class NotificacionModelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function listar_notificaciones($userID, $estado, $limit = 5)
    {
        $this->db->select('nl.pk_notificacion_log AS ID, nl.notificacion_nombre AS NOMBRE, nl.notificacion_fecreg AS FECREG, nl.notificacion_estado AS ESTADO, ac.nombre_actividad AS ACTIVIDAD');
        $this->db->from('notificacion_log nl');
        $this->db->join('actividad ac', 'nl.fk_actividad = ac.pk_actividad');
        //$this->db->join('notificacion_pendiente np', 'nl.pk_notificacion_log = np.fk_notificacion_log', 'right');
        if ($userID != "" && $userID != null) {
            $this->db->where('ac.fk_usuario', $userID);
        }
        if ($estado != "" && $estado != null) {
            $this->db->where('nl.notificacion_estado', $estado);
        }
        $this->db->order_by('nl.notificacion_fecreg', 'DESC');
        if ($limit != false) {
            $this->db->limit($limit);
        }
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function insertar_notificacion($actividad, $nombre, $estado)
    {
        $data_notif_l = array(
            'fk_actividad' => $actividad, // CON LA ACTIVIDAD SE OBTIENE EL USUARIO
            'notificacion_nombre' => $nombre,
            'notificacion_fecreg' => date('Y-m-d H:i:s'),
            'notificacion_estado' => $estado,
        );
        $id_notif = $this->crudm->ingresar_data($data_notif_l, "notificacion_log");
        $data_notif_p = array(
            'fk_notificacion_log' => $id_notif
        );
        $insert_notif_p = $this->db->insert("notificacion_pendiente", $data_notif_p);
        return $insert_notif_p;
    }

    public function publicar_notificacion($id_user, $actividad, $nombre)
    {
        $estado = "0";
        $insertar_notificacion = $this->notifim->insertar_notificacion($actividad, $nombre, $estado);
        if ($insertar_notificacion) {
            $this->notifim->obtener_notificaciones($id_user, "0", false);
            return true;
        } else {
            return false;
        }
    }

    public function actualizar_estado_notificacion($IDnotif, $estado)
    {
        $success = true;
        $data_notif = array(
            'notificacion_estado' => $estado
        );
        $where_data = array("pk_notificacion_log" => $IDnotif);
        $this->crudm->actualizar_data($where_data, $data_notif, 'notificacion_log');
        if ($estado == 1) {
            $success = $this->db->delete('notificacion_pendiente', array('fk_notificacion_log' => $IDnotif));
        }
        return $success;
    }

    function obtener_notificaciones($idUser, $estado, $onenotify, $pusher = true)
    {
        $limite = 1; //LIMITE POR DEFECTO SI SE IMPRIME UNA SOLA NOTIFICACION
        if ($onenotify == false) {
            $limite = 5;
        }
        //LISTADO DE TODAS LAS NOTIFCACIONES PENDIENTES EN EL SISTEMA
        $lstnotify_all = $this->listar_notificaciones($idUser, $estado, false);
        $cant_notify_all = count($lstnotify_all);

        $userID_cript = $this->crudm->encript_data($idUser);
        $lstnotify = $this->listar_notificaciones($idUser, $estado, $limite);
        $html_notify = '';
        if (count($lstnotify) > 0) {
            foreach ($lstnotify as $row) {
                $id_notif = $row->ID;
                $nom_notif = $row->NOMBRE;
                $fecreg_notif = $row->FECREG;
                //$estado_notif = $row->ESTADO;
                //$nom_act = $row->ACTIVIDAD;

                $DATE_NOW = date("d-m-Y");
                $DATE_YESTERDAY = date("d-m-Y", strtotime("-1 day", strtotime($DATE_NOW)));
                $FULLDAY_NOTIF = date("d-m-Y", strtotime($fecreg_notif));
                $FULLHOUR_NOTIF = date("h:ia", strtotime($fecreg_notif));
                if ($FULLDAY_NOTIF == $DATE_NOW) {
                    $FECHA_NOTIF = "Hoy a las " . $FULLHOUR_NOTIF;
                } else if ($FULLDAY_NOTIF == $DATE_YESTERDAY) {
                    $FECHA_NOTIF = "Ayer a las " . $FULLHOUR_NOTIF;
                } else {
                    $FECHA_NOTIF = date("d-m-Y h:ia", strtotime($fecreg_notif));
                }

                $id_encript = $this->crudm->encript_data($id_notif);

                $html_notify .=
                    '<li class="contentedor-notify-pending">
                        <a class="notify-pending" js-id="' . $id_encript . '">
                            <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                            <div class="notification-content">
                                <h6 class="notification-heading">' . $nom_notif . '</h6>
                                <span class="notification-text">' . $FECHA_NOTIF . '</span> 
                            </div>
                        </a>
                    </li>';
            }
        }
        /*else {
            $html_notify =
                '<li class="contentedor-notify-pending">
                    <a class="notify-pending-none">
                        <div class="notification-content">
                            <h6 class="notification-heading">No tienes notificaciones pendientes</h6>
                        </div>
                     </a>
                </li>';
        }*/
        if ($onenotify == false) {
            $data_notify = [
                "HTMLNOTIFY" => $html_notify,
                "NOTIFYPENDALL" => $cant_notify_all,
                "USERNOTIFY" => $userID_cript,
                "TYPENOTIFY" => "LASTFIVE"
            ];
            /*if ($pusher == false) {
                return $data_notify;
            }*/
        } else { //IMPRIMIR ULTIMA NOTIFICACION PENDIENTE
            $data_notify = [
                "HTMLNOTIFY" => $html_notify,
                "NOTIFYPENDALL" => $cant_notify_all,
                "USERNOTIFY" => $userID_cript,
                "TYPENOTIFY" => "ONE"
            ];
        }
        if ($pusher) {
            //PUSHER NOTIFICATION
            $pusher = $this->ci_pusher->get_pusher();
            $pusher->trigger('canal-notificaciones', 'register-n', $data_notify);
        } else {
            return $data_notify;
        }
    }
}
