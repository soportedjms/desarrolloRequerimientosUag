<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inicial extends CI_Controller {

    public function __constructor() {
        parent::__constructor();
    }

    // this is the home page
    public function index() {
        if (!is_logged_in()) {
            redirect(base_url() . 'index.php/login');
        }

        if ($this->input->post('submit_registro')) {
            
        } else {
            $this->cargarInicial();
        }
    }

    public function cargarInicial() {
        $this->load->model('modeloArtefacto');
        $artefactos = $this->modeloArtefacto->get_artefactosPantallaInicial();
        $this->load->model('modeloPeticion');
        $peticiones = $this->modeloPeticion->get_peticionesPantallaInicial();
        $this->load->model('modeloRequerimiento');
        $requerimientos = $this->modeloRequerimiento->get_requerimientosPantallaInicial();
        $this->load->model('modeloMetricasGenerales');
        $totalReqAsignados= $this->modeloMetricasGenerales->get_totalRequerimientosAsignados();
        $totalTerm=$this->modeloMetricasGenerales->get_totalRequerimientosAsignadosTerminados();
        $reqPeticion= $this->modeloMetricasGenerales->get_totalPeticionAsignada();
        $petReq=$this->modeloMetricasGenerales->get_peticionesActivas();
        $actividades = $this->modeloMetricasGenerales->get_cambiosPorActividad();
        $totalActividades=0;
        foreach ($actividades as $val) {
            $totalActividades = $totalActividades + $val["cambios"];
        }
        $data = array('artefactos' => $artefactos, "peticiones" => $peticiones, "requerimientos"=>$requerimientos,
            "totalReq"=>$totalReqAsignados, "totalTerm"=>$totalTerm,"reqPeticion"=>$reqPeticion,"petReq"=>$petReq,
            "totalActividades"=>$totalActividades);
        $this->load->view('inicial', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/login');
    }

}
