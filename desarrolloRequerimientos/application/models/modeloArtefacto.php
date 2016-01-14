<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modeloartefacto extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->config = array(
            'upload_path' => dirname($_SERVER["SCRIPT_FILENAME"]) . "/archivosArtefactos/",
            'upload_url' => base_url() . "archivosArtefactos/",
            'allowed_types' => "jpg|png|jpeg|pdf|doc|xml|docx|xlsx",
            'overwrite' => FALSE,
            'max_size' => "5000KB",
            'max_height' => "1152",
            'max_width' => "2048"
        );
    }

    public function get_artefactos() {

        $query = $this->db->query("SELECT artefacto.*, estatus.descripcion descEstatus, proyecto.nombre nombreProyecto "
                . " FROM artefacto  "
                . " inner join estatus on estatus.idEstatus=artefacto.idEstatus"
                . " inner join proyecto on proyecto.idProyecto=artefacto.idProyecto"
                . " order by proyecto.nombre, artefacto.descripcion");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
     public function get_artefactosPantallaInicial() {

        $query = $this->db->query("SELECT artefacto.*, estatus.descripcion descEstatus, proyecto.nombre nombreProyecto "
                . " FROM artefacto  "
                . " inner join estatus on estatus.idEstatus=artefacto.idEstatus"
                . " inner join proyecto on proyecto.idProyecto=artefacto.idProyecto"
                . " where artefacto.idEstatus=1 order by proyecto.nombre, artefacto.descripcion limit 5");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_artefacto($id) {

        $query = $this->db->query("SELECT * FROM artefacto
                where idArtefacto=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function get_artefactosProyecto($idProyecto, $artefactos, $incluirArtefactos) {
        $consulta = 'SELECT *  FROM artefacto
                where idProyecto=? and idEstatus=1';
        if ($artefactos != "") {
            if ($incluirArtefactos == 1)
                $consulta = $consulta . " AND idArtefacto in (" . $artefactos . ")";
            else {
                $consulta = $consulta . " AND idArtefacto not in (" . $artefactos . ")";
            }
        }

        $query = $this->db->query($consulta, array($idProyecto));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function validarAsignacion($id) {
        $query = $this->db->query("SELECT idArtefacto FROM requerimiento_artefacto
					where idArtefacto=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function insertarArtefacto($data) {
        try {
            $this->db->trans_begin();
            $artefacto_data = array(
                "descripcion" => $data['descripcion'],
                "descripcionDetallada" => $data['descripcionDetallada'],
                "idEstatus" => $data['idEstatus'],
                "idProyecto" => $data['idProyecto']);

            $this->db->insert("artefacto", $artefacto_data);
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

    public function editarArtefacto($data) {
        try {
            $artefacto = $data['artefacto'];
            $artefacto_data = array(
                "descripcion" => $artefacto['descripcion'],
                "descripcionDetallada" => $artefacto['descripcionDetallada'],
                "idEstatus" => $artefacto['idEstatus'],
                "idProyecto" => $artefacto['idProyecto']);
            $this->db->trans_begin();
            $this->db->update("artefacto", $artefacto_data, array('idArtefacto' => $artefacto["idArtefacto"]));

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

    public function eliminarArtefacto($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('archivo_artefacto', array('idArtefacto' => $id));
            $this->db->delete('artefacto', array('idArtefacto' => $id));
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

    /////////funciones para archivos/////////////////////
    public function do_upload($idArtefacto) {

        $resultado = array();
        $this->load->library('upload', $this->config);
        if ($this->upload->do_upload()) {
            $archivo = $this->upload->data();
            //Si se cargo correcto entonces guardar información en la base de datos
            $archivo_data = array(
                "idArtefacto" => $idArtefacto,
                "nombre" => $archivo['file_name'],
                "ruta" => $archivo['full_path'],
                "url" => base_url() . "archivosArtefactos/" . $archivo['file_name']);
            $this->db->trans_begin();
            $this->db->insert("archivo_artefacto", $archivo_data);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resultado = array("status" => false, "mensaje" => "Error al insertar.");
            } else {
                $this->db->trans_commit();
                $resultado = array("status" => true, "mensaje" => "Archivo subido correctamente.");
            }
        } else {
            $resultado = array("status" => false, "mensaje" => $this->upload->display_errors());
        }
        return $resultado;
    }

    function remove_dir($dir) {
        try {
            if (file_exists($dir)) {
                unlink($dir);
                return 'ok';
            } else {
                return 'no';
            }
        } catch (Exception $ex) {
            return 'error';
        }
    }

    public function eliminarArchivo($idArchivo) {
        $query = $this->db->query("SELECT ruta  FROM archivo_artefacto
                where idArchivo=? limit 1", array($idArchivo));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            //eliminar archivo
            $val = $this->remove_dir($row['ruta']);
            if ($val == 'ok') {
                //eliminar registro de la bd
                $this->db->delete('archivo_artefacto', array('idArchivo' => $idArchivo));
                return 'ok';
            }
            if ($val == 'no')
                return 'No se encontró archivo.';
            if ($val == 'error')
                return 'no';
        } else {
            return 'no';
        }
    }

    public function get_archivos($id) {
        $query = $this->db->query("SELECT *  FROM archivo_artefacto
                where idArtefacto=? ", array($id));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

}
