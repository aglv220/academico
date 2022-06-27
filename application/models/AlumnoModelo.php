<?php

class AlumnoModelo extends CI_Model
{
    public $ID;
    public $usuario_ID;
    public $nombres;
    public $apellidos;
    public $carrera;
    public $codigo;
    public $celular;
    public $fec_nac;

    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo','crudm');
    }

    public function registrar_alumno($user,$nom,$ape,$carr,$ciclo,$cod,$cel,$fec_nac)
    {
        $campos = [ ["campo"=>"alumno_codigo", "valor"=>$cod] ];
        $alumnol = $this->crudm->listar_tabla_xcampo('alumno',$campos);
        if (count($alumnol) == 0) {
            $DATA_ALUMNO = array(
                'fk_usuario ' => $user,
                'alumno_nombre ' => $nom,
                'alumno_apellidos ' => $ape,
                'alumno_carrera ' => $carr,
                'alumno_ciclo ' => $ciclo,
                'alumno_codigo ' => $cod,
                'alumno_celular ' => $cel,
                'alumno_fecnac ' => $fec_nac
            );
            $INSERT_ALUMNO = $this->db->insert('alumno', $DATA_ALUMNO);
            if ($INSERT_ALUMNO) {
                return "OK";
            } else {
                return "ERROR";
            }
        } else {
            return "EXIST";
        }
    }
}