<?php

if (!defined('BASEPATH')){
exit('No direct script access allowed');}

class Login extends CI_Controller {

    public function __constructor() {
        parent::__constructor();
        $this->load->model('modeloUsuario');
    }

    // this is the home page
    public function index() {
        if (!empty($_POST)) {
            $this->validaAcceso();
        } else {
            $this->load->view("login");
        }
    }

   public function validaAcceso() {
        $error_msg = "";
        if (!empty($_POST["password"])) {
            $this->load->model('modeloUsuario');
            $user = $this->modeloUsuario->validaUsuarioSesion($_POST["usuario"],$_POST["password"],$_POST["rol"]);
            if (!empty($user))
            {
                $user_data = array(
                    'idUsuario' => $user["idUsuario"],
                    'idRol' => $user["idRol"],
                    'nombre' => $user["nombre"],
                    'usuario' => $user["usuario"],
                    'descRol' => $user["descRol"],
                    'correo' => $user["correo"],
                    'esAdministrador' => $user["esAdministrador"]
                );
             
                $this->session->set_userdata($user_data);
				redirect(base_url().'index.php/inicial');
            }
            else
            {
                $error_msg = "Proporcione usuario, rol y contraseña correctos.";
                $this->load->model('modeloRol');
                $roles= $this->modeloRol->traerRoles();
                $data = array("mensaje" => $error_msg, "roles"=>$roles);
                $this->load->view("login", $data);
            }
        }
    }
}
