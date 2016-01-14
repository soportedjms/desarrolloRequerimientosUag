<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Glosarios extends CI_Controller {

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
            $this->todosGlosarios();
        }
    }

    public function nuevo() {
        $this->load->view('glosarios/nuevo');
    }

    public function guardarNuevo() {
        $data['nombre'] = $_POST['nombre'];
        $data['descripcion'] = $_POST['descripcion'];
        $data['objetivo'] = $_POST['objetivo'];
        $data['idProyecto'] = $_POST['idProyecto'];
        $data['idEstatus'] = $_POST['estatus'];

        $error_msg = $this->validaGuardar($data['idProyecto'],0);
        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg);
            $this->load->view('glosarios/nuevo', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modeloglosario');
            if (empty($this->Modeloglosario->insertarGlosario($data))) {
                $error_msg = "No se pudo insertar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('glosarios/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id) {
        $this->load->model('Modeloglosario');
        $glosario = $this->Modeloglosario->get_glosario($id);
        $data = array("glosario" => $glosario);
        $this->load->view('glosarios/editar', $data);
    }

    public function guardarEditar() {
        $glosario = array("idGlosario" => $_POST['idGlosario'], 'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'], "objetivo" => $_POST['objetivo'], 
            'idProyecto' => $_POST['idProyecto'],'idEstatus' => $_POST['estatus']);
        $data = array("glosario" => $glosario);

        $error_msg = "";
        $error_msg = $this->validaGuardar($_POST['idProyecto'],$_POST['idGlosario']);

        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg, "glosario" => $glosario);
            $this->load->view('glosarios/editar', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modeloglosario');
            if (empty($this->Modeloglosario->editarGlosario($data))) {
                $error_msg = "No se pudo editar el registro.";
                $data = array("mensaje" => $error_msg, "glosario" => $glosario);
                $this->load->view('glosarios/editar', $data);
            } else {
                $this->index();
            }
        }
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosGlosarios() {
        $this->load->model('Modeloglosario');
        $glosarios = $this->Modeloglosario->get_glosarios();
        $data['glosarios'] = $glosarios;
        $this->load->view('glosarios/lista', $data);
    }

    function validaGuardar($proyecto,$glosario) {
       $this->load->model('Modeloglosario');
        $glosario = $this->Modeloglosario->validaGlosario($proyecto, $glosario);

        $error_msg = "";
        if (!empty($glosario)) {
            $error_msg = "Ya existe un glosario para el proyecto proporcionado.";
        }

        return $error_msg;
    }

}
