<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estatus extends CI_Controller {

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
            $this->todosEstatus();
        }
    }

    public function nuevo() {
        $this->load->view('estatus/nuevo');
    }

    public function guardarNuevo() {
        $todos = 0;
        $requisitos = 0;
        $actividades = 0;
        if (isset($_POST['todos']))
            $todos = 1;
        if (isset($_POST['requisitos']))
            $requisitos = 1;
        if (isset($_POST['actividades']))
            $actividades = 1;
        $data['descripcion'] = $_POST['descripcion'];
        $data["todos"] = $todos;
        $data["requisitos"] = $requisitos;
        $data["actividades"] = $actividades;
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloEstatus');
        if (empty($this->modeloEstatus->insertarEstatus($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('estatus/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('modeloEstatus');
        $estatus = $this->modeloEstatus->get_estatus_part($id);
        $data = array("estatus" => $estatus);
        $this->load->view('estatus/editar', $data);
    }

    public function guardarEditar() {
        $todos = 0;
        $requisitos = 0;
        $actividades = 0;
        if (isset($_POST['todos']))
            $todos = 1;
        if (isset($_POST['requisitos']))
            $requisitos = 1;
        if (isset($_POST['actividades']))
            $actividades = 1;
        $estatus = array("idEstatus" => $_POST['idEstatus'], 'descripcion' => $_POST['descripcion'],
            "todos" => $todos, "requisitos" => $requisitos, "actividades" => $actividades);
        $data = array("estatus" => $estatus);
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloEstatus');
        if (empty($this->modeloEstatus->editarEstatus($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "estatus" => $estatus);
            $this->load->view('estatus/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarEstatus() {
        $estatus = $this->input->post('idestatus');
        $this->load->model('modeloEstatus');
        $val = $this->modeloEstatus->eliminarEstatus($estatus);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    public function llenaComboActividades() {
        $stri = llenaComboEstatus("1", "A");
        echo $stri;
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosEstatus() {
        $this->load->model('modeloEstatus');
        $estatus = $this->modeloEstatus->get_estatus();
        $data['estatus'] = $estatus;
        $this->load->view('estatus/lista', $data);
    }

}
