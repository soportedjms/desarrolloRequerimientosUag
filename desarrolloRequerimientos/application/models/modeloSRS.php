<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloSRS extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_SRS($proyecto, $linea, $srs) {
        $consulta = "SELECT srs.*, proyecto.nombre nombreProyecto, linea_base.nombre nombreLineaBase,
                usuario.nombre nombreUsrCreacion
                FROM srs
                inner join proyecto on srs.idProyecto=proyecto.idProyecto
                inner join linea_base on linea_base.idLineaBase=srs.idLineaBase
                inner join usuario on usuario.idUsuario=srs.usuarioCreacion
                WHERE srs.idProyecto=" . $proyecto;
        if ($srs != "") {
            $consulta = $consulta . " AND srs.idSRS=" . $srs;
            $consulta = $consulta . " AND srs.idLineaBase=" . $linea;
        }

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            if ($srs == "") {
                $rows = $query->result_array();
                return $rows;
            } else {
                $rows = $query->row_array();
                return $rows;
            }
        } else {
            return null;
        }
    }

    public function getSRSPeticiones($proyecto, $linea, $srs) {
        $consulta = "SELECT DISTINCT peticion_interesados.* 
                FROM srs
                inner join linea_base on linea_base.idLineaBase=srs.idLineaBase and linea_base.idProyecto=srs.idProyecto
                inner join requerimiento_linea_base on requerimiento_linea_base.idLineaBase=linea_base.idLineaBase
                inner join requerimiento on requerimiento.idRequerimiento=requerimiento_linea_base.idRequerimiento and requerimiento.idRequerimientoUsuario=requerimiento_linea_base.idRequerimientoUsuario
                inner join requerimiento_peticion_interesados on requerimiento.idRequerimientoUsuario=requerimiento_peticion_interesados.idRequerimientoUsuario
                inner join peticion_interesados on requerimiento_peticion_interesados.idPeticion=peticion_interesados.idPeticion
                WHERE srs.idLineaBase=? and srs.idProyecto=? and srs.idSRS=?";

        $query = $this->db->query($consulta, array($linea, $proyecto, $srs));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function getSRSArtefactos($proyecto, $linea, $srs) {
        $consulta = "SELECT DISTINCT artefacto.* 
                FROM srs
                inner join linea_base on linea_base.idLineaBase=srs.idLineaBase and linea_base.idProyecto=srs.idProyecto
                inner join requerimiento_linea_base on requerimiento_linea_base.idLineaBase=linea_base.idLineaBase
                inner join requerimiento on requerimiento.idRequerimiento=requerimiento_linea_base.idRequerimiento and requerimiento.idRequerimientoUsuario=requerimiento_linea_base.idRequerimientoUsuario
                inner join requerimiento_artefacto on requerimiento.idRequerimientoUsuario=requerimiento_artefacto.idRequerimientoUsuario
                inner join artefacto on artefacto.idArtefacto=requerimiento_artefacto.idArtefacto
                WHERE srs.idLineaBase=? and srs.idProyecto=? and srs.idSRS=?";

        $query = $this->db->query($consulta, array($linea, $proyecto, $srs));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function generarSRS($data) {
        try {
            $this->db->trans_begin();
            //Generar nuevo srs
            $this->db->insert("srs", $data);
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

    public function editarLineaBase($data) {
        try {
            $linea = $data['idLineaBase'];
            $linea_data = array();
            if ($data['estaAprobada'] == 0) {
                $linea_data = array(
                    "nombre" => $data['nombre'],
                    "descripcion" => $data['descripcion'],
                    "idEstatus" => $data['estatus']);
            } else {
                $fecha = date('Y-m-d H:i:s');
                $linea_data = array(
                    "nombre" => $data['nombre'],
                    "descripcion" => $data['descripcion'],
                    "idEstatus" => $data['estatus'],
                    "estaAprobada" => $data['estaAprobada'],
                    "usuarioAprobacion" => $this->session->userdata('idUsuario'),
                    "fechaAprobacion" => $fecha);
            }
            $this->db->trans_begin();
            $this->db->update("linea_base", $linea_data, array('idLineaBase' => $linea, 'idProyecto' => $data['idProyecto']));

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
