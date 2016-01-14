<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelorequerimiento extends CI_Model {

    public function __construct() {
// Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_requerimientos($proyecto, $nombre, $idUsuario, $estatus, $tipo, $prioridad, $historial) {
        $consulta = " SELECT req.*, pro.nombre nombreProyecto,e.descripcion descEstatus, "
                . "   pri.descripcion descPrioridad,t.descripcion descTipo, cr.fechaOperacion fecha "
                . " FROM requerimiento req"
                . " inner join proyecto pro on pro.idProyecto=req.idProyecto "
                . " inner join estatus e on e.idEstatus=req.idEstatus "
                . " inner join prioridad pri on pri.idPrioridad=req.idPrioridad "
                . " inner join tipo_requerimiento t on t.idTipo=req.idTipo"
                . " inner join cambio_requerimiento cr on cr.idRequerimiento=req.idRequerimiento ";

        if ($proyecto == '') {
            $consulta = $consulta . " WHERE req.idProyecto=(SELECT idProyecto FROM proyecto WHERE idEstatus<>3 order by nombre limit 1) ";
        } else {
            $consulta = $consulta . " WHERE req.idProyecto=" . $proyecto;
        }

        if ($historial == 0) {
            $consulta = $consulta . " AND req.activo=1 ";
        }

        if ($nombre != "") {
            $consulta = $consulta . " AND req.nombre like '%" . $nombre . "%' ";
        }

        if ($idUsuario != "") {
            $consulta = $consulta . " AND req.idRequerimientoUsuario='" . $idUsuario . "'";
        }

        if ($estatus != "") {
            $consulta = $consulta . " AND req.idEstatus=" . $estatus;
        }

        if ($tipo != "") {
            $consulta = $consulta . " AND req.idTipo=" . $tipo;
        }

        if ($prioridad != "") {
            $consulta = $consulta . " AND req.idPrioridad=" . $prioridad;
        }
        $consulta = $consulta . " ORDER BY req.idRequerimientoUsuario, pri.orden";
        $query = $this->db->query($consulta);

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

       public function get_requerimientosPantallaInicial(){
        $consulta = " SELECT req.*, pro.nombre nombreProyecto,e.descripcion descEstatus, "
                . "   pri.descripcion descPrioridad,t.descripcion descTipo, cr.fechaOperacion fecha "
                . " FROM requerimiento req"
                . " inner join proyecto pro on pro.idProyecto=req.idProyecto "
                . " inner join estatus e on e.idEstatus=req.idEstatus "
                . " inner join prioridad pri on pri.idPrioridad=req.idPrioridad "
                . " inner join tipo_requerimiento t on t.idTipo=req.idTipo"
                . " inner join cambio_requerimiento cr on cr.idRequerimiento=req.idRequerimiento"
                . " where req.activo=1 ";

        
        $consulta = $consulta . " ORDER BY cr.fechaOperacion, req.idRequerimientoUsuario, pri.orden limit 10";
        $query = $this->db->query($consulta);

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }
    
    
    public function get_requerimientosLineaBase($proyecto, $lineaBase) {
        $consulta = " SELECT req.*,e.descripcion descEstatus, "
                . "   pri.descripcion descPrioridad,t.descripcion descTipo, cr.fechaOperacion fecha "
                . " FROM requerimiento req"
                . " inner join estatus e on e.idEstatus=req.idEstatus "
                . " inner join prioridad pri on pri.idPrioridad=req.idPrioridad "
                . " inner join tipo_requerimiento t on t.idTipo=req.idTipo"
                . " inner join cambio_requerimiento cr on cr.idRequerimiento=req.idRequerimiento "
                . " inner join requerimiento_linea_base rlb on rlb.idRequerimiento=req.idRequerimiento AND rlb.idRequerimientoUsuario=req.idRequerimientoUsuario "
                . " WHERE rlb.idProyecto=".$proyecto
                . " AND rlb.idLineaBase=".$lineaBase;
        $consulta = $consulta . " ORDER BY req.idRequerimientoUsuario, pri.orden";
        $query = $this->db->query($consulta);

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function validaRequerimiento($proyecto, $idUsuario) {
        $query = $this->db->query("SELECT idRequerimientoUsuario FROM requerimiento
					where idProyecto=? AND activo=1
                                        AND idRequerimientoUsuario=? LIMIT 1", array($proyecto, $idUsuario));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function get_requerimiento($idReq, $idReqUsuario) {
        $query = $this->db->query("SELECT r.*, estatus.descripcion descEstatus
                FROM requerimiento r
                INNER JOIN estatus ON estatus.idEstatus=r.idEstatus
                where r.idRequerimiento=? AND r.idRequerimientoUsuario=? LIMIT 1", array($idReq, $idReqUsuario));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        } else {
            return null;
        }
    }

    public function get_requerimientoAtributos($idReq, $idReqUsuario) {
        $query = $this->db->query("SELECT a.idAtributo,a.descripcion,a.valor,"
                . " CASE WHEN ra.idAtributo IS NULL THEN 0 ELSE 1 END activo "
                . " FROM atributo a"
                . " LEFT JOIN requerimiento_atributo ra ON ra.idAtributo=a.idAtributo"
                . " AND ra.idRequerimientoUsuario=? "
                . " order by descripcion", array($idReqUsuario));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_requerimientoPeticiones($idReq, $idReqUsuario) {
        $query = $this->db->query("SELECT pi.idPeticion, pi.nombre, pi.descripcion "
                . " FROM requerimiento_peticion_interesados rpi "
                . " INNER JOIN peticion_interesados pi ON pi.idPeticion=rpi.idPeticion"
                . " WHERE rpi.idRequerimientoUsuario=?", array($idReqUsuario));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_requerimientoArtefactos($idReq, $idReqUsuario) {
        $query = $this->db->query("SELECT a.idArtefacto, a.descripcion "
                . " FROM requerimiento_artefacto ra "
                . " INNER JOIN artefacto a ON ra.idArtefacto=a.idArtefacto"
                . " WHERE ra.idRequerimientoUsuario=?", array($idReqUsuario));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_requerimientoActividades($idReq, $idReqUsuario) {
        $query = $this->db->query("SELECT ra.idActividad, a.descripcion, a.ordenEjecucion, a.duracionHrs, "
                . " ra.responsable, ra.hrsReales, ra.idEstatus, ra.idRequerimiento,e.descripcion descEstatus"
                . " FROM requerimiento_actividad ra"
                . " INNER JOIN estatus e ON e.idEstatus=ra.idEstatus "
                . " INNER JOIN actividad a ON ra.idActividad=a.idActividad"
                . " WHERE ra.idRequerimientoUsuario=?"
                . " ORDER BY a.ordenEjecucion", array($idReqUsuario));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    public function get_requerimientosActivosNoAsignados($proyecto) {
        $query = $this->db->query("SELECT r.idRequerimiento, r.idRequerimientoUsuario "
                . " FROM requerimiento r "
//                . " LEFT JOIN requerimiento_linea_base rlb ON rlb.idRequerimiento=r.idRequerimiento "
//                . "     AND rlb.idRequerimientoUsuario=r.idRequerimientoUsuario where AND rlb.idRequerimiento IS NULL"
                . " WHERE r.idProyecto=? AND r.activo=1 AND r.idEstatus=8  ", array($proyecto));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

    function insertaLogRequerimiento($idReq, $idReqUs, $oper, $idAct) {
        $log_data = array(
            "idRequerimiento" => $idReq,
            "idRequerimientoUsuario" => $idReqUs,
            "idOperacion" => $oper,
            "idUsuario" => $this->session->userdata('idUsuario'),
            "idRol" => $this->session->userdata('idRol'),
            "idActividad" => $idAct);
        $this->Modelohistorial->insertarCambioRequerimiento($log_data);
    }

    public function validaActividades($idReq, $idUsuario, $actividadesNuevas) {
        //Validar si alguna actividad cambio, para insertar en en el log, 
        //después eliminarlas e insertar las que quedaron
        $actividades = $this->get_requerimientoActividades('', $idUsuario);
        //Si no tenía y sigue sin tenerlo
        if ($actividadesNuevas == "" && empty($actividades)) {
            return;
        }
        $this->load->model('Modelohistorial');
        //si tenia y se le quitaron
        if (!empty($actividades) && $actividadesNuevas == "") {
            //guardar log de que fueron eliminadas
            foreach ($actividades as $val) {
                $this->insertaLogRequerimiento($val["idRequerimiento"], $idUsuario, 2, $val["idActividad"]);
            }
        }
        //si no tenia y se le añadieron
        if (empty($actividades) && $actividadesNuevas != "") {
            //guardar log de que se crearon
            foreach ($actividadesNuevas as $val) {
                $this->insertaLogRequerimiento($idReq, $idUsuario, 1, $val['id']);
            }
        }
        //si ambos tenían y se modificaron
        if (!empty($actividades) && $actividadesNuevas != "") {
            //Si se elimino
            $encontrado = array();
            foreach ($actividades as $val) {
                $encontrado = array();
                foreach ($actividadesNuevas as $valN) {
                    if ($val["idActividad"] == $valN["id"]) {
                        $encontrado = $valN;
                        break;
                    }
                }
                if (!empty($encontrado)) { //Se encontró validar si cambio
                    if ($val["hrsReales"] != $encontrado["hrsReales"] ||
                            $val["responsable"] != $encontrado["responsable"] ||
                            $val["idEstatus"] != $encontrado["idEstatus"])
                        $this->insertaLogRequerimiento($val["idRequerimiento"], $idUsuario, 4, $val["idActividad"]);
                }
                else { //, si no entonces se eliminó  Insertar en el log la eliminación
                    $this->insertaLogRequerimiento($val["idRequerimiento"], $idUsuario, 2, $val["idActividad"]);
                }
            }
            //si se inserto---Falta
        }
        //Borrar actividades, posteriormente se vuelven a insertar
        $this->db->query("delete from requerimiento_actividad "
                . " where idRequerimientoUsuario='{$idUsuario}'");
    }

    public function guardarCambioEstatus($cambiados) {
        try {
            $this->db->trans_begin();
            //Validar si es cancelado, cambiar estatus de actividades
            $this->load->model('Modelohistorial');
            foreach ($cambiados as $val) {
                if ($val["idEstatus"] == 2) {
                    //cambiar estatus de las actividades
                    $this->db->query("update requerimiento_actividad set idEstatus=2 "
                            . " where idRequerimientoUsuario='{$val["idRequerimientoUsuario"]}'");
                }

                //Traer la información del requerimiento para insertarlo con el nuevo estatus
                $query = $this->db->query("SELECT r.*
                FROM requerimiento r
                where r.idRequerimiento=? AND r.idRequerimientoUsuario=? LIMIT 1", array($val["idRequerimiento"], $val["idRequerimientoUsuario"]));
                $requerimiento = $query->row_array();
                //Actualizar los requerimientos anteriores a activo=0
                $this->db->query("update requerimiento set activo=0 "
                        . " where idRequerimientoUsuario='{$val["idRequerimientoUsuario"]}'");
                //Extraer informacion del requerimiento para duplicarlo con el nuevo estatus
                $req = array("idRequerimientoUsuario" => $requerimiento['idRequerimientoUsuario'],
                    "nombre" => $requerimiento['nombre'],
                    "precondicion" => $requerimiento['precondicion'],
                    "postcondicion" => $requerimiento['postcondicion'],
                    "descripcionCorta" => $requerimiento['descripcionCorta'],
                    "descripcionDetallada" => $requerimiento['descripcionDetallada'],
                    "idProyecto" => $requerimiento['idProyecto'],
                    "idTipo" => $requerimiento['idTipo'],
                    "idPrioridad" => $requerimiento['idPrioridad'],
                    "idEstatus" => $val["idEstatus"],
                    "activo" => 1);
                //Insertar requerimiento 
                $this->db->insert("requerimiento", $req);
                $insertID = $this->db->insert_id();
                //Insertar log de la operacion
                $log_data = array(
                    "idRequerimiento" => $insertID,
                    "idRequerimientoUsuario" => $val["idRequerimientoUsuario"],
                    "idOperacion" => 3,
                    "idUsuario" => $this->session->userdata('idUsuario'),
                    "idRol" => $this->session->userdata('idRol'),
                    "idActividad" => NULL);
                $this->Modelohistorial->insertarCambioRequerimiento($log_data);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return array("status" => false, "message" => $ex->getMessage());
        }
    }

    public function guardarRequerimiento($idRequerimiento, $idUsuario, $requerimiento, $extras, $nuevo) {
        try {
            $this->db->trans_begin();
            //Cambiar activo=0 de requerimiento pasado  si es editar y eliminar antes de insertar
            $cambio = 0;
            if ($nuevo != 1) {
                //Cambiar activo
                $this->db->query("update requerimiento set activo=0 "
                        . " where idRequerimientoUsuario='{$idUsuario}'");
                //Traer version anterior del requerimiento para validar si cambió o si se agrego algún artefacto nuevo
                $reqAnt = $this->get_requerimiento($idRequerimiento, $idUsuario);
                $artAnt = $this->get_requerimientoArtefactos($idRequerimiento, $idUsuario);
                //Si el estatus del requisito es 3 en adelante entonces  y poner el estatus del 
                //requisito en 3
                if (($reqAnt["descripcionCorta"] != $requerimiento["descripcionCorta"] ||
                        $reqAnt["descripcionDetallada"] != $requerimiento["descripcionDetallada"] ||
                        count($artAnt) < count($extras['artefactos'])) && $requerimiento["idEstatus"] >= 3) {
                    $cambio = 1;
                    //modificar estatus del requisito
                    $requerimiento["idEstatus"] = 3;
                }
            }
            //Insertar requerimiento 
            $this->db->insert("requerimiento", $requerimiento);
            $insertID = $this->db->insert_id(); //////////////Revisar si regresa el consecutivo         

            if ($nuevo != 1) {
                $this->db->query("delete from requerimiento_atributo "
                        . " where idRequerimientoUsuario='{$idUsuario}'");
                $this->db->query("delete from requerimiento_peticion_interesados "
                        . " where idRequerimientoUsuario='{$idUsuario}'");
                $this->db->query("delete from requerimiento_artefacto "
                        . " where idRequerimientoUsuario='{$idUsuario}'");
                $this->validaActividades($insertID, $idUsuario, $extras['actividades']);
            }

            if ($cambio == 1) {
                // si el requisito cambio en los campos especificados entonces 
                // asignar actividades default Modificacion, estatus de actividades, y modificar estatus de casos de prueba
                $this->db->query("update caso_prueba set idEstatus=3 "
                        . " where idCasoPrueba IN (SELECT idCasoPrueba from requerimiento_caso_prueba WHERE "
                        . "    idRequerimientoUsuario='{$idUsuario}')");
                //Traer actividades modificacionDefault=1 y verificar cual no esta agregada para añadirla,
                //y cambiar estatus de todas
                $this->load->model('Modeloactividad');
                $actModificacion = $this->Modeloactividad->get_actividadesFiltro($requerimiento["idProyecto"], 0, 1);
                if (!empty($actModificacion)) {
                    foreach ($actModificacion as $val) {
                        $encontro = 0;
                        foreach ($extras['actividades'] as $act) {
                            if ($act["id"] == $val["idActividad"]) {
                                $encontro = 1;
                                break;
                            }
                        }
                        if ($encontro == 0) { //No existe, insertar
                            $ac = array(
                                "idActividad" => $val['idActividad'],
                                "idRequerimiento" => $insertID,
                                "idRequerimientoUsuario" => $idUsuario,
                                "hrsReales" => $val['hrsReales'],
                                "responsable" => $val['responsable'],
                                "idEstatus" => 1);
                            $this->db->insert("requerimiento_actividad", $ac);
                        }
                    }
                }
            }
//Insertar actividades
            $actividades = array();
            if ($extras["actividades"] != "") {
                foreach ($extras['actividades'] as $val) {
                    $estatus = $val['idEstatus'];
                    if ($cambio == 1)
                        $estatus = 1;
                    $actividades = array(
                        "idActividad" => $val['id'],
                        "idRequerimiento" => $insertID,
                        "idRequerimientoUsuario" => $idUsuario,
                        "hrsReales" => $val['hrsReales'],
                        "responsable" => $val['responsable'],
                        "idEstatus" => $estatus);
                    $this->db->insert("requerimiento_actividad", $actividades);
                }
            }

//Insertar información de los atributos
            $atributos = array();
            if ($extras["atributos"] != "") {
                foreach ($extras['atributos'] as $val) {
                    $atributos = array(
                        "idAtributo" => $val['id'],
                        "idRequerimiento" => $insertID,
                        "idRequerimientoUsuario" => $idUsuario);
                    $this->db->insert("requerimiento_atributo", $atributos);
                }
            }

//Insertar información de los artefactos
            $artefactos = array();
            if ($extras["artefactos"] != "") {
                foreach ($extras['artefactos'] as $val) {
                    $artefactos = array(
                        "idArtefacto" => $val['id'],
                        "idRequerimiento" => $insertID,
                        "idRequerimientoUsuario" => $idUsuario);
                    $this->db->insert("requerimiento_artefacto", $artefactos);
                }
            }

//Insertar información de las peticiones
            $peticiones = array();
            if ($extras["peticiones"] != "") {
                foreach ($extras['peticiones'] as $val) {
                    $peticiones = array(
                        "idPeticion" => $val['id'],
                        "idRequerimiento" => $insertID,
                        "idRequerimientoUsuario" => $idUsuario);
                    $this->db->insert("requerimiento_peticion_interesados", $peticiones);
                }
            }

//insertar registro en el log
            $operacion = 1; //nuevo
            if ($nuevo != 1) {
                $operacion = 4;
            } //modificacion

            $log_data = array(
                "idRequerimiento" => $insertID,
                "idRequerimientoUsuario" => $idUsuario,
                "idOperacion" => $operacion,
                "idUsuario" => $this->session->userdata('idUsuario'),
                "idRol" => $this->session->userdata('idRol'),
                "idActividad" => NULL);
            $this->load->model('Modelohistorial');
            $this->Modelohistorial->insertarCambioRequerimiento($log_data);

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

    public function estatusActividadesCasosPrueba($idReqUsuario) {
        $query = $this->db->query("SELECT  requerimiento.* "
                . " from requerimiento "
                . " inner join requerimiento_actividad on requerimiento_actividad.idRequerimientoUsuario=requerimiento.idRequerimientoUsuario "
                . " where requerimiento.idRequerimientoUsuario=? and requerimiento_actividad.idEstatus<>8 "
                . " union ALL "
                . " select requerimiento.* "
                . " from requerimiento "
                . " inner join requerimiento_caso_prueba on requerimiento.idRequerimientoUsuario=requerimiento_caso_prueba.idRequerimientoUsuario "
                . " inner join caso_prueba on caso_prueba.idCasoPrueba=requerimiento_caso_prueba.idCasoPrueba "
                . " where requerimiento.idRequerimientoUsuario=? and caso_prueba.idEstatus<>8", array($idReqUsuario, $idReqUsuario));
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        } else {
            return null;
        }
    }

}
