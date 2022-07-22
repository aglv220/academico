<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuarioControlador extends UTP_Controller
{
    public $modsis = 5;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('UsuarioModelo', 'usuariom');
        $this->load->model('TareaModelo', 'tareamod');
        $this->load->model('ActividadExternaModelo', 'actexmod');
        $this->load->model('AuditoriaModelo', 'audmod');
        $this->load->model('CRUD_Modelo', 'crudm');
        date_default_timezone_set('America/lima');
    }

    public function validar_sesion_usuario()
    {
        echo $this->encript_data($this->get_SESSID());
    }

    public function actualizar_perfil_personal()
    {
        $this->is_loged_off();
        $msg_error = "";
        $idUser = $this->session->userdata('SESSION_ID');
        $nombre = trim($this->input->post("usuario_nombre"));
        $apellidos = trim($this->input->post("usuario_apellidos"));
        $celular = $this->input->post("usuario_celular");
        $fec_nac = $this->input->post("usuario_fecnac");
        $carrera = $this->input->post("usuario_carrera");
        $ciclo = $this->input->post("usuario_ciclo");

        $where_data_a = array("fk_usuario" => $idUser);
        $data_alumno = array('alumno_nombre' => $nombre, 'alumno_apellidos' => $apellidos, 'alumno_carrera' => $carrera, 'alumno_ciclo' => $ciclo, 'alumno_celular' => $celular, 'alumno_fecnac' => $fec_nac);
        if ($this->input->post("usuario_newpass")) {
            $new_pass = $this->input->post("usuario_newpass");
            $where_data_u = array("pk_usuario" => $idUser);
            $data_user = array('usuario_password' => password_hash($new_pass, PASSWORD_DEFAULT));
            if (strlen($new_pass) >= 8) {
                $this->crudm->actualizar_data($where_data_u, $data_user, 'usuario');
            } else {
                $msg_error = "ERROR_PASS_SHORT";
            }
        }
        if ($msg_error == "") {
            $actualizar_alumno = $this->crudm->actualizar_data($where_data_a, $data_alumno, 'alumno');
            switch ($actualizar_alumno) {
                case true:
                    $msg_error = "OK_SUCCESS";
                    $this->audmod->registrar_evento_auditoria($this->modsis, $idUser, 2, "Actualización de perfil", "El usuario ha actualizado su perfil personal");
                    break;
                case false:
                    $msg_error = "ERROR_NO_CHANGES";
                    break;
            }
        }
        echo $msg_error;
    }

    public function actualizar_configuracion_usuario()
    {
        $this->is_loged_off();
        $idUser = $this->get_SESSID();
        $activ_cfg_all = $this->input->post("chk_cfg_activ") == "on" ? 1 : 0;
        if ($activ_cfg_all == 1) {
            $activ_cfg_n = 1;
            $activ_cfg_d = 1;
            $activ_cfg_u = 1;
        } else {
            $activ_cfg_n = $this->input->post("chk_cfg_activ_n") == "on" ? 1 : 0;
            $activ_cfg_d = $this->input->post("chk_cfg_activ_d") == "on" ? 1 : 0;
            $activ_cfg_u = $this->input->post("chk_cfg_activ_u") == "on" ? 1 : 0;
        }
        $piza_cfg_all = $this->input->post("chk_cfg_piza") == "on" ? 1 : 0;
        if ($piza_cfg_all == 1) {
            $piza_cfg_n = 1;
            $piza_cfg_d = 1;
            $piza_cfg_u = 1;
        } else {
            $piza_cfg_n = $this->input->post("chk_cfg_piza_n") == "on" ? 1 : 0;
            $piza_cfg_d = $this->input->post("chk_cfg_piza_d") == "on" ? 1 : 0;
            $piza_cfg_u = $this->input->post("chk_cfg_piza_u") == "on" ? 1 : 0;
        }
        $lst_config_opt = array(
            'en_c_n' => $activ_cfg_n,
            'en_c_d' => $activ_cfg_d,
            'en_c_u' => $activ_cfg_u,
            'en_b_n' => $piza_cfg_n,
            'en_b_d' => $piza_cfg_d,
            'en_b_u' => $piza_cfg_u,
        );
        $update_configuracion = $this->usuariom->establecer_configuracion($idUser, $lst_config_opt);
        if ($update_configuracion) {
            echo "OK";
        } else {
            echo "ERROR";
        }
    }

    public function obtener_historial_usuario($userID)
    {
        $this->is_loged_off();
        $html_history = "";
        $history_user = $this->usuariom->listar_historial_usuario($userID);
        foreach ($history_user as $row) {
            $fecha = $row->FECHA;
            $modulo = $row->NOM_MOD;
            $accion = $row->ACCION;
            $titulo = $row->TITULO;
            $detalle = $row->DETALLE;
            $nombres = $row->NOMBRES;
            $html_history .= "<tr>";
            $html_history .= "<td>" . $fecha . "</td>";
            $html_history .= "<td>" . $modulo . "</td>";
            $html_history .= "<td>" . $accion . "</td>";
            $html_history .= "<td>" . $titulo . "</td>";
            $html_history .= "<td>" . $detalle . "</td>";
            $html_history .= "</tr>";
        }
        return $html_history;
    }

    public function obtener_notificaciones_usuario($userID)
    {
        $this->is_loged_off();
        $html_history = "";
        $history_user = $this->usuariom->listar_notificaciones_usuario($userID);
        foreach ($history_user as $row) {
            $fecha = $row->FECREG;
            $actividad = $row->N_ACTIVIDAD;
            $titulo = $row->NOTIFY;
            $estado = $row->ESTADO;
            $usuario = $row->USUARIO;
            $detalle_a = $row->D_ACTIVIDAD;
            $html_history .= "<tr>";
            $html_history .= "<td>" . $fecha . "</td>";
            $html_history .= "<td>" . $actividad . "</td>";
            $html_history .= "<td>" . $titulo . "</td>";
            $html_history .= "<td>" . $estado . "</td>";
            $html_history .= "</tr>";
        }
        return $html_history;
    }

    public function obtener_configuracion_usuario($userID)
    {
        $this->is_loged_off();
        $html_config = "";
        $config_user = $this->crudm->listar_tabla_xcampo('configuracion_usuario', [["campo" => "fk_usuario", "valor" => $userID]]);
        if (count($config_user) > 0) {
            foreach ($config_user as $row) {
                $en_calendar_new = $row->emailnotify_calendar_new == 1 ? "checked" : "";
                $en_calendar_del = $row->emailnotify_calendar_delete == 1 ? "checked" : "";
                $en_calendar_upd = $row->emailnotify_calendar_update == 1 ? "checked" : "";
                $en_board_new = $row->emailnotify_board_new == 1 ? "checked" : "";
                $en_board_del = $row->emailnotify_board_delete == 1 ? "checked" : "";
                $en_board_upd = $row->emailnotify_board_update == 1 ? "checked" : "";

                $cfgnoti_calendar = $row->emailnotify_calendar_new == 1 && $row->emailnotify_calendar_delete == 1 && $row->emailnotify_calendar_update == 1 ? "checked" : "";
                $calendar_subopt = $cfgnoti_calendar == "checked" ? "disabled" : "";

                $cfgnoti_board = $row->emailnotify_board_new == 1 && $row->emailnotify_board_delete == 1 && $row->emailnotify_board_update == 1 ? "checked" : "";
                $board_subopt = $cfgnoti_board == "checked" ? "disabled" : "";

                $opt_cfg_all = array(
                    ["Actividades", "activ", $cfgnoti_calendar],
                    ["Pizarra", "piza", $cfgnoti_board],
                );
                $cont = 0;
                for ($i = 0; $i < count($opt_cfg_all); $i++) {
                    $html_config .=
                        '<h5 class="text-muted">' . $opt_cfg_all[$i][0] . '</h5>
                        <div class="form-group mt-3">
                            <div class="form-check mb-3">
                                <label class="form-check-label">
                                <input type="checkbox" name="chk_cfg_' . $opt_cfg_all[$i][1] . '" class="form-check-input chkcfg_user" js-type="' . $opt_cfg_all[$i][1] . '" ' . $opt_cfg_all[$i][2] . '>Activar todas las notificaciones disponibles (' . $opt_cfg_all[$i][0] . ')</label>
                            </div>
                        </div>';
                    $nom_input = array(
                        ["activ_n", "crea", $en_calendar_new],
                        ["activ_u", "actualice", $en_calendar_upd],
                        ["activ_d", "elimine", $en_calendar_del],
                        ["piza_n", "crea", $en_board_new],
                        ["piza_u", "actualice", $en_board_upd],
                        ["piza_d", "elimine", $en_board_del]
                    );
                    $html_config .= '<div class="form-group ml-5">';
                    $nom_item = "actividad";
                    $nom_modu = "el calendario";
                    $input_dsb = $calendar_subopt;
                    for ($x = $cont; $x < count($nom_input); $x++) {
                        if ($x > 2) {
                            $nom_item = "tarea";
                            $nom_modu = "la pizarra";
                            $input_dsb = $board_subopt;
                        }
                        $html_config .=
                            '<div class="form-check mb-3">
                                <label class="form-check-label">
                                <input type="checkbox" name="chk_cfg_' . $nom_input[$x][0] . '" class="form-check-input subopt_' . $nom_item . '" ' . $nom_input[$x][2] . " " . $input_dsb . ' >Notificar cuando se ' . $nom_input[$x][1] . ' una ' . $nom_item . ' en ' . $nom_modu . '</label>
                            </div>';
                        if ($x == 2) {
                            $cont = $x + 1;
                            break;
                        }
                    }
                    $html_config .= '</div>';
                }
            }
        } else {
            $html_config = false;
        }
        return $html_config;
    }

    public function pagina_principal()
    {
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $data["tareas"] = $this->tareamod->listarCursos($idUser);
        $data["actividades"] = $this->actexmod->listarActividades($idUser);
        $data_header['title_page'] = 'Página principal';
        $this->cabecera_pagina($data_header);
        $this->load->view('dashboard', $data);
        $this->pie_pagina();
    }

    public function perfil_usuario()
    {
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $lst_data_usuario = $this->usuariom->inicio_sesion($idUser, "pk_usuario")[0];
        $carrera_usuario = $lst_data_usuario->alumno_carrera;
        $data["info_usuario"] = $lst_data_usuario;
        $data['lst_carreras'] = $this->llenar_select($this->crudm->listar_tabla('carrera'), $carrera_usuario);
        $data_header['title_page'] = 'Perfil de usuario';
        $this->cabecera_pagina($data_header);
        $this->load->view('usuario/perfil_usuario', $data);
        $this->pie_pagina();
    }

    public function calendario()
    {
        $this->is_loged_off();
        $idUser = $this->session->userdata('SESSION_ID');
        $data["tareas"] = $this->actexmod->listarCursosFueraCalendario($idUser);
        $data["tipos_actividades"] = $this->tareamod->listarActividadXtipo();
        $data_header['title_page'] = 'Calendario de Actividades';
        $this->cabecera_pagina($data_header);
        $this->load->view('actividades/calendar', $data);
        $this->pie_pagina();
    }

    public function pizarra()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Pizarra de Tareas';
        $this->cabecera_pagina($data_header);
        $this->load->view('tareas/board');
        $this->pie_pagina();
    }

    public function reporte_actividades()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Reporte de Actividades';
        $this->cabecera_pagina($data_header);
        $this->load->view('reportes/reporteActividades');
        $this->pie_pagina();
    }

    public function reporte_tareas()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Reporte de Tareas';
        $this->cabecera_pagina($data_header);
        $this->load->view('reportes/reporteTareas');
        $this->pie_pagina();
    }

    public function configuracion_usuario()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Configuración de usuario';
        $data_page['cfg_html_user'] = $this->obtener_configuracion_usuario($this->get_SESSID());
        $this->cabecera_pagina($data_header);
        $this->load->view('usuario/configuracion', $data_page);
        $this->pie_pagina();
    }

    public function historial_usuario()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Historial de usuario';
        $data_page['history_user'] = $this->obtener_historial_usuario($this->get_SESSID());
        $this->cabecera_pagina($data_header);
        $this->load->view('usuario/historial', $data_page);
        $this->pie_pagina();
    }

    public function notificaciones_usuario()
    {
        $this->is_loged_off();
        $data_header['title_page'] = 'Notificaciones de usuario';
        $data_page['notifys_user'] = $this->obtener_notificaciones_usuario($this->get_SESSID());
        $this->cabecera_pagina($data_header);
        $this->load->view('usuario/notificaciones', $data_page);
        $this->pie_pagina();
    }

    public function recuperar_password()
    {
        $this->is_loged_on();
        $data_header['title_page'] = 'Recuperar contraseña';
        $this->load->view('base/head', $data_header);
        $this->load->view('usuario/recuperar_password');
        $this->include_js();
    }

    //test
    public function sum($n1, $n2)
    {
        return $n1 + $n2;
    }
}
