<?php

class UsuarioModelo extends CI_Model
{
    public $ID;
    public $correo;
    public $password;

    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo','crudm');
        $this->load->model('AlumnoModelo','alumm');
    }

    public function inicio_sesion($correo_o_valor,$campo="usuario_correo")
    {
        $this->db->select('u.pk_usuario AS ID, usuario_correo, usuario_password, alumno_nombre, alumno_apellidos, alumno_codigo');
        $this->db->from('usuario u');
        $this->db->join('alumno a','a.fk_usuario = u.pk_usuario','left');
        $this->db->where('u.'.$campo, $correo_o_valor);
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function registrar_usuario($correo,$password)
    {
        $userxacceso = $this->inicio_sesion($correo);
        if (count($userxacceso) == 0) { //SI EL CORREO NO EXISTE
            $DATA_USUARIO = array(
                'usuario_correo' => $correo,
                'usuario_password' => password_hash($password, PASSWORD_DEFAULT)
            );
            $INSERT_USUARIO = $this->db->insert('usuario', $DATA_USUARIO);
            if ($INSERT_USUARIO) {                
                //ID DE USUARIO REGISTRADO
                $userid = $this->crudm->listar_maxID_tabla('usuario');

                //REGISTRO DE DATOS DEL ALUMNO                
                //$registro_alumno = $this->alumm->registrar_alumno($userid,$nombres,$apellidos,$carrera,$codigo,$celular,$fecnac);
                
                return "OK";
            } else {
                return "ERROR";
            }
        } else {
            return "EXIST";
        }
    }
}
?>