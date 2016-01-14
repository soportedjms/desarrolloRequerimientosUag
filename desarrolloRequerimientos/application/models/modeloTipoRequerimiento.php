<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloTipoRequerimiento extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_tipos_requerimientos() {
        $query = $this->db->query("SELECT * FROM tipo_requerimiento ORDER BY descripcion ");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_TipoRequerimiento($id) {

        $query = $this->db->query("SELECT *  FROM tipo_requerimiento
                where idTipo=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function insertarTipoRequerimientos($data) {
        try {
            $this->db->trans_begin();
            $tipo_data = array(
                "descripcion" => $data['descripcion'],
                "furps" => $data['furps']);

            $insert = $this->db->insert("tipo_requerimiento", $tipo_data);
            $insert_id = $this->db->insert_id();

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

    public function editarTipoRequerimientos($data) {
        try {
            $tipo = $data['tipo'];
            $tipo_data = array(
                "descripcion" => $tipo['descripcion'],
                "furps" => $tipo['furps']);
            $this->db->trans_begin();
            $insert = $this->db->update("tipo_requerimiento", $tipo_data, array('idTipo' => $tipo["idTipo"]));

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

    public function eliminarTipoRequerimiento($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('tipo_requerimiento', array('idTipo' => $id));
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
