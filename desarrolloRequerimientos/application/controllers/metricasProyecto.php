<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MetricasProyecto extends CI_Controller {

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
            $this->generaMetricas('1');
        }
    }

    public function consulta() {
        $proyecto = $_POST['idProyecto'];
        $this->generaMetricas($proyecto);
    }

    function generaMetricas($proyecto) {
        $this->load->model('modeloMetricasProyecto');
        //Metricas generales
        $totalReqAsignados = $this->modeloMetricasProyecto->get_totalRequerimientosAsignados($proyecto);
        $totalActividades = 0;
        $actividades = $this->modeloMetricasProyecto->get_cambiosPorActividad($proyecto);
        foreach ($actividades as $val) {
            $totalActividades = $totalActividades + $val["cambios"];
        }
        $reqPeticion = $this->modeloMetricasProyecto->get_totalRequerimientosPeticion($proyecto);
        $reqCasoPrueba = $this->modeloMetricasProyecto->get_totalRequerimientosCasosPrueba($proyecto);
        $reqePeticion = $this->calculaPorcentaje($reqPeticion['cantidad'], $totalReqAsignados['cantidad']);
        $reqeCasoPrueba = $this->calculaPorcentaje($reqCasoPrueba['cantidad'], $totalReqAsignados['cantidad']);
        $cambiosReq = $this->modeloMetricasProyecto->get_totalCambiosRequerimientos($proyecto);
        $totalRendimiento = $this->modeloMetricasProyecto->get_totalRequerimientosPorTipo($proyecto, 5);
        $totalConfiabilidad = $this->modeloMetricasProyecto->get_totalRequerimientosPorTipo($proyecto, 1);
        $totalSeguridad = $this->modeloMetricasProyecto->get_totalRequerimientosPorTipo($proyecto, 9);
        $totalConfiguracion = $this->modeloMetricasProyecto->get_totalRequerimientosPorTipo($proyecto, 10);
        $totalFuncionalidad = $this->modeloMetricasProyecto->get_totalRequerimientosPorTipo($proyecto, 3);
        $totalSuport = $this->modeloMetricasProyecto->get_totalRequerimientosPorTipo($proyecto, 4);

        ///////////////Metricas de linea base
        //Número de requisitos activos en la línea base
        $totalReqLB = $this->modeloMetricasProyecto->get_totalRequerimientosAsignados($proyecto);
        $cambiosNoAplicadosLB = $this->modeloMetricasProyecto->get_cambiosPorAplicar($proyecto);
        $reqAprobados=$this->modeloMetricasProyecto->get_requerimientoAprobados($proyecto);
        $porReqAprobados=$this->calculaPorcentaje($reqAprobados['cantidad'], $totalReqLB['cantidad']);
        $reqAbiertos=$this->modeloMetricasProyecto->get_requerimientosAbiertos($proyecto);
        $porReqAbiertos=$this->calculaPorcentaje($reqAbiertos['cantidad'], $totalReqLB['cantidad']);
        $cambiosIncorporados=$this->modeloMetricasProyecto->get_CambiosIncorporados($proyecto);
        $volatilidad=$this->calculaPorcentaje($cambiosNoAplicadosLB['cantidad'],$totalReqLB['cantidad']);
        //Regresar datos a la vista
        $data = array("proyecto" => $proyecto, "actividades" => $actividades, "totalActividades" => $totalActividades, "totalReq" => $totalReqAsignados,
            "cambiosReq" => $cambiosReq, "totalRendimiento" => $totalRendimiento, "totalConfiabilidad" => $totalConfiabilidad,
            "totalSeguridad" => $totalSeguridad, "totalConfig" => $totalConfiguracion, "totalFunc" => $totalFuncionalidad,
            "reqPeticion" => $reqePeticion, "reqCasoPrueba" => $reqeCasoPrueba, "totalSuport" => $totalSuport,
            "totalReqLB" => $totalReqLB,"cambiosNoAplicadosLB"=>$cambiosNoAplicadosLB,
            "reqAprobados"=>$reqAprobados,"porReqAprobados"=>$porReqAprobados, "reqAbiertos"=>$reqAbiertos,
            "porReqAbiertos"=>$porReqAbiertos, "cambiosIncorporados"=>$cambiosIncorporados,"volatilidad"=>$volatilidad);
        $this->load->view('metricasProyecto/lista', $data);
    }

    function calculaPorcentaje($valor, $total) {
        $porcentaje=0;
        if ($valor != 0 && $total != 0) {
            $porcentaje=number_format((float) (($valor / $total) * 100), 2, '.', '');
        } 
        return $porcentaje;
    }

}
