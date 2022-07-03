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
            $rcampo = $row->$campo;
        }
        return $rcampo;
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

    public function ingresar_data($data,$table)
    {
      $this->db->insert($table, $data);
      return $this->db->insert_id();
    }

    public function ingresar_datos_masivo($data,$table)
    {
      return $this->db->insert_batch($table, $data);
    }

    public function actualizar_data($where,$data,$tabla){

      $this->db->update($tabla, $data, $where);

      if ( $this->db->affected_rows() > 0 )
      {
        return true;
      }  else {
        return false;
      }
    }

    public function encript_data($DATA)
    {
        $fase_1 = strrev($DATA);
        $fase_2 = convert_uuencode($fase_1);
        $fase_3 = base64_encode($fase_2);
        $fase_4 = strrev($fase_3);
        return $fase_4;
    }

    public function decript_data($DATA)
    {
        $fase_1 = strrev($DATA);
        $fase_2 = base64_decode($fase_1);
        $fase_3 = convert_uudecode($fase_2);
        $fase_4 = strrev($fase_3);
        return $fase_4;
    }
}