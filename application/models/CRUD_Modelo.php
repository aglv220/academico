<?php

class CRUD_Modelo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function listar_tabla($tabla){
        $this->db->select('*');
        $this->db->from($tabla);
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function listar_tabla_xid($tabla,$id){
        $this->db->select('*');
        $this->db->from($tabla);
        $this->db->where('pk_'.$tabla,$id);
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function listar_tabla_xcampo($tabla,$cv){
        $this->db->select('*');
        $this->db->from($tabla);

        if (count($cv) > 0) {
            foreach ($cv as $row) {
                $this->db->where($row["campo"],$row["valor"]);
            }
        }
        
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function listar_maxID_tabla($tabla){
        $this->db->select('MAX(pk_'.$tabla.') AS MAXID');
        $this->db->from($tabla);
        $consulta = $this->db->get();
        $result = $consulta->result();
        foreach ($result as $row) {
            $id = $row->MAXID;
        }
        return $id;
    }

    public function listar_campo_tabla_xcond($tabla,$campo,$cv){
        $this->db->select($campo);
        $this->db->from($tabla);

        if (count($cv) > 0) {
            foreach ($cv as $row) {
                $this->db->where($row["campo"],$row["valor"]);
            }
        }

        $consulta = $this->db->get();
        $result = $consulta->result();
        foreach ($result as $row) {
            $campo = $row->$campo;
        }
        return $campo;
    }

    public function listar_tabla_xcond($tabla,$cv){
        $this->db->select("*");
        $this->db->from($tabla);
        if (count($cv) > 0) {
            foreach ($cv as $row) {
                $this->db->where($row["campo"],$row["valor"]);
            }
        }
        $consulta = $this->db->get();
        $result = $consulta->result();
        return $result;
    }

    public function eliminar_xid_tabla($id,$tabla){
        $this->db->where('pk_'.$tabla, $id);
        $DELETE = $this->db->delete($tabla);
        if ($DELETE) {
            return "OK";
        } else {
            return "ERROR";
        }
    }
}