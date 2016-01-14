<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operaciones extends CI_Controller {

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
            $this->todosOperaciones();
        }
    }

    public function nuevo() {
        $this->load->view('operaciones/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modelooperacion');
        if (empty($this->Modelooperacion->insertarOperacion($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('operaciones/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('Modelooperacion');
        $operacion = $this->Modelooperacion->get_operacion($id);
        $data = array("operacion" => $operacion);
        $this->load->view('operaciones/editar', $data);
    }

    public function guardarEditar() {
        $estatus = array("idOperacion" => $_POST['idOperacion'],'descripcion' => $_POST['descripcion'] );
        $data = array("operacion" => $operacion);
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modelooperacion');
        if (empty($this->Modelooperacion->editarOperacion($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "operacion" => $operacion);
            $this->load->view('operaciones/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarOperacion() {
        $operacion = $this->input->post('idoperacion');
        $this->load->model('Modelooperacion');
        $val = $this->Modelooperacion->eliminarOperacion($estatus);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosOperaciones() {
        $this->load->model('Modelooperacion');
        $operacion = $this->Modelooperacion->get_operaciones();
        $data['operaciones'] = $operacion;
        $this->load->view('operaciones/lista', $data);
    }
}
