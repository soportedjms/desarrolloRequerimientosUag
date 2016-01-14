<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends CI_Controller {

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
            $this->todosRoles();
        }
    }

    public function nuevo() {
        $this->load->view('roles/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modelorol');
        $id = $this->Modelorol->insertarRol($data);

        if (isset($id)) {
            $this->index();
        } else {
            $error_msg = "No se pudo insertar el rol.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('roles/nuevo', $data);
        }
    }

    public function editar($id) {
        $this->load->model('Modelorol');
        $roles = $this->Modelorol->get_rol($id);
        $data = array("roles" => $roles);
        $this->load->view('roles/editar', $data);
    }

    public function guardarEditar() {
        $roles = array("idRol" => $_POST['idRol'], 'descripcion' => $_POST['descripcion']);
        $data = array("roles" => $roles);

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modelorol');
        $id = $this->Modelorol->editarRol($data);

        if (isset($id)) {
            $this->index();
        } else {
            $error_msg = "No se pudo actualizar el registro.";
            $data = array("mensaje" => $error_msg, "roles" => $roles);
            $this->load->view('roles/editar', $data);
        }
    }


    public function eliminarRol() {
        $rol= $this->input->post('idrol');
        $this->load->model('Modelorol');
        if (empty( $this->Modelorol->eliminarRol($rol)))
            echo 'no';
        else
            echo 'ok';
    }


    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosRoles() {
        $this->load->model('Modelorol');
        $roles = $this->Modelorol->traerRoles();
        $data['roles'] = $roles;
        $this->load->view('roles/lista', $data);
    }
}
