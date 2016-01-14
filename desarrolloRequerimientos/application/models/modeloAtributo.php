<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloAtributo extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function traerAtributos() {
        $query = $this->db->query("SELECT idAtributo,descripcion,valor,0 activo FROM atributo order by descripcion");
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return null;
        }
    }


    public function get_atributo($id) {

        $query = $this->db->query("SELECT *  FROM atributo
                where idAtributo=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

     public function insertarAtributo($data) {

        $atributo_data = array(
            "descripcion" => $data['descripcion'],
            "valor" => $data['valor']);

        $insert = $this->db->insert("atributo", $atributo_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function editarAtributo($data) {
        $atributo = $data['atributo'];
        $atributo_data = array(
            "descripcion" => $atributo['descripcion'],
            "valor" => $atributo['valor']);

        $insert = $this->db->update("atributo", $atributo_data, array('idAtributo' => $atributo["idAtributo"]));
        return $insert;
    }
    
    public function eliminarAtributo($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('atriburo', array('idAtributo' => $id));
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
