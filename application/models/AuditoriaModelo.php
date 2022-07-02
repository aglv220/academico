<?php

class AuditoriaModelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function registrar_evento_auditoria($modID, $userID, $accion, $titulo, $detalle)
    {
        $nom_acc = "";
        switch ($accion) {
            case 1:
                $nom_acc = "INSERTAR";
                break;
            case 2:
                $nom_acc = "ACTUALIZAR";
                break;
            case 3:
                $nom_acc = "ELIMINAR";
                break;
            case 4:
                $nom_acc = "INICIAR SESION";
                break;
            case 5:
                $nom_acc = "CERRAR SESION";
                break;
            case 6:
                $nom_acc = "RECUPERACION";
                break;
        }
        $data = array(
            'fk_modulo ' => $modID,
            'fk_usuario ' => $userID,
            'auditoria_accion ' => $nom_acc,
            'auditoria_titulo ' => $titulo,
            'auditoria_detalle ' => $detalle,
            'auditoria_fecha ' => date('Y-m-d H:i:s')
        );
        $this->db->insert('auditoria', $data);
        //return $insertar_auditoria;
    }
}
