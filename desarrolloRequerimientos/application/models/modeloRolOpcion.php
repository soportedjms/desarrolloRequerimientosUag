<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloRolOpcion extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_rol_opciones($rol) {
        //devolver todas las opciones dadas de altas con un campo que indique si el rol
        //tiene permiso a la opcion
        $query = $this->db->query(" SELECT "
                . " o.idOpcion, o.descripcion descOpcion, o.idModulo, m.descripcion descModulo,"
                . " CASE WHEN rol_opcion.idOpcion IS NULL THEN 0 ELSE 1 END tienePermiso "
                . " FROM opcion o"
                . " LEFT JOIN rol_opcion ON o.idOpcion=rol_opcion.idOpcion AND rol_opcion.idRol=?"
                . " INNER JOIN modulo m ON m.idModulo=o.idModulo", array($rol));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_rol_opciones_permiso($rol) {
        $query = $this->db->query(" SELECT "
                . " o.idOpcion, o.descripcion descOpcion,o.nombreControlador, o.idModulo, "
                . " m.descripcion descModulo, m.nombreIcono "
                . " FROM opcion o"
                . " INNER JOIN rol_opcion ON o.idOpcion=rol_opcion.idOpcion "
                . " INNER JOIN modulo m ON m.idModulo=o.idModulo"
                . " WHERE rol_opcion.idRol=?"
                . " ORDER BY o.idModulo, o.descripcion ", array($rol));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function guardar($rolOpciones, $rol) {
        try {
            $this->db->trans_begin();
            //eliminar los roles opciones ya existentes
            $this->db->delete('rol_opcion', array('idRol' => $rol));
            //insertar nuevos
            if (!empty($rolOpciones)) {
                foreach ($rolOpciones as $opcion) {
                    $this->db->insert("rol_opcion", $opcion);
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
