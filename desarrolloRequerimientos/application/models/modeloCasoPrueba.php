<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloCasoPrueba extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_casosPruebas() {
        $query = $this->db->query("SELECT caso_prueba.*, estatus.descripcion descEstatus, "
                . " proyecto.nombre nombreProyecto"
                . " FROM caso_prueba "
                . " inner join proyecto on proyecto.idProyecto=caso_prueba.idProyecto "
                . " inner join estatus on estatus.idEstatus=caso_prueba.idEstatus "
                . " order by proyecto.nombre, caso_prueba.idCasoPrueba");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_casoPrueba($id) {

        $query = $this->db->query("SELECT *  FROM caso_prueba
                where idCasoPrueba=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function insertarCasoPrueba($data) {
        try {
            $this->db->trans_begin();
            $casoPrueba_data = array(
                "descripcion" => $data['descripcion'],
                "precondicion" => $data['precondicion'],
                "poscondicion" => $data['poscondicion'],
                "responsable" => $data['responsable'],
                "descripcionDetallada" => trim($data['descripcionDetallada']),
                "idEstatus" => $data['idEstatus'],
                "idProyecto" => $data['idProyecto']);

            $this->db->insert("caso_prueba", $casoPrueba_data);
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

    public function editarCasoPrueba($data) {
        try {
            $casoPrueba = $data['casoPrueba'];
            $casoPrueba_data = array(
                "descripcion" => $casoPrueba['descripcion'],
                "precondicion" => $casoPrueba['precondicion'],
                "poscondicion" => $casoPrueba['poscondicion'],
                "responsable" => $casoPrueba['responsable'],
                "descripcionDetallada" => trim($casoPrueba['descripcionDetallada']),
                "idEstatus" => $casoPrueba['idEstatus'],
                "idProyecto" => $casoPrueba['idProyecto']);

            $this->db->trans_begin();
            $this->db->update("caso_prueba", $casoPrueba_data, array('idCasoPrueba' => $casoPrueba["idCasoPrueba"]));
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

    public function eliminarCasoPrueba($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('requerimiento_caso_prueba', array('idCasoPrueba' => $id));
            $this->db->delete('caso_prueba', array('idCasoPrueba' => $id));
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return null;
            } else {
                $this->db->trans_commit();
            }
            return true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return null;
        }
    }

}
