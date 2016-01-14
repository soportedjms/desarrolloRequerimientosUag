<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Opciones extends CI_Controller {

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
            $this->todosOpciones();
        }
    }

    public function nuevo() {
        $this->load->view('opciones/nuevo');
    }

    public function guardarNuevo() {
        $data['idModulo'] = $_POST['idModulo'];
        $data['descripcion'] = $_POST['descripcion'];
        $data['nombreControlador'] = $_POST['nombreControlador'];
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloOpcion');
        if (empty($this->modeloOpcion->insertarOpcion($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('opciones/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('modeloOpcion');
        $opcion = $this->modeloOpcion->get_opcion($id);
        $data = array("opcion" => $opcion);
        $this->load->view('opciones/editar', $data);
    }

    public function guardarEditar() {

        $opcion = array("idOpcion" => $_POST['idOpcion'], 'idModulo' => $_POST['idModulo'], 
            'descripcion' => $_POST['descripcion'],'nombreControlador' => $_POST['nombreControlador'] );
        $data = array("opcion" => $opcion);
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloOpcion');
        if (empty($this->modeloOpcion->editarOpcion($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "opcion" => $opcion);
            $this->load->view('opciones/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarOpcion() {
        $opcion = $this->input->post('idopcion');
        $this->load->model('modeloOpcion');
        $val = $this->modeloOpcion->eliminarOpcion($opcion);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosOpciones() {
        $this->load->model('modeloOpcion');
        $opciones = $this->modeloOpcion->get_opciones();
        $data['opciones'] = $opciones;
        $this->load->view('opciones/lista', $data);
    }
}
