<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TiposRequerimiento extends CI_Controller {

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
            $this->todosTipos();
        }
    }

    public function nuevo() {
        $this->load->view('tiposRequerimiento/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        $data['furps'] = $_POST['furps'];
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloTipoRequerimiento');
        if (empty($this->modeloTipoRequerimiento->insertarTipoRequerimientos($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('tiposRequerimiento/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('modeloTipoRequerimiento');
        $tipo = $this->modeloTipoRequerimiento->get_TipoRequerimiento($id);
        $data = array("tipo" => $tipo);
        $this->load->view('tiposRequerimiento/editar', $data);
    }

    public function guardarEditar() {

        $tipo = array("idTipo" => $_POST['idTipo'],'descripcion' => $_POST['descripcion'],
            'furps' => $_POST['furps']);
        $data = array("tipo" => $tipo);
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloTipoRequerimiento');
        if (empty($this->modeloTipoRequerimiento->editarTipoRequerimientos($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "tipo" => $tipo);
            $this->load->view('tiposRequerimiento/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarTipoRequerimiento() {
        $tipo = $this->input->post('idtipo');
        $this->load->model('modeloTipoRequerimiento');
        $val = $this->modeloTipoRequerimiento->eliminarTipoRequerimiento($tipo);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosTipos() {
        $this->load->model('modeloTipoRequerimiento');
        $tipos = $this->modeloTipoRequerimiento->get_tipos_requerimientos();
        $data['tipos'] = $tipos;
        $this->load->view('tiposRequerimiento/lista', $data);
    }
}
