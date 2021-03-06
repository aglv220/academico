<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginControlador extends UTP_Controller
{
    public $modsis = 5;

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/lima');
        $this->load->library('session');
        $this->load->model('UsuarioModelo', 'usuariom');
        $this->load->model('AuditoriaModelo', 'audmod');
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function index()
    {
        $this->is_loged_on();
        $data_header['title_page'] = 'Inicio de sesión';
        $this->load->view('base/head', $data_header);
        $this->load->view('login');
        $this->include_js();
    }

    public function validar_correo_usuario()
    {
        $this->usuariom->correo = $this->input->post("usuario_correo");
        $fase_operacion = $this->input->post("operation_phase");
        $return_msg = "";
        switch ($fase_operacion) {
            case 'validate':
                $lst_login = $this->usuariom->inicio_sesion($this->usuariom->correo);
                if (count($lst_login) > 0) {
                    foreach ($lst_login as $row) {
                        $correo = $row->usuario_correo;
                        $nombre = $row->alumno_nombre;
                        $apellidos = $row->alumno_apellidos;
                        $cod_rec = $row->usuario_codrecover;
                        $idUser = $row->ID;
                        if ($cod_rec == "" || $cod_rec == NULL) {
                            if ($nombre == "" || $nombre == NULL) {
                                $nombre == "alumno";
                            }
                            $cod_rec = $this->generar_codigo_recuperacion($correo);
                            $set_codrec = $this->usuariom->actualizar_cod_rec($correo, $cod_rec);
                            if ($set_codrec) {
                                $asunto = 'Recuperación de contraseña';
                                $mensaje = 'Estimado <b>' . $nombre . ' ' . $apellidos . '</b>,<br>Has solicitado la recuperación de tu contraseña, para lograr reestablecer tu cuenta, copia el código que se muestra a continuación:<br><br><b>' . $cod_rec . '</b><br><br>Luego de ello regresa a la página del aplicativo y pégalo donde el sistema te lo solicite.<br><br><b>Atte. Sistema de Actividades Académicas</b>';
                                $enviar_correo = $this->enviar_email($correo, $asunto, $mensaje);
                                if ($enviar_correo) {
                                    $return_msg = "validate_ok";
                                    $this->audmod->registrar_evento_auditoria($this->modsis, $idUser, 6, "Recuperación de contraseña", "El usuario ha solicitado recuperación de contraseña");
                                } else {
                                    $return_msg = "validate_error_mail";
                                }
                            } else {
                                $return_msg = "validate_error_cr";
                            }
                        } else {
                            $return_msg = "validate_error_codsended";
                        }
                    }
                } else {
                    $return_msg = "validate_error";
                }
                break;

            case 'recover':
                $new_pass = $this->input->post("usuario_password");
                $new_pass_c = $this->input->post("usuario_password_c");
                $codigo_recover = $this->input->post("usuario_codigorecover");
                //OBTENER CODIGO DE RECUPERACIÓN DEL USUARIO A RECUPERAR
                $where_codrecover = [["campo" => "usuario_correo", "valor" => $this->usuariom->correo]];
                $get_codrecover_user = $this->crudm->listar_campo_tabla_xcond("usuario", "usuario_codrecover", $where_codrecover);
                if (strcmp($new_pass, $new_pass_c) == 0) { //VALIDACIÓN DE PASSWORD Y CONFIRMACIÓN DE PASSWORD
                    if (strcmp($codigo_recover, $get_codrecover_user) == 0) { //VALIDACIÓN DE CÓDIGO DE RECUPERACIÓN
                        $change_pass = $this->usuariom->actualizar_password($this->usuariom->correo, $new_pass_c);
                        if ($change_pass) { //VALIDAR SI SE CAMBIO DE CONTRASEÑA
                            //VACIAR EL CAMPO CODIGO DE RECUPERACION SI YA SE CAMBIO LA CONTRASEÑA
                            $this->usuariom->actualizar_cod_rec($this->usuariom->correo, "");
                            $return_msg = "changepass_ok";
                            //REGISTRO DE EVENTO DE AUDITORIA
                            $where_idUser = [["campo" => "usuario_correo", "valor" => $this->usuariom->correo]];
                            $idUser = $this->crudm->listar_campo_tabla_xcond("usuario", "pk_usuario", $where_idUser);
                            $this->audmod->registrar_evento_auditoria($this->modsis, $idUser, 6, "Recuperación de contraseña", "El usuario ha restablecido su contraseña");
                        } else {
                            $return_msg = "changepass_error";
                        }
                    } else {
                        $return_msg = "codrecover_error";
                    }
                } else {
                    $return_msg = "pass_error";
                }
                break;
        }
        echo $return_msg;
    }

    public function iniciar_sesion()
    {
        $return_msg = "";
        $this->usuariom->correo = $this->input->post("usuario_correo");
        $this->usuariom->password = $this->input->post("usuario_clave");
        $lst_login = $this->usuariom->inicio_sesion($this->usuariom->correo);
        if (count($lst_login) > 0) {
            foreach ($lst_login as $row) {
                $id_usuario = $row->ID;
                $registro_completo = $row->usuario_regcomp;
                if (password_verify($this->usuariom->password, $row->usuario_password)) {
                    if ($registro_completo == 0) { //NO HA COMPLETADO EL REGISTRO
                        $correo_cod = base64_encode($this->usuariom->correo);
                        $return_msg = $correo_cod;
                    } else { // SI EL USUARIO HA CAMPLETADO EL REGISTRO ANTERIORMENTE
                        $ROWDATA['SESSION_CORREO'] = $row->usuario_correo;
                        $ROWDATA['SESSION_NOMBRES'] = $row->alumno_nombre;
                        $ROWDATA['SESSION_APELLIDOS'] = $row->alumno_apellidos;
                        $ROWDATA['SESSION_ID'] = $id_usuario;
                        $this->session->set_userdata($ROWDATA);
                        $return_msg = true;
                        $this->audmod->registrar_evento_auditoria($this->modsis, $id_usuario, 4, "Inicio de sesión", "El usuario ha iniciado sesión en el sistema");
                        $this->usuariom->establecer_configuracion($id_usuario);
                    }
                } else {
                    $return_msg = false;
                }
            }
        } else {
            $return_msg = false;
        }
        echo $return_msg;
    }

    public function cerrar_sesion()
    {
        if ($this->session->userdata('SESSION_CORREO')) {
            $this->audmod->registrar_evento_auditoria($this->modsis, $this->session->userdata('SESSION_ID'), 5, "Cierre de sesión", "El usuario ha cerrado sesión en el sistema");
            $this->session->sess_destroy();
            redirect(base_url() . "inicio-sesion");
        }
    }
}
