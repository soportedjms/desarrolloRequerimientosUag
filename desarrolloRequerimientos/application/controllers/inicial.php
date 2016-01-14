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
        $this->load->model('Modeloartefacto');
        $artefactos = $this->Modeloartefacto->get_artefactosPantallaInicial();
        $this->load->model('Modelopeticion');
        $peticiones = $this->Modelopeticion->get_peticionesPantallaInicial();
        $this->load->model('Modelorequerimiento');
        $requerimientos = $this->Modelorequerimiento->get_requerimientosPantallaInicial();
        $this->load->model('Modelometricasgenerales');
        $totalReqAsignados= $this->Modelometricasgenerales->get_totalRequerimientosAsignados();
        $totalTerm=$this->Modelometricasgenerales->get_totalRequerimientosAsignadosTerminados();
        $reqPeticion= $this->Modelometricasgenerales->get_totalPeticionAsignada();
        $petReq=$this->Modelometricasgenerales->get_peticionesActivas();
        $actividades = $this->Modelometricasgenerales->get_cambiosPorActividad();
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
