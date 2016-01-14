<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LineasBase extends CI_Controller {

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
            $this->todosLineasBase('1');
        }
    }

    public function consulta() {
        $proyecto = $_POST['idProyecto'];
        $this->todosLineasBase($proyecto);
    }

    public function nuevo() {
        $this->load->view('lineasBase/nuevo');
    }

    public function guardarNuevo() {
        $datos = array("idProyecto" => $_POST['idProyecto'], "nombre" => $_POST['nombre'], "descripcion" => $_POST['descripcion'],
            "estatus" => $_POST['estatus']);
        $proyecto = $_POST['idProyecto'];
        $data['idProyecto'] = $proyecto;
        $data['nombre'] = $_POST['nombre'];
        $data['descripcion'] = $_POST['descripcion'];
        $data['estatus'] = $_POST['estatus'];
        //Validar si existen requisitos para ser agregados, requisitos terminados activos
        $this->load->model('Modelorequerimiento');
        $requerimientos = $this->Modelorequerimiento->get_requerimientosActivosNoAsignados($proyecto);
        if (empty($requerimientos)) {
            $error_msg = "No existen requerimientos para agregar a la nueva línea base.";
            $data = array("mensaje" => $error_msg, "datos" => $datos);
            $this->load->view('lineasBase/nuevo', $data);
        } else {
            //Traer definiciones a ser agregadas
            $this->load->model('Modelodefinicion');
            $definiciones = $this->Modelodefinicion->get_definicionProyectoActivos($proyecto);
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modelolineabase');
            if (empty($this->Modelolineabase->generarLineaBase($data, $requerimientos, $definiciones))) {
                $error_msg = "No se pudo generar la línea base.";
                $data = array("mensaje" => $error_msg, "datos" => $datos);
                $this->load->view('lineasBase/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id, $proyecto) {
        $this->load->model('Modelolineabase');
        $lineaBase = $this->Modelolineabase->get_LineasBase($proyecto, $id);

        $data = array("datos" => $lineaBase);
        $this->load->view('lineasBase/editar', $data);
    }

    public function guardarEditar() {
        $estaAprobada=0;
         if (isset($_POST['estaAprobada']))
            $estaAprobada = 1;
        $datos = array("idProyecto" => $_POST['idProyecto'], "nombre" => $_POST['nombre'], "descripcion" => $_POST['descripcion'],
            "estatus" => $_POST['estatus'], "idLineaBase" => $_POST['idLineaBase'], "estaAprobada" => $estaAprobada);
        //Editar
        $this->load->model('Modelolineabase');
        if (empty($this->Modelolineabase->editarLineaBase($datos))) {
            $error_msg = "No se pudo actualizar la línea base.";
            $data = array("mensaje" => $error_msg, "datos" => $datos);
            $this->load->view('lineasBase/editar', $data);
        } else {
            $this->index();
        }
    }

     public function detalle($id, $proyecto) {
        $this->load->model('Modelolineabase');
        $lineaBase = $this->Modelolineabase->get_LineasBase($proyecto, $id);
        $this->load->model('Modelodefinicion');
        $definiciones=$this->Modelodefinicion->get_definicionesLineaBase($proyecto,$id);
        $this->load->model('Modelorequerimiento');
        $requerimientos=$this->Modelorequerimiento->get_requerimientosLineaBase($proyecto, $id);
        $data = array("datos" => $lineaBase,"definiciones"=>$definiciones,"requerimientos"=>$requerimientos);
        $this->load->view('lineasBase/detalle', $data);
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosLineasBase($proyecto) {
        $consulta = array("idProyecto" => $proyecto);
        $this->load->model('Modelolineabase');
        $lineasBase = $this->Modelolineabase->get_LineasBase($proyecto, '');
        $data = array("lineasBase" => $lineasBase, "consulta" => $consulta);
        $this->load->view('lineasBase/lista', $data);
    }

}
