<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloRol extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function traerRoles() {
        $query = $this->db->query("SELECT idRol,descripcion FROM rol");
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return null;
        }
    }


    public function get_rol($id) {

        $query = $this->db->query("SELECT *  FROM rol
                where idRol=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

     public function insertarRol($data) {

        $rol_data = array(
            "descripcion" => $data['descripcion']);

        $insert = $this->db->insert("rol", $rol_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function editarRol($data) {
        $roles = $data['roles'];
        $rol_data = array(
            "descripcion" => $roles['descripcion']);

        $insert = $this->db->update("rol", $rol_data, array('idRol' => $roles["idRol"]));
        return $insert;
    }
    
    public function eliminarRol($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('rol', array('idRol' => $id));
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
