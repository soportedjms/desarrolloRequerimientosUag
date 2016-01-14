<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelomodulo extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_modulos() {

        $query = $this->db->query("SELECT * FROM modulo order by descripcion");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_modulo($id) {

        $query = $this->db->query("SELECT *  FROM modulo
                where idModulo=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function validaModulo($descripcion, $id) {
        if ($id != 0) { //es guardar editar, validar que el usuario no exista en otro rgistro diferente al que se esta modificando
            $query = $this->db->query("SELECT descripcion FROM modulo
					where descripcion=? AND idModulo<>? LIMIT 1", array($descripcion, $id));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        } else {
            $query = $this->db->query("SELECT descripcion FROM modulo
					where descripcion=? LIMIT 1", array($descripcion));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        }
    }

    public function insertarModulo($data) {
        try {
            $this->db->trans_begin();
            $modulo_data = array(
                "descripcion" => $data['descripcion'],
                "nombreIcono" => $data['nombreIcono']);

            $insert = $this->db->insert("modulo", $modulo_data);
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

    public function editarModulo($data) {
        try {
            $modulo = $data['modulo'];
            $modulo_data = array(
                "descripcion" => $modulo['descripcion'],
                "nombreIcono" => $modulo['nombreIcono']);
            $this->db->trans_begin();
            $insert = $this->db->update("modulo", $modulo_data, array('idModulo' => $modulo["idModulo"]));
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

    public function eliminarModulo($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('modulo', array('idModulo' => $id));
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
