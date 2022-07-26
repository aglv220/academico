<?php

class UsuarioModelo extends CI_Model
{
    public $ID;
    public $correo;
    public $password;

    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo', 'crudm');
        $this->load->model('AlumnoModelo', 'alumm');
    }

    public function inicio_sesion($correo_o_valor, $campo = "usuario_correo")
    {
        $this->db->select('u.pk_usuario AS ID, usuario_correo, usuario_password, usuario_regcomp, usuario_codrecover, alumno_nombre, alumno_apellidos, alumno_codigo, alumno_carrera, alumno_celular, alumno_ciclo, alumno_fecnac, alumno_correonotify');
        $this->db->from('usuario u');
        $this->db->join('alumno a', 'a.fk_usuario = u.pk_usuario', 'left');
        $this->db->where('u.' . $campo, $correo_o_valor); //COLLATE utf8_bin
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function actualizar_cod_rec($correo, $cod_rec)
    {
        $data_user = array(
            'usuario_codrecover' => $cod_rec
        );
        $where_data = array("usuario_correo" => $correo);
        $UPDATE_PASS = $this->crudm->actualizar_data($where_data, $data_user, 'usuario');
        return $UPDATE_PASS;
    }

    public function actualizar_password($correo, $password)
    {
        $data_user = array(
            'usuario_password' => password_hash($password, PASSWORD_DEFAULT)
        );
        $where_data = array("usuario_correo" => $correo);
        $UPDATE_PASS = $this->crudm->actualizar_data($where_data, $data_user, 'usuario');
        return $UPDATE_PASS;
    }

    public function registrar_usuario($correo, $password, $getid = false)
    {
        $userxacceso = $this->inicio_sesion($correo);
        if (count($userxacceso) == 0) { //SI EL CORREO NO EXISTE
            $DATA_USUARIO = array(
                'usuario_correo' => $correo,
                'usuario_password' => password_hash($password, PASSWORD_DEFAULT),
                'usuario_regcomp' => 0
            );
            $INSERT_USUARIO = $this->db->insert('usuario', $DATA_USUARIO);
            if ($INSERT_USUARIO) {
                if ($getid) {
                    return $this->db->insert_id();
                } else {
                    return "OK";
                }
            } else {
                return "ERROR";
            }
        } else {
            return "EXIST";
        }
    }

    public function listar_historial_usuario($userID)
    {
        $REPORT_SQL = "CALL LISTAR_HISTORIAL_USUARIO(?)";
        $DATA = array(
            'IDUSER' => $userID
        );
        $consulta = $this->db->query($REPORT_SQL, $DATA);
        $result = $consulta->result();
        $consulta->next_result();
        $consulta->free_result();
        return $result;
    }

    public function listar_notificaciones_usuario($userID)
    {
        $REPORT_SQL = "CALL LISTAR_NOTIFICACIONES_USUARIO(?)";
        $DATA = array(
            'IDUSER' => $userID
        );
        $consulta = $this->db->query($REPORT_SQL, $DATA);
        $result = $consulta->result();
        $consulta->next_result();
        $consulta->free_result();
        return $result;
    }

    public function establecer_configuracion($userID, $config_opt = array())
    {
        $config_user = $this->crudm->listar_tabla_xcampo('configuracion_usuario', [["campo" => "fk_usuario", "valor" => $userID]]);
        if (count($config_opt) == 0) { //CONFIGURACIÓN PREDETERMINADA
            $config_opt = array(
                'en_c_n' => 1,
                'en_c_d' => 0,
                'en_c_u' => 0,
                'en_b_n' => 1,
                'en_b_d' => 0,
                'en_b_u' => 0,
            );
        }
        $success = true;
        if (count($config_user) > 0) { //ACTUALIZAR CONFIGURACION EXISTENTE
            $data_config = array(
                'emailnotify_calendar_new' => $config_opt["en_c_n"],
                'emailnotify_calendar_delete' => $config_opt["en_c_d"],
                'emailnotify_calendar_update' => $config_opt["en_c_u"],
                'emailnotify_board_new' => $config_opt["en_b_n"],
                'emailnotify_board_delete' => $config_opt["en_b_d"],
                'emailnotify_board_update' => $config_opt["en_b_u"]
            );
            $where_data = array("fk_usuario" => $userID);
            $this->crudm->actualizar_data($where_data, $data_config, 'configuracion_usuario');
            //NO REGISTRAR ERROR AL ACTUALIZAR
        } else { //INSERTAR CONFIGURACION
            $data_config = array(
                'emailnotify_calendar_new' => $config_opt["en_c_n"],
                'emailnotify_calendar_delete' => $config_opt["en_c_d"],
                'emailnotify_calendar_update' => $config_opt["en_c_u"],
                'emailnotify_board_new' => $config_opt["en_b_n"],
                'emailnotify_board_delete' => $config_opt["en_b_d"],
                'emailnotify_board_update' => $config_opt["en_b_u"],
                "fk_usuario" => $userID
            );
            $success = $this->db->insert('configuracion_usuario', $data_config);
            //RETORNA UN ERROR SI NO SE GRABA
        }
        return $success;
    }
}
