<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloHistorial extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function insertarCambioGlosario($data) {
        $fecha = date('Y-m-d H:i:s');
        $glosario_data = array(
            "idDefinicion" => $data['idDefinicion'],
            "idOperacion" => $data['idOperacion'],
            "idUsuario" => $data['idUsuario'],
            "idRol" => $data['idRol'],
            "fechaOperacion" => $fecha);
        $this->db->insert("cambio_glosario", $glosario_data);
    }

    public function insertarCambioRequerimiento($data) {
        $fecha = date('Y-m-d H:i:s');
        $req_data = array(
            "idRequerimiento" => $data['idRequerimiento'],
            "idRequerimientoUsuario" => $data['idRequerimientoUsuario'],
            "fechaOperacion" => $fecha,
            "idOperacion" => $data['idOperacion'],
            "idUsuario" => $data['idUsuario'],
            "idRol" => $data['idRol'],
            "idActividad" => $data['idActividad']);
        $this->db->insert("cambio_requerimiento", $req_data);
    }

}
