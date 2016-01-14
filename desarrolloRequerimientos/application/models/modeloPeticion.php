<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelopeticion extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->config = array(
            'upload_path' => dirname($_SERVER["SCRIPT_FILENAME"]) . "/archivosPeticionInteresados/",
            'upload_url' => base_url() . "archivosPeticionInteresados/",
            'allowed_types' => "jpg|png|jpeg|pdf|doc|xml|docx|xlsx",
            'overwrite' => FALSE,
            'max_size' => "5000KB",
            'max_height' => "1152",
            'max_width' => "2048"
        );
    }

    public function get_peticiones() {
        $query = $this->db->query("SELECT peticion.*, estatus.descripcion descEstatus, "
                . " proyecto.nombre nombreProyecto "
                . " FROM peticion_interesados peticion "
                . " INNER JOIN proyecto on proyecto.idProyecto=peticion.idProyecto "
                . " inner join estatus on estatus.idEstatus=peticion.idEstatus "
                . " order by proyecto.nombre, peticion.descripcion");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
    public function get_peticionesPantallaInicial() {
        $query = $this->db->query("SELECT peticion.*, estatus.descripcion descEstatus, "
                . " proyecto.nombre nombreProyecto "
                . " FROM peticion_interesados peticion "
                . " INNER JOIN proyecto on proyecto.idProyecto=peticion.idProyecto "
                . " inner join estatus on estatus.idEstatus=peticion.idEstatus "
                . " where peticion.idEstatus=1 order by peticion.descripcion limit 5");

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_peticion($id) {

        $query = $this->db->query("SELECT *  FROM peticion_interesados
                where idPeticion=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

     public function get_peticionesProyecto($idProyecto,$peticiones,$incluirPeticiones) {
        $consulta='SELECT *  FROM peticion_interesados
                where idProyecto=? and idEstatus=1';
        if ($peticiones!="")
        {
            if ($incluirPeticiones==1)
                $consulta=$consulta." AND idPeticion in (".$peticiones.")";
            else {
                $consulta=$consulta." AND idPeticion not in (".$peticiones.")";
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
        $query = $this->db->query("SELECT idPeticion FROM requerimiento_peticion_interesados
					where idPeticion=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function insertarPeticion($data) {
        try {
            $this->db->trans_begin();
            $peticion_data = array(
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "descripcionDetallada" => $data['descripcionDetallada'],
                "idEstatus" => $data['idEstatus'],
                "idProyecto" => $data['idProyecto']);

            $this->db->insert("peticion_interesados", $peticion_data);
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

    public function editarPeticion($data) {
        try {
            $peticion = $data['peticion'];
            $peticion_data = array(
                "nombre" => $peticion['nombre'],
                "descripcion" => $peticion['descripcion'],
                "descripcionDetallada" => $peticion['descripcionDetallada'],
                "idEstatus" => $peticion['idEstatus'],
                 "idProyecto" => $peticion['idProyecto']);
            $this->db->trans_begin();
            $this->db->update("peticion_interesados", $peticion_data, array('idPeticion' => $peticion["idPeticion"]));

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

    public function eliminarPeticion($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('requerimiento_peticion_interesados', array('idPeticion' => $id));
            $this->db->delete('archivo_peticion_interesados', array('idPeticion' => $id));
            $this->db->delete('peticion_interesados', array('idPeticion' => $id));
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
    public function do_upload($idPeticion) {
        //$this->remove_dir($this->config["upload_path"], false);
        $resultado = array();
        $this->load->library('upload', $this->config);
        if ($this->upload->do_upload()) {
            $archivo = $this->upload->data();
            //Si se cargo correcto entonces guardar información en la base de datos
            $archivo_data = array(
                "idPeticion" => $idPeticion,
                "nombre" => $archivo['file_name'],
                "ruta" => $archivo['full_path'],
                "url" => base_url() . "archivosPeticionInteresados/" . $archivo['file_name']);
            $this->db->trans_begin();
            $this->db->insert("archivo_peticion_interesados", $archivo_data);
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
        $query = $this->db->query("SELECT ruta  FROM archivo_peticion_interesados
                where idArchivo=? limit 1", array($idArchivo));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            //eliminar archivo
            $val=$this->remove_dir($row['ruta']);
            if ($val=='ok') {
                //eliminar registro de la bd
                $this->db->delete('archivo_peticion_interesados', array('idArchivo' => $idArchivo));
                return 'ok';
            }
            if($val=='no')
                return 'No se encontró archivo.';
            if ($val=='error')
                return 'no';
        } else {
            return 'no';
        }
    }

    public function get_archivos($id) {
        $query = $this->db->query("SELECT *  FROM archivo_peticion_interesados
                where idPeticion=? ", array($id));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

}
