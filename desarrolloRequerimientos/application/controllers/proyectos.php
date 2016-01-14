<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyectos extends CI_Controller {

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
            $this->todosProyectos();
        }
    }

    public function nuevo() {
        $this->load->view('proyectos/nuevo');
    }

    public function guardarNuevo() {
        $timestamp = strtotime($_POST['fechaInicio']);
        $fechaInicio = date('Y-m-d', $timestamp);
        $timestamp = strtotime($_POST['fechaTermino']);
        $fechaTermino = date('Y-m-d', $timestamp);

        $data['nombre'] = $_POST['nombre'];
        $data['descripcion'] = $_POST['descripcion'];
        $data['fechaInicio'] = $fechaInicio;
        $data['fechaTermino'] = $fechaTermino;
        $data['usuarioCreacion'] = $this->session->userdata('idUsuario');
        ;
        $data['idEstatus'] = $_POST['estatus'];
        $error_msg = $this->validaGuardar($_POST['fechaInicio'], $_POST['fechaTermino']);
        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg);
            $this->load->view('proyectos/nuevo', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modeloproyecto');
            if (empty($this->Modeloproyecto->insertarProyecto($data))) {
                $error_msg = "No se pudo insertar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('proyectos/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id) {
        $this->load->model('Modeloproyecto');
        $proyecto = $this->Modeloproyecto->get_proyecto($id);
        $data = array("proyecto" => $proyecto);
        $this->load->view('proyectos/editar', $data);
    }

    public function guardarEditar() {
        $timestamp = strtotime($_POST['fechaInicio']);
        $fechaInicio = date('Y-m-d', $timestamp);
        $timestamp = strtotime($_POST['fechaTermino']);
        $fechaTermino = date('Y-m-d', $timestamp);

        $proyecto = array("idProyecto" => $_POST['idProyecto'], 'nombre' => $_POST['nombre'], 'descripcion' => $_POST['descripcion'],
            "fechaInicio" => $fechaInicio, 'fechaTermino' => $fechaTermino,
            'usuarioCreacion' => $_POST['usuarioCreacion'], 'idEstatus' => $_POST['estatus']);
        $data = array("proyecto" => $proyecto);

        $error_msg = "";
        $error_msg = $this->validaGuardar($_POST['fechaInicio'], $_POST['fechaTermino']);

        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg, "proyecto" => $proyecto);
            $this->load->view('proyectos/editar', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modeloproyecto');
            if (empty($this->Modeloproyecto->editarProyecto($data))) {
                $error_msg = "No se pudo editar el registro.";
                $data = array("mensaje" => $error_msg, "proyecto" => $proyecto);
                $this->load->view('proyectos/editar', $data);
            } else {
                $this->index();
            }
        }
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosProyectos() {
        $this->load->model('Modeloproyecto');
        $proyecto = $this->Modeloproyecto->get_proyectos();
        $data['proyectos'] = $proyecto;
        $this->load->view('proyectos/lista', $data);
    }

    function validaGuardar($fechaIncio, $fechaTermino) {
        //Validar que el usuario no exista
        $error_msg = "";
        if ((strtotime($fechaIncio) >= strtotime($fechaTermino))) {
            $error_msg = "La fecha de termino debe ser mayor a la fecha de inicio.";
        }
        return $error_msg;
    }

}
