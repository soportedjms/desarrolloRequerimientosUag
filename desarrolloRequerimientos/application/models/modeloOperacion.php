<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelooperacion extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

     public function get_operaciones() {
        $query = $this->db->query("SELECT * FROM operacion order by idOperacion");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_operacion($id) {
        $query = $this->db->query("SELECT * FROM operacion
                where idOperacion=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }
   
    public function insertarOperacion($data) {
        try {
            $this->db->trans_begin();
            $operacion_data = array(
                "descripcion" => $data['descripcion']);
            $insert = $this->db->insert("operacion", $operacion_data);
           
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }

    public function editarOperacion($data) {
        try {
            $operacion = $data['operacion'];
             $operacion_data = array(
                "descripcion" => $data['descripcion']);
            $this->db->trans_begin();
            $this->db->update("operacion", $operacion_data, array('idOperacion' => $operacion["idOperacion"]));
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }

    public function eliminarOperacion($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('operacion', array('idOperacion' => $id));
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }
}
