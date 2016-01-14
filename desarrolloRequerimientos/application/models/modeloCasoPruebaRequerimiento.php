<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloCasoPruebaRequerimiento extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_casoPruebaRequerimientos($casoPrueba) {
        //devolver todas los requerimientos asignados a un caso de pruebas 
        $query = $this->db->query(" SELECT r.*, CASE WHEN rcp.idCasoPrueba IS NULL THEN 0 ELSE 1 END asignado "
                ." FROM requerimiento r "
                ." LEFT JOIN  requerimiento_caso_prueba rcp ON r.idRequerimientoUsuario=rcp.idRequerimientoUsuario "
                ." WHERE r.activo=1 and r.idProyecto IN (SELECT idProyecto FROM caso_prueba WHERE idCasoPrueba=?) "
                , array($casoPrueba));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    public function guardar($casoPruebaRequerimientos, $casoPrueba) {
        try {
            $this->db->trans_begin();
            //eliminar los requerimientos asignados
            $this->db->delete('requerimiento_caso_prueba', array('idCasoPrueba' => $casoPrueba));
            //insertar nuevos
            if (!empty($casoPruebaRequerimientos)) {
                foreach ($casoPruebaRequerimientos as $requerimiento) {
                    $this->db->insert("requerimiento_caso_prueba", $requerimiento);
                };
            }
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
