<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prioridades extends CI_Controller {

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
            $this->todosPrioridades();
        }
    }

    public function nuevo() {
        $this->load->view('prioridades/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        $data['orden'] = $_POST['orden'];
        $error_msg = $this->validaGuardar($_POST['orden'], 0);
        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg);
            $this->load->view('prioridades/nuevo', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('modeloPrioridad');
            if (empty($this->modeloPrioridad->insertarPrioridad($data))) {
                $error_msg = "No se pudo insertar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('prioridades/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id) {
        $this->load->model('modeloPrioridad');
        $prioridad = $this->modeloPrioridad->get_prioridad($id);
        $data = array("prioridad" => $prioridad);
        $this->load->view('prioridades/editar', $data);
    }

    public function guardarEditar() {

        $prioridad = array("idPrioridad" => $_POST['idPrioridad'], 'descripcion' => $_POST['descripcion'],
            'orden' => $_POST['orden']);
        $data = array("prioridad" => $prioridad);

        $error_msg = "";
        $error_msg = $this->validaGuardar($_POST['orden'], $_POST['idPrioridad']);

        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg, "prioridad" => $prioridad);
            $this->load->view('prioridades/editar', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('modeloPrioridad');
            if (empty($this->modeloPrioridad->editarPrioridad($data))) {
                $error_msg = "No se pudo editar el registro.";
                $data = array("mensaje" => $error_msg, "prioridad" => $prioridad);
                $this->load->view('prioridades/editar', $data);
            } else {
                $this->index();
            }
        }
    }

    public function eliminarPrioridad() {
        $prioridad = $this->input->post('idprioridad');
        $this->load->model('modeloPrioridad');
        $val = $this->modeloPrioridad->eliminarPrioridad($prioridad);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosPrioridades() {
        $this->load->model('modeloPrioridad');
        $prioridades = $this->modeloPrioridad->get_prioridades();
        $data['prioridades'] = $prioridades;
        $this->load->view('prioridades/lista', $data);
    }

    function validaGuardar($orden, $id) {
        //Validar que la prioridad no exista
        $error_msg = "";
        if (!is_numeric($orden)) {
            $error_msg = "El orden debe ser número.";
        } else {
            $this->load->model('modeloPrioridad');
            $prioridad = $this->modeloPrioridad->validaPrioridad($orden, $id);
            if (!empty($prioridad)) {
                $error_msg = "Ya existe el orden proporcionado.";
            }
        }
        return $error_msg;
    }

}
