<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

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
            $this->todosUsuarios();
        }
    }

    public function nuevo() {
        $this->load->view('usuarios/nuevo');
    }

    public function guardarNuevo() {
        $data['usuario'] = $_POST['usuario'];
        $data['password'] = $_POST['password'];
        $data['nombre'] = $_POST['nombre'];
        $data['email'] = $_POST['email'];
        $data['esAdmin'] = $_POST['esAdmin'];
        $data['roles'] = $_POST['rol'];
        $error_msg = $this->validaGuardar($_POST['usuario'], 0);
        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg);
            $this->load->view('usuarios/nuevo', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modelousuario');
            if (empty($this->Modelousuario->insertarUsuario($data))) {
                $error_msg = "No se pudo insertar el registro.";
                $data = array("mensaje" => $error_msg);
                $this->load->view('usuarios/nuevo', $data);
            } else {
                $this->index();
            }
        }
    }

    public function editar($id) {
        $this->load->model('Modelousuario');
        $user = $this->Modelousuario->get_usuario($id);
        $roles = $this->Modelousuario->get_usuario_roles($id);
        $array = array();
        if (!empty($roles)) {
            foreach ($roles as $row) {
                $array[] = $row["idRol"];
            }
        }
        $data = array("user" => $user, "roles" => $array);
        $this->load->view('usuarios/editar', $data);
    }

    public function guardarEditar() {
                
        $user = array("idUsuario" => $_POST['idUsuario'], 'usuario' => $_POST['usuario'], 'password' => $_POST['password'],
            "nombre" => $_POST['nombre'], 'correo' => $_POST['correo'], 'esAdministrador' => $_POST['esAdministrador']);
        $roles=$_POST['rol'];
        $data = array("user" => $user,"roles"=>$roles);
        
        $error_msg = "";
        $error_msg = $this->validaGuardar($_POST['usuario'], $_POST['idUsuario']);

        if ($error_msg != "") {
            $data = array("mensaje" => $error_msg, "user" => $user,"roles"=>$roles);
            $this->load->view('usuarios/editar', $data);
        } else {
            //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
            $this->load->model('Modelousuario');
            if (empty($this->Modelousuario->editarUsuario($data))) {
                $error_msg = "No se pudo editar el registro.";
                $data = array("mensaje" => $error_msg, "user" => $user,"roles"=>$roles);
                $this->load->view('usuarios/editar', $data);
            } else {
                $this->index();
            }
        }
    }

    public function eliminarUsuario() {
        $usuario = $this->input->post('idusuario');
        $this->load->model('Modelousuario');
        $val=$this->Modelousuario->eliminarUsuario($usuario);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosUsuarios() {
        $this->load->model('Modelousuario');
        $users = $this->Modelousuario->get_usuarios();
        $data['usuarios'] = $users;
        $this->load->view('usuarios/lista', $data);
    }

    function validaGuardar($usuario, $id) {
        //Validar que el usuario no exista
        $this->load->model('Modelousuario');
        $user = $this->Modelousuario->validaUsuario($usuario, $id);

        $error_msg = "";
        if (!empty($user)) {
            $error_msg = "Ya existe el usuario proporcionado.";
        }

        return $error_msg;
    }

}
