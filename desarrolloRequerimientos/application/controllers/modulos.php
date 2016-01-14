<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modulos extends CI_Controller {

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
            $this->todosModulos();
        }
    }

    public function nuevo() {
        $this->load->view('modulos/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        $data['nombreIcono'] = $_POST['nombreIcono'];

        $error_msg = $this->validaGuardar($_POST['descripcion'], 0);
        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg);
            $this->load->view('modulos/nuevo', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modelomodulo');
            if (empty($this->Modelomodulo->insertarModulo($data))) {
                $error_msg = "No se pudo insertar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('modulos/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id) {
        $this->load->model('Modelomodulo');
        $modulo = $this->Modelomodulo->get_modulo($id);
        $data = array("modulo" => $modulo);
        $this->load->view('modulos/editar', $data);
    }

    public function guardarEditar() {

        $modulo = array("idModulo" => $_POST['idModulo'], 'descripcion' => $_POST['descripcion'],
            'nombreIcono' => $_POST['nombreIcono']);

        $data = array("modulo" => $modulo);

        $error_msg = "";
        $error_msg = $this->validaGuardar($_POST['descripcion'], $_POST['idModulo']);

        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg, "modulo" => $modulo, 'nombreIcono' => $_POST['nombreIcono']);
            $this->load->view('modulos/editar', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modelomodulo');
            if (empty($this->Modelomodulo->editarModulo($data))) {
                $error_msg = "No se pudo editar el registro.";
                $data = array("mensaje" => $error_msg, "modulo" => $modulo);
                $this->load->view('modulos/editar', $data);
            } else {
                $this->index();
            }
        }
    }

    public function eliminarModulo() {
        $modulo = $this->input->post('idmodulo');
        $this->load->model('Modelomodulo');
        $val = $this->Modelomodulo->eliminarModulo($modulo);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosModulos() {
        $this->load->model('Modelomodulo');
        $modulos = $this->Modelomodulo->get_modulos();
        $data['modulos'] = $modulos;
        $this->load->view('modulos/lista', $data);
    }

    function validaGuardar($descripcion, $id) {
        //Validar que el usuario no exista
        $this->load->model('Modelomodulo');
        $modulo = $this->Modelomodulo->validaModulo($descripcion, $id);

        $error_msg = "";
        if (!empty($modulo)) {
            $error_msg = "Ya existe el modulo proporcionado.";
        }

        return $error_msg;
    }

}
