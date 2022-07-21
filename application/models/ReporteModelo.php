<?php

class ReporteModelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('CRUD_Modelo', 'crudm');
    }

    public function reporte_actividades_xtipo($mes,$userID)
    {
        $REPORT_SQL = "CALL REPORTE_ACTIVIDADES_XTIPO(?,?)";
        $DATA = array(
            'MES' => $mes,
            'USUARIO' => $userID
        );
        $consulta = $this->db->query($REPORT_SQL, $DATA);
        // $resultado['data'] = $consulta -> result_array();
        // return $resultado;
        $result = $consulta->result();
        $consulta->next_result();
        $consulta->free_result();
        return $result;
    }

    public function reporte_actividades_xestado($mes,$userID)
    {
        $REPORT_SQL = "CALL REPORTE_ACTIVIDADES_XESTADO(?,?)";
        $DATA = array(
            'MES' => $mes,
            'USUARIO' => $userID
        );
        $consulta = $this->db->query($REPORT_SQL, $DATA);
        // $resultado['data'] = $consulta -> result_array();
        // return $resultado;
        $result = $consulta->result();
        $consulta->next_result();
        $consulta->free_result();
        return $result;
    }
}
