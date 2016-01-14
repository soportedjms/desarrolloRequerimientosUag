<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Definiciones extends CI_Controller {

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
            $this->todosDefiniciones('', '');
        }
    }

    function consulta() {
        $palabra = $_POST['palabraFiltro'];
        $glosario = $_POST['idGlosario'];
        $this->todosDefiniciones($palabra, $glosario);
    }

    public function nuevo() {
        $this->load->view('definiciones/nuevo');
    }

    public function validaGuardar() {
       
        $this->load->model('Modelodefinicion');
        $id=0;
        if (!empty($_POST['idDefinicion']))
            $id=$_POST['idDefinicion'];
         
        $definicion = $this->Modelodefinicion->validaPalabra($_POST['palabra'], $_POST['idGlosario'], $id);
       
//        //si ya existe la definicion preguntar 
        if (!empty($definicion)) {
            echo 'modal';
        } else {
            $this->guardarNuevo();
        }
    }

    public function guardarNuevo() {
       
        if (!empty($_POST['idDefinicion'])) {
            $data['idDefinicion'] = $_POST['idDefinicion'];
        } else {
            $data['idDefinicion'] = 0;
        }
    
        $data['idGlosario'] = $_POST['idGlosario'];
        $data['palabra'] = $_POST['palabra'];
        $data['definicion'] = $_POST['definicion'];
        $data['activo'] = 1;
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modelodefinicion');
        
        if (empty($this->Modelodefinicion->insertarDefinicion($data))) {
            echo "No se pudo insertar el registro.";
        } else {
            echo "";
        }
    }

    public function editar($id) {
        $this->load->model('Modelodefinicion');
        $definicion = $this->Modelodefinicion->get_definicion($id);
        $data = array("definicion" => $definicion);
        $this->load->view('definiciones/editar', $data);
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosDefiniciones($palabra, $glosario) {
        $this->load->model('Modelodefinicion');
        $definiciones = $this->Modelodefinicion->get_definiciones($palabra, $glosario);
        $data['definiciones'] = $definiciones;
        $this->load->view('definiciones/lista', $data);
    }

}
