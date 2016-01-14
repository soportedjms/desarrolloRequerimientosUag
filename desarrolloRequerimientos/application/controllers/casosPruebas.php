<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CasosPruebas extends CI_Controller {

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
            $this->todosCasosPruebas();
        }
    }

    public function nuevo() {
        $this->load->view('casosPruebas/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        $data['precondicion'] = $_POST['precondicion'];
        $data['poscondicion'] = $_POST['poscondicion'];
        $data['responsable'] = $_POST['responsable'];
        $data['descripcionDetallada'] = $_POST['descripcionDetallada'];
        $data['idEstatus'] = $_POST['estatus'];
        $data['idProyecto'] = $_POST['idProyecto'];
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloCasoPrueba');
        if (empty($this->modeloCasoPrueba->insertarCasoPrueba($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('casosPruebas/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('modeloCasoPrueba');
        $casoPrueba = $this->modeloCasoPrueba->get_casoPrueba($id);
        $data = array("casoPrueba" => $casoPrueba);
        $this->load->view('casosPruebas/editar', $data);
    }

    public function guardarEditar() {

        $casoPrueba = array("idCasoPrueba" => $_POST['idCasoPrueba'], 'descripcion' => $_POST['descripcion'],
            'precondicion' => $_POST['precondicion'], "poscondicion" => $_POST['poscondicion'],
            'responsable' => $_POST['responsable'], 'descripcionDetallada' => $_POST['descripcionDetallada'],
            'idEstatus' => $_POST['estatus'],'idProyecto' => $_POST['idProyecto']);
        $data = array("casoPrueba" => $casoPrueba);
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloCasoPrueba');
        if (empty($this->modeloCasoPrueba->editarCasoPrueba($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "casoPrueba" => $casoPrueba);
            $this->load->view('casosPruebas/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarCasoPrueba() {
        $casoPrueba = $this->input->post('idcasoprueba');
        $this->load->model('modeloCasoPrueba');
        $val = $this->modeloCasoPrueba->eliminarCasoPrueba($casoPrueba);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosCasosPruebas() {
        $this->load->model('modeloCasoPrueba');
        $casosPruebas = $this->modeloCasoPrueba->get_casosPruebas();
        $data['casosPruebas'] = $casosPruebas;
        $this->load->view('casosPruebas/lista', $data);
    }

}