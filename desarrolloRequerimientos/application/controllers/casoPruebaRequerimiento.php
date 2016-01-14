<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class casoPruebaRequerimiento extends CI_Controller {

    public function __constructor() {
        parent::__constructor();
    }

    // this is the home page
    public function index() {
        if (!is_logged_in()) {
            redirect(base_url() . 'index.php/login');
        }
        $casosPrueba = $this->traerCasoPruebaRequerimientosInicio(1);
        $data = array("casosPrueba" => $casosPrueba);
        $this->load->view('casoPruebaRequerimiento/lista', $data);
    }

    public function traerCasoPruebaRequerimientosInicio($casoPrueba) {
        //traer las opciones junto con las ya asignadas al usuario seleccionado
        $this->load->model('modeloCasoPruebaRequerimiento');
        $casoRequerimientos = $this->modeloCasoPruebaRequerimiento->get_casoPruebaRequerimientos($casoPrueba);
        return $casoRequerimientos;
    }

    public function traerCasoPruebaRequerimientos() {
        $casoPrueba = $this->input->post('idcasoprueba');
        //traer las opciones junto con las ya asignadas al usuario seleccionado
        $this->load->model('modeloCasoPruebaRequerimiento');
        $resultado = $this->modeloCasoPruebaRequerimiento->get_casoPruebaRequerimientos($casoPrueba);
        echo ( json_encode($resultado) );
    }

    public function guardar() {
        if ($_POST) {
            $this->load->library('form_validation');
            $this->load->helper('string');
            $casoPrueba = $this->input->post('idCasoPrueba');
            $reqUsuario = $this->input->post('idRequerimientoUsuario');
            $casoRequerimiento = array();
            if (!empty($this->input->post('idRequerimiento'))) {
                $i = 0;
                foreach ($this->input->post('idRequerimiento') as $req) {
                    $casoRequerimiento[] = array(
                        'idCasoPrueba' => $casoPrueba,
                        'idRequerimiento' => $req,
                        'idRequerimientoUsuario' => $reqUsuario[$i]);
                    $i = $i + 1;
                };
            }
            $this->load->model('modeloCasoPruebaRequerimiento');
            if (empty($this->modeloCasoPruebaRequerimiento->guardar($casoRequerimiento, $casoPrueba))) {
                $error_msg = "No se pudo actualizar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('casoPruebaRequerimiento/lista', $data);
            } else {
                $casosPrueba = $this->traerCasoPruebaRequerimientosInicio(1);
                $data = array("casosPrueba" => $casosPrueba);
                $this->load->view('casoPruebaRequerimiento/lista', $data);
            }
        }
    }

}
