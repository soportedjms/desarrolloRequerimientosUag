<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelolineabase extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_LineasBase($proyecto, $lineaBase) {
        $consulta = "SELECT linea_base.*, estatus.descripcion descEstatus, proyecto.nombre nombreProyecto,
                usuario.nombre nombreUsrCreacion, 
                CASE WHEN us2.nombre IS NULL THEN '' ELSE us2.nombre END nombreUsrAprobacion
                FROM linea_base
                inner join estatus on estatus.idEstatus=linea_base.idEstatus
                inner join proyecto on proyecto.idProyecto=linea_base.idProyecto
                inner join usuario on usuario.idUsuario=linea_base.usuarioCreacion
                left join usuario us2 on us2.idUsuario=linea_base.usuarioAprobacion
                WHERE linea_base.idProyecto=" . $proyecto;
        if ($lineaBase != "") {
            $consulta = $consulta . " AND linea_base.idLineaBase=" . $lineaBase;
        }

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            if ($lineaBase == "") {
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

    public function get_ultimaLineaBaseAprobada($proyecto) {
        $consulta = "SELECT linea_base.*
                FROM linea_base
                WHERE linea_base.estaAprobada=1 AND linea_base.idProyecto=" . $proyecto
                . " ORDER BY fechaAprobacion DESC limit 1 ";

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->row_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function generarLineaBase($data, $requisitos, $definiciones) {
        try {
            $this->db->trans_begin();
            $fecha = date('Y-m-d H:i:s');
            $linea_data = array(
                "idProyecto" => $data['idProyecto'],
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "usuarioCreacion" => $this->session->userdata('idUsuario'),
                "fechaCreacion" => $fecha,
                "idEstatus" => $data['estatus'],
                "estaAprobada" => 0,
                "usuarioAprobacion" => NULL,
                "fechaAprobacion" => NULL);

            //Generar nueva linea base
            $this->db->insert("linea_base", $linea_data);
            $insertID = $this->db->insert_id();

            //Guardar  requisitos terminados
            foreach ($requisitos as $var) {
                $requisito = array(
                    "idRequerimiento" => $var['idRequerimiento'],
                    "idRequerimientoUsuario" => $var['idRequerimientoUsuario'],
                    "idLineaBase" => $insertID,
                    "idProyecto" => $data['idProyecto']
                );
                $this->db->insert("requerimiento_linea_base", $requisito);
                //Asignarle linea base a todos las operaciones de los requisitos asignados
                $this->db->query("update cambio_requerimiento set idLineaBase={$insertID}, idProyecto={$data['idProyecto']} "
                        . " where idLineaBase IS NULL AND idRequerimientoUsuario='{$var['idRequerimientoUsuario']}'");
            }
            //Guardar definiciones terminadas
            foreach ($definiciones as $var) {
                $definicion = array(
                    "idDefinicion" => $var['idDefinicion'],
                    "idLineaBase" => $insertID,
                    "idProyecto" => $data['idProyecto']
                );
                $this->db->insert("definicion_linea_base", $definicion);
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
