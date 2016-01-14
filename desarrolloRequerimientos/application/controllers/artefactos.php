<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artefactos extends CI_Controller {

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
            $this->todosArtefactos();
        }
    }

    public function nuevo() {
        $this->load->view('artefactos/nuevo');
    }

    public function guardarNuevo() {
        $data['descripcion'] = $_POST['descripcion'];
        $data['descripcionDetallada'] = $_POST['descripcionDetallada'];
        $data['idEstatus'] = $_POST['estatus'];
        $data['idProyecto'] = $_POST['idProyecto'];
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modeloartefacto');
        if (empty($this->Modeloartefacto->insertarArtefacto($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("mensaje" => $error_msg);
            $this->load->view('artefactos/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('Modeloartefacto');
        $artefacto = $this->Modeloartefacto->get_artefacto($id);
        $data = array("artefacto" => $artefacto);
        $this->load->view('artefactos/editar', $data);
    }

    public function guardarEditar() {

        $artefacto = array("idArtefacto" => $_POST['idArtefacto'], 'descripcion' => $_POST['descripcion'],
            'idEstatus' => $_POST['estatus'], 'descripcionDetallada' => $_POST['descripcionDetallada'],
            'idProyecto' => $_POST['idProyecto']);

        $data = array("artefacto" => $artefacto);

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modeloartefacto');
        if (empty($this->Modeloartefacto->editarArtefacto($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "artefacto" => $artefacto);
            $this->load->view('artefactos/editar', $data);
        } else {
            $this->index();
        }
    }

    public function eliminarArtefacto() {
        $artefacto = $this->input->post('idartefacto');
        $this->load->model('Modeloartefacto');
        $existe = $this->Modeloartefacto->validarAsignacion($artefacto);
        if (!empty($existe)) {
            echo 'asignado';
        } else {
            $val = $this->Modeloartefacto->eliminarArtefacto($artefacto);
            if (empty($val))
                echo 'no';
            else
                echo 'ok';
        }
    }
    
     public function artefactosProyecto() {
        $proyecto = $this->input->post('idproyecto');
        $artefactos = $this->input->post('artefactos');
        $incluirArtefactos=$this->input->post('incluirArtefactos');
        $this->load->model('Modeloartefacto');
        $artefactos = $this->Modeloartefacto->get_artefactosProyecto($proyecto, $artefactos,$incluirArtefactos);
        if (!empty($artefactos))
            echo ( json_encode($artefactos) );
        else
            echo "no";
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosArtefactos() {
        $this->load->model('Modeloartefacto');
        $artefactos = $this->Modeloartefacto->get_artefactos();
        $data['artefactos'] = $artefactos;
        $this->load->view('artefactos/lista', $data);
    }

    ///////Funciones y acciones para los archivos//////////////////
    public function cargarArchivos($id) {
        $this->load->model('Modeloartefacto');
        $archivos = $this->Modeloartefacto->get_archivos($id);
        $data = array("archivos" => $archivos, "idArtefacto" => $id);
        $this->load->view('artefactos/archivos', $data);
    }

    public function nuevoArchivo() {
        try {
            $idArtefacto = $_POST['idArtefacto'];
            $this->load->model('Modeloartefacto');
            $resultado = $this->Modeloartefacto->do_upload($idArtefacto);
            $archivos = $this->Modeloartefacto->get_archivos($idArtefacto);
            $data = array("archivos" => $archivos, "idArtefacto" => $idArtefacto,
                "mensaje" => $resultado["mensaje"]);
            if ($resultado["status"] == true)
                redirect("artefactos/cargarArchivos/" . $idArtefacto, $data);
            else
                $this->load->view('artefactos/archivos', $data);
        } catch (Exception $err) {
            log_message("error", $err->getMessage());
            return show_error($err->getMessage());
        }
    }

    public function eliminarArchivo() {
        $archivo = $this->input->post('idarchivo');
        $this->load->model('Modeloartefacto');
        $val = $this->Modeloartefacto->eliminarArchivo($archivo);
        echo $val;
    }

}
