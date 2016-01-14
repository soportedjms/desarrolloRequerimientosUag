<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModeloActividad extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_actividades() {
        $query = $this->db->query("SELECT actividad.*, proyecto.nombre nombreProyecto"
                . " FROM actividad "
                . " inner join proyecto on proyecto.idProyecto=actividad.idProyecto"
                . " order by proyecto.nombre, actividad.ordenEjecucion ");
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_actividad($id) {

        $query = $this->db->query("SELECT *  FROM actividad
                where idActividad=? LIMIT 1", array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

     public function get_actividadesFiltro($proyecto,$default,$modificacion) {
         $consulta="SELECT idActividad, descripcion, ordenEjecucion, duracionHrs, "
                . " '' responsable, duracionHrs hrsReales "
                . " FROM actividad "
                . " where idproyecto=" . $proyecto;
        if ($default==1)
               $consulta= $consulta . " and actividadDefault=1 ";
        if ($modificacion==1)
            $consulta= $consulta . " and defaultModificacion=1 ";
        $consulta= $consulta . " order by ordenEjecucion ";
        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
            
      public function get_actividadesProyecto($idProyecto, $actividades, $incluirActividades) {
          $consulta="SELECT idActividad, descripcion, ordenEjecucion, duracionHrs, "
                . " '' responsable, duracionHrs hrsReales "
                . " FROM actividad "
                . " where idproyecto=" . $idProyecto;
        if ($actividades != "") {
            if ($incluirActividades == 1)
                $consulta = $consulta . " AND idActividad in (" . $actividades . ")";
            else {
                $consulta = $consulta . " AND idActividad not in (" . $actividades . ")";
            }
        }

        $query = $this->db->query($consulta);
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
    public function insertarActividad($data) {
        try {
            $this->db->trans_begin();
            $actividad_data = array(
                "descripcion" => $data['descripcion'],
                "actividadDefault" => $data['actividadDefault'],
                "defaultModificacion" => $data['defaultModificacion'],
                "ordenEjecucion" => $data['ordenEjecucion'],
                "duracionHrs" => $data['duracionHrs'],
                "idProyecto" => $data['idProyecto']);

            $insert = $this->db->insert("actividad", $actividad_data);
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

    public function editarActividad($data) {
        try {
            $actividad = $data['actividad'];
            $actividad_data = array(
                "descripcion" => $actividad['descripcion'],
                "actividadDefault" => $actividad['actividadDefault'],
                "defaultModificacion" => $actividad['defaultModificacion'],
                "ordenEjecucion" => $actividad['ordenEjecucion'],
                "duracionHrs" => $actividad['duracionHrs'],
                "idProyecto" => $actividad['idProyecto']);
            $this->db->trans_begin();
            $insert = $this->db->update("actividad", $actividad_data, array('idActividad' => $actividad["idActividad"]));

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

    public function eliminarActividad($id) {
        try {
            $this->db->trans_begin();
            $this->db->delete('actividad', array('idActividad' => $id));
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
