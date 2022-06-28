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
        $this->db->select('u.pk_usuario AS ID, usuario_correo, usuario_password, usuario_regcomp, usuario_codrecover, alumno_nombre, alumno_apellidos, alumno_codigo');
        $this->db->from('usuario u');
        $this->db->join('alumno a', 'a.fk_usuario = u.pk_usuario', 'left');
        $this->db->where('u.' . $campo, $correo_o_valor);
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

    public function registrar_usuario($correo, $password)
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
                return "OK";
            } else {
                return "ERROR";
            }
        } else {
            return "EXIST";
        }
    }
}
