<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modeloproyecto extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_proyectos() {
        $query = $this->db->query("SELECT proyecto.*,estatus.descripcion descEstatus FROM proyecto"
                . " inner join estatus on estatus.idEstatus=proyecto.idEstatus order by nombre");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_proyectos_combo() {
        $query = $this->db->query("SELECT idProyecto, nombre FROM proyecto"
                . " where idEstatus<>3 order by nombre");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
    public function get_proyecto($id) {
        $query = $this->db->query("SELECT *  FROM proyecto
                where idProyecto=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

//    public function validaProyecto($status) {
//
//    }

    public function insertarProyecto($data) {
        try {
            $this->db->trans_begin();
            $proyecto_data = array(
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "fechaInicio" => $data['fechaInicio'],
                "fechaTermino" => $data['fechaTermino'],
                "usuarioCreacion" => $data['usuarioCreacion'],
                "idEstatus" => $data['idEstatus']);

            $insert = $this->db->insert("proyecto", $proyecto_data);
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

    public function editarProyecto($data) {
        try {
            $proyecto = $data['proyecto'];
            echo $proyecto['fechaInicio'];
            $proyecto_data = array(
                "nombre" => $proyecto['nombre'],
                "descripcion" => $proyecto['descripcion'],
                "fechaInicio" => $proyecto['fechaInicio'],
                "fechaTermino" => $proyecto['fechaTermino'],
                "usuarioCreacion" => $proyecto['usuarioCreacion'],
                "idEstatus" => $proyecto['idEstatus']);

            $this->db->trans_begin();
            $this->db->update("proyecto", $proyecto_data, array('idProyecto' => $proyecto["idProyecto"]));
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
