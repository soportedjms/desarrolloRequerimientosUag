<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modeloprioridad extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_prioridades() {
        $query = $this->db->query("SELECT * FROM prioridad order by orden");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_prioridad($id) {
        $query = $this->db->query("SELECT *  FROM prioridad
                where idPrioridad=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function validaPrioridad($orden, $id) {
        if ($id != 0) { //es guardar editar, validar que el usuario no exista en otro rgistro diferente al que se esta modificando
            $query = $this->db->query("SELECT orden FROM prioridad
					where orden=? AND idPrioridad<>? LIMIT 1", array($orden, $id));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        } else {
            $query = $this->db->query("SELECT orden FROM prioridad
					where orden=? LIMIT 1", array($orden));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        }
    }

    public function insertarPrioridad($data) {
        try {
            $this->db->trans_begin();
            $prioridad_data = array(
                "descripcion" => $data['descripcion'],
                "orden" => $data['orden']);

            $this->db->insert("prioridad", $prioridad_data);
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

    public function editarPrioridad($data) {
        try {
            $prioridad = $data['prioridad'];
            $prioridad_data = array(
                "descripcion" => $prioridad['descripcion'],
                "orden" => $prioridad['orden']);
            $this->db->trans_begin();
            $this->db->update("prioridad", $prioridad_data, array('idPrioridad' => $prioridad["idPrioridad"]));
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

    public function eliminarPrioridad($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('prioridad', array('idPrioridad' => $id));
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
