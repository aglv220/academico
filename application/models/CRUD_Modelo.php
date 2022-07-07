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

    public function generate_token(){
        $r1 = [rand(1389,2787),rand(3036,4668),rand(5187,6798)];
        $r2 = [rand(7641,8315),rand(9961,10544),rand(11319,12634)];
        $r3 = [rand(-8661,-6915),rand(-5761,-3644),rand(-2545,1345)];
        $r4 = [rand(2567,4287),rand(5129,7856),rand(8896,10649)];
        $vr1 = $r1[array_rand($r1)];
        $vr2 = $r2[array_rand($r2)];
        $vr3 = $r3[array_rand($r3)];
        $vr4 = $r4[array_rand($r4)];
        $time = date("ihs");
        $num_rand = rand($vr1,$vr2).$time.rand($vr3,$vr4).$time.rand($vr1,$vr3);
        $encode = $this->encript_data($num_rand);
        return $encode;
    }
}