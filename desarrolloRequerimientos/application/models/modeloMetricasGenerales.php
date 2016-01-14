<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloMetricasGenerales extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_cambiosPorActividad() {
        $consulta = "SELECT actividad.idActividad, actividad.descripcion,count(cambio_requerimiento.idActividad) cambios, 0 porcentaje
        FROM actividad
        left join cambio_requerimiento on cambio_requerimiento.idActividad=actividad.idActividad
        GROUP BY actividad.idActividad, actividad.descripcion";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
     public function get_peticionesActivas() {
        $consulta = "SELECT count(idPeticion) cantidad "
                . " from peticion_interesados"
                . " where idEstatus=1 ";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalCambiosRequerimientos() {
        $consulta = "SELECT count(requerimiento.idRequerimientoUsuario) cambios
        FROM requerimiento
        inner join cambio_requerimiento on cambio_requerimiento.idRequerimientoUsuario=requerimiento.idRequerimientoUsuario
        where requerimiento.activo=1 AND cambio_requerimiento.idActividad IS NULL
        ";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosAsignados() {
        $consulta = "    select count(idRequerimiento) cantidad
            from requerimiento
            where activo=1";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }
    
     public function get_totalRequerimientosAsignadosTerminados() {
        $consulta = "    select count(idRequerimiento) cantidad
            from requerimiento
            where activo=1 and idEstatus=8";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosPorTipo($tipo) {
        $consulta = "    select count(idRequerimiento) cantidad
            from requerimiento
            where activo=1 and idTipo=" . $tipo;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosPeticion() {
        $consulta = "select count(distinct idRequerimientoUsuario)  cantidad
            from requerimiento_peticion_interesados";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }
    
    public function get_totalPeticionAsignada() {
        $consulta = "select count(distinct idPeticion)  cantidad
            from requerimiento_peticion_interesados";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }
    
        public function get_totalRequerimientosCasosPrueba() {
        $consulta = "select count(distinct idRequerimientoUsuario) cantidad
        from requerimiento_caso_prueba";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

}
