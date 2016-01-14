<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modeloopcion extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_opciones() {

        $query = $this->db->query("SELECT o.*,m.descripcion descModulo FROM opcion o "
                . " INNER JOIN modulo m ON m.idModulo=o.idModulo order by o.descripcion ");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_opcion($id) {

        $query = $this->db->query("SELECT *  FROM opcion
                where idOpcion=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function insertarOpcion($data) {
        try {
            $this->db->trans_begin();
            $opcion_data = array(
                "idModulo" => $data['idModulo'],
                "descripcion" => $data['descripcion'],
                "nombreControlador" => $data['nombreControlador']);

            $insert = $this->db->insert("opcion", $opcion_data);
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

    public function editarOpcion($data) {
        try {
            $opcion = $data['opcion'];
            $opcion_data = array(
                "idModulo" => $opcion['idModulo'],
                "descripcion" => $opcion['descripcion'],
                "nombreControlador" => $opcion['nombreControlador']);
            $this->db->trans_begin();
            $insert = $this->db->update("opcion", $opcion_data, array('idOpcion' => $opcion["idOpcion"]));

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

    public function eliminarOpcion($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('opcion', array('idOpcion' => $id));
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
