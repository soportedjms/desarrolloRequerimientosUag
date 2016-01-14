<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelometricasproyecto extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_cambiosPorActividad($proyecto) {
        $consulta = "SELECT actividad.idActividad, actividad.descripcion,count(cambio_requerimiento.idActividad) cambios, 0 porcentaje
        FROM actividad
        left join cambio_requerimiento on cambio_requerimiento.idActividad=actividad.idActividad 
        where actividad.idProyecto=" . $proyecto
                . " GROUP BY actividad.idActividad, actividad.descripcion";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalCambiosRequerimientos($proyecto) {
        $consulta = "SELECT count(requerimiento.idRequerimientoUsuario) cambios
        FROM requerimiento
        inner join cambio_requerimiento on cambio_requerimiento.idRequerimientoUsuario=requerimiento.idRequerimientoUsuario
        where requerimiento.activo=1 AND cambio_requerimiento.idActividad IS NULL and requerimiento.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosAsignados($proyecto) {
        $consulta = "    select count(idRequerimiento) cantidad
            from requerimiento
            where activo=1 and idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosPorTipo($proyecto, $tipo) {
        $consulta = "    select count(idRequerimiento) cantidad
            from requerimiento
            where activo=1 and idTipo=? and idProyecto=?";

        $query = $this->db->query($consulta, array($tipo, $proyecto));
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosPeticion($proyecto) {
        $consulta = "select count(distinct rpi.idRequerimientoUsuario)  cantidad
            from requerimiento_peticion_interesados rpi
            inner join peticion_interesados pi on pi.idPeticion=rpi.idPeticion 
            where pi.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_totalRequerimientosCasosPrueba($proyecto) {
        $consulta = "select count(distinct rcp.idRequerimientoUsuario) cantidad
        from requerimiento_caso_prueba rcp 
        inner join caso_prueba cp on cp.idCasoPrueba=rcp.idCasoPrueba
        where cp.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_cambiosPorAplicar($proyecto) {
        $consulta = "SELECT count(distinct cambio_requerimiento.idCambio) cantidad
        FROM cambio_requerimiento
        inner join requerimiento on cambio_requerimiento.idRequerimientoUsuario=requerimiento.idRequerimientoUsuario
        where cambio_requerimiento.idLineaBase IS NULL AND 
        cambio_requerimiento.idActividad IS NULL AND requerimiento.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_requerimientoAprobados($proyecto) {
        $consulta = "SELECT count(requerimiento.idRequerimientoUsuario) cantidad
        FROM requerimiento
        where activo=1 and idEstatus=6 AND requerimiento.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_requerimientosAbiertos($proyecto) {
        $consulta = "SELECT count(requerimiento.idRequerimientoUsuario) cantidad
        FROM requerimiento
        where activo=1 and idEstatus not in (2,8) AND requerimiento.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

     public function get_CambiosIncorporados($proyecto) {
        $consulta = "SELECT count(distinct cambio_requerimiento.idCambio) cantidad
        FROM cambio_requerimiento
        inner join requerimiento on cambio_requerimiento.idRequerimientoUsuario=requerimiento.idRequerimientoUsuario
        where cambio_requerimiento.idLineaBase IS NULL AND requerimiento.idEstatus=8 and requerimiento.activo=1 and
        cambio_requerimiento.idActividad IS NULL AND requerimiento.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }
    
     public function get_Volatilidad($proyecto) {
        $consulta = "SELECT count(distinct cambio_requerimiento.idCambio) cantidad
        FROM cambio_requerimiento
        inner join requerimiento on cambio_requerimiento.idRequerimientoUsuario=requerimiento.idRequerimientoUsuario
        where cambio_requerimiento.idLineaBase IS NULL AND requerimiento.idEstatus=8 and requerimiento.activo=1 and
        cambio_requerimiento.idActividad IS NULL AND requerimiento.idProyecto=" . $proyecto;

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }
}
