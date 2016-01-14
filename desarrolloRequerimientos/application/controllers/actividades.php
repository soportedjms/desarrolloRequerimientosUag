<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Actividades extends CI_Controller {

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
            $this->todosActividades();
        }
    }

    public function nuevo() {
        $this->load->view('actividades/nuevo');
    }

    public function guardarNuevo() {
        $actividad = 0;
        $modificacion = 0;
        if (isset($_POST['actividadDefault']))
            $actividad = 1;
        if (isset($_POST['defaultModificacion']))
            $modificacion = 1;
        $data['descripcion'] = $_POST['descripcion'];
        $data['actividadDefault'] = $actividad;
        $data['defaultModificacion'] = $modificacion;
        $data['ordenEjecucion'] = $_POST['ordenEjecucion'];
        $data['duracionHrs'] = $_POST['duracionHrs'];
        $data['idProyecto'] = $_POST['idProyecto'];

        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modeloactividad');
        if (empty($this->Modeloactividad->insertarActividad($data))) {
            $error_msg = "No se pudo insertar el registro.";
            $data = array("actividad" => $error_msg);
            $this->load->view('actividades/nuevo', $data);
        } else {
            $this->index();
        }
    }

    public function editar($id) {
        $this->load->model('Modeloactividad');
        $actividad = $this->Modeloactividad->get_actividad($id);
        $data = array("actividad" => $actividad);
        $this->load->view('actividades/editar', $data);
    }

    public function guardarEditar() {
        $actividad = 0;
        $modificacion = 0;
        if (isset($_POST['actividadDefault']))
            $actividad = 1;
        if (isset($_POST['defaultModificacion']))
            $modificacion = 1;
        $actividad = array("idActividad" => $_POST['idActividad'], 'descripcion' => $_POST['descripcion'],
            'actividadDefault' => $actividad, "defaultModificacion" => $modificacion,
            'ordenEjecucion' => $_POST['ordenEjecucion'], 'duracionHrs' => $_POST['duracionHrs'],
            'idProyecto' => $_POST['idProyecto']);
        $data = array("actividad" => $actividad);
        //llamamos al modelo, concretamente a la función insert() para que nos haga el insert en la base de datos.
        $this->load->model('Modeloactividad');
        if (empty($this->Modeloactividad->editarActividad($data))) {
            $error_msg = "No se pudo editar el registro.";
            $data = array("mensaje" => $error_msg, "actividad" => $actividad);
            $this->load->view('actividades/editar', $data);
        } else {
            $this->index();
        }
    }

    public function actividadesProyecto() {
        $proyecto = $this->input->post('idproyecto');
        $actividades = $this->input->post('actividades');
        $incluirActividades = $this->input->post('incluirActividades');
        $this->load->model('Modeloactividad');
        $act = $this->Modeloactividad->get_actividadesProyecto($proyecto, $actividades, $incluirActividades);
        if (!empty($act)) {
            $var = json_encode($act);
            echo ($var);
        } else
            echo "no";
    }
    
      public function actividadesFiltro() {
        $proyecto = $this->input->post('idproyecto');
        $default = $this->input->post('default');
        $modificacion = $this->input->post('modificacion');
        $this->load->model('Modeloactividad');
        $act = $this->Modeloactividad->get_actividadesFiltro($proyecto,$default,$modificacion);
        if (!empty($act)) {
            $var = json_encode($act);
            echo ($var);
        } else
            echo "no";
    }

    public function eliminarActividad() {
        $actividad = $this->input->post('idactividad');
        $this->load->model('Modeloactividad');
        $val = $this->Modeloactividad->eliminarActividad($actividad);
        if (empty($val))
            echo 'no';
        else
            echo 'ok';
    }

    ////////////////////////////////////////////FUNCIONES///////////////////////////
    function todosActividades() {
        $this->load->model('Modeloactividad');
        $actividad = $this->Modeloactividad->get_actividades();
        $data['actividades'] = $actividad;
        $this->load->view('actividades/lista', $data);
    }

}
