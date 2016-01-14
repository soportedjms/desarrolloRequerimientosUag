<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloDefinicion extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_definiciones($palabra, $glosario) {
        $consulta = " SELECT definicion.*, glosario.nombre nombreGlosario "
                . " FROM definicion"
                . " inner join glosario on glosario.idGlosario=definicion.idGlosario ";
        if ($glosario == '') {
            $consulta = $consulta . " WHERE definicion.idGlosario=(SELECT idGlosario FROM glosario WHERE idEstatus<>2 ORDER BY nombre limit 1) ";
        } else {
            $consulta = $consulta . " WHERE definicion.idGlosario=" . $glosario;
        }

        if ($palabra != "") {
            $consulta = $consulta . " AND definicion.palabra='" . $palabra . "'";
        }
        $consulta = $consulta . " ORDER BY definicion.activo desc, definicion.palabra asc ";
        $query = $this->db->query($consulta);

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_definicionProyectoActivos($proyecto) {
        $query = $this->db->query("SELECT definicion.*, glosario.nombre nombreGlosario
                FROM definicion
                inner join glosario on glosario.idGlosario=definicion.idGlosario
                where glosario.idProyecto=? AND definicion.activo=1", array($proyecto));
         if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
     public function get_definicionesLineaBase($proyecto,$lineaBase) {
        $query = $this->db->query("SELECT definicion.*, glosario.nombre nombreGlosario, glosario.idGlosario
                FROM definicion
                Inner join glosario on glosario.idGlosario=definicion.idGlosario
                inner join definicion_linea_base dlb on dlb.idDefinicion=definicion.idDefinicion
                where dlb.idProyecto=? AND dlb.idLineaBase=?", array($proyecto,$lineaBase));
         if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
    public function get_definicion($id) {
        $query = $this->db->query("SELECT definicion.*, glosario.nombre nombreGlosario
                FROM definicion
                inner join glosario on glosario.idGlosario=definicion.idGlosario
                where definicion.idDefinicion=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function validaPalabra($palabra, $glosario, $idDefinicion) {
        if ($idDefinicion != 0) { //es guardar editar, validar que el la palabra no exista en otro rgistro diferente al que se esta modificando y el mismo glosario
            $query = $this->db->query("SELECT idDefinicion FROM definicion
					where palabra=? AND idDefinicion<>? AND activo=1
                                        AND idGlosario=? LIMIT 1", array($palabra, $idDefinicion, $glosario));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        } else {
            $query = $this->db->query("SELECT idDefinicion FROM definicion
					where activo=1 and palabra=? AND idGlosario=? LIMIT 1", array($palabra, $glosario));
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row;
            } else {
                return null;
            }
        }
    }

    public function insertarDefinicion($data) {
        try {

            $this->db->trans_begin();
            $definicion_data = array(
                "idGlosario" => $data['idGlosario'],
                "palabra" => $data['palabra'],
                "definicion" => $data['definicion'],
                "activo" => $data['activo']);
            //poner estatus activo=0 a todas las palabras iguales anteriores del glosario
            $query = $this->db->query("update definicion set activo=0 where palabra='{$data['palabra']}' and idGlosario={$data['idGlosario']}");
 
            //si cambio la palabra poner inactiva la palabra anterior
            if ($data['idDefinicion'] != 0)
                $this->db->query("update definicion set activo=0 where idDefinicion=?", array($data['idDefinicion']));
            //guardar nueva palabra
            $this->db->insert("definicion", $definicion_data);
            $insertID = $this->db->insert_id();

            //insertar registro en el log
            $operacion = 1; //nuevo
            if ($data['idDefinicion'] != 0)
                $operacion = 4; //modificacion

            $log_data = array(
                "idDefinicion" => $insertID,
                "idOperacion" => $operacion,
                "idUsuario" => $this->session->userdata('idUsuario'),
                "idRol" => $this->session->userdata('idRol'),
                "nuevo" => $data['idDefinicion']);
            $this->load->model('modeloHistorial');
            $this->modeloHistorial->insertarCambioGlosario($log_data);
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
