<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RolOpciones extends CI_Controller {

    public function __constructor() {
        parent::__constructor();
    }

    // this is the home page
    public function index() {
        if (!is_logged_in()) {
            redirect(base_url() . 'index.php/login');
        }
        $opciones = $this->traerOpcionesRolInicio(1);
        $data = array("opciones" => $opciones);
        $this->load->view('rolOpciones/lista', $data);
    }

    public function traerOpcionesRolInicio($rol) {
        //traer las opciones junto con las ya asignadas al usuario seleccionado
        $this->load->model('Modelorolopcion');
        $rolOpciones = $this->Modelorolopcion->get_rol_opciones($rol);
        return $rolOpciones;
    }

    public function traerOpcionesRol() {
        $rol = $this->input->post('idrol');
        //traer las opciones junto con las ya asignadas al usuario seleccionado
        $this->load->model('Modelorolopcion');
        $rolOpciones = $this->Modelorolopcion->get_rol_opciones($rol);
        echo ( json_encode($rolOpciones) );
    }

    public function guardar() {
        if ($_POST) {
            $this->load->library('form_validation');
            $this->load->helper('string');
            $rol = $this->input->post('rol');
            $rolOpciones = array();
            if (!empty($this->input->post('idOpcion'))) {
                foreach ($this->input->post('idOpcion') as $opcion) {
                    echo $opcion;
                    $rolOpciones[] = array(
                        'idRol' => $rol,
                        'idOpcion' => $opcion);
                };
            }
            $this->load->model('Modelorolopcion');


            if (empty($this->Modelorolopcion->guardar($rolOpciones, $rol))) {
                $error_msg = "No se pudo actualizar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('rolOpciones/lista', $data);
            } else {
                $opciones = $this->traerOpcionesRolInicio(1);
                $data = array("opciones" => $opciones);
                $this->load->view('rolOpciones/lista', $data);
            }
        }
    }

}
