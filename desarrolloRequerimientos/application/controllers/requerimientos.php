<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Requerimientos extends CI_Controller {

    public function __constructor() {
        parent::__constructor();
    }

    // this is the home page
    public function index() {
        if (!is_logged_in()) {
            redirect(base_url() . 'index.php/login');
        }
        if ($this->input->post('nuevo')) {
            $this->nuevo();
        } else {
            $this->todosRequerimientos('', '', '', '', '', '', 0);
        }
    }

    public function consulta() {
        $historial = 0;
        if (isset($_POST['historial']))
            $historial = 1;
        $id = $_POST['idRequerimiento'];
        $proyecto = $_POST['idProyecto'];
        $nombre = $_POST['nombre'];
        $estatus = $_POST['estatus'];
        $tipo = $_POST['idTipo'];
        $prioridad = $_POST['idPrioridad'];
        $this->todosRequerimientos($proyecto, $nombre, $id, $estatus, $tipo, $prioridad, $historial);
    }

    public function nuevo() {
        $this->load->model('modeloAtributo');
        $atributos = $this->modeloAtributo->traerAtributos();
        $this->load->model('modeloActividad');
        $actividades = $this->modeloActividad->get_actividadesFiltro(1, 1, 0);
        $data = array("atributos" => $atributos, "actividades" => $actividades);
        $this->load->view('requerimientos/nuevo', $data);
    }

    public function editar($idReq, $idReqUsuario, $opcion) {
        //Opcion E=Editar D=Detalle (Mandar disabled)
        //Traer información del requerimiento
        $this->load->model('modeloRequerimiento');
        $requerimiento = $this->modeloRequerimiento->get_requerimiento($idReq, $idReqUsuario);
        //Traer información de los atributos
        $atributos = $this->modeloRequerimiento->get_requerimientoAtributos($idReq, $idReqUsuario);
        //Traer información de las peticiones
        $peticiones = $this->modeloRequerimiento->get_requerimientoPeticiones($idReq, $idReqUsuario);
        ////Traer información de los artefactos
        $artefactos = $this->modeloRequerimiento->get_requerimientoArtefactos($idReq, $idReqUsuario);
        //Traer información de las actividades
        $actividades = $this->modeloRequerimiento->get_requerimientoActividades($idReq, $idReqUsuario);
        //Enviar todo al formulario
        $modificar = "";
        $detalle = "";
        if ($opcion == "E") {
            $modificar = "";
            $detalle = 'style="display:none;"';
            $data = array("requerimiento" => $requerimiento, "atributos" => $atributos, "peticiones" => $peticiones,
                "artefactos" => $artefactos, "actividades" => $actividades, "disabled" => "",
                "operacion" => "E", "modificar" => $modificar, "detalle" => $detalle);
        } else {
            $modificar = 'style="display:none;"';
            $detalle = '';
            $data = array("requerimiento" => $requerimiento, "atributos" => $atributos, "peticiones" => $peticiones,
                "artefactos" => $artefactos, "actividades" => $actividades, "disabled" => "disabled",
                "operacion" => "D", "modificar" => $modificar, "detalle" => $detalle);
        }
        $this->load->view('requerimientos/editar', $data);
    }

    public function guardar() {
        $json = $this->input->post('jsonGuardar');
        $nuevo = $this->input->post('nuevo');
        $req = json_decode($json, true);
        //Extraer información del requerimiento
        $requerimiento = array("idRequerimientoUsuario" => $req['idUsuario'],
            "nombre" => $req['nombre'],
            "precondicion" => $req['precondicion'],
            "postcondicion" => $req['postcondicion'],
            "descripcionCorta" => $req['descripcionCorta'],
            "descripcionDetallada" => $req['descripcionDetallada'],
            "idProyecto" => $req['idProyecto'],
            "idTipo" => $req['idTipo'],
            "idPrioridad" => $req['idPrioridad'],
            "idEstatus" => $req['idEstatus'],
            "activo" => 1);
        $idRequerimiento = 0;
        if ($nuevo != 1)
            $idRequerimiento = $req['idRequerimiento'];
        $this->load->model('modeloRequerimiento');
        $resultado = $this->modeloRequerimiento->guardarRequerimiento($idRequerimiento, $req['idUsuario'], $requerimiento, $req, $nuevo);
        if (empty($resultado)) {
            echo "No";
        } else {
            echo "Si";
        }
    }

    public function guardarCambioEstatus() {
        $json = $this->input->post('json');
        $req = json_decode($json, true);      
        $this->load->model('modeloRequerimiento');
        //Extraer información de los requisitos cambiados
        foreach ($req['cambiados'] as $val) {
            //Validar que si es terminado todas las actividades y los casos de prueba estén en terminados
            if ($val["idEstatus"]==8)
            {
                if (!empty($this->modeloRequerimiento->estatusActividadesCasosPrueba($val["idRequerimientoUsuario"])))
                {
                    echo 'No se puede cambiar a estatus "Terminado" el requisito "' . $val["idRequerimientoUsuario"] 
                            . '" ya que tiene casos de pruebas o actividades pendientes de terminar.';
                    return;
                }
            }
        }

        $resultado = $this->modeloRequerimiento->guardarCambioEstatus($req['cambiados']);
//        var_dump( $resultado);
//        return;
        if (empty($resultado)) {
            echo "No se pudo realizar la actualización de los estatus.";
        } else {
            echo "Si";
        }
    }

    public function validaGuardar() {
        $proyecto = $this->input->post('idproyecto');
        $idUsuario = $this->input->post('idusuario');
        $idProyectoOri = $this->input->post('idProyectoOri');
        if ($proyecto == $idProyectoOri && $idProyectoOri != 0) {
            echo "";
        } else {
            //Validar que el id de usuario no exista
            $this->load->model('modeloRequerimiento');
            $requerimiento = $this->modeloRequerimiento->validaRequerimiento($proyecto, $idUsuario);
            $error_msg = "";
            if (!empty($requerimiento)) {
                $error_msg = "Ya existe el id de usuario proporcionado.";
            }
            echo $error_msg;
        }
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosRequerimientos($proyecto, $nombre, $idUsuario, $estatus, $tipo, $prioridad, $historial) {
        $consulta = array("idProyecto" => $proyecto, 'nombre' => $nombre,
            "idRequerimiento" => $idUsuario, "idEstatus" => $estatus, "idTipo" => $tipo,
            "idPrioridad" => $prioridad, "historial" => $historial);
        $this->load->model('modeloRequerimiento');
        $requerimientos = $this->modeloRequerimiento->get_requerimientos($proyecto, $nombre, $idUsuario, $estatus, $tipo, $prioridad, $historial);

        $data = array("consulta" => $consulta, "requerimientos" => $requerimientos);
        $this->load->view('requerimientos/lista', $data);
    }

}
