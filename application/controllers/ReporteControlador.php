<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReporteControlador extends UTP_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('TareaModelo', 'tarea');
        $this->load->model('UsuarioModelo', 'userm');
        $this->load->model('ReporteModelo', 'repom');
        $this->load->model('CRUD_Modelo', 'crudm');
        date_default_timezone_set('America/lima');
    }

    public function listar_reporte_actividades()
    {
        $mes = $this->input->post("input_mes");
        $tipo_rep = $this->input->post("input_tiprep");
        $id_user = $this->get_SESSID();
        $reporte_graph = "";
        switch ($tipo_rep) {
            case 1:
                $reporte_graph = $this->repom->reporte_actividades_xtipo($mes, $id_user);
                break;
            case 2:
                $reporte_graph = $this->repom->reporte_actividades_xestado($mes, $id_user);
                break;
        }

        $pie_data = [];
        $color_lst = ["#456487", '#7571F9', '#ff5e5e', '#e62739', '#9097c4', '#1f8023'];

        // for ($i = 0; $i < count($reporte_graph["data"]); $i++) {
        //     $nombre = $reporte_graph["data"][$i]["NOMBRE"];
        //     $cantidad = $reporte_graph["data"][$i]["CANTIDAD"];
        //     $color_sel = $color_lst[$i];
        //     array_push(
        //         $pie_data,
        //         [
        //             "label" => $nombre,
        //             "data" => [$cantidad],
        //             "color" => $color_sel
        //         ]
        //     );
        // }

        $cont = 0;
        foreach ($reporte_graph as $row) {
            $nombre = $row->NOMBRE;
            $cantidad = $row->CANTIDAD;
            $color_sel = $color_lst[$cont];
            $cont ++;
            array_push(
                $pie_data,
                [
                    "label" => $nombre,
                    "data" => [$cantidad],
                    "color" => $color_sel
                ]
            );
        }

        echo json_encode($pie_data);
    }
}
