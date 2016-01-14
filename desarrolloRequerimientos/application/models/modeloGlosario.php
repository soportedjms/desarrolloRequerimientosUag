<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modeloglosario extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_glosarios() {

        $query = $this->db->query("SELECT glosario.*,proyecto.nombre nombreProyecto,estatus.descripcion descEstatus "
                . " FROM glosario"
                . " inner join proyecto on proyecto.idProyecto=glosario.idProyecto "
                . " inner join estatus on estatus.idEstatus=glosario.idEstatus order by glosario.nombre");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_glosarioCombo() {

        $query = $this->db->query("SELECT idGlosario, nombre"
                . " from glosario"
                . " where idEstatus<>2 ORDER BY nombre");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_glosario($id) {
        $query = $this->db->query("SELECT *  FROM glosario
                where idGlosario=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function validaGlosario($proyecto, $id) {
        if ($id != 0) { //es guardar editar, validar que el usuario no exista en otro rgistro diferente al que se esta modificando
            $query = $this->db->query("SELECT idGlosario FROM glosario
					where idProyecto=? AND idGlosario<>? AND idEstatus<>3 LIMIT 1", array($proyecto, $id));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        } else {
            $query = $this->db->query("SELECT idGlosario FROM glosario
					where idProyecto=? AND idEstatus<>3 LIMIT 1", array($proyecto));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        }
    }

    public function insertarGlosario($data) {
        try {
            $this->db->trans_begin();
            $glosario_data = array(
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "objetivo" => $data['objetivo'],
                "idProyecto" => $data['idProyecto'],
                "idEstatus" => $data['idEstatus']);

            $this->db->insert("glosario", $glosario_data);
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

    public function editarGlosario($data) {
        try {
            $glosario = $data['glosario'];
            $glosario_data = array(
                "nombre" => $glosario['nombre'],
                "descripcion" => $glosario['descripcion'],
                "objetivo" => $glosario['objetivo'],
                "idProyecto" => $glosario['idProyecto'],
                "idEstatus" => $glosario['idEstatus']);

            $this->db->trans_begin();
            $this->db->update("glosario", $glosario_data, array('idGlosario' => $glosario["idGlosario"]));
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
