<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Atributos extends CI_Controller {

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
            $this->todosAtributos();
        }
    }

    public function nuevo() {
        $this->load->view('atributos/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        $data['valor'] = $_POST['valor'];

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modeloatributo');
        $id = $this->Modeloatributo->insertarAtributo($data);

        if (isset($id)) {
            $this->index();
        } else {
            $error_msg = "No se pudo insertar el atributo.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('atributos/nuevo', $data);
        }
    }

    public function editar($id) {
        $this->load->model('Modeloatributo');
        $atributos = $this->Modeloatributo->get_atributo($id);
        $data = array("atributo" => $atributos);
        $this->load->view('atributos/editar', $data);
    }

    public function guardarEditar() {
        $atributo = array("idAtributo" => $_POST['idAtributo'], 'descripcion' => $_POST['descripcion'],
            'valor' => $_POST['valor']);
        $data = array("atributo" => $atributo);

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modeloatributo');
        $id = $this->Modeloatributo->editarAtributo($data);

        if (isset($id)) {
            $this->index();
        } else {
            $error_msg = "No se pudo actualizar el registro.";
            $data = array("mensaje" => $error_msg, "atributo" => $atributo);
            $this->load->view('atributos/editar', $data);
        }
    }


    public function eliminarAtributo() {
        $atributo= $this->input->post('idatributo');
        $this->load->model('Modeloatributo');
        if (empty( $this->Modeloatributo->eliminarAtributo($atributo)))
            echo 'no';
        else
            echo 'ok';
    }


    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosAtributos() {
        $this->load->model('Modeloatributo');
        $atributos = $this->Modeloatributo->traerAtributos();
        $data['atributos'] = $atributos;
        $this->load->view('atributos/lista', $data);
    }
}
