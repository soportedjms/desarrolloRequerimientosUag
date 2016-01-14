<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Peticiones extends CI_Controller {

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
            $this->todosPeticiones();
        }
    }

    public function nuevo() {
        $this->load->view('peticiones/nuevo');
    }

    public function guardarNuevo() {
        $data['nombre'] = $_POST['nombre'];
        $data['descripcion'] = $_POST['descripcion'];
        $data['descripcionDetallada'] = $_POST['descripcionDetallada'];
        $data['idEstatus'] = $_POST['estatus'];
        $data['idProyecto'] = $_POST['idProyecto'];
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloPeticion');
        if (empty($this->modeloPeticion->insertarPeticion($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('peticiones/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('modeloPeticion');
        $peticion = $this->modeloPeticion->get_peticion($id);
        $data = array("peticion" => $peticion);
        $this->load->view('peticiones/editar', $data);
    }

    public function guardarEditar() {

        $peticion = array("idPeticion" => $_POST['idPeticion'], 'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'idEstatus' => $_POST['estatus'], 'descripcionDetallada' => $_POST['descripcionDetallada'],
            'idProyecto' => $_POST['idProyecto']);

        $data = array("peticion" => $peticion);

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('modeloPeticion');
        if (empty($this->modeloPeticion->editarPeticion($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "peticion" => $peticion);
            $this->load->view('peticiones/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarPeticion() {
        $peticion = $this->input->post('idpeticion');
        $this->load->model('modeloPeticion');
        $existe = $this->modeloPeticion->validarAsignacion($peticion);
        if (!empty($existe)) {
            echo 'asignado';
        } else {
            $val = $this->modeloPeticion->eliminarPeticion($peticion);
            if (empty($val))
                echo 'no';
            else
                echo 'ok';
        }
    }

    public function peticionesProyecto() {
        $proyecto = $this->input->post('idproyecto');
        $peticiones = $this->input->post('peticiones');
        $incluirPeticiones=$this->input->post('incluirPeticiones');
        $this->load->model('modeloPeticion');
        $peticiones = $this->modeloPeticion->get_peticionesProyecto($proyecto, $peticiones,$incluirPeticiones);
        if (!empty($peticiones))
            echo ( json_encode($peticiones) );
        else
            echo "no";
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosPeticiones() {
        $this->load->model('modeloPeticion');
        $peticiones = $this->modeloPeticion->get_peticiones();
        $data['peticiones'] = $peticiones;
        $this->load->view('peticiones/lista', $data);
    }

    function nombreBlanco($variable) {
        if (empty($variable))
            return "";
        else
            return $variable;
    }

    ///////Funciones y acciones para los archivos//////////////////
    public function cargarArchivos($id) {
        $this->load->model('modeloPeticion');
        $archivos = $this->modeloPeticion->get_archivos($id);
        $data = array("archivos" => $archivos, "idPeticion" => $id);
        $this->load->view('peticiones/archivos', $data);
    }

    public function nuevoArchivo() {
        try {
            $idPeticion = $_POST['idPeticion'];
            $this->load->model('modeloPeticion');
            $resultado = $this->modeloPeticion->do_upload($idPeticion);
            $archivos = $this->modeloPeticion->get_archivos($idPeticion);
            $data = array("archivos" => $archivos, "idPeticion" => $idPeticion,
                "mensaje" => $resultado["mensaje"]);
            if ($resultado["status"] == true)
                redirect("peticiones/cargarArchivos/" . $idPeticion, $data);
            else
                $this->load->view('peticiones/archivos', $data);
        } catch (Exception $err) {
            log_message("error", $err->getMessage());
            return show_error($err->getMessage());
        }
    }

    public function eliminarArchivo() {
        $archivo = $this->input->post('idarchivo');
        $this->load->model('modeloPeticion');
        $val = $this->modeloPeticion->eliminarArchivo($archivo);
        echo $val;
    }

}
