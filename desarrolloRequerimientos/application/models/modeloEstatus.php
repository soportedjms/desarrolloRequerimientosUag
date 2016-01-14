<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modeloestatus extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_estatus() {
        $query = $this->db->query("SELECT * FROM estatus order by descripcion ");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_estatusCombo($filtro) {
        //T Todos
        //R Requisitos
        //A Actividades
        $consulta="SELECT * FROM estatus ";
        if ($filtro=='T')
            $consulta=$consulta . " WHERE todos=1";
        if ($filtro=='R')
            $consulta=$consulta . " WHERE requisitos=1";
        if ($filtro=='A')
            $consulta=$consulta . " WHERE actividades=1";
        $consulta=$consulta . " order by descripcion";
        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_estatus_part($id) {

        $query = $this->db->query("SELECT *  FROM estatus
                where idEstatus=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function insertarEstatus($data) {
        try {
            $this->db->trans_begin();
            $estatus_data = array(
                "descripcion" => $data['descripcion'],
                "todos" => $data['todos'],
                "requisitos" => $data['requisitos'],
                "actividades" => $data['actividades']);

            $insert = $this->db->insert("estatus", $estatus_data);
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

    public function editarEstatus($data) {
        try {
            $estatus = $data['estatus'];

            $estatus_data = array(
                "descripcion" => $estatus['descripcion'],
                "todos" => $estatus['todos'],
                "requisitos" => $estatus['requisitos'],
                "actividades" => $estatus['actividades']);
            $this->db->trans_begin();
            $insert = $this->db->update("estatus", $estatus_data, array('idEstatus' => $estatus["idEstatus"]));

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

    public function eliminarEstatus($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('estatus', array('idEstatus' => $id));
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
