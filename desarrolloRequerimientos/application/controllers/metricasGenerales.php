<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MetricasGenerales extends CI_Controller {

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
            $this->generaMetricas();
        }
    }

    function generaMetricas() {
        $this->load->model('Modelometricasgenerales');
        $totalReqAsignados= $this->Modelometricasgenerales->get_totalRequerimientosAsignados();
        $totalActividades = 0;
        $actividades = $this->Modelometricasgenerales->get_cambiosPorActividad();
        foreach ($actividades as $val) {
            $totalActividades = $totalActividades + $val["cambios"];
        }
        $reqPeticion= $this->Modelometricasgenerales->get_totalRequerimientosPeticion();
        $reqePeticion=number_format((float)(($reqPeticion['cantidad']/$totalReqAsignados['cantidad'])*100), 2, '.', '');
        $reqCasoPrueba= $this->Modelometricasgenerales->get_totalRequerimientosCasosPrueba();
        $reqeCasoPrueba=number_format((float)(($reqCasoPrueba['cantidad']/$totalReqAsignados['cantidad'])*100), 2, '.', '');
        $cambiosReq = $this->Modelometricasgenerales->get_totalCambiosRequerimientos();
        $totalRendimiento= $this->Modelometricasgenerales->get_totalRequerimientosPorTipo(5);
        $totalConfiabilidad= $this->Modelometricasgenerales->get_totalRequerimientosPorTipo(1);
        $totalSeguridad= $this->Modelometricasgenerales->get_totalRequerimientosPorTipo(9);
        $totalConfiguracion= $this->Modelometricasgenerales->get_totalRequerimientosPorTipo(10);
        $totalFuncionalidad= $this->Modelometricasgenerales->get_totalRequerimientosPorTipo(3);
        $totalSuport= $this->Modelometricasgenerales->get_totalRequerimientosPorTipo(4);
        $data = array("actividades" => $actividades, "totalActividades" => $totalActividades,"totalReq"=>$totalReqAsignados,
            "cambiosReq"=>$cambiosReq,"totalRendimiento"=>$totalRendimiento,"totalConfiabilidad"=>$totalConfiabilidad,
            "totalSeguridad"=>$totalSeguridad,"totalConfig"=>$totalConfiguracion,"totalFunc"=>$totalFuncionalidad,
            "reqPeticion"=>$reqePeticion,"reqCasoPrueba"=>$reqeCasoPrueba, "totalSuport"=>$totalSuport);
        $this->load->view('metricasGenerales/lista', $data);
    }

}
